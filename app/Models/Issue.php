<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issue extends Model
{
    use HasFactory;

    protected $fillable = [
        'inspect_id',
        'plan_id', 
        'position_x',
        'position_y',
        'number',
        'problem',
        'suggest',
        'is_closed',
        'ref_issue_id',
        'close_at_inspect_id'
    ];

    public function inspect()
    {
        return $this->belongsTo(Inspect::class);
    }

    public function closeAtInspect()
    {
        return $this->belongsTo(Inspect::class, 'close_at_inspect_id', 'id');
    }

    public function referenceIssue()
    {
        return $this->belongsTo(Issue::class, 'ref_issue_id', 'id');
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function issueFiles()
    {
        return $this->hasMany(IssueFile::class);
    }
}
