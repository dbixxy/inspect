<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'customer_id', 
        'name', 
        'property_type', 
        'development_name', 
        'area_name',
        'gps_position',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id');
    }

    public function plans()
    {
        return $this->hasMany(Plan::class);
    }

    public function inspects()
    {
        return $this->hasMany(Inspect::class);
    }

    public function issues()
    {
        return $this->hasManyThrough(Issue::class, Inspect::class);
    }
}
