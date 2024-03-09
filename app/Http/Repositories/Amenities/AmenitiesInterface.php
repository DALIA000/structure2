<?php

namespace App\Http\Repositories\Amenities;

interface AmenitiesInterface{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
}
