<?php namespace App\Models;

use CodeIgniter\Model;

class IndicadorFinancieroModel extends Model{
    protected $table = 'indicadorfinancieros';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $allowedFields = ['nombreindicador','codigoindicador','unidadmedidaindicador','valorindicador','fechaindicador'];
    protected $validationRules =[
        'nombreindicador'=>'required|min_length[1]',
        'codigoindicador'=>'required|min_length[1]',
        'unidadmedidaindicador'=>'required|min_length[1]',
        'valorindicador'=>'required|numeric|min_length[1]',
        'fechaindicador'=>'required|min_length[1]|is_unique[indicadorfinancieros.fechaindicador,indicadorfinancieros.id,{id}]',
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    protected $skipValidation = false;
}


