<?php

namespace Delivery\Transformers;

use Delivery\Models\Client;
use Delivery\Models\OrderItem;
use Illuminate\Support\Collection;
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

    protected $availableIncludes = ['cupom','items','client'];
    //protected $avaliableIncludes = [];

    public function transform(Order $model)
    {
        return [
            'id'         => (int) $model->id,
            'total'      => (float) $model->total,
            'product_names' => $this->getArrayProductNames($model->items),
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    protected function getArrayProductNames(Collection $items){
        $names = [];
        foreach($items as $item){
            $names[] = $item->product->name;
        }
        return $names;
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

    public function includeItems(Order $model){


        return $this->collection($model->items, new OrderItemTransformer());
    }

}
