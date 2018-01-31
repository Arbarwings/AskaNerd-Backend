<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\QuestionsRequest;
use App\Http\Controllers\Controller;
use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class QuestionController extends Controller
{
    private $currentUser;
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', []);
        $this->currentUser = Auth::guard()->user();
    }

    public function index()
    {
        return response()->json(Question::where('user_id', $this->currentUser->id)->get());
    }

    public function store(QuestionsRequest $request)
    {
        $question = new Question();
        $question->value = $request['value'];
        $question->compensation = $request['compensation'];
        $question->user_id = $this->currentUser->id;
        if(!$question->save()) {
            return response()->json([
                'error' => [
                    'message' => 'Cannot create question',
                    'status_code' => 500
                ]
            ], 500);
        }

        return response()->json([
            'status' => 'ok'
        ], 201);
    }

    public function show($question)
    {
        $question = Question::where('id', $question)->get();
        if(!$question) {
            throw new NotFoundHttpException;
        }

        return response()->json($question);
    }

    public function update($questionID, QuestionsRequest $request)
    {
        $question = Question::where('id', $questionID)->get();
        if(!$question) {
            throw new NotFoundHttpException;
        }

        Question::where('id', $questionID)->update(['value' => $request['value'], ['compensation' => $request['compensation']]]);

        return response()->json([
            'status' => 'ok'
        ], 201);
    }

    public function destroy($questionID)
    {
        $question = Question::where('id', $questionID)->get();
        if(!$question) {
            throw new NotFoundHttpException;
        }

        Question::where('id', $questionID)->delete();

        return response()->json([
            'status' => 'ok'
        ], 201);
    }
}
