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
        $result = $this->model
            ->where('id', $id)
            ->where('user_deliveryman_id',$deliverymanid )
            ->first();

            if($result){
                return $this->parserResult($result);
            }
            throw (new ModelNotFoundException())->setModel(get_class($this->model));

    }

    public function getByIdAndClient($id, $idClient)
    {
        $result = $this->model
            ->where('id', $id)
            ->where('client_id',$idClient )
            ->first();

        if($result){
            return $this->parserResult($result);
        }
        throw (new ModelNotFoundException())->setModel($this->model());

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