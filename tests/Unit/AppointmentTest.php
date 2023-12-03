<?php

namespace Tests\Unit;

use App\Models\User;
use App\Repositories\UserRepository;
use Tests\TestCase;

class AppointmentTest extends TestCase
{
    protected static $token;

    /**
     * Setup Resources for Tests
     */
    public function setUp(): void
    {
        parent::setUp();
        $user = User::factory()->create();
        self::$token = $user->createToken('Payment-app')->plainTextToken;
    }

    /**
     * Task Store Test.
     */
    public function test_book_appointment(): void
    {
        $userRepo = new UserRepository();
        $doctor = $userRepo->getFirstDoctor();
        $appointment = [
            "booking_time" => now()->format('Y-m-d H:i:m'),
            "doctor_id" => $doctor->id,
        ];

        $response = $this->withHeader('Authorization', 'Bearer ' . self::$token)->postJson(route('appointments.store'), $appointment);
 
        $response->assertStatus(200);
    }
}
