<?php

namespace App\Http\Repositories\Quiz;

interface QuizInterface
{
    public function models($request);
    public function create($request);
    public function changeStatus($id);
    public function read($id);
    public function unread($id);
}