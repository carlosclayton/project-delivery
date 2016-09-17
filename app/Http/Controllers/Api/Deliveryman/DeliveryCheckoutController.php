<?php

namespace Delivery\Http\Controllers\Api\Deliveryman;


use Delivery\Http\Controllers\Controller;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class DeliveryCheckoutController extends Controller
{
    private $orderRepository;
    private $userRepository;
    private $service;

    public function __construct(OrderRepository $orderRepository,  UserRepository $userRepository, OrderService $service){
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->service = $service;
    }

    public function index(){
        $id = Authorizer::getResourceOwnerId();
        $orders = $this->orderRepository->with(['items'])->scopeQuery(function($query) use ($id) {
           return $query->where('user_deliveryman_id', '=', $id);
        })->paginate();

        return $orders;
    }

    public function edit($id){
        $cat    =   $this->repository->find($id);

        return view('admin.cupoms.edit', compact('cat'));
    }

    public function updateStatus(Request $request, $id ){
        $deliverymanid = Authorizer::getResourceOwnerId();
        $order = $this->service->updateStatus($id, $deliverymanid, $request->get('status'));
        if($order){
            return $order;
        }
        abort(400,'Order not found');

    }

    public function show($id){
        $deliverymanid = Authorizer::getResourceOwnerId();
        return $this->orderRepository->getDeliverymanById($id, $deliverymanid);
    }

}
