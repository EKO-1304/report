<?php

namespace Modules\Users\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;

class DataPermissions extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}

	public function index()
	{
    $order = array("description" => "ASC");
    $query = $this->ModelMaster->tampildataresult("auth_permissions",$select="",$where="",$order,$group="");

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Permissions Users',
			'title' => 'Data Permissions Users',
			'query' => $query,
		];

		return view('Modules\Users\Views\permissions',$data);
	}
	public function tambah_permissions()
	{

    $rules = [
      'namapermissions'=> [
        'rules'  => 'required',
        'errors' => [
          'required'  => '<b>Nama Permissions</b> harus di isi !!!',
        ]
      ],
      'description'=> [
        'rules'  => 'required',
        'errors' => [
          'required'  => '<b>Description</b> harus di isi !!!',
        ]
      ]

    ];

    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('KetForm', 'tambahdata');
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
    }else{
      $data = array(
          'name' => $this->request->getPost('namapermissions'),
          'description' => $this->request->getPost('description'),
      );
  		$status = $this->ModelMaster->datatambah("auth_permissions",$data);

      if ($status) {
      
        $this->logdata("auth_permissions","1",array("name" => $this->request->getPost('namapermissions')));
  
    		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Permissions !' );
    		return redirect()->to('/manage-permissions');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Permissions !' );
    		return redirect()->to('/manage-permissions');
      }
    }

	}
	public function edit_permissions()
	{
    $rules = [
      'namapermissions'=> [
        'rules'  => 'required',
        'errors' => [
          'required'  => '<b>Nama Permissions</b> harus di isi !!!',
        ]
      ],
      'description'=> [
        'rules'  => 'required',
        'errors' => [
          'required'  => '<b>Description</b> harus di isi !!!',
        ]
      ]

    ];

    $random = $this->request->getPost('random');
    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('KetForm', 'editdata'.$random);
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
    }else{
      $data = array(
          'name' => $this->request->getPost('namapermissions'),
          'description' => $this->request->getPost('description'),
      );
      $where = array("id" => $random);
  		$status = $this->ModelMaster->dataedit("auth_permissions",$where,$data);

      if ($status) {

        $this->logdata("auth_permissions","2",array("id" => $random));

    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Permissions !' );
    		return redirect()->to('/manage-permissions');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Permissions !' );
    		return redirect()->to('/manage-permissions');
      }
    }

	}

	public function delete_permissions()
	{
    $random = $this->request->getPost('random');
    $this->logdata("auth_permissions","3",array("id" => $random));
    $where = array("id" => $random);
		$status = $this->ModelMaster->datadelete("auth_permissions",$where);

    if ($status) {


  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Permissions !' );
  		return redirect()->to('/manage-permissions');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Permissions !' );
  		return redirect()->to('/manage-permissions');
    }

	}

}
