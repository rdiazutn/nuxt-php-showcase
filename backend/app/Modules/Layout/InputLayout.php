<?php


namespace App\Modules\Layout;


use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;
use Laravel\Nova\Makeable;

class InputLayout
{
    use Makeable;

    public string $key;
    public string $label;
    public ?string $value;

    /**
     * InputLayout constructor.
     * @param string $key
     * @param string $label
     * @param string|null $value
     */
    public function __construct(string $key, string $label, ?string $value)
    {
        $this->key = $key;
        $this->label = $label;
        $this->value = $value;
    }

    /**
     * @param array|Collection $values
     * @param array $data
     * @return Collection
     */
    public static function fromArray($values, array $data): Collection
    {
        return collect($values)
            ->map(fn ($label, $key) =>
                self::make($key, $label, $data[$key]['value'] ?? null)
            );
    }

    /**
     * @param string|Enum $class
     * @param array $data
     * @return Collection
     */
    public static function fromEnum(string $class, array $data): Collection
    {
        return self::fromArray($class::asSelectArray(), $data);
    }
}
