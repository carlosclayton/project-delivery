<?php

namespace Delivery\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Delivery\Models\Product;
use Delivery\Presenters\ProductPresenter;


/**
 * Class ProductRepositoryEloquent
 * @package namespace Delivery\Repositories;
 */
class ProductRepositoryEloquent extends BaseRepository implements ProductRepository
{

    protected $skipPresenter = true;

    public function model()
    {
        return Product::class;
    }

    public function selectProds()
    {
        return $this->model->lists('name', 'id');
    }


    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }


    public function presenter()
    {
        return ProductPresenter::class;
    }


}
