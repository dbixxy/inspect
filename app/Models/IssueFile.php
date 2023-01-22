<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IssueFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'issue_id',
        'file', 
    ];

    public function issue()
    {
        return $this->belongsTo(Issue::class);
    }
}

