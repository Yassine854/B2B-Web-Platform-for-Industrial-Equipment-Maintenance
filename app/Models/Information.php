<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    protected $table='informations';
    use HasFactory;
    protected $fillable = [
        'def',
        'description',
        'image',
    ];


    public function diagnostic()
    {
        return $this->belongsTo(Diagnostic::class);
    }
}
