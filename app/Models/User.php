<?php

namespace Delivery\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements Transformable
{
    use TransformableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */

    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = ['password', 'remember_token'];


    public function client()
    {
        return $this->hasOne(Client::class);
    }

}
