<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\Part;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:cars,registration_number',
            'is_registered' => 'required|boolean',
        ]);

        $car = Car::create($request->all());

        return response()->json($car, 201);
    }

    public function index()
    {
        return response()->json(Car::all(), 200, ['Content-Type' => 'application/json']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');

        $cars = Car::where('name', 'LIKE', "%{$query}%")
            ->orWhere('registration_number', 'LIKE', "%{$query}%")
            ->get();

        return response()->json($cars);
    }

    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'required|string|unique:cars,registration_number,' . $car->id,
            'is_registered' => 'required|boolean',
        ]);

        $car->update($request->all());

        return response()->json($car, 200);
    }

    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return response()->json(null, 204);
    }

    public function show($id){
        $car = Car::where('id', '=', $id)->first();

        return response()->json($car);
    }

    public function group($id){
        $parts = Part::where('car_id', '=', $id)->get();

        return response()->json($parts);
    }
}
