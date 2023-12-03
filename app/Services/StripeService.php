<?php
namespace App\Services;

use App\Repositories\AppointmentRepository;
use Stripe\StripeClient;

class StripeService{

    private $stripeClient;

    public function __construct(){
        $this->stripeClient = app()->make(StripeClient::class);
    }

    public function createAccount($data){
        $this->stripeClient->accounts->create(['type' => 'express']);
        $account = $this->stripeClient->accounts->create([
            'type' => 'express',
            'country' => 'US',
            'email' => $data['email'],
            'capabilities' => [
              'card_payments' => ['requested' => true],
              'transfers' => ['requested' => true],
            ],
          ]
        );

        // $id = 'acct_1OJC5aGaKIsIGCFE';

        $accountLink = $this->stripeClient->accountLinks->create([
            'account' => $account->id,
            'refresh_url' => url('/'), //'https://example.com/reauth',
            'return_url' => url('/'), //'https://example.com/return',
            'type' => 'account_onboarding',
        ]);

        $data = [
            'account_id' => $account->id,
            'url' => $accountLink->url,
        ];

        return $data;
    }

    public function createProduct($data){
        $product = $this->stripeClient->products->create([
            'name' => 'Doctor Appointment Fee',
            'default_price_data' => [
              'unit_amount' => $data['doctor_fee_amount'] * 100,
              'currency' => 'usd',
            ],
            'expand' => ['default_price'],
        ]);

        return $product;
    }

    public function makePayment($appointment){
        $checkout = $this->stripeClient->checkout->sessions->create(
            [
                'mode' => 'payment',
                'line_items' => [
                [
                    'price' => $appointment->doctor->stripe_price_id,
                    'quantity' => 1,
                ],
                ],
                'payment_intent_data' => [
                    'application_fee_amount' => $appointment->admin_fee_amount * 100,
                    'transfer_data' => [
                        'destination' => $appointment->doctor->stripe_account_id 
                    ],
                ],
                'success_url' => url('/'),
                'cancel_url' => url('/'),
            ]
        );

        return $checkout->url;
    }
    
}