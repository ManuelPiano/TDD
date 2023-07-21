<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Property;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PropertyRequest;
use Illuminate\Http\Request; 




class PropertyController extends Controller
{
    public function index()
	{
        return response()->json([  
		    'data' => Property::all()  
		]);
	}

    public function store(PropertyRequest $request)  : JsonResponse
	{ 
		return response()->json([
			'data' => Property::create($request->all())
		], 201); 
	}


	public function update(PropertyRequest $request, Property $property)
	{
		$property->update($request->all());
		return response()->json([
			'data' => $property
		]);
	}


	public function destroy(Property $property)
{
	$property->delete();

	return response([], 204);
}
}
