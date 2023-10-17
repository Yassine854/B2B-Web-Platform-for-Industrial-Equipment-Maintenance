<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pdr;
use App\Models\Information;

class Diagnostic extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'product_id',
        'date',
        'description'
    ];

    public function informations()
    {
        return $this->hasMany(Information::class);
    }

    public function pdrs()
    {
        return $this->hasMany(Pdr::class);
    }
}
