<?php

namespace Delivery\Transformers;

use League\Fractal\TransformerAbstract;
use Delivery\Models\Cupom;

/**
 * Class CupomTransformer
 * @package namespace Delivery\Transformers;
 */
class CupomTransformer extends TransformerAbstract
{

    /**
     * Transform the \Cupom entity
     * @param \Cupom $model
     *
     * @return array
     */
    public function transform(Cupom $model)
    {
        return [
            'id'         => (int) $model->id,

            'code' => $model->code,
            'value' => (float) $model->value,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }
}
