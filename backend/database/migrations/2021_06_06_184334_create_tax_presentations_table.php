<?php

use App\Modules\Tax\Models\TaxPeriod;
use App\Modules\Tax\Presentation\Models\PaymentMethodType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxPresentationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_presentations', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(TaxPeriod::class)->constrained();
            $table->unsignedInteger('amount');
            $table->foreignIdFor(\App\Modules\File\Models\File::class, 'draft_id')->constrained('files');
            $table->foreignIdFor(\App\Modules\File\Models\File::class, 'voucher_id')->nullable()->constrained('files');
            $table->enum('payment_method', PaymentMethodType::getValues())->nullable();
            $table->timestamp('voucher_expiration_date')->nullable();
            $table->unsignedInteger('balance');
            $table->text('comment')->nullable();
            $table->unsignedInteger('used_balance')->default(0);
            $table->timestamp('voucher_generation_date')->nullable();
            $table->foreignIdFor(\App\Modules\File\Models\File::class, 'presentation_id')->nullable()->constrained('files');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_presentations');
    }
}
