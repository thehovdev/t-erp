<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    // role name and id
    public static $list = [1 => 'buyer',  2 => 'sales', 3 => 'supplier'];

}
