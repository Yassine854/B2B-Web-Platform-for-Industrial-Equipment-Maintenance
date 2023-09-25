<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;
class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'c_huile',
        'c_filtre',
        'c_dehuil',
        'entretien',
    ];

    public function client()
    {
        return $this->belongsToMany(User::class, 'assignment_client', 'assignment_id', 'client_id');
    }

    public function product()
    {
        return $this->belongsToMany(Product::class, 'assignment_product', 'assignment_id', 'product_id');
    }

}
