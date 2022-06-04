<?php

namespace Modules\Layout\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\Layout\Models\ModelLayout as ModelLayout;

class Layout extends BaseController
{
	protected $session;
	protected $ModelMaster;
	protected $ModelLayout;
	protected $db;

	public function __construct(){

		$this->session = service('session');
		$this->auth = service('authentication');

    	$this->ModelMaster = new ModelMaster();
		$this->ModelLayout = new ModelLayout();
		$this->db = \Config\Database::connect();

	}



	public function index()
	{
		
		return redirect()->to('manage-home');
		
	}
	public function home()
	{		

		if (! $this->auth->check())
		{
			return redirect()->to('login');
		}
		
      	$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Dashboard',
			'title' => 'Admin',
		];

		return view('Modules\Layout\Views\home',$data);
	}


}
