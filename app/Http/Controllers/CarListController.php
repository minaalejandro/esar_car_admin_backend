<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use DB;
use App\AllCar;
use App\Car;

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
    public function getCarData(Request $request)
    {
        $models = AllCar::where('model_year', $request['year'])
            ->where('model_make_id', $request['manufacturer'])
            ->where('model_name', $request['model'])
            ->where('model_transmission_type', $request['transmission'])
            ->get();
            return response()->json(['data' => $models], 200);
    }

    public function addCar(Request $request) {
        $user_email = $request['user_email'];
        $user = User::where('email', $user_email)->get();
        $user_id = $user[0] ->id;

        $car = new Car;
        $car->user_id = $user_id;
        $car->long_location = $request['long_location'];
        $car->lat_location = $request['lat_location'];
        $car->car_city = $request['car_city'];
        $car->car_manufacturer = $request['car_manufacturer'];
        $car->car_model = $request['car_model'];
        $car->production_year = $request['production_year'];
        $car->trim = $request['trim'];
        $car->style = $request['style'];
        $car->car_transmission = $request['car_transmission'];
        $car->brended = 1;
        $car->car_value = $request['car_value'];
        $car->car_odometer = 1;
        $car->save();

        return json_encode(['car' => $car], 200);
    }

    public function updateNotice(Request $request, $id) {
        $car = Car::find($id);
        $car->notice = $request['advance_notice'];
        $car->short_trip = $request['short_possible_trip'];
        $car->long_trip = $request['long_possible_trip'];
        $car->save();
        return json_encode(['message' =>"sucess"], 200);
    }
}
