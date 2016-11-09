<?php

namespace Delivery\Http\Controllers\Api;

use Delivery\Http\Controllers\Controller;

use Delivery\Repositories\UserRepository;

use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    private $userRepository;
    /**
     * Create a new password controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticated(){
        $id = Authorizer::getResourceOwnerId();
        return $this->userRepository->skipPresenter(false)->find($id);
    }

    public function updateDeviceToken(Request $request){
        $id = Authorizer::getResourceOwnerId();
        $device_token = $request->get('device_token');
        //dd($device_token);
        return $this->userRepository->skipPresenter(false)->updateDeviceToken($id, $device_token );

    }
}
