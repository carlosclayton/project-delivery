<?php

namespace Delivery\Http\Controllers\Api\Deliveryman;


use Delivery\Http\Controllers\Controller;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Http\Request;
use Delivery\Models\Geo;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use Delivery\Events\GetLocationDeliveryman;


class DeliveryCheckoutController extends Controller
{
    private $orderRepository;
    private $userRepository;
    private $service;
    private $with = ['client', 'cupom', 'items'];

    public function __construct(OrderRepository $orderRepository, UserRepository $userRepository, OrderService $service)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->service = $service;
    }

    public function index()
    {
        $id = Authorizer::getResourceOwnerId();
        $orders = $this->orderRepository->skipPresenter(false)
            ->with(['items'])->scopeQuery(function ($query) use ($id) {
                return $query->where('user_deliveryman_id', '=', $id);
            })->paginate();

        return $orders;
    }

    public function edit($id)
    {
        $cat = $this->repository->find($id);

        return view('admin.cupoms.edit', compact('cat'));
    }

    public function updateStatus(Request $request, $id)
    {
        $deliverymanid = Authorizer::getResourceOwnerId();
        return $this->service->updateStatus($id, $deliverymanid, $request->get('status'));
    }

    public function show($id)
    {
        $deliverymanid = Authorizer::getResourceOwnerId();
        return $this->orderRepository->skipPresenter(false)
            ->getDeliverymanById($id, $deliverymanid);
    }

    public function geo(Request $request, Geo $geo, $id)
    {
        $deliverymanid = Authorizer::getResourceOwnerId();
        $order =  $this->orderRepository->skipPresenter(true)
            ->getDeliverymanById($id, $deliverymanid);
        //return $request->get('lat');

        $geo->lat = $request->get('lat');
        $geo->long = $request->get('long');
        event(new GetLocationDeliveryman($geo,$order));
        return $geo;
    }

}
