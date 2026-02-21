<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Satuan;
use App\Models\Employee;
use App\Models\Item;
use App\Models\Metode;
use App\Models\Vendor;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class OrderController extends Controller
{   
     public function MasterOrder( )
    {
        $order = Order::latest()->get();  
        return view('backend.order.master_order', compact('order'));
    } // End Method

      public function AddOrder( )
    { 
        $item = Item::latest()->get();
        $satuan = Satuan::latest()->get();
        $employee = Employee::latest()->get();    
        return view('backend.order.add_order', compact('item', 'satuan', 'employee'));
    } // End Method

    public function StoreOrder (Request $request)
    { 
        $validateData = $request->validate([
            'nomor_ppbj' => 'required',
            'disposisi' => 'required',
            'tanggal_masuk' => 'required',
            'item' => 'required',
            'harga_awal' => 'required',
            'satuan' => 'required',
        ]);

        $image = $request->file('profile_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::read($image)->resize(300,300)->save('upload/document/'.$name_generate);
        $save_url = 'upload/document/'.$name_generate;

        Order::insert([

            'nomor_ppbj' => $request->nomor_ppbj,
            'disposisi' => $request->disposisi,
            'tanggal_masuk' => $request->tanggal_masuk,
            'item' => $request->item,
            'satuan' => $request->satuan,
            'harga_awal' => $request->harga_awal,
            'file_ppbj' => $save_url,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Order Added Successfully', 
            'alert_type' => 'success'
        );

         return redirect()->route('master.order')->with($notification);

        }// End Method

    public function EditOrder($id)
    { 
        $order = Order::findOrFail($id);
        $user = Employee::findOrFail($id);
        $item = Item::findOrFail($id);
        $satuan = Satuan::findOrFail($id);
        return view('backend.order.edit_order', compact('order', 'item', 'satuan', 'user'));
    } // End Method

    public function UpdateOrder(Request $request)
    { 
        $order_id = $request->id;
        if ($request->file('profile_image')) {

            $image = $request->file('profile_image');
            $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            Image::read($image)->resize(300,300)->save('upload/document/'.$name_generate);
            $save_url = 'upload/document/'.$name_generate;

        Order::findOrFail($order_id)->update([

            'nomor_ppbj' => $request->nomor_ppbj,
            'disposisi' => $request->disposisi,
            'tanggal_masuk' => $request->tanggal_masuk,
            'item' => $request->item,
            'satuan' => $request->satuan,
            'harga_awal' => $request->harga_awal,
            'file_ppbj' => $save_url,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Order Updated Successfully', 
            'alert_type' => 'success'
        );
        
        return redirect()->route('master.order')->with($notification);

        }
        else {
        Order::findOrFail($order_id)->update([

                    'nomor_ppbj' => $request->nomor_ppbj,
                    'disposisi' => $request->disposisi,
                    'tanggal_masuk' => $request->tanggal_masuk,
                    'item' => $request->item,
                    'satuan' => $request->satuan,
                    'harga_awal' => $request->harga_awal,
                    'created_at' => Carbon::now(),
        ]);

                $notification = array(
                    'message' => 'Order Updated Successfully', 
                    'alert_type' => 'success'
                );
                
        return redirect()->route('master.order')->with($notification);
        } // End Else Condition
    } // End Method

    public function DeleteOrder($id)
    { 
        $order_image = Order::findOrFail($id);
        $image = $order_image->image;
        unlink($image);

        Order::findOrFail($id)->delete();  
        $notification = array(
                    'message' => 'Deleted Successfully', 
                    'alert_type' => 'success'
                );
                
        return redirect()->route('master.order')->with($notification);      
    } // End Method 
    
    public function AddSpph( )
    { 
        $metode = Metode::latest()->get(); 
        $vendor = Vendor::latest()->get();  
        return view('backend.order.add_spph', compact('metode', 'vendor'));
    } // End 
    
    public function AddSph( )
    { 
        return view('backend.order.add_sph');
    } // End Method

    public function AddPurOrdr( )
    { 
        return view('backend.order.add_purordr');
    } // End Method

}
