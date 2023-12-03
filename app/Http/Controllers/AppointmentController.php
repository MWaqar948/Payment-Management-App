<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Repositories\AppointmentRepository;
use App\Http\Requests\AppointmentStoreRequest;
use App\Repositories\UserRepository;
use App\Services\StripeService;

class AppointmentController extends Controller
{
    public $appointmentRepository;
    public $stripeService;
    public $userRepository;

    public function __construct(AppointmentRepository $appointmentRepository = null, StripeService $stripeService, UserRepository $userRepository) {
        $this->appointmentRepository = $appointmentRepository;
        $this->stripeService = $stripeService;
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $params = [
            'doctor_id' => auth()->id()
        ];

        // Fetch Data        
        $appointments = $this->appointmentRepository->getAppointmentsByDoctor($params);

        $payload = [
            'appointments' => $appointments,
        ];

        return response()->success($payload);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AppointmentStoreRequest $request)
    {
        $validatedData =  $request->validated();

        $doctor = $this->userRepository->getUserById($validatedData['doctor_id']);

        $defaultData = [
            'client_id' => auth()->id(),
            'doctor_fee_amount' => $doctor?->doctor_fee_amount,
        ];

        $combinedData = array_merge($defaultData, $validatedData);

        $appointment = $this->appointmentRepository->save($combinedData);

        $checkout_url = $this->stripeService->makePayment($appointment);

        $payload = [
            'appointment' => $appointment,
            'url' => $checkout_url
        ];

        return response()->success($payload);
    }
}
