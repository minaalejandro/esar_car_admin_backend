<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;

class CarListController extends Controller
{
   public function getOwners(Request $request) {
       $search = $request['0'];
       $owners = User::select('email')->where('email', 'like','%' .$search.'%')->take(5)->get();
       return response()->json(['owners' => $owners,], 200);
   }

   public function chooseManufacturer($year) {
        $cars = DB::table('esar_cars')
        ->select('model_make_id AS manufacturer', 'manufacturer_arabic AS manufacturerArabic')
        ->where('model_year', $year)
        ->distinct()
        ->get();
    return response()->json(['data' => $cars], 200);
    }
    public function chooseModel(Request $request)
    {
        $models = DB::table('esar_cars')
            ->where('model_year', $request['year'])
            ->where('model_make_id', $request['manufacturer'])
            ->distinct()
            ->pluck('model_name');
        return response()->json(['data' => $models], 200);
    }
    public function getTransmission(Request $request)
    {
        $models = DB::table('esar_cars')
            ->select('model_transmission_type AS modelTransmissionType', 'model_transmission_type_arabic AS modelTransmissionTypeArabic')
            ->where('model_year', $request['year'])
            ->where('model_make_id', $request['manufacturer'])
            ->where('model_name', $request['model'])
            ->distinct()
            ->get();
        return response()->json(['data' => $models], 200);
    }
}
