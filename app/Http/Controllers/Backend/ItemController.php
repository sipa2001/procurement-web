<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Item;
use Intervention\Image\Laravel\Facades\Image;
use Carbon\Carbon;

class ItemController extends Controller
{
    public function MasterItem( )
    {
        $item = Item::latest()->get();  
        return view('backend.item.master_item', compact('item'));
    } // End Method

    public function AddItem( )
    { 
        return view('backend.item.add_item');
    } // End Method

    public function StoreItem(Request $request)
    { 
        $validateData = $request->validate([
            'name' => 'required|max:200',       
        ]);

        $image = $request->file('profile_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
        Image::read($image)->resize(300,300)->save('upload/item/'.$name_generate);
        $save_url = 'upload/item/'.$name_generate;

        Item::insert([

            'name' => $request->name,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Item Added Successfully', 
            'alert_type' => 'success'
        );

         return redirect()->route('master.item')->with($notification);

        }// End Method

    public function EditItem($id)
    { 
        $item = Item::findOrFail($id);
        return view('backend.item.edit_item', compact('item'));
    } // End Method

    public function UpdateItem(Request $request)
    { 
        $item_id = $request->id;
        if ($request->file('profile_image')) {

        $image = $request->file('profile_image');
        $name_generate = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();

        Image::read($image)->resize(300,300)->save('upload/item/'.$name_generate);
        $save_url = 'upload/item/'.$name_generate;


        Item::findOrFail($item_id)->update([

            'name' => $request->name,
            'image' => $save_url,
            'created_at' => Carbon::now(),
        ]);

           $notification = array(
            'message' => 'Item Updated Successfully', 
            'alert_type' => 'success'
        );
        
        return redirect()->route('master.user')->with($notification);

        }
        else {
            Item::findOrFail($item_id)->update([
                'name' => $request->name,
                'created_at' => Carbon::now(),
                ]);

                $notification = array(
                    'message' => 'User Profile Updated Successfully', 
                    'alert_type' => 'success'
                );
                
                return redirect()->route('master.item')->with($notification);
        } // End Else Condition
    } // End Method

    public function DeleteItem($id)
    { 
        $item_image = Item::findOrFail($id);
        $image =  $item_image->image;
        unlink($image);

        Item::findOrFail($id)->delete();  
         $notification = array(
                    'message' => 'Deleted Successfully', 
                    'alert_type' => 'success'
                );
                
                return redirect()->route('master.item')->with($notification);      
    } // End Method    
}
    

