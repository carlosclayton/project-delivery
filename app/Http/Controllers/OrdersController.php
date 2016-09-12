<?php

namespace Delivery\Http\Controllers;


use Delivery\Http\Requests\AdminOrderRequest;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\UserRepository;

class OrdersController extends Controller
{
    private $repository;
    private $userRepository;

    public function __construct(OrderRepository $repository, UserRepository $userRepository){
        $this->repository = $repository;
        $this->userRepository = $userRepository;
    }

    public function index(){
        $orders = $this->repository->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function create(){
        return view('admin.orders.create');
    }

    public function edit($id){
        $order    =   $this->repository->find($id);
        $list_status = [0=> 'Pendente', 1 => 'A caminho', 2=> 'Entregue'];
        $deliveryman = $this->userRepository->getDeliverymen();
        return view('admin.orders.edit', compact('order', 'list_status', 'deliveryman'));
    }


    public function store(AdminClientRequest $request){
        //dd($request->all());

        $data = $request->all();
        $this->repository->create($data);
        return redirect()->route('index');

    }

    public function update(AdminOrderRequest $request, $id){
        //dd($request->all());

        $data = $request->all();
        $this->repository->update($data, $id);
        return redirect()->route('index');

    }

    public function destroy($id){
        $this->repository->delete($id);
        return redirect()->route('index');

    }

}
