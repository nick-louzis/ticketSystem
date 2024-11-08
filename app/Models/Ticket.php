<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = ['title','description', 'user_id', 'civil_id', 'status', 'category_id', 'endDate'];

    // protected $casts =[
    //     'step_id' => 'array',
    // ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function steps(){
        return  $this->hasMany(Step::class);
      }

      public function category(){
        return  $this->belongsTo(Category::class);
      }

      public function civil(){
        return $this->belongsTo(Civil::class, 'civil_id');
      }
}
