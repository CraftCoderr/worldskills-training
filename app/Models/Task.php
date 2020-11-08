<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'start',
        'end'
    ];

    protected $casts = [
        'start' => 'date',
        'end' => 'date',
    ];

    public function section() {
        return $this->belongsTo('App\Models\Section');
    }

    public function spec() {
        return $this->belongsTo('App\Models\Spec');
    }

    public function threads() {
        return $this->hasMany('App\Models\Thread');
    }

    public function assignee() {
        return $this->belongsTo('App\Models\User');
    }

}
