<?php

namespace App\Http\Repositories\Type;

interface TypeInterface{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
}
