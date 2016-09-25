<?php

namespace Delivery\Transformers;

use League\Fractal\TransformerAbstract;
use Delivery\Models\Item;

/**
 * Class ItemTransformer
 * @package namespace Delivery\Transformers;
 */
class ItemTransformer extends TransformerAbstract
{

    /**
     * Transform the \Item entity
     * @param \Item $model
     *
     * @return array
     */
    public function transform(Item $model)
    {
        return [
            'id'         => (int) $model->id,

            /* place your other model properties here */

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
