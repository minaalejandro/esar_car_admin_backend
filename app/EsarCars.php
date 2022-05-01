<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EsarCars extends Model
{
    protected $table = 'esar_cars';
    protected $fillable = [
		'model_make_id', 'model_name', 'model_trim', 'model_year','model_transmission_type','model_body'
	];
}