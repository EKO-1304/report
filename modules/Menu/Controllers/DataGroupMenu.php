<?php

namespace Modules\Menu\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataGroupMenu extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}

	public function group_menu()
	{
    $order  = array('no_urut' => 'ASC');
    $where  = array('deleted_at' => null);
    $query  = $this->ModelMaster->tampildataresult("menu_group",$select = "",$where,$order,$group = "");

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Group Menu',
			'title' => 'Data Menu Group',
			'query' => $query,
		];

		return view('Modules\Menu\Views\group_menu',$data);
	}

	public function tambah_group_menu()
	{

		$rules = [
			'namagroupsmenu' => [
				'rules'  => 'required|is_unique[menu_group.nama_group]',
				'errors' => [
					'required'  => '<b>Nama Groups Menu</b> harus di isi !!!',
					'is_unique' => '<b>Nama Groups Menu</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'managegroupsmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Groups Menu</b> harus di isi !!!',
				]
			],
			'linkgroup' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Link Groups Menu</b> harus di isi !!!',
				]
			],
			'nourut' => [
				'rules'  => 'required|alpha',
				'errors' => [
					'required'  => '<b>No Urut</b> harus di isi !!!',
					'alpha' 	=> '<b>No Urut</b> harus karakter / alfabet !!!'
				]
			],
			'new' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Menu</b> harus di pilih !!!',
				]
			],
		];

    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('KetForm', 'tambahdata');
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
	}else{
	  $random = sha1(time().rand(0,9999999));
      $data = array(
          'random' => $random,
          'nama_group' => $this->request->getPost('namagroupsmenu'),
          'slug_group' => url_title(strtolower($this->request->getPost('namagroupsmenu'))),
          'manage' => $this->request->getPost('managegroupsmenu'),
          'linkgroup' => $this->request->getPost('linkgroup'),
          'no_urut' => $this->request->getPost('nourut'),
		  'new' => $this->request->getPost('new'),
          'created_at' => date("Y-m-d H:i:s"),
      );
  		$status = $this->ModelMaster->datatambah("menu_group",$data);

      if ($status) {
		$this->logdata("menu_group","1",array("random" => $random));
		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Group Menu !' );
		return redirect()->to('/manage-menu-group');
      }else{
		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Group Menu !' );
		return redirect()->to('/manage-menu-group');
      }
    }


	}
	public function edit_group_menu()
	{

		$rules = [
			'namagroupsmenu' => [
				'rules'  => 'required|is_unique[menu_group.nama_group,random,{random}]',
				'errors' => [
					'required'  => '<b>Nama Groups Menu</b> harus di isi !!!',
					'is_unique' => '<b>Nama Groups Menu</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'managegroupsmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Groups Menu</b> harus di isi !!!',
				]
			],
			'linkgroup' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Link Groups Menu</b> harus di isi !!!',
				]
			],
			'nourut' => [
				'rules'  => 'required|alpha',
				'errors' => [
					'required'  => '<b>No Urut</b> harus di isi !!!',
					'alpha' 	=> '<b>No Urut</b> harus karakter / alfabet !!!'
				]
			],
			'new' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Menu</b> harus di pilih !!!',
				]
			],
		];

  $random = $this->request->getPost('random');

    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('KetForm', 'editdata'.$random);
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
	}else{
      $data = array(
          'nama_group' => $this->request->getPost('namagroupsmenu'),
          'slug_group' => url_title(strtolower($this->request->getPost('namagroupsmenu'))),
          'manage' => $this->request->getPost('managegroupsmenu'),
          'linkgroup' => $this->request->getPost('linkgroup'),
          'no_urut' => $this->request->getPost('nourut'),
		  'new' => $this->request->getPost('new'),
          'updated_at' => date("Y-m-d H:i:s"),
      );
      $where  = array('random' => $random);
  	  $status = $this->ModelMaster->dataedit("menu_group",$where,$data);

      if ($status) {
		$this->logdata("menu_group","2",array("random" => $random));
		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Group Menu !' );
		return redirect()->to('/manage-menu-group');
      }else{
		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Group Menu !' );
		return redirect()->to('/manage-menu-group');
      }
    }


	}

	public function delete_group_menu()
	{
    $random = $this->request->getPost('random');
    $where  = array('random' => $random);
    $data = array(
        "deleted_at" => date("Y-m-d H:i:s"),
    );
		$status = $this->ModelMaster->dataedit("menu_group",$where,$data);

    if ($status) {
		$this->logdata("menu_group","3",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Group Menu !' );
  		return redirect()->to('/manage-menu-group');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Group Menu !' );
  		return redirect()->to('/manage-menu-group');
    }
	}

}
