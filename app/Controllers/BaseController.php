<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


use Modules\Users\Models\ModelUsers;

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

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['auth','my_helpers'];
	protected $db;

	public function __construct(){
		$this->ModelMaster = new ModelMaster();
		$this->db = \Config\Database::connect();
	}
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}
	public function logdata($table,$status,$where)
	{
		$this->builder = $this->db->table($table);
		$this->builder->select("*");
		$this->builder->where($where);
		$query = $this->builder->get();
		$dt = $query->getRowArray();
		$logfield = json_encode($dt);

		$data = array(
			"random"     => sha1(time().rand(0,9999999999)),
			"id_user"    => user()->id,
			"ip"         => $this->request->getIPAddress(),
			"browser"    => (string)$this->request->getUserAgent(),
			"tabel"      => $table,
			"idtabel"    => $dt['id'],
			"status"     => $status,
			"keterangan" => $logfield,
			"created_at" => date("Y-m-d H:i:s"),
		);
	    $this->db->table("logdata")->insert($data);
	}
	
	public function profilecek($random)
	{
		$this->builder = $this->db->table("profile_user");
		$this->builder->where("random",$random);
		$total = $this->builder->countAllResults();
		return $total;
		
	}
	
		
  
}
