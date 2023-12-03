<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository {

    public function getAllRoles(){
        return Role::where('name', '<>', 'admin')->get();
    }

    public function getRoleById($id){
        return Role::find($id);
    }

}