<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ItemController extends Controller
{

    // protected $fillable = [
    //     'photo',
    //     'name',
    //     'type',
    //     'brand',
    //     'sn',
    //     'code',
    //     'status',
    //     'condition',
    //     'procurement_date',
    //     'description',
    //     'is_used',
    //     'unit',
    //     'sub_unit',
    //     'user',
    //     'sap_number',
    // ];

    //add item with photo upload
    public function addItem(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'sn' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'procurement_date' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_used' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'sub_unit' => 'required|string|max:255',
            'user' => 'required|string|max:255',
            'sap_number' => 'required|string|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item = Item::create($request->all());

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/items'), $photoName);
            $item->photo = $photoName;
            $item->save();
        }

        return response()->json([
            'message' => 'successfully added item',
            'data' => $item
        ]);
    }

    //get items
    public function getItems()
    {
        $items = Item::all();
        return response()->json([
            'message' => 'successfully get items',
            'data' => $items
        ]);
    }

    //update item by id with photo upload
    public function updateItemById(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'sn' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'condition' => 'required|string|max:255',
            'procurement_date' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'is_used' => 'required|string|max:255',
            'unit' => 'required|string|max:255',
            'sub_unit' => 'required|string|max:255',
            'user' => 'required|string|max:255',
            'sap_number' => 'required|string|max:255',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $item = Item::find($id);
        if ($item == null) {
            return response()->json([
                'message' => 'item not found'
            ], 404);
        }
        $item->update($request->all());
        if ($request->hasFile('photo')) {
            $oldPhoto = public_path('images/items/' . $item->photo);
            if (File::exists($oldPhoto)) {
                File::delete($oldPhoto);
            }
            $photo = $request->file('photo');
            $photoName = time() . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('images/items'), $photoName);
            $item->photo = $photoName;
            $item->save();
        }

        return response()->json([
            'message' => 'successfully updated item',
            'data' => $item
        ]);
    }

    //delete item by id
    public function deleteItemById(Request $request, $id)
    {
        $item = Item::find($id);
        if ($item == null) {
            return response()->json([
                'message' => 'item not found'
            ], 404);
        }
        $item->delete();
        return response()->json([
            'message' => 'successfully deleted item',
            'data' => $item
        ]);
    }
}
