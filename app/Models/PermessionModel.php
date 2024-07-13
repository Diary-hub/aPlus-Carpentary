<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermessionModel extends Model
{
    use HasFactory;




    protected $fillable = [
        'isAdmin',
        'canViewProduct',
        'canViewProduct',
        'canViewProduct',
        'canEditProduct',
        'canEditCompany',
        'canEditCategory',
        'canAddProduct',
        'canViewEmployee',
        'canEditEmployee',
        'user_id',
        'created_by',
        'updated_by',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
