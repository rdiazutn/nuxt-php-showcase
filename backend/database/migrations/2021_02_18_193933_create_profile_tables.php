<?php

use App\Models\Customer;
use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Profile\Models\ProfileQuestionType;
use App\Modules\Profile\Models\ProfileStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfileTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('title');
            $table->longText('body');
            $table->string('image');
            $table->integer('order')->default(0);
            $table->enum('type', ProfileQuestionType::getValues());
            $table->json('data')->nullable();
        });

        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->enum('status', ProfileStatus::getValues());
            $table->foreignIdFor(Customer::class)->constrained();
        });

        Schema::create('customer_profile_questions', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->json('answer')->nullable();
            $table->softDeletes();
            $table->foreignIdFor(Customer::class)->constrained();
            $table->foreignIdFor(ProfileQuestion::class)->constrained();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_profile_questions');
        Schema::dropIfExists('profiles');
        Schema::dropIfExists('profile_questions');
    }
}
