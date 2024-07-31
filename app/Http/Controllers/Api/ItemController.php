<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{

    //add item
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
            'procurement_date' => 'required|date',
            'description' => 'string|max:255',
            'is_used' => 'boolean',
            'unit' => 'string|max:255',
            'sub_unit' => 'string|max:255',
            'user' => 'string|max:255',
            'sap_number' => 'string|max:255',
        ]);

        $item = Item::create($request->all());

        return response()->json([
            'message' => 'successfully added item',
            'data' => $item
        ]);
    }

    //get all items
    public function getItems()
    {
        $items = Item::all();
        return response()->json([
            'message' => 'successfully fetched items',
            'data' => $items
        ]);
    }

    //update item by id
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
            'procurement_date' => 'required|date',
            'description' => 'string|max:255',
            'is_used' => 'boolean',
            'unit' => 'string|max:255',
            'sub_unit' => 'string|max:255',
            'user' => 'string|max:255',
            'sap_number' => 'string|max:255',
        ]);
        $item = Item::find($id);
        $item->update($request->all());
        return response()->json([
            'message' => 'successfully updated item',
            'data' => $item
        ]);
    }

    //delete item by id
    public function deleteItemById($id)
    {
        $item = Item::find($id);
        $item->delete();
        return response()->json([
            'message' => 'successfully deleted item',
            'data' => $item
        ]);
    }
}
