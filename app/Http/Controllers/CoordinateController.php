<?php

namespace App\Http\Controllers;

use App\Http\Requests\CoordinateRequest;
use App\Http\Resources\CoordinateResource;
use App\Models\Coordinate;
use Illuminate\Http\Request;

class CoordinateController extends Controller
{
    public function coordinates(CoordinateRequest $request){
        $data = $request->validated();
        Coordinate::create([
            'latitude'=>$data['lat'],
            'longitude'=>$data['lng']
        ]);
        return response()->json([
            'status'=>200
        ]);
    }
    public function getCoordinates(Request $request){
       $coordinats = Coordinate::all();
       return CoordinateResource::collection($coordinats);
    }
    public function deleteCoordinates(){
        $oneMinuteAgo = now()->subMinute();
      Coordinate::where('created_at', '<=', $oneMinuteAgo)
            ->delete();
    }
}
