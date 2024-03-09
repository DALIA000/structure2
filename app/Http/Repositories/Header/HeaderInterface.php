<?php

namespace App\Http\Repositories\Header;

interface HeaderInterface
{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
}
