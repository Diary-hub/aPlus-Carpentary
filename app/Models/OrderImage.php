<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderImage extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'image',
        'order_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
