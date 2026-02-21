<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Metode;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class MetodeController extends Controller
{
    public function MasterMetode( )
    {
    $metode = Metode::latest()->get();  
    return view('backend.metode.master_metode', compact('metode'));
    } // End Method

    public function AddMetode( )
    { 
        return view('backend.metode.add_metode');
    } // End Method

    public function StoreMetode(Request $request)
    { 
        $validateData = $request->validate([
            'name' => 'required|max:200',       
        ]);

        Metode::insert([

            'name' => $request->name,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Unit Added Successfully', 
            'alert_type' => 'success'
        );

         return redirect()->route('master.metode')->with($notification);

        }// End Method

        public function EditMetode($id)
        { 
            $metode = Metode::findOrFail($id);
            return view('backend.metode.edit_metode', compact('metode'));
        } // End Method

        public function UpdateMetode(Request $request)
        { 
            $metode_id = $request->id;
            Metode::findOrFail($metode_id)->update([

                'name' => $request->name,
                'created_at' => Carbon::now(),
            ]);

            $notification = array(
                'message' => 'Unit Updated Successfully', 
                'alert_type' => 'success'
            );
        
        return redirect()->route('master.metode')->with($notification);
        } // End Method

        public function DeleteMetode($id)
        { 
            Metode::findOrFail($id)->delete();  
            $notification = array(
                        'message' => 'Deleted Successfully', 
                        'alert_type' => 'success'
                    );
                    
        return redirect()->route('master.metode')->with($notification);
        } // End Method
}
