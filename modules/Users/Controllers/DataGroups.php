<?php

namespace Modules\Users\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;

class DataGroups extends BaseController
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
    $order = array("name" => "ASC");
    $query = $this->ModelMaster->tampildataresult("auth_groups",$select="",$where="",$order,$group="");

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Group Users',
			'title' => 'Data Group Users',
			'query' => $query,
		];

		return view('Modules\Users\Views\groups',$data);
	}
	public function tambah_groups()
	{

		$rules = [
			'namagroups'=> [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Nama Groups</b> harus di isi !!!',
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
          'name' => $this->request->getPost('namagroups'),
          'description' => $this->request->getPost('description'),
      );
  		$status = $this->ModelMaster->datatambah("auth_groups",$data);

      if ($status) {
    		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Groups !' );
    		return redirect()->to('/manage-groups');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Groups !' );
    		return redirect()->to('/manage-groups');
      }
    }

	}
	public function edit_groups()
	{

		$rules = [
			'namagroups'=> [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Nama Groups</b> harus di isi !!!',
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
          'name' => $this->request->getPost('namagroups'),
          'description' => $this->request->getPost('description'),
      );
	$where = array("id" => $random);
	$status = $this->ModelMaster->dataedit("auth_groups",$where,$data);

      if ($status) {
    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Groups !' );
    		return redirect()->to('/manage-groups');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Groups !' );
    		return redirect()->to('/manage-groups');
      }
    }
	}
	public function delete_groups()
	{
    $random = $this->request->getPost('random');
    $where = array("id" => $random);
		$status = $this->ModelMaster->datadelete("auth_groups",$where);

    if ($status) {
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Group User !' );
  		return redirect()->to('/manage-groups');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Group User !' );
  		return redirect()->to('/manage-groups');
    }

	}

}
