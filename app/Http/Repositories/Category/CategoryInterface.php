<?php

namespace App\Http\Repositories\Category;
use App\Http\Repositories\Base\BaseInterface;

interface CategoryInterface{
    public function models($request);
    public function edit($request, $id);
}
