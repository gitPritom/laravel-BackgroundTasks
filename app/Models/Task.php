<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'tasks';

    protected $fillable = [
        'type',
        'payload',
        'status',
        'attempts',
        'error_message',
        'created_at',
        'updated_at'
    ];
}
