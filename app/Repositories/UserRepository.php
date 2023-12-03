<?php

namespace App\Repositories;

use App\Models\Role;
use App\Models\User;

class UserRepository {

    public function save($data){

        return User::create($data);
    
    }

    public function getDoctors(){
       
        return User::select('id', 'name')->whereHas('role', function($query){
            $query->where('name', 'doctor');
       })->get();

    }

    public function getUserById($id){

        return User::roleName()->where('id', $id)->first();
    
    }
    
    public function getFirstDoctor(){
       
        return User::select('id',)->whereHas('role', function($query){
            $query->where('name', 'doctor');
       })->first();

    }

}