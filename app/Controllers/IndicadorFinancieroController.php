<?php

namespace App\Controllers;
use App\Models\IndicadorFinancieroModel;

class IndicadorFinancieroController extends BaseController
{
    public function index()
    {   
        $modelo = new IndicadorFinancieroModel();
        $data['indicadores_uf'] = $modelo->orderBy('fechaindicador','DESC')->findAll();  
        return view('header').view('indicadorFinancieroView',$data);
    } 
}
