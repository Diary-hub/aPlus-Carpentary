<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'gender',
        'age',
        'image',
        'salary',
        'description',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];


    public function employee_images()
    {
        return $this->hasMany(EmployeeImage::class);
    }

    public function getFormattedPhoneAttribute()
    {
        $phone = $this->attributes['phone'];

        if (strlen($phone) === 11) {
            return substr($phone, 0, 4) . ' ' . substr($phone, 4, 3) . ' ' . substr($phone, 7, 4);
        }

        return $phone;
    }

    protected $appends = ['formatted_phone'];
}
