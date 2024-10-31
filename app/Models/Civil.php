<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Civil extends Model
{
    protected $fillable = ['name', 'email', 'number'];

    protected $casts =[
        'ticket_id' => 'array',
    ];


    public function tickets(): HasMany{
        return $this->hasMany(Ticket::class, 'ticket_id');
    }
}
