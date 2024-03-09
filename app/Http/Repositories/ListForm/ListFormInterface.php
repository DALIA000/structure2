<?php

namespace App\Http\Repositories\ListForm;

interface ListFormInterface
{
    public function models($request);
    public function create($request);
    public function changeStatus($id);
    public function read($id);
    public function unread($id);
}