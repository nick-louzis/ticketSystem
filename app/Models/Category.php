<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['title', 'ticket_id'];

    // public function ticket(){
    //     return $this->hasMany(Ticket::class);
    // }
}
