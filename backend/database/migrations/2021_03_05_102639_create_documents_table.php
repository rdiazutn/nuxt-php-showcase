<?php

use App\Modules\Document\Models\DocumentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('description');
            $table->enum('status', DocumentStatus::getValues());
            $table->foreignIdFor(\App\Modules\Tax\Models\TaxPeriod::class)->constrained();
            $table->foreignIdFor(\App\Modules\File\Models\File::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('documents');
    }
}
