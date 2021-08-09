<?php

namespace App\Providers;

use App\Modules\IIBB\Models\CustomerCondition;
use App\Modules\Profile\Models\InputType;
use App\Modules\Profile\Models\ProfileQuestionType;
use App\Modules\Profile\Models\ProfileStatus;
use App\Modules\Profile\Models\QuestionRule;
use App\Modules\Tax\Presentation\Models\PaymentMethodType;
use App\Modules\Tax\Models\TaxPeriodStatus;
use App\Modules\Tax\Models\TaxPeriodType;
use App\Modules\Tax\Models\TaxStatus;
use Illuminate\Support\ServiceProvider;
use Nuwave\Lighthouse\Schema\TypeRegistry;
use Nuwave\Lighthouse\Schema\Types\LaravelEnumType;

class GraphQLServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Nuwave\Lighthouse\Exceptions\DefinitionException
     */
    public function boot(TypeRegistry $typeRegistry)
    {
        collect([
            ProfileStatus::class,
            ProfileQuestionType::class,
            TaxPeriodType::class,
            TaxPeriodStatus::class,
            InputType::class,
            QuestionRule::class,
            TaxStatus::class,
            PaymentMethodType::class,
            CustomerCondition::class,
        ])->each(fn ($class) => $typeRegistry->register(new LaravelEnumType($class)));
    }
}
