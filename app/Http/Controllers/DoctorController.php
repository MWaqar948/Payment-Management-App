<?php

namespace App\Http\Controllers;

use App\Http\Requests\DoctorIndexRequest;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public $userRepository;

    public function __construct(UserRepository $userRepository = null) {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch Data        
        $doctors = $this->userRepository->getDoctors();

        $payload = [
            'doctors' => $doctors,
        ];

        return response()->success($payload);
        
    }
}
