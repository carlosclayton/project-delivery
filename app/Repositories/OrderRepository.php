<?php

namespace Delivery\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface OrderRepository
 * @package namespace Delivery\Repositories;
 */
interface OrderRepository extends RepositoryInterface
{
    //
    public function getDeliverymanById($id, $deliverymanid);
    public function getByIdAndClient($id, $idClient);
}
