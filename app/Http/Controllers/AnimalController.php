<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Requests\AnimalRequest;
use App\Http\Resources\AnimalResource;
use App\Models\Animal;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function index()
    {
        $animals = Animal::paginate(20);

        if (!$animals) {
            throw new NotFoundException('Animals not found');
        }

        return AnimalResource::collection($animals)->response();
    }

    public function getAnimal($id)
    {
        $animal = Animal::firstWhere('id', $id);

        if (!$animal) {
            throw new NotFoundException('Animal not found');
        }

        return AnimalResource::make($animal)->response();
    }

    public function create(AnimalRequest $request)
    {
        try {
            $animal = Animal::create($request->only('name', 'type', 'description'));
        } catch (\Exception $e) {
            throw new NotFoundException('Failed to create Animal');
        }

        return AnimalResource::make($animal)->response();
    }

    public function update(Request $request, $id)
    {
        $animal = Animal::firstWhere('id', $id);

        if (!$animal) {
            throw new NotFoundException('Failed to update Animal');
        }

        $animal->update($request->only('name', 'type', 'description'));

        return AnimalResource::make($animal)->response();
    }

    public function delete($id)
    {
        $animal = Animal::firstWhere('id', $id);

        if (!$animal) {
            throw new NotFoundException('Animal not found');
        }

        $animal->delete();

        return response()->json(['status' => true], 200);
    }
}
