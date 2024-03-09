<?php

namespace App\Http\Repositories\Community;

interface CommunityInterface{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
}
