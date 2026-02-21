<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;
use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\UserImport;


class EmployeeController extends Controller
{
    public function MasterUser( )
    {
        $employee = Employee::latest()->get();  
        return view('backend.employee.master_user', compact('employee'));
    } // End Method

     public function AddUser( )
    { 
        return view('backend.employee.add_user');
    } // End Method

    public function StoreUser(Request $request)
    { 
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:employees', 
            'function' => 'required',
        ]);

        $image = $request->file('profile_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::read($image)->resize(300,300)->save('upload/user/'.$name_generate);
        $save_url = 'upload/item/'.$name_generate;

        Employee::insert([

            'name' => $request->name,
            'email' => $request->email,
            'function' => $request->function,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'User Added Successfully', 
            'alert_type' => 'success'
        );

         return redirect()->route('master.user')->with($notification);

        }// End Method

    
    public function EditUser($id)
    { 
        $user = Employee::findOrFail($id);
        return view('backend.employee.edit_user', compact('user'));
    } // End Method

    
    public function UpdateUser(Request $request)
    { 
        $user_id = $request->id;
        if ($request->file('profile_image')) {
             $image = $request->file('profile_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::read($image)->resize(300,300)->save('upload/user/'.$name_generate);
        $save_url = 'upload/user/'.$name_generate;

        Employee::findOrFail($user_id)->update([

            'name' => $request->name,
            'email' => $request->email,
            'function' => $request->function,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'User Profile Updated Successfully', 
            'alert_type' => 'success'
        );
        
        return redirect()->route('master.user')->with($notification);

        }
        else {
        Employee::findOrFail($user_id)->update([

                    'name' => $request->name,
                    'email' => $request->email,
                    'function' => $request->function,
                    'created_at' => Carbon::now(),
                ]);

                $notification = array(
                    'message' => 'User Profile Updated Successfully', 
                    'alert_type' => 'success'
                );
                
                return redirect()->route('master.user')->with($notification);
        } // End Else Condition
    } // End Method

   public function DeleteUser($id)
    { 
        $user_image = Employee::findOrFail($id);
        $image = $user_image->image;
        unlink($image);

        Employee::findOrFail($id)->delete();  
         $notification = array(
                    'message' => 'Deleted Successfully', 
                    'alert_type' => 'success'
                );
                
        return redirect()->route('master.user')->with($notification);      
    } // End Method    

    public function ImportUser()
    { 
        return view('backend.employee.import_user');
    } // End Method

    public function ExportUser()
    { 
        return Excel::download(new UserExport, 'user.xlsx');
    } // End Method

    public function Import(Request $request)
    { 
        Excel::import(new UserImport, $request->file('import_user'));
           $notification = array(
                    'message' => 'User Imported Successfully', 
                    'alert_type' => 'success'
                );
        
       return redirect()->route('master.user')->with($notification);                      
    } // End Method
}   


