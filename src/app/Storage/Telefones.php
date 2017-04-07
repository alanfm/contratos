<?php

namespace App\Storage;

use \ActiveRecord\Model;

class Telefones extends Model
{    
    static $table_name = 'telefones';
    static $belongs_to = [['pessoas']];
}