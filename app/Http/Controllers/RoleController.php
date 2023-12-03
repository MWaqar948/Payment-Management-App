<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public $roleRepository;

    public function __construct(RoleRepository $roleRepository = null) {
        $this->roleRepository = $roleRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = $this->roleRepository->getAllRoles();
        
        $payload = [
            'roles' => $roles
        ];

        return response()->success($payload);
    }

}
