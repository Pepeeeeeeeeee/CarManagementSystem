<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;

class PartController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'car_id' => 'required|exists:cars,id',
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:parts,serial_number',
        ]);

        $part = Part::create($request->all());

        return response()->json($part, 201);
    }

    public function index()
    {
        return response()->json(Part::all(), 200, ['Content-Type' => 'application/json']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $cars = Part::where('name', 'LIKE', "%{$query}%")
            ->orWhere('serial_number', 'LIKE', "%{$query}%")
            ->orWhere('car_id', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($cars);
    }

    public function update(Request $request, $id)
    {
        $part = Part::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'serial_number' => 'required|string|unique:cars,registration_number,' . $part->id,
            'car_id' => 'required|int',
        ]);

        $part->update($request->all());

        return response()->json($part, 200);
    }

    public function destroy($id)
    {
        $car = Part::findOrFail($id);
        $car->delete();

        return response()->json(null, 204);
    }

    public function show($id){
        $car = Part::where('id', '=', $id)->first();

        return response()->json($car);
    }

    public function group($id){
        $car = Car::where('id', '=', $id)->first();

        return response()->json($car);
    }
}
