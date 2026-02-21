<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use File;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

         $notification = array(
            'message' => 'User Logout Successfully', 
            'alert_type' => 'success'
        );

        return redirect('/login')->with($notification);
    } // End Method


    public function Profile( )
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);

        return view('admin.admin_profile_view', compact('adminData'));
    } // End Method

    
    public function EditProfile( )
    {
        $id = Auth::user()->id;
        $editData = User::find($id);

        return view('admin.admin_profile_edit', compact('editData'));
    } // End Method

    public function StoreProfile(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->username = $request->username;

        if($request->file('profile_image')){
            $file = $request->file('profile_image');
            $filename = date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('upload/admin_images'),$filename);
            $data['profile_image'] = $filename;
        }
        $data->save();
        
        $notification = array(
            'message' => 'Profile Updated Successfully', 
            'alert_type' => 'success'
        );
        return redirect()->route('admin.profile')->with($notification);
    }// End Method

    public function MasterDisposisi( )
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);

        return view('admin.master_disposisi');
    } // End Method
    
    public function MasterProgress( )
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);

        return view('admin.master_progress');
    } // End Method

        public function MasterTask( )
    {
        $id = Auth::user()->id;
        $adminData = User::find($id);

        return view('admin.master_task');
    } // End Method

    public function NewOrder( )
    {
        $id = Auth::user()->id;
        $editData = User::find($id);

        return view('admin.new_order');
    } // End Method

        
    public function EditOrder( )
    {
        $id = Auth::user()->id;
        $editData = User::find($id);

        return view('admin.edit_order');
    } // End Method
    
    public function MonitoringOrder( )
    {
        $id = Auth::user()->id;
        $editData = User::find($id);

        return view('admin.monitoring_order');
    } // End Method

    public function DetailOrder( )
    {
        $id = Auth::user()->id;
        $editData = User::find($id);

        return view('admin.detail_order');
    } // End Method

    // Database Backup Method

    public function DatabaseBackup(){
        return view('admin.db_backup')->with('files', File::allFiles(storage_path('\app\private\SIMProcurement')));
    } // End Method

     public function BackupNow(){
       Artisan::call('backup:run');

        $notification = array(
            'message' => 'Database Backup Successfully', 
            'alert_type' => 'success'
        );
        return redirect()->route('database.backup')->with($notification);
    }

        public function DownloadDatabase($getFilename){

            $path = storage_path('\app\private\SIMProcurement'.$getFilename);
            return response()->download($path);
    }

        public function DeleteDatabase($getFilename){
            Storage::delete('SIMProcurement'.$getFilename);

            $notification = array(
                'message' => 'Database Deleted Successfully', 
                'alert_type' => 'success'
        );
        return redirect()->route('database.backup')->with($notification);
        }
}

