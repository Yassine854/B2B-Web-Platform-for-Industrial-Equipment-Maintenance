<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Typeindustrie extends Model
{
    use HasFactory;
    protected $table = 'typeindustries';

    protected $fillable = [
        'name',
    ];

    public function type()
    {
        return $this->belongsTo(User::class, 'type_ind');
    }
}
