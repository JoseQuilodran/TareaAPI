<?php

namespace App\Controllers;
use CodeIgniter\API\ResponseTrait;
use App\Models\IndicadorFinancieroModel;

class IndicadorFinancieroController extends BaseController
{
    use ResponseTrait;
    public function index()
    {   
        $modelo = new IndicadorFinancieroModel();
        $data['indicadores_uf'] = $modelo->orderBy('fechaindicador','DESC')->findAll();  
        return view('header').view('indicadorFinancieroView',$data);
    } 

    public function getAll()
    {   
        $modelo = new IndicadorFinancieroModel();
        $data['data'] = $modelo->orderBy('fechaindicador','DESC')->findAll();  
        return $this->respond($data, 200);
    } 
    public function getGraph()
    {   
        helper(['form','url']);
        $modelo = new IndicadorFinancieroModel();
        $fechaInicio=$this->request->getVar('fechaInicio');
        $fechaFin=$this->request->getVar('fechaFin');
        $x = array();
        $y = array();
        if(empty($fechaInicio)||empty($fechaFin)) {
            $filtro =$modelo->select('fechaindicador,valorindicador')->orderBy('fechaindicador','DESC')->findAll();
            foreach ($filtro as $row) {
                array_push($x, $row['fechaindicador']);
                array_push($y, $row['valorindicador']);
            }
            $data=[
                "x"=>$x,
                "y"=>$y
            ];
            return $this->respond($data, 200);
        }     
        if($fechaInicio> $fechaFin) {            
            $data=[
                "x"=>[],
                "y"=>[]
            ];
            return $this->respond($data, 400);
        }    
        
        $filtro =$modelo->select('fechaindicador,valorindicador')->where('fechaindicador >=',$fechaInicio)->where('fechaindicador <=',$fechaFin)->orderBy('fechaindicador','DESC')->findAll();
        foreach ($filtro as $row) {
            array_push($x, $row['fechaindicador']);
            array_push($y, $row['valorindicador']);
        }
        $data=[
            "x"=>$x,
            "y"=>$y
        ];
        return $this->respond($data, 200);
        
    } 

    public function create()
    {   
        
        helper(['form','url']);        
        $modelo = new IndicadorFinancieroModel();
        $existeFecha =$modelo->where('fechaindicador',$this->request->getVar('addDate'))->countAllResults();
        if ($existeFecha > 0) {           
            return $this->fail(null, 402,"fecha ya esta registrada");
        }

        $maxIdRow = $modelo->orderBy('id','DESC')->first();
        $newId=$maxIdRow['id']+1;
        
        $data = [                    
            'id'=>$newId,
            'nombreindicador'  => 'UNIDAD DE FOMENTO (UF)',
            'codigoindicador'  => 'UF',
            'unidadmedidaindicador'  => 'Pesos',
            'valorindicador'  => $this->request->getVar('addValue'),
            'fechaindicador'  => $this->request->getVar('addDate'),
        ];
                
        $create = $modelo->insert($data,false);
               
        if($create != false){           
            echo json_encode (array("status" => true));
        }
        else{          
            echo json_encode (array("status" => false));
        }        
    } 
    public function update()
    {   
        
        helper(['form','url']);        
        $modelo = new IndicadorFinancieroModel();         
        $data = [       
            'valorindicador'  => $this->request->getVar('updateValue'),
        ];
                
        $update = $modelo->update($this->request->getVar('updateId'),$data);
               
        if($update != false){           
            echo json_encode (array("status" => true));
        }
        else{          
            echo json_encode (array("status" => false));
        }        
    }
    public function delete()
    {   
        
        helper(['form','url']);        
        $modelo = new IndicadorFinancieroModel();       
        $delete = $modelo->delete($this->request->getVar('deleteId'));
               
        if($delete != false){           
            echo json_encode (array("status" => true));
        }
        else{          
            echo json_encode (array("status" => false));
        }        
    } 
    
}
