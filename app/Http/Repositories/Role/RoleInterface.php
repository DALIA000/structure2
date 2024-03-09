<?php
namespace App\Http\Repositories\Role;

use App\Http\Repositories\Base\BaseInterface;

interface RoleInterface extends BaseInterface{
        public function models($request);
        public function create($request);
        public function edit($request, $id);
        public function delete($id);
}
