<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'qyasat_id',
        'employee_id',
        'color',
        'price',
        'resource_type',
        'description',
        'price_meter',
        'meter',
        'total_meter_price',


        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];


    public function order_detail_files()
    {
        return $this->hasMany(OrderDetailImage::class);
    }


    public function qyas()
    {
        return $this->belongsTo(Qyasat::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
