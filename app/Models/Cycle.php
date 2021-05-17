<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cycle extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public $timestamps = false;

    public static function boot()
    {
        parent::boot();

        static::deleting(function($cycle){
            $cycle->levels()->delete();
        });
    }

    public function levels()
    {
        return $this->hasMany(Level::class);
    }
}
