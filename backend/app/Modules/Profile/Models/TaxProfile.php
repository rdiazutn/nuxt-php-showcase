<?php


namespace App\Modules\Profile\Models;


use App\Models\Customer;
use Illuminate\Support\Collection;
use Laravel\Nova\Makeable;

class TaxProfile
{
    use Makeable;

    protected Customer $customer;

    /**
     * TaxProfile constructor.
     * @param Customer $customer
     */
    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    /**
     * @param int $id
     * @param string|null $key
     * @return mixed
     */
    protected function getAnswer(int $id, string $key = null)
    {
        /**
         * @var CustomerProfileQuestion $answer
         */
        $answer = $this->customer->profileQuestions->firstWhere('profile_question_id', $id);
        return $answer->getAnswer($key);
    }

    /**
     * @return Collection
     */
    public function getActivities(): Collection
    {
        return collect($this->getAnswer(3, 'selected'));
    }

    /**
     * @return Collection
     */
    public function getRegions(): Collection
    {
        return collect($this->getAnswer(2));
    }
}
