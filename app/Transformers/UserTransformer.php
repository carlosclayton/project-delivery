<?php

namespace Delivery\Transformers;

use League\Fractal\TransformerAbstract;
use Delivery\Models\User;

/**
 * Class UserTransformer
 * @package namespace Delivery\Transformers;
 */
class UserTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['client'];

    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'id' => (int)$model->id,

            'name' => $model->name,
            'email' => $model->email,
            'role' => $model->role,
            'device_token' => $model->device_token,

            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at
        ];
    }

    public function includeClient(User $model)
    {
        if($model->client) {
            return $this->item($model->client, new ClientTransformer());
        }else{
            return null;
        }

    }
}
