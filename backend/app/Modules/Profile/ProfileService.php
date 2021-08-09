<?php


namespace App\Modules\Profile;


use App\Modules\Profile\Contract\ProfileServiceInterface;
use App\Modules\Profile\Models\ProfileQuestion;
use App\Modules\Profile\Models\CustomerProfileQuestion;
use Illuminate\Support\Facades\Auth;

class ProfileService implements ProfileServiceInterface
{

    /**
     * @param ProfileQuestion $question
     * @param array $data
     * @return CustomerProfileQuestion
     * @noinspection PhpIncompatibleReturnTypeInspection
     */
    public function setUserAnswer(ProfileQuestion $question, array $data): CustomerProfileQuestion
    {
        $question->userAnswers()->delete();
        return $question->answers()->create([
            'data' => $data,
            'user_id' => Auth::user()->getAuthIdentifier()
        ]);
    }
}
