<?php

namespace App\Storage;

use \ActiveRecord\Model;

class Sessoes extends Model
{    
    static $table_name = 'sessoes';
    static $belongs_to = [['usuarios']];
}