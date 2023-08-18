<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Typeproduct;
class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'name',
        'type_prod',
        'debit',
        'unity_debit',
        'pression',
        'year',
        'time_day',
    ];


    public function type()
    {
        return $this->belongsTo(Typeproduct::class, 'type_prod');
    }
}
