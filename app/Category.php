<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Model;

class Category extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'categories';

//    public $id;
//    public $name;
//    public $details;
//    public $ancestors = [];
//    public $children = [];
}
