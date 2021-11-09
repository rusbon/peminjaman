<?php

namespace App\Http\Controllers;

use App\Loaning;
use App\Type;
use Illuminate\Http\Request;

class LoaningController extends Controller
{
    public function index()
    {
        $type = Type::all();
        return view('loaning', compact('type'));
    }

    public function submit(Request $request)
    {
        $loaning = new Loaning;
        $loaning->inventory_id = $request->itemId;
        $loaning->name = $request->username;
        $loaning->nrp = $request->nrp;
        $loaning->quantity = $request->quantity;

        $loaning->save();

        return redirect()->back()->with('notif', 'Data Telah Tersimpan!');
    }
}
