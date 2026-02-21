<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Satuan;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;


class SatuanController extends Controller
{
      public function MasterSatuan( )
    {
        $satuan = Satuan::latest()->get();  
        return view('backend.satuan.master_satuan', compact('satuan'));
    } // End Method

       public function AddSatuan( )
    { 
        return view('backend.satuan.add_satuan');
    } // End Method

    public function StoreSatuan(Request $request)
    { 
        $validateData = $request->validate([
            'name' => 'required|max:200',       
        ]);

        Satuan::insert([

            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Unit Added Successfully', 
            'alert_type' => 'success'
        );

         return redirect()->route('master.satuan')->with($notification);

        }// End Method

        public function EditSatuan($id)
    { 
        $satuan = Satuan::findOrFail($id);
        return view('backend.satuan.edit_satuan', compact('satuan'));
    } // End Method

       public function UpdateSatuan(Request $request)
    { 
        $satuan_id = $request->id;
        Satuan::findOrFail($satuan_id)->update([

            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Unit Updated Successfully', 
            'alert_type' => 'success'
        );
        
        return redirect()->route('master.satuan')->with($notification);
        } // End Method

        public function DeleteSatuan($id)
    { 
        Satuan::findOrFail($id)->delete();  
         $notification = array(
                    'message' => 'Deleted Successfully', 
                    'alert_type' => 'success'
                );
                
                return redirect()->route('master.satuan')->with($notification);
    } // End Method
}