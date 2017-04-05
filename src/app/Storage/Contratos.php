<?php

namespace App\Storage;

use \ActiveRecord\Model;

class Contratos extends Model
{    
    static $table_name = 'contratos';
    static $belongs_to = [['pessoas'], ['lotes'], ['usuarios']];
}