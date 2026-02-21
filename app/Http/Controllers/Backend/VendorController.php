<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vendor;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;


class VendorController extends Controller
{  public function MasterVendor( )
    {
        $vendor = Vendor::latest()->get();  
        return view('backend.vendor.master_vendor', compact('vendor'));
    } // End Method

        public function AddVendor( )
    { 
        return view('backend.vendor.add_vendor');
    } // End Method

     public function StoreVendor(Request $request)
    { 
        $validateData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:vendors', 
            'address' => 'required|max:100',
        ]);

        Vendor::insert([

            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Vendor Added Successfully', 
            'alert_type' => 'success'
        );

         return redirect()->route('master.vendor')->with($notification);

        }// End Method

    public function EditVendor($id)
    { 
        $vendor = Vendor::findOrFail($id);
        return view('backend.vendor.edit_vendor', compact('vendor'));
    } // End Method

    public function UpdateVendor(Request $request)
    { 
        $vendor_id = $request->id;
        Vendor::findOrFail($vendor_id)->update([

            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Vendor Profile Updated Successfully', 
            'alert_type' => 'success'
        );
        
        return redirect()->route('master.vendor')->with($notification);

        } // End Method 

       public function DeleteVendor($id)
    {    
        Vendor::findOrFail($id)->delete();  
         $notification = array(
                    'message' => 'Deleted Successfully', 
                    'alert_type' => 'success'
                );
                
                return redirect()->route('master.vendor')->with($notification);      
    } // End Method    
}
    

    


