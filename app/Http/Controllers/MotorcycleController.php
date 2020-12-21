<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Motorcycle;
use Illuminate\Support\Facades\Auth;

class MotorcycleController extends Controller
{
    public function index()
    {
        return Motorcycle::all();
    }

    public function store(Request $request)
    {
        $motorcycle = new Motorcycle;
        $motorcycle->brand = $request->brand;
        $motorcycle->plate_number = $request->plate_number;
        $motorcycle->user_id = Auth::User()->client->user_id;

        if ($motorcycle->save()) {
            return response()->json(['message' => "Data Successfully Added"]);
        }
    }

    public function show()
    {
        return response()->json(['motorcycles' => Auth::User()->client->motorcycle]);
    }

    public function findById($id)
    {
        return response()->json(['motorcycles' => Motorcycle::find($id)]);
    }

    public function update(Request $request, $id)
    {
        $motorcycle = Motorcycle::where('user_id', Auth::User()->client->user_id)
                                    ->where('motorcycle_id', $id)->first();

        if ($request->brand != null)
            $motorcycle->brand = $request->brand;

        if ($request->plate_number != null)
            $motorcycle->plate_number = $request->plate_number;
        
        if ($motorcycle->save()) {
            return response()->json([ 'message' => "Data Successfully Updated"]);
        }
    }

    public function destroy($id)
    {
        $motorcycle = Motorcycle::where('user_id', Auth::User()->client->user_id)
                                    ->where('motorcycle_id', $id)->first();

        if ($motorcycle->delete()) {
            return response()->json([ 'message' => "Data Successfully Deleted"]);
        }
    }
}
