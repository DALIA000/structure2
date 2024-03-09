<?php

namespace App\Http\Repositories\Blog;

interface BlogInterface
{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
    public function addView($slug);
    public function like($slug);
    public function unlike($slug);
}