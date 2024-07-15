<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QyasatImage extends Model
{
    use HasFactory;
    use SoftDeletes;


    protected $fillable = [
        'image',
        'qyasat_id',
        'created_by',
        'updated_by',
        'deleted_by',
        'deleted_at'
    ];

    public function qyasat()
    {
        return $this->belongsTo(Qyasat::class);
    }
}
