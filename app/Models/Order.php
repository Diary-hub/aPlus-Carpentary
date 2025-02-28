<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'employee_id',
        'qyas_id',
        'order_detail_id',
        'start_date',
        'end_date',
        'house_date',
        'items',
        'isDone',
        'isSumbited',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at',
    ];


    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }


    public function qyas()
    {
        return $this->belongsTo(Qyasat::class);
    }

    public function order_files()
    {
        return $this->hasMany(OrderImage::class);
    }
}
