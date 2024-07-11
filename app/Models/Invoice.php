<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'code',
        'quantity',
        'dinar_price',
        'dolar_price',
        'dolar_data',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
        'product_id',
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
