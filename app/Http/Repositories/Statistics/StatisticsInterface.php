<?php

namespace App\Http\Repositories\Statistics;

interface StatisticsInterface{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
    public function header($request);
    public function header_edit($request);
    public function cards($request);
    public function card($request, $id);
    public function card_edit($request, $id);
}
