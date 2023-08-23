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
        'c_huile',
        'c_filtre',
        'c_dehuil',
        'entretien',
    ];

    public function clients()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

}
