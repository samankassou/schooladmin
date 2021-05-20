<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'cycle_id'];

    public function cycle()
    {
        return $this->belongsTo(Cycle::class);
    }

    public function classrooms()
    {
        return $this->hasMany(Classroom::class);
    }


}
 