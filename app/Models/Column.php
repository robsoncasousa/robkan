<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Column extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function cards(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Card::class, 'column_id')->orderBy('order');
    }
}
