<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text',
        'type'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function task() {
        return $this->belongsTo('App\Models\Task');
    }

    public function messages() {
        return $this->hasMany('App\Models\Message');
    }

}
