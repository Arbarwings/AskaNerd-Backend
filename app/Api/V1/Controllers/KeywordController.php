<?php

namespace App\Api\V1\Controllers;

use App\Http\Controllers\Controller;
use App\Api\V1\Requests\KeywordsRequest;
use App\Keyword;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class KeywordController extends Controller
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
        return response()->json(Keyword::where('nerd_id', $this->currentUser->id)->get());
    }

    public function store(KeywordsRequest $request)
    {
        $keyword = new Keyword();
        $keyword->value = $request['value'];
        $keyword->nerd_id = $this->currentUser->id;
        if(!$keyword->save()) {
            return response()->json([
                'error' => [
                    'message' => 'Cannot create keyword',
                    'status_code' => 500
                ]
            ], 500);
        }

        return response()->json([
            'status' => 'ok'
        ], 201);
    }

    public function show($keyword)
    {
        $keyword = Keyword::where('id', $keyword)->get();
        if(!$keyword) {
            throw new NotFoundHttpException;
        }

        return response()->json($keyword);
    }

    public function update($keywordID, KeywordsRequest $request)
    {
        $keyword = Keyword::where('id', $keywordID)->get();
        if(!$keyword) {
            throw new NotFoundHttpException;
        }

        Keyword::where('id', $keywordID)->update(['value' => $request['value']]);

        return response()->json([
            'status' => 'ok'
        ], 201);
    }

    public function destroy($keywordID)
    {
        $keyword = Keyword::where('id', $keywordID)->get();
        if(!$keyword) {
            throw new NotFoundHttpException;
        }

        Keyword::where('id', $keywordID)->delete();

        return response()->json([
            'status' => 'ok'
        ], 201);
    }

}
