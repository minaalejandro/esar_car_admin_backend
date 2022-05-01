<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EsarCars;

class CarDataController extends Controller
{
    public function getEsarCar(Request $request)
    {
        $page = $request->get('page');
        // $request->get('dates')
        $results = $request->get('results');
        if (empty($results)) {
            $datas = EsarCars::select("*")->skip(($page-1)*10)->take(10)->get();
        }
        if ($results == 10 ){
            $datas = EsarCars::select("*")->skip(($page-1)*10)->take(10)->get();
        } else if ($results == 20) {
            $datas = EsarCars::select("*")->skip(($page-1)*20)->take(20)->get();
        } else if ($results == 50) {
            $datas = EsarCars::select("*")->skip(($page-1)*50)->take(50)->get();
        } else if ($results == 100) {
            $datas = EsarCars::select("*")->skip(($page-1)*100)->take(100)->get();
        };
       
        $meta = EsarCars::select("*")->count();
        $total = ceil($meta / 10);
        return response()->json(['data' => $datas, 'total'=>$total], 200);
    }
}
