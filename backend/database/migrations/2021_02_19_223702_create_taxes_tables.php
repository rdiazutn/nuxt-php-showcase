<?php

use App\Modules\Tax\Models\TaxStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('taxes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name');
            $table->string('short_name');
            $table->enum('period_type', \App\Modules\Tax\Models\TaxPeriodType::getValues());
        });

        Schema::create('tax_periods', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('status', \App\Modules\Tax\Models\TaxPeriodStatus::getValues());
            $table->date('period_date');
            $table->foreignIdFor(\App\Modules\Tax\Models\Tax::class)->constrained();
            $table->foreignIdFor(\App\Models\Customer::class)->constrained();
            $table->json('data')->nullable();
        });

        Schema::create('customer_tax', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();
            $table->foreignIdFor(\App\Models\Customer::class)->constrained();
            $table->foreignIdFor(\App\Modules\Tax\Models\Tax::class)->constrained();
            $table->enum('status', TaxStatus::getValues());
            $table->date('expires_at')->nullable();
        });

        Schema::create('profile_question_tax', function (Blueprint $table) {
             $table->id();
             $table->foreignIdFor(\App\Modules\Profile\Models\ProfileQuestion::class)->constrained();
             $table->foreignIdFor(\App\Modules\Tax\Models\Tax::class)->constrained();
         });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */

    public function down()
    {
        Schema::dropIfExists('profile_question_tax');
        Schema::dropIfExists('tax_customer');
        Schema::dropIfExists('tax_periods');
        Schema::dropIfExists('taxes');
    }
}
