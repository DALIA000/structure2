<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Repositories\Quiz\QuizInterface;
use App\Http\Resources\Dashboard\QuizListResource;
use App\Http\Resources\Dashboard\QuizResource;
use App\Services\ResponseService;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function __construct(private QuizInterface $quizI, private ResponseService $responseService)
    {
        $this->quizI = $quizI;
    }

    public function models(Request $request)
    {
        if (!$request->exists('order') || $request->order == null) {
            $request->merge(['order' => 'desc']);
        }
        if (!$request->exists('sort') || $request->sort == null) {
            $request->merge(['sort' => 'updated_at']);
        }
        $data = $this->quizI->models($request);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        $data = QuizListResource::collection($data['data']);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function find(Request $request, $id)
    {
        $data = $this->quizI->findById($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['errors' => [trans('messages.error')]]);
        }
        $data = new QuizResource($data);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function changeStatus($id)
    {
        $data = $this->quizI->changeStatus($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function read($id)
    {
        $data = $this->quizI->read($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function unread($id)
    {
        $data = $this->quizI->unread($id);
        return $this->responseService->json('Success!', $data, 200);
    }

    public function delete($id)
    {
        $data = $this->quizI->delete($id);
        if (!$data) {
            return $this->responseService->json('Fail!', [], 400, ['error' => [trans('messages.error')]]);
        }
        if (!$data['status']) {
            return $this->responseService->json('Fail!', [], 400, $data['errors']);
        }
        return $this->responseService->json('Success!', [], 200);
    }
}
