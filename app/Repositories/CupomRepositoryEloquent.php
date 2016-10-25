<?php

namespace Delivery\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Repositories\CupomRepository;
use Delivery\Models\Cupom;
use Delivery\Presenters\CupomPresenter;


/**
 * Class CupomRepositoryEloquent
 * @package namespace Delivery\Repositories;
 */
class CupomRepositoryEloquent extends BaseRepository implements CupomRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */

    protected $skipPresenter = true;


    public function model()
    {
        return Cupom::class;
    }

    public function findByCode($code){
        $result = $this->model->where('code', $code)
            ->where('used', 0)
            ->first();

        if($result){
            return $this->parserResult($result);
        }
        throw(new ModelNotFoundException)->setModel(get_class($this->model));
    }

    public function presenter(){
        return CupomPresenter::class;

    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
