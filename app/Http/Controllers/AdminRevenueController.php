<?php

namespace App\Http\Controllers;

use App\Repositories\AppointmentRepository;
use Illuminate\Http\Request;

class AdminRevenueController extends Controller
{
    public $appointmentRepository;

    public function __construct(AppointmentRepository $appointmentRepository = null) {
        $this->appointmentRepository = $appointmentRepository;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        // Fetch Data        
        $total_revenue = $this->appointmentRepository->getAdminEarnings();

        $payload = [
            'revenue' => $total_revenue,
        ];

        return response()->success($payload);
    }
}
