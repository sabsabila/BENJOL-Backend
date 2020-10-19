<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bengkel;

class BengkelController extends Controller
{
    public function index() {
        return Bengkel::all();
    }

    public function store(Request $request) {
        $bengkel = new Bengkel;
        $bengkel->account_id = $request->account_id;
        $bengkel->name = $request->name;
        $bengkel->address = $request->address;

        if ($bengkel->save()) {
            echo "Data Successfully Added";
        }
    }

    public function show($id)
    {
        return Bengkel::find($id);
    }

    public function update(Request $request, $id) {
        $bengkel = Bengkel::find($id);

        if ($request->account_id != null)
            $bengkel->account_id = $request->account_id;
        
        if ($request->name != null)
            $bengkel->name = $request->name;

        if ($request->address != null)
            $bengkel->address = $request->address;
        
        if ($bengkel->save()) {
            echo "Data Successfully Updated";
        }
    }

    public function delete($id) {
        $bengkel = Bengkel::find($id);
        
        if ($bengkel->delete()) {
            echo "Bengkel with id " . (int) $id . " successfully deleted";
        }
    }
}
