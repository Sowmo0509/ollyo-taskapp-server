<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'due_date'
    ];

    protected $casts = [
        'due_date' => 'datetime'
    ];
}
