<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use DateTime;
use CalculoNomina;
class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = [];

	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
        //Set Timezone
        date_default_timezone_set("America/Mexico_City");
        //date_default_timezone_set("America/Mazatlan");
        $this->session = \Config\Services::session();
        $this->db = \Config\Database::connect();
		//$this->mesa=\Config\Database::connect('mesa',true);
		//$this->federacion=\Config\Database::connect('federacion',true);

        helper('functions');
        helper('vacaciones');
        helper('anticipos');
        helper('nomina');
        helper('excel');
        helper('gcrud');
		helper('mesadeayuda');
		helper('correo');


        $this->session->start();
        //$this->permisos = getPermisos($this->session->get('id'),$this);
        //$this->session->set('permisos',$this->permisos);
	}

}