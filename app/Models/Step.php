<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    protected $fillable =['description','ticket_id'];

    public function tickets(){
        return  $this->belongsTo(Ticket::class);
      }
}