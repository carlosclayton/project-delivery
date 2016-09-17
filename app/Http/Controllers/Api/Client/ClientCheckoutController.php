<?php

namespace Delivery\Http\Controllers\Api\Client;


use Delivery\Http\Controllers\Controller;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class ClientCheckoutController extends Controller
{
    private $userRepository;
    private $orderRepository;
    private $productRepository;
    private $service;

    public function __construct(OrderRepository $orderRepository, ProductRepository $productRepository, UserRepository $userRepository, OrderService $service){
        $this->userRepository = $userRepository;
        $this->productRepository = $productRepository;
        $this->orderRepository = $orderRepository;
        $this->service = $service;
    }

    public function index(){
        $id = Authorizer::getResourceOwnerId();
        $clientId = $this->userRepository->find($id)->client->id;
        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use ($clientId) {
           return $query->where('client_id', '=', $clientId);
        })->paginate();

        return $orders;
    }

    public function edit($id){
        $cat    =   $this->repository->find($id);

        return view('admin.cupoms.edit', compact('cat'));
    }


    public function store(Request $request){
        //dd($request->all());
        $id = Authorizer::getResourceOwnerId();
        $data = $request->all();
        $clientId = $this->userRepository->find($id)->client->id;
        $data['client_id'] = $clientId;
        $ret = $this->service->create($data);
        $ret = $this->orderRepository->with('items')->find($ret->id);
        return $ret;

    }

    public function update(Request $request, $id){
        //dd($request->all());

        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('index');

    }

    public function show($id){
        $order = $this->orderRepository->with('items', 'client', 'cupom')->find($id);
        $order->items->each(function($item){
           $item->product;
        });
        return $order;


    }

}
