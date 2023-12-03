<?php

namespace App\Http\Controllers;

use Stripe\StripeClient;
use Illuminate\Http\Request;
use App\Services\StripeService;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use App\Http\Requests\AuthRegisterRequest;

class AuthController extends Controller
{
    public $userRepository;
    public $stripService;
    public $roleRepository;

    public function __construct(UserRepository $userRepository = null,  StripeService $stripService, RoleRepository $roleRepository /*, StripeClient $stripeClient */) {
        $this->userRepository = $userRepository;
        $this->stripService = $stripService;
        $this->roleRepository = $roleRepository;
    }
    
    /**
     * Registers a new user
     */
    public function register(AuthRegisterRequest $request){
        $validatedData =  $request->validated();

        $role = $this->roleRepository->getRoleById($validatedData['role_id']);

        if($role->name === 'doctor'){
            //create stripe account for doctor
            $account = $this->stripService->createAccount($validatedData);
            $validatedData['stripe_account_id'] = $account['account_id'];

            $product = $this->stripService->createProduct($validatedData);
            $validatedData['stripe_price_id'] = $product?->default_price?->id;
        }

        $user = $this->userRepository->save($validatedData);

        $user = $this->userRepository->getUserById($user->id);
        $token = $user->createToken('Payment-app')->plainTextToken;

        $payload = [
            'user' => $user, 
            'token' => $token
        ];

        if(isset($account['url'])){
            $payload['url'] = $account['url'];
        }

        return response()->success($payload);
    }

    /**
     * Login an existing user
     */
    public function login(Request $request){
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!auth()->attempt($data)) {
            return response()->unauthorized();
        }

        $user = $this->userRepository->getUserById(auth()->id());

        $token = $user->createToken('Payment-app')->plainTextToken;

        $payload = [
            'user' => $user, 
            'token' => $token
        ];

        return response()->success($payload);
    }

    /**
     * Logout a user
     */
    public function logout(Request $request){
       
        auth()->user()->tokens()->delete();
        return response()->logout();
    }
}
