<?php

namespace App\Storage;

use \ActiveRecord\Model;

class Parcelas extends Model
{    
    static $table_name = 'parcelas';
    static $belongs_to = [['contratos']];
}