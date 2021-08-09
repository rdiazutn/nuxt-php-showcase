<?php


namespace App\Modules\Profile\Contract;


use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Profile\Models\CustomerProfileQuestion;

interface ProfileServiceInterface
{
    /**
     * @param ProfileQuestion $question
     * @param array $data
     * @return CustomerProfileQuestion
     */
    public function setUserAnswer(ProfileQuestion $question, array $data): CustomerProfileQuestion;
}
