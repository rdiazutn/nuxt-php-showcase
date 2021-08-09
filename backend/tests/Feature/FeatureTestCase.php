<?php


namespace Tests\Feature;


use App\Models\Customer;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Nuwave\Lighthouse\Testing\MakesGraphQLRequests;
use Tests\TestCase;

abstract class FeatureTestCase extends TestCase
{
    use MakesGraphQLRequests;

    protected function setUp(): void
    {
        parent::setUp();
        $this->migrate();
    }

    private function migrate()
    {
        $this->artisan('migrate:fresh');
    }

    /**
     * @param string $query
     * @param array $variables
     * @param array $extraParams
     * @return TestResponse
     */
    protected function graphQlQuery(string $query, array $variables = [], array $extraParams = []): TestResponse
    {
        if (file_exists($path = base_path('../graphql/' . $query . '.graphql'))) {
            $query = file_get_contents($path);
        }
        return $this->graphQL($query, $variables, $extraParams);
    }

    public function getCustomer(): Customer
    {
        return Customer::first();
    }

    public function actingAsCustomer(): FeatureTestCase
    {
        return $this->actingAs($this->getCustomer());
    }
}
