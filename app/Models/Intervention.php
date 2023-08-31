<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pdr;
class Intervention extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'client_id',
        'product_id',
        'description',
        'date'
    ];



    public function pdrs()
    {
        return $this->hasMany(Pdr::class);
    }
}
