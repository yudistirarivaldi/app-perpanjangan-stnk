<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $table = 'vehicles';

    protected $fillable = [
        'user_id',
        'plate_number',
        'category_id',
        'merk_id',
        'model',
        'year',
        'tax_due_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function merk()
    {
        return $this->belongsTo(Merk::class, 'merk_id', 'id');
    }

}
