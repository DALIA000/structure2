<?php

namespace App\Http\Repositories\Availability;

interface AvailabilityInterface
{
    public function models($request);
    public function create($request);

}