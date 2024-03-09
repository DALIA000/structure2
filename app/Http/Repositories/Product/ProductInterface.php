<?php

namespace App\Http\Repositories\Product;

interface ProductInterface{
    public function models($request);
    public function create($request);
    public function edit($request, $id);
    public function createForm($request);
    public function getForm($request);
    public function findForm($request, $id);
    public function read($request, $id);
    public function unread($request, $id);
    public function delete($id);
}
