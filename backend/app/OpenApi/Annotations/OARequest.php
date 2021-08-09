<?php


namespace App\OpenApi\Annotations;


use App\OpenApi\RequestBodies\RequestBodyFromRulesFactory;
use Vyuldashev\LaravelOpenApi\Annotations\RequestBody;
use InvalidArgumentException;

/**
 * @Annotation
 *
 * @Target({"METHOD"})
 */
class OARequest extends RequestBody
{
    public $factory;

    /**
     * @Required()
     */
    public string $request;

    public function __construct($values)
    {
        $request = $values['request'];
        $requestClass = class_exists($request) ? $request : app()->getNamespace().'Http\\Requests\\'.$request;

        $request = new $requestClass();

        if(!method_exists($request, 'rules'))
            throw new InvalidArgumentException("rules method not found at request (class $requestClass)");

        $rules = $request->rules();
        $example = method_exists($request, 'example')? $request->example() : null;
        $bindKey = 'requestBodyFactory'.$requestClass;

        app()->bind($bindKey, function () use ($rules, $example) {
            return new RequestBodyFromRulesFactory($rules, $example);
        });

        $this->factory = $bindKey;
    }
}
