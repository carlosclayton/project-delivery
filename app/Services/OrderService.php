<?php
/**
 * Created by PhpStorm.
 * User: Clayton
 * Date: 24/08/2016
 * Time: 19:11
 */

namespace Delivery\Services;


use Delivery\Models\Order;
use Delivery\Repositories\CupomRepository;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;

class OrderService{

    private $orderRepository;
    private $userRepository;
    private $productRepository;
    private $cupomRepository;

    public function __construct(OrderRepository $orderRepository, CupomRepository $cupomRepository, ProductRepository $productRepository){
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->cupomRepository = $cupomRepository;
    }

    public function update(array $data, $id){
        $this->orderRepository->update($data, $id);
        $userId = $this->orderRepository->find($id, ['user_id'])->user_id;
        $this->userRepository->update($data['user'], $userId);
    }

    public function updateStatus($id, $deliverymanid, $status){
        $order = $this->orderRepository->getDeliverymanById($id, $deliverymanid);

        if($order instanceof Order){
            $order->status = $status;
            $order->save();
            return $order;
        }
        return false;
    }

    public function create(array $data){
        $data['status'] = 0;

        if(isset($data['cupom_id'])){
            unset($data['cupom_id']);
        }


        if(isset($data['cupom_code'])){
            $cupom = $this->cupomRepository->findByField('code', $data['cupom_code'])->first();
            $data['cupom_id'] = $cupom->id;
            $cupom->used = 1;
            $cupom->save();
            unset($data['cupom_code']);
        }

        $items = $data['items'];
        unset($data['items']);

        $order = $this->orderRepository->create($data);
        $total = 0;

        foreach($items as $item){
            $item['price'] = $this->productRepository->find($item['product_id'])->price;
            $order->items()->create($item);
            $total += $item['price'] * $item['qtd'];
        }

        $order->total = $total;

        if(isset($cupom)){
            $order->total = $total - $cupom->value;
        }

        $order->save();
        return $order;





    }

}
