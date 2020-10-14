<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bengkel;

class BengkelController extends Controller
{
    public function index() {
        $bengkel = Bengkel::all();

        $data = ['bengkel' => $bengkel];

        return $data;
    }

    public function create(Request $request) {
        $bengkel = new Bengkel();
        $bengkel->account_id = $request->account_id;
        $bengkel->name = $request->name;
        $bengkel->address = $request->address;
        $bengkel->save();

        return " Data Saved ";
    }

    public function update(Request $request, $id) {
        $bengkel = Bengkel::find($id);
        $bengkel->account_id = $request->account_id;
        $bengkel->name = $request->name;
        $bengkel->address = $request->address;
        $bengkel->save();

        return " Data Updated ";
    }

    public function delete($id) {
        $bengkel = Bengkel::find($id);
        
        return $bengkel;
    }
}
