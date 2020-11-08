<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'text'
    ];

    private $title;
    private $text;

    public function author() {
        return $this->belongsTo('App\Models\User');
    }

}
