<?php

namespace App\Storage;

use \ActiveRecord\Model;

class Quadras extends Model
{    
    static $table_name = 'quadras';
    static $belongs_to = [['terrenos']];
}