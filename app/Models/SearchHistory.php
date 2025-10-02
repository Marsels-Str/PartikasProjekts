<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
{
    use HasFactory;

    protected $fillable = ['product_name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
