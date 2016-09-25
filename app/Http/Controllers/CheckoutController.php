<?php

namespace Delivery\Http\Controllers;


use Delivery\Http\Requests\CheckoutRequest;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
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
        $clientId = $this->userRepository->find(Auth::user())->client->id;

        dd($clientId);
        $orders = $this->orderRepository->scopeQuery(function($query) use ($clientId) {
           return $query->where('client_id', '=', $clientId);
        })->paginate();
        return view('index', compact('orders'));
    }

    public function create(){

        $products = $this->productRepository->all();
        return view('customer.orders.create', compact('products'));
    }

    public function edit($id){
        $cat    =   $this->repository->find($id);

        return view('admin.cupoms.edit', compact('cat'));
    }


    public function store(CheckoutRequest $request){
        //dd($request->all());

        $data = $request->all();
        $clientId = $this->userRepository->find(Auth::user()->id)->client->id;
        $data['client_id'] = $clientId;
        $this->service->create($data);
        return redirect()->route('cupoms.orders.index');

    }

    public function update(AdminCupomRequest $request, $id){
        //dd($request->all());

        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('index');

    }

}
