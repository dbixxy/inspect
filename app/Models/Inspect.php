<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspect extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'number', 
        'date_start',
        'date_end',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function issues()
    {
        return $this->hasMany(Issue::class);
    }
}
