<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sensor extends Model
{
    use HasFactory;

    protected $table = 'sensors';

    protected $fillable = [
        'temperature',
        'humidity',
        'tds_value',
        'ph',
        'water_level',
        'pump_a_status',
        'pump_b_status',
        'refill_status',
    ];
}