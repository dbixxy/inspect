<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Issue;
use App\Models\IssueFile;
use Illuminate\Support\Facades\Storage;

class IssueFileController extends Controller
{
    public function delete($id)
    {
        $issue_file = IssueFile::findOrFail($id);
        Storage::delete($issue_file->file);
        $issue_file->delete(); //returns true/false
        return $issue_file->delete();
    }
}
