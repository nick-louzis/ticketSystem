<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['title', 'name', 'email', 'number','description', 'user_id', 'status'];

    protected $casts =[
        'step_id' => 'array',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps(){
        return  $this->hasMany(Step::class);
      }
}
