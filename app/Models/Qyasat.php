<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Qyasat extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'type',
        'customer_name',
        'customer_address',
        'customer_phone',
        'description',
        'image',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];



    public function qyasat_files()
    {
        return $this->hasMany(QyasatImage::class);
    }


    public function getFormattedPhoneAttribute()
    {
        $phone = $this->attributes['customer_phone'];

        if (strlen($phone) === 11) {
            return substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 4);
        }

        return $phone;
    }

    protected $appends = ['formatted_phone'];
}
