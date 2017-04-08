<?php

namespace App\Storage;

use \ActiveRecord\Model;

class Enderecos extends Model
{    
    static $table_name = 'enderecos';
    static $belongs_to = [['cidades']];
}