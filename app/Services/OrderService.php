<?php
/**
 * Created by PhpStorm.
 * User: Clayton
 * Date: 24/08/2016
 * Time: 19:11
 */

namespace Delivery\Services;



use Delivery\Repositories\CupomRepository;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Dmitrovskiy\IonicPush\PushProcessor;


class OrderService
{

    private $orderRepository;
    private $userRepository;
    private $productRepository;
    private $cupomRepository;
    private $pushProcessor;

    public function __construct(OrderRepository $orderRepository, CupomRepository $cupomRepository, ProductRepository $productRepository, PushProcessor $pushProcessor)
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->cupomRepository = $cupomRepository;
        $this->pushProcessor = $pushProcessor;
    }

    public function update(array $data, $id)
    {
        $this->orderRepository->update($data, $id);
        $userId = $this->orderRepository->find($id, ['user_id'])->user_id;
        $this->userRepository->update($data['user'], $userId);
    }

    public function updateStatus($id, $deliverymanid, $status)
    {
        $order = $this->orderRepository->getDeliverymanById($id, $deliverymanid);
        $order->status = $status;
        switch((int) $status){
            case 1:
                if(!$order->hash ){
                    $order->hash = md5((new \DateTime())->getTimestamp());
                }
                $order->save();
                break;
            case 2:
                $user = $order->client->user;
                $order->save();
                //dd($user->device_token);
                $this->pushProcessor->notify([$user->device_token],[
                    'message' => "Seu pedido {$order->id} foi entregue"
                ]);
                break;

        }

        return $order;
    }

    public function create(array $data)
    {
        $data['status'] = 0;

        if (isset($data['cupom_id'])) {
            unset($data['cupom_id']);
        }


        if (isset($data['cupom_code'])) {
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

        foreach ($items as $item) {
            $item['price'] = $this->productRepository->find($item['product_id'])->price;
            $order->items()->create($item);
            $total += $item['price'] * $item['qtd'];
        }

        $order->total = $total;

        if (isset($cupom)) {
            $order->total = $total - $cupom->value;
        }

        $order->save();
        return $order;


    }

}
