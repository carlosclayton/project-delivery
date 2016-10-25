<?php

namespace Delivery\Http\Controllers\Api\Client;


use Delivery\Http\Controllers\Controller;
use Delivery\Http\Requests\CheckoutRequest;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Http\Request;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class ClientCheckoutController extends Controller
{
    private $userRepository;
    private $orderRepository;
    private $productRepository;
    private $service;
    private $with = ['client', 'cupom', 'items'];

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, UserRepository $userRepository, OrderService $service){
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->service = $service;
    }

    public function index(){
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository->skipPresenter(false)
        ->with($this->with)->scopeQuery(function($query) use ($clientId) {
           return $query->where('client_id', '=', $clientId);
        })->paginate();

        return $orders;
    }


    public function store(CheckoutRequest $request){
        //dd($request->all());
        $id = Authorizer::getResourceOwnerId();
        $data = $request->all();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $ret = $this->service->create($data);
        return $this->orderRepository->skipPresenter(false)
            ->with($this->with)->find($ret->id);

    }


    public function show($id){
        //$order = $this->orderRepository->skipPresenter()->with(['items','client','cupom'])->find($id);


        return $this->orderRepository->skipPresenter(false)
        ->with($this->with)->find($id);


    }

}
