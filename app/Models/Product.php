<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ProductAdd;

class Product extends Model
{
    use HasFactory, Notifiable, SoftDeletes;

    public function scopeAvailable()
    {
        return $this->where('status', 1)->get();
    }
}
