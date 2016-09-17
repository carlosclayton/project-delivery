<?php
/**
 * Created by PhpStorm.
 * User: Clayton
 * Date: 16/09/2016
 * Time: 09:27
 */

namespace Delivery\OAuth2;


use Illuminate\Support\Facades\Auth;

class Verifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}