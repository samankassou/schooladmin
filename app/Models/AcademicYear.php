<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $dates = ['start_date', 'end_date'];

    /**
     * Scope a query to return only current academic year.
     */
    public static function current()
    {
        $currentYear = self::firstWhere([
            ['start_date', '<=', now()->addYear()],
            ['end_date', '>=', now()->addYear()]
        ]);
        $defaultYear = self::firstWhere('name', '2020/2021');
        
        return $currentYear ?? $defaultYear;
    }
}
