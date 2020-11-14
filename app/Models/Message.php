<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
      'text',
      'date',
      'changed'
    ];

    protected $casts = [
        'date' => 'datetime'
    ];

    public function thread() {
        return $this->belongsTo('App\Models\Thread');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}
