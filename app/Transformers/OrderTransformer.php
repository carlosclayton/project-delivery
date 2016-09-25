<?php

namespace Delivery\Transformers;

use Delivery\Models\Client;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Delivery\Models\Order;

/**
 * Class OrderTransformer
 * @package namespace Delivery\Transformers;
 */
class OrderTransformer extends TransformerAbstract
{

    /**
     * Transform the \Order entity
     * @param \Order $model
     *
     * @return array
     */

    protected $defaultIncludes = ['cupom', 'item', 'client'];
    //protected $avaliableIncludes = [];

    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'total'      => (float) $model->total,
            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeCupom(Order $model){
        if(!$model->cupom){
            return null;
        }

        return $this->item($model->cupom, new CupomTransformer());
    }
    public function includeClient(Order $model){
        return $this->item($model->client, new ClientTransformer());
    }

    public function includeItem(Order $model){
        if(!$model->item){
            return null;
        }

        return $this->item($model->item, new ItemTransformer());
    }

}
