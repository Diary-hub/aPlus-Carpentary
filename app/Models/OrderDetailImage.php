<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetailImage extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'image',
        'order_detail_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    public function order_detail()
    {
        return $this->belongsTo(OrderDetail::class);
    }
}
