<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarDataController extends Controller
{
    public function getEsarCar(Request $request)
    {
        $data = "123";
       return json_encode($data);
    }
}
