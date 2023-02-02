<?php

namespace App\Controllers;
use App\Models\IndicadorFinancieroModel;

class Home extends BaseController
{
    public function index()
    {
        
        $db = db_connect();        
        $ifModel = new IndicadorFinancieroModel($db);
        $indicador = $ifModel->find('6');
        var_dump($indicador);
        return view('welcome_message');
    }
}
