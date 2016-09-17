<?php

namespace Delivery\Repositories;

use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Models\Order;

/**
 * Class OrderRepositoryEloquent
 * @package namespace Delivery\Repositories;
 */
class OrderRepositoryEloquent extends BaseRepository implements OrderRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Order::class;
    }

    public function getDeliverymanById($id, $deliverymanid){
        $result = $this->with('client', 'items', 'cupoms')->findWhere(['id' => $id, 'user_deliveryman_id' => $deliverymanid]);
        $result = $result->first();
        if($result){
            $result = $result->first();
            $result->items->each(function($item){
               $item->product;
            });

        }
        return $result;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
