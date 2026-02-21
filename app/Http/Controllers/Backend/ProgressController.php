<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Progress;
use App\Models\Employee;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;

class ProgressController extends Controller
{
   public function MasterProgress( )
    {
        $progress = Progress::latest()->get();  
        return view('backend.progress.master_progress', compact('progress'));
    } // End Method

    public function AddProgress( )
    { 
        $employee = Employee::latest()->get();
        return view('backend.progress.add_progress', compact('employee'));
    } // End Method
}
