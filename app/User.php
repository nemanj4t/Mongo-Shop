<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Jenssegers\Mongodb\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function products()
    {
        return $this->belongsToMany('App\Product', null, 'user_ids', 'product_ids');
    }

    public function shoppingCart()
    {
        return $this->hasOne('App\ShoppingCart', 'user_id');
    }
}
