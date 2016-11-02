<?php

namespace Delivery\Http\Middleware;

use Closure;
use Delivery\Repositories\UserRepository;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class Oauth2CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    private $userRepository;
    public function __construct(UserRepository $userRepository){
        $this->userRepository = $userRepository;
    }

    public function handle($request, Closure $next, $role)
    {

        $id = Authorizer::getResourceOwnerId();
        $user = $this->userRepository->skipPresenter(true)->find($id);

        if($user->role != $role){
            abort(403, 'Access Forbidden');
        }

        return $next($request);
    }
}
