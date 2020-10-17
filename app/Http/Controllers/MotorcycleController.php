<?php

namespace App\Http\Controllers;

use App\Models\Motorcycle;
use Illuminate\Http\Request;

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
        $motorcycle->user_id = $request->user_id;

        if ($motorcycle->save()) {
            echo "Data Successfully Added";
        }
    }

    public function update(Request $request, $id)
    {
        $motorcycle = Motorcycle::find($id);

        if ($request->brand != null)
            $motorcycle->brand = $request->brand;

        if ($request->plate_number != null)
            $motorcycle->plate_number = $request->plate_number;

        if ($request->user_id != null)
            $motorcycle->user_id = $request->user_id;
        
        if ($motorcycle->save()) {
            echo "Data Successfully Updated";
        }
    }

    public function destroy($id)
    {
        $motorcycle = Motorcycle::find($id);

        if ($motorcycle->delete()) {
            echo "Motorcycle with id " . (int) $id . " successfully deleted";
        }
    }
}
