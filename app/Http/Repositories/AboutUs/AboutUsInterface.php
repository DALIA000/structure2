<?php

namespace App\Http\Repositories\AboutUs;

interface AboutUsInterface
{
    public function about($request);
    public function why($request);
    public function benefits($request);
    public function edit($request, $id);
}
