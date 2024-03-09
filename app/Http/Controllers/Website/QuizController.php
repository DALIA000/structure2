<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Quiz\QuizInterface;
use App\Http\Requests\QuizRequest;
use App\Services\ResponseService;

class QuizController extends Controller
{
    public function __construct(private QuizInterface $quizI, private ResponseService $responseService)
    {
        $this->quizI = $quizI;
    }

    public function create(QuizRequest $request)
    {
        $data = $this->quizI->create($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
