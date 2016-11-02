<?php

namespace Delivery\Repositories;



use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Models\Order;
use Delivery\Presenters\OrderPresenter;

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

    protected $skipPresenter = true;

    public function model()
    {
        return Order::class;
    }

    public function getDeliverymanById($id, $deliverymanid)
    {
        $result = $this->with(['client','items','cupom'])->findWhere(['id' => $id, 'user_deliveryman_id' => $deliverymanid]);
        if($result instanceof Collection){
            $result = $result->first();
        }else{
            if(isset($result['data']) && count($result['data']) == 1){
                $result = [
                  'data' => $result['data'][0]
                ];
            }else{
                throw new ModelNotFoundException('Order nao existe');
            }
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

    public function presenter()
    {
        return OrderPresenter::class;
    }
}