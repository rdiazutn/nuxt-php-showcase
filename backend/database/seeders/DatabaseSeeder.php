<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use App\Modules\Tax\Models\Tax;
use App\Modules\Tax\Models\TaxPeriod;
use Database\Factories\Modules\Tax\TaxPresentationFactory;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create(['email' => 'example@example.com']);
        $customer = Customer::factory()->create(['email' => 'customer@example.com']);
        $this->call(NotificationSeeder::class);
        $this->call(PermissionSeeder::class);
        $customer->assignRole(Role::findByName('customer', 'sanctum'));
        $this->call(TaxSeeder::class);
        $this->call(TaxSeeder::class);
        foreach (Tax::all() as $tax)
        {
            $customer->taxes()->attach($tax, ['expires_at' => now()->addMonth()]);
            TaxPeriod::factory()
                ->for($customer)
                ->for($tax)
                ->has(TaxPresentationFactory::new(), 'presentations')
                ->create();
            TaxPeriod::factory()
                ->for($customer)
                ->for($tax)
                ->create([
                    'period_date' => now()->subMonth()
                ]);
        }
    }
}
