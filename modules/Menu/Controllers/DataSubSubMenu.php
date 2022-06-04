<?php

namespace Modules\Menu\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataSubSubMenu extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}

	public function sub_sub_menu()
	{
    $where = array("deleted_at" => null);
    $order = array("nama_sub_menu" => "ASC");
    $sub_menu = $this->ModelMaster->tampildataresult("sub_menu",$select = "",$where,$order,$group="");

    $query = $this->db
      ->table('sub_sub_menu')
      ->select('sub_sub_menu.manage,nama_sub_menu,sub_sub_menu.random as random_sub_sub,link_sub_sub_menu,slug_sub_sub_menu,nama_sub_sub_menu,sub_sub_menu.status as status_sub_sub,sub_sub_menu.no_urut as no_urut_sub_sub,id_sub_menu,sub_sub_menu.id')
      ->join('sub_menu','sub_menu.id=sub_sub_menu.id_sub_menu','left')
      ->where('sub_sub_menu.deleted_at', null)
      ->get()
      ->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Sub-Sub Menu',
			'title' => 'Data Sub-Sub Menu',
			'sub_menu' => $sub_menu,
			'query' => $query,
		];

		return view('Modules\Menu\Views\sub_sub_menu',$data);
	}

	public function tambah_sub_sub_menu()
	{

    $rules = [
			'namasubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Nama Menu</b> harus di pilih !!!',
				]
			],
			'namasubsubmenu' => [
				'rules'  => 'required|is_unique[sub_sub_menu.nama_sub_sub_menu]',
				'errors' => [
					'required'  => '<b>Nama Sub-Sub Menu</b> harus di isi !!!',
					'is_unique' => '<b>Nama Sub-Sub Menu</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'linksubsubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Link Sub-Sub Menu</b> harus di isi !!!',
				]
			],
			'managesubsubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Sub-Sub Menu</b> harus di isi !!!',
				]
			],
			'statussubsubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Sub-Sub Menu</b> harus di isi !!!',
				]
			],
			'nourut' => [
				'rules'  => 'required|alpha',
				'errors' => [
					'required'  => '<b>No Urut</b> harus di isi !!!',
					'alpha' 	=> '<b>No Urut</b> harus karakter / alfabet !!!'
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
          'nama_sub_sub_menu' => filterdata($this->request->getPost('namasubsubmenu')),
          'slug_sub_sub_menu' => url_title(strtolower(filterdata($this->request->getPost('namasubsubmenu')))),
          'id_sub_menu' => filterdata($this->request->getPost('namasubmenu')),
          'link_sub_sub_menu' => filterdata($this->request->getPost('linksubsubmenu')),
          'manage' => filterdata($this->request->getPost('managesubsubmenu')),
          'status' => filterdata($this->request->getPost('statussubsubmenu')),
          'no_urut' => filterdata($this->request->getPost('nourut')),
          'created_at' => date("Y-m-d H:i:s"),
      );
      $status = $this->ModelMaster->datatambah("sub_sub_menu",$data);

      if ($status) {
		$this->logdata("sub_sub_menu","1",array("random" => $random));
		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Sub-Sub Menu !' );
		return redirect()->to('/manage-sub-sub-menu');
      }else{
		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Sub-Sub Menu !' );
		return redirect()->to('/manage-sub-sub-menu');
      }
    }

  }
	public function edit_sub_sub_menu()
	{

    $rules = [
			'namasubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Nama Menu</b> harus di pilih !!!',
				]
			],
			'namasubsubmenu' => [
				'rules'  => 'required|is_unique[sub_sub_menu.nama_sub_sub_menu,random,{random}]',
				'errors' => [
					'required'  => '<b>Nama Sub-Sub Menu</b> harus di isi !!!',
					'is_unique' => '<b>Nama Sub-Sub Menu</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'linksubsubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Link Sub-Sub Menu</b> harus di isi !!!',
				]
			],
			'managesubsubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Sub-Sub Menu</b> harus di isi !!!',
				]
			],
			'statussubsubmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Sub-Sub Menu</b> harus di isi !!!',
				]
			],
			'nourut' => [
				'rules'  => 'required|alpha',
				'errors' => [
					'required'  => '<b>No Urut</b> harus di isi !!!',
					'alpha' 	=> '<b>No Urut</b> harus karakter / alfabet !!!'
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
          'nama_sub_sub_menu' => filterdata($this->request->getPost('namasubsubmenu')),
          'slug_sub_sub_menu' => url_title(strtolower(filterdata($this->request->getPost('namasubsubmenu')))),
          'id_sub_menu' => filterdata($this->request->getPost('namasubmenu')),
          'link_sub_sub_menu' => filterdata($this->request->getPost('linksubsubmenu')),
          'manage' => filterdata($this->request->getPost('managesubsubmenu')),
          'status' => filterdata($this->request->getPost('statussubsubmenu')),
          'no_urut' => filterdata($this->request->getPost('nourut')),
          'created_at' => date("Y-m-d H:i:s"),
      );
      $where = array("random" => $random);
      $status = $this->ModelMaster->dataedit("sub_sub_menu",$where,$data);

      if ($status) {
		$this->logdata("sub_sub_menu","2",array("random" => $random));
		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Sub-Sub Menu !' );
		return redirect()->to('/manage-sub-sub-menu');
      }else{
		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Sub-Sub Menu !' );
		return redirect()->to('/manage-sub-sub-menu');
      }
    }

  }

  public function delete_sub_sub_menu()
  {
    $random = $this->request->getPost('random');
    $data = array(
        "deleted_at" => date("Y-m-d H:i:s"),
    );
    $where = array("random" => $random);
  	$status = $this->ModelMaster->dataedit($table="sub_sub_menu",$where,$data);
    if ($status) {
		$this->logdata("sub_sub_menu","3",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Sub-Sub Menu !' );
  		return redirect()->to('/manage-sub-sub-menu');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Sub-Sub Menu !' );
  		return redirect()->to('/manage-sub-sub-menu');
    }
  }

}
