<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Stock extends Model
{
      protected $guarded = [
        'id'
      ];

      public function cart()
      {
       return $this->hasOne('\App\Models\Cart');
      }
}
