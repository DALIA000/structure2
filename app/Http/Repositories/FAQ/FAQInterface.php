<?php

namespace App\Http\Repositories\FAQ;

interface FAQInterface
{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
}