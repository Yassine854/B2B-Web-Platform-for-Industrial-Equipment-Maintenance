<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pdr extends Model
{
    use HasFactory;

    protected $fillable = [
        'designation',
        'reference',
        'quantite',
    ];


    public function intervention()
    {
        return $this->belongsTo(Intervention::class);
    }

    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }
}
