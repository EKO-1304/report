<?php

namespace Modules\Menu\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataSubMenu extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}

	public function sub_menu()
	{
    $where = array("deleted_at" => null);
    $order = array("nama_menu" => "ASC");
    $menu = $this->ModelMaster->tampildataresult("menu",$select = "",$where,$order,$group="");

    $query = $this->db
      ->table('sub_menu')
      ->select('sub_menu.new,sub_menu.manage,nama_menu,sub_menu.random as random_sub,link_sub_menu,slug_sub_menu,nama_sub_menu,sub_menu.status as status_sub,sub_menu.no_urut as no_urut_sub,id_menu,sub_menu.id')
      ->join('menu','menu.id=sub_menu.id_menu','left')
      ->where('sub_menu.deleted_at', null)
      ->get()
      ->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Sub Menu',
			'title' => 'Data Sub Menu',
			'menu' => $menu,
			'query' => $query,
		];

		return view('Modules\Menu\Views\sub_menu',$data);
	}

	public function tambah_sub_menu()
	{

    $rules = [
			'namamenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Nama Menu</b> harus di pilih !!!',
				]
			],
			'namasubmenu' => [
				'rules'  => 'required|is_unique[sub_menu.nama_sub_menu]',
				'errors' => [
					'required'  => '<b>Nama Sub Menu</b> harus di isi !!!',
					'is_unique' => '<b>Nama Sub Menu</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'linksubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Link Sub Menu</b> harus di isi !!!',
				]
			],
			'managesubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Sub Menu</b> harus di isi !!!',
				]
			],
			'statussubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Sub Menu</b> harus di isi !!!',
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
          'nama_sub_menu' => $this->request->getPost('namasubmenu'),
          'slug_sub_menu' => url_title(strtolower($this->request->getPost('namasubmenu'))),
          'id_menu' => $this->request->getPost('namamenu'),
          'link_sub_menu' => $this->request->getPost('linksubmenu'),
          'manage' => $this->request->getPost('managesubmenu'),
          'status' => $this->request->getPost('statussubmenu'),
		  'new' => $this->request->getPost('new'),
          'no_urut' => $this->request->getPost('nourut'),
          'created_at' => date("Y-m-d H:i:s"),
      );
      $status = $this->ModelMaster->datatambah("sub_menu",$data);

      if ($status) {
		$this->logdata("sub_menu","1",array("random" => $random));
		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Sub Menu !' );
		return redirect()->to('/manage-sub-menu');
      }else{
		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Sub Menu !' );
		return redirect()->to('/manage-sub-menu');
      }
    }

  }
	public function edit_sub_menu()
	{

    $rules = [
			'namamenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Nama Menu</b> harus di pilih !!!',
				]
			],
			'namasubmenu' => [
				'rules'  => 'required|is_unique[sub_menu.nama_sub_menu,random,{random}]',
				'errors' => [
					'required'  => '<b>Nama Sub Menu</b> harus di isi !!!',
					'is_unique' => '<b>Nama Sub Menu</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'linksubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Link Sub Menu</b> harus di isi !!!',
				]
			],
			'managesubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Sub Menu</b> harus di isi !!!',
				]
			],
			'statussubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Sub Menu</b> harus di isi !!!',
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
          'nama_sub_menu' => $this->request->getPost('namasubmenu'),
          'slug_sub_menu' => url_title(strtolower($this->request->getPost('namasubmenu'))),
          'id_menu' => $this->request->getPost('namamenu'),
          'link_sub_menu' => $this->request->getPost('linksubmenu'),
          'manage' => $this->request->getPost('managesubmenu'),
          'status' => $this->request->getPost('statussubmenu'),
		  'new' => $this->request->getPost('new'),
          'no_urut' => $this->request->getPost('nourut'),
          'created_at' => date("Y-m-d H:i:s"),
      );
      $where = array("random" => $random);
      $status = $this->ModelMaster->dataedit("sub_menu",$where,$data);

      if ($status) {
		$this->logdata("sub_menu","2",array("random" => $random));
		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Sub Menu !' );
		return redirect()->to('/manage-sub-menu');
      }else{
		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Sub Menu !' );
		return redirect()->to('/manage-sub-menu');
      }
    }

  }

  public function delete_sub_menu()
  {
    $random = $this->request->getPost('random');
    $data = array(
        "deleted_at" => date("Y-m-d H:i:s"),
    );
    $where = array("random" => $random);
  	$status = $this->ModelMaster->dataedit($table="sub_menu",$where,$data);
    if ($status) {
		$this->logdata("sub_menu","3",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Sub Menu !' );
  		return redirect()->to('/manage-sub-menu');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Sub Menu !' );
  		return redirect()->to('/manage-sub-menu');
    }
  }

}
