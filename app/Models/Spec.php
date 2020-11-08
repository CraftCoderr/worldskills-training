<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spec extends Model
{
    use HasFactory;

    /**
     * @var string
     */
    private $name;


    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

}
