<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

use App\Models\IndicadorFinancieroModel;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    // protected $session;

    /**
     * Constructor.
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
                
        ini_set('display_errors', 1);
        $db = db_connect(); 
        if($db->tableExists('indicadorfinancieros')){           }
        else{   
            echo 'tabla no existe!.. creando';         
            $db->query('CREATE TABLE IndicadorFinancieros (
                id NUMERIC PRIMARY KEY,
                nombreIndicador VARCHAR NOT NULL CHECK (char_length(nombreIndicador) >= 1),
                codigoIndicador VARCHAR NOT NULL CHECK (char_length(codigoIndicador) >= 1),
                unidadmedidaindicador VARCHAR NOT NULL CHECK (char_length(unidadmedidaindicador) >= 1),
                valorIndicador DOUBLE PRECISION NOT NULL CHECK (valorIndicador >= 0),
                fechaIndicador VARCHAR NOT NULL CHECK (char_length(fechaIndicador) >= 1),
                created_at TIMESTAMP  ,
                updated_at TIMESTAMP       
            );');
        };        
        $query = $db->query('SELECT * FROM indicadorfinancieros');
        if ($query->getNumRows()==0) {            
        
        //Obtener un token JWT mediante POST para acceder a los indicadores
        $client = \Config\Services::curlrequest();
        $body =array('userName'=>getenv('API_USERNAME') ,'flagJson'=> true);
        $response = $client->post('https://postulaciones.solutoria.cl/api/acceso',['json' => $body]);          
        $token =$response->getBody();
        $jwt = json_decode($token)->token;
        //Obtener todos los indicadores financieros mediante un POST con el Token anterior en el cuerpo de la solicitud        
        
        $response = $client->request('get','https://postulaciones.solutoria.cl/api/indicadores',[
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer '.$jwt              
            ]
        ]);      
        $data = $response->getBody();   
        
        //Transformar la resuesta JSON a un array 
        //recorrer el arreglo y guardar los indicadores de UF solamente
        
        $decoded = json_decode($data,true);
        $indicadorFinancieroModel = new IndicadorFinancieroModel($db);

        foreach($decoded as $item){      
            if(strcmp($item['codigoIndicador'],'UF')==0){              
               
                $data = [                    
                    'id'=>$item['id'],
                    'nombreindicador'  => $item['nombreIndicador'],
                    'codigoindicador'  => $item['codigoIndicador'],
                    'unidadmedidaindicador'  => 'Pesos',
                    'valorindicador'  => $item['valorIndicador'],
                    'fechaindicador'  => $item['fechaIndicador'],
                ];
                
               $indicadorFinancieroModel->insert($data);
            }     
                   
        }

        
        
        
        
        }       
    }
}
