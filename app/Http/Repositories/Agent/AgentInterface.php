<?php

namespace App\Http\Repositories\Agent;

interface AgentInterface
{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
    public function addClick($slug);

}
