<?php
/**
 * Created by PhpStorm.
 * User: Clayton
 * Date: 24/08/2016
 * Time: 19:11
 */

namespace Delivery\Services;

use Delivery\Repositories\ClientRepository;
use Delivery\Repositories\UserRepository;

class ClientService{

    private $clientRepository;
    private $userRepository;

    public function __construct(ClientRepository $clientRepository, UserRepository $userRepository){
        $this->clientRepository = $clientRepository;
        $this->userRepository = $userRepository;
    }

    public function update(array $data, $id){
        $this->clientRepository->update($data, $id);
        $userId = $this->clientRepository->find($id, ['user_id'])->user_id;
        $this->userRepository->update($data['user'], $userId);
    }

    public function create(array $data){
        $data['user']['password'] = bcrypt(123456);
        $user = $this->userRepository->create($data['user']);
        $data['user_id'] = $user->id;
        $this->clientRepository->create($data);


    }

}
