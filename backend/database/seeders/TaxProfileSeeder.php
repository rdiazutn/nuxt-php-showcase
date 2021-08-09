<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Tax\Models\Tax;
use Database\Factories\Modules\Profile\Models\CustomerProfileQuestionFactory;
use Illuminate\Database\Seeder;

class TaxProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Customer::all() as $customer)
        {
            $this->seedIIBBProfile($customer);
        }
    }

    private function seedIIBBProfile(Customer $customer)
    {
        $customer->taxes->each(fn (Tax $tax) =>
            $tax->profileQuestions->each(fn (ProfileQuestion $question) =>
                CustomerProfileQuestionFactory::new()
                    ->for($customer)
                    ->answering($question)
                    ->create()
            )
        );
    }
}
