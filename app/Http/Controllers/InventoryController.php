<?php

namespace App\Http\Controllers;

use App\Inventory;
use App\LocSpecific;
use App\Type;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        $type = Type::all();
        $locSpecifics = LocSpecific::where('location_id', 1)->get();

        return view('inventory', compact('type', 'locSpecifics'));
    }

    public function submit(Request $request)
    {
        if ($request->action == "Submit") {
            $inventory = new Inventory;
            $inventory->locSpecific_id = $request->locSpecific;
            $inventory->type_id = $request->type;
            $inventory->name = $request->name;

            $inventory->save();

            return redirect()->back()->with([
                'notif' => 'Record telah tersimpan',
                'itemId' => $inventory->id,
            ]);

        } elseif ($request->action == "Update") {
            $inventory = Inventory::findOrFail($request->itemId);
            $inventory->type_id = $request->type;
            $inventory->locSpecific_id = $request->locSpecific;
            $inventory->name = $request->name;

            $inventory->save();

            return redirect()->back()->with(['notif' => 'Barang Telah Diupdate']);
        }
    }

    public function search(Request $request)
    {
        $inventories = Inventory::where('type_id', $request->typeId)
            ->where('name', 'like', '%' . $request->name . '%')
            ->get();

        return response()->json($inventories);
    }

    public function searchId(Request $request)
    {
        $inventories = Inventory::findOrFail($request->itemId);

        return response()->json($inventories);
    }
}
