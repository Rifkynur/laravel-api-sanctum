<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    protected $fillable = [
        'name','desc','is_done'
    ];
}
