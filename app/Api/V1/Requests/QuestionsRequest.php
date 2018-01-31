<?php

namespace App\Api\V1\Requests;

use Config;
use Dingo\Api\Http\FormRequest;

class QuestionsRequest extends FormRequest
{
    public function rules()
    {
        return Config::get('boilerplate.questions.validation_rules');
    }

    public function authorize()
    {
        return true;
    }
}
