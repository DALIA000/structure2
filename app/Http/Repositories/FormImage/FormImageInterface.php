<?php

namespace App\Http\Repositories\FormImage;

interface FormImageInterface{
    public function expert($request);
    public function updateExpert($request);
    public function list($request);
    public function updateList($request);
}
