<?php

namespace App\Http\Repositories\Developer;

interface DeveloperInterface{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
}
