<?php

namespace Delivery\Presenters;

use Delivery\Transformers\OrderItemTransformer;
use Delivery\Transformers\OrderTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class OrderPresenter
 *
 * @package namespace Delivery\Presenters;
 */
class OrderItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new OrderItemTransformer();
    }
}
