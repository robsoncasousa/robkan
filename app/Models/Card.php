<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function column(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Column::class, 'column_id');
    }

}
