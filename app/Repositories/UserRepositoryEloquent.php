<?php

namespace Delivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Models\User;
use Delivery\Presenters\UserPresenter;


/**
 * Class UserRepositoryEloquent
 * @package namespace Delivery\Repositories;
 */
class UserRepositoryEloquent extends BaseRepository implements UserRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    public function getDeliverymen(){
        return $this->model->where(['role' => 'deliveryman'])->lists('name', 'id');
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter(){
        return UserPresenter::class;
    }

    public function updateDeviceToken($id, $deviceToken){
        $model = $this->model->find($id);
        $model->device_token = $deviceToken;

        $model->save();
        return $this->parserResult($model);
    }
}
