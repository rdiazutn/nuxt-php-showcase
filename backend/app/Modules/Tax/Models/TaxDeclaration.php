<?php


namespace App\Modules\Tax\Models;


use App\Models\Model;
use App\Modules\Profile\Models\TaxProfile;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Laravel\Nova\Makeable;

abstract class TaxDeclaration extends \Illuminate\Database\Eloquent\Model
{
    use Makeable;

    protected TaxPeriod $period;

    /**
     * TaxDeclaration constructor.
     * @param TaxPeriod $period
     * @throws Exception
     */
    public function __construct(TaxPeriod $period)
    {
        parent::__construct([]);
        $this->period = $period;
        if ($this->period->customer->profileQuestions->isEmpty()) {
            throw new Exception("Uncompleted customer profile");
        }
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    protected function getValue(string $key, $default = null)
    {
        return data_get($this->period->data, $key, $default);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    protected function getPreviousPeriodValue(string $key, $default = null)
    {
        return collect(
            optional($this->period->previousPeriod)->data
        )->get($key, $default);
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed
     */
    protected function getOrPreviousValue(string $key, $default = null)
    {
        return $this->getValue(
            $key,
            $this->getPreviousPeriodValue($key, $default)
        );
    }

    protected function getProfile(): TaxProfile
    {
        return $this->period->customer->getProfile();
    }

    /**
     * @param array $data
     * @return $this
     */
    public function answer(array $data): self
    {
        $data = collect($data)->mapWithKeys(
            fn ($value, $key) => $this->mapKeys($key, $value)
        );
        $this->period->update(compact('data'));
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return array
     */
    private function mapKeys($key, $value): array
    {
        if (is_array($value)) {
            $key = $value['key'] ?? $key;
            $value = collect($value)->mapWithKeys(
                fn ($value, $key) => $this->mapKeys($key, $value)
            )->toArray();
        }
        return [$key => $value];
    }
}
