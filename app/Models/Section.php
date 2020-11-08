<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function project() {
        return $this->belongsTo('App\Models\Project');
    }

    public function tasks() {
        return $this->hasMany('App\Models\Task');
    }

}
