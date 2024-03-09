<?php

namespace App\Http\Repositories\Service;

interface ServiceInterface{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
}
