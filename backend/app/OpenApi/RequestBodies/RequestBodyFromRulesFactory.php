<?php


namespace App\OpenApi\RequestBodies;


use GoldSpecDigital\ObjectOrientedOAS\Contracts\SchemaContract;
use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\RequestBody;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;
use Vyuldashev\LaravelOpenApi\Factories\RequestBodyFactory;

/**
 * Class RequestBodyFromRulesFactory
 * @package App\OpenApi\RequestBodies
 */
class RequestBodyFromRulesFactory extends RequestBodyFactory
{
    private SchemaContract $schema;

    private array $schemas;


    /**
     * RequestBodyRulesParser constructor.
     * @param array $rules
     * @param $example
     * @throws InvalidArgumentException
     */
    public function __construct(array $rules, $example)
    {
        $this->schema = Schema::object()
            ->properties(...$this->parseRules($rules))
            ->example($example);
    }

    /**
     * @param $key
     * @return bool
     */
    private function isArrayDetail($key): bool
    {
        return preg_match('/(.*)(\.\*)(.*)/', $key);
    }

    private function isArrayOrObjectDetail($key): bool
    {
        return strpos($key, '.') !== false;
    }

    /**
     * @param $key
     * @return string
     */
    private function getArrayKey($key): string
    {
        return substr($key, 0, strpos($key, '.'));
    }

    /**
     * @param array $rules
     * @return Schema[]
     * @throws InvalidArgumentException
     */
    private function parseRules(array $rules): array
    {
        $rules = $this->prepareRules($rules);

        $schemas = [];
        foreach ($rules as $key => $rule)
        {
            if($this->isArrayOrObjectDetail($key)) {
                $schemas[$this->getArrayKey($key)] = $this->parseArrayRule($schemas[$this->getArrayKey($key)], $key, $rule);
                continue;
            }

            $schema = $this->createSchema($key, $rule);

            unset($rules[$key]);

            $schemas[$key] = $schema;
        }

        return array_values($schemas);
    }

    /**
     * @param int $key
     * @param $rules
     * @return Schema
     * @throws InvalidArgumentException
     */
    private function createSchema($key, $rules): Schema
    {
        if(!is_array($rules))
            $rules = explode('|', $rules);

        $schema = Schema::string($key);
        foreach ($rules as $rule)
        {
            if (is_object($rule) && !method_exists($rule, '__toString')) {
                if (method_exists($rule, 'openApiMessage')) {
                    $schema = $this->addDescription($schema, $rule->openApiMessage());
                }
                continue;
            }
            $parameters = explode(':', $rule);
            $rule = $parameters[0];
            $parameters = $parameters[1] ?? '';
            $parameters = explode(',', $parameters);

            if($rule === 'required')
                $schema = $schema->required($key);
            else
                $schema = $this->parseRule($schema, $rule, ...$parameters);
        }

        return $schema;
    }

    private function parseRule(Schema $schema, $rule, ...$param): Schema
    {
        if ($rule === 'string')
            return $schema->type(Schema::TYPE_STRING);

        if ($rule === 'numeric')
            return $schema->type(Schema::TYPE_NUMBER);

        if ($rule === 'integer')
            return $schema->type(Schema::TYPE_INTEGER);

        if ($rule === 'boolean')
            return $schema->type(Schema::TYPE_BOOLEAN);

        if ($rule === 'array')
            return $schema->type(Schema::TYPE_ARRAY);

        if ($rule === 'date_format:Y-m-d')
            return $schema->format(Schema::FORMAT_DATE);

        if($schema->type === Schema::TYPE_STRING) {
            if ($rule === 'min')
                return $schema->minLength((int) $param[0]);

            if ($rule === 'max')
                return $schema->maxLength((int) $param[0]);
        }

        if(in_array($schema->type, [Schema::TYPE_INTEGER, Schema::TYPE_NUMBER])) {
            if ($rule === 'min')
                return $schema->minimum((int) $param[0]);

            if ($rule === 'max')
                return $schema->maximum((int) $param[0]);
        }

        if ($rule === 'exists') {
            $table = $param[0];
            $column = $param[1] ?? $schema->objectId;
            return $this->addDescription($schema, sprintf("Property must exist on table '%s' at column '%s'", $table, $column));
        }

        if ($rule === 'unique') {
            $table = $param[0];
            $column = $param[1] ?? $schema->objectId;
            return $this->addDescription($schema, sprintf("Property must not exist on table '%s' at column '%s'", $table, $column));
        }

        if ($rule === 'nullable')
            return $schema->nullable(true);

        if ($rule === 'in') {
            $param = array_map(function ($param) {
                return str_replace('"', '', $param);
            }, $param);
            return $schema->enum(...$param);
        }

        if ($rule === 'required_if') {
            $field = $param[0];
            $values = implode("' or '", array_splice($param, 1));
            return $this->addDescription($schema, sprintf("Property is required if field '%s' is one of ('%s')", $field, $values));
        }

        if ($rule === 'lte') {
            $field = $param[0];
            return $this->addDescription($schema, sprintf("Property must less or equal to field '%s'", $field));
        }

        if ($rule === 'lt') {
            $field = $param[0];
            return $this->addDescription($schema, sprintf("Property must less than field '%s'", $field));
        }

        if ($rule === 'gte') {
            $field = $param[0];
            return $this->addDescription($schema, sprintf("Property must greater or equal to field '%s'", $field));
        }

        if ($rule === 'gt') {
            $field = $param[0];
            return $this->addDescription($schema, sprintf("Property must greater than field '%s'", $field));
        }

        return $schema;
    }

    private function addDescription($schema, $newDescription)
    {
        $description = $schema->description;
        if($description)
            $description .= '<BR>';
        $description .= $newDescription;
        return $schema->description($description);
    }

    /**
     * @param Schema $schema
     * @param string $key
     * @param string|array $rules
     * @return Schema
     * @throws InvalidArgumentException
     */
    private function parseArrayRule(Schema $schema, string $key, $rules): Schema
    {
        $keys = $this->parseKeys($key);

        if ($this->isArrayDetail($key)) {
            $items = $schema->items;

            if (count($keys) === 1) {
                $items = $this->createSchema($key, $rules);
            } else {
                if (is_null($items))
                    $items = Schema::object();

                $items = $this->pushSchema($items, $this->createSchema($keys[1], $rules));
            }

            return $schema->items($items);
        } else {
            $schema = $schema->type(Schema::TYPE_OBJECT);

            if (!isset($keys[1])) {
                dd($keys);
            }

            return $this->pushSchema($schema, $this->createSchema($keys[1], $rules));
        }
    }

    function parseKeys(string $key): array
    {
        if ($this->isArrayDetail($key)) {
            $keys = explode('*', $key);
            $keys = array_map(function ($key) {
                return str_replace('.', '', $key);
            }, $keys);
        } else {
            $keys = explode('.', $key);
        }

        return array_filter($keys, function ($key) { return !empty($key); });
    }

    private function pushSchema(Schema $schema, Schema $property)
    {
        $properties = $schema->properties;
        $properties[] = $property;
        return $schema->properties(...$properties);
    }

    /**
     * @return RequestBody
     */
    public function build(): RequestBody
    {
        return RequestBody::create()
            ->content(
                MediaType::json()->schema($this->schema)
            );
    }

    /**
     * @param array $rules
     * @return array
     */
    protected function prepareRules(array $rules): array
    {
        return array_map(function ($rule) {
            return $rule;
        }, $rules);
    }
}
