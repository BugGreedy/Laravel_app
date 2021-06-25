<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;
    // 下記を追加
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }
}
