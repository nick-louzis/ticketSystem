<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Civil extends Model
{
    protected $fillable = ['name','number', 'email', 'ticket_id'];

    public function ticket(){
            return $this->hasMany(Ticket::class);
         }
}
