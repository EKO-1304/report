<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataSesiMobil extends BaseController
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
    $query = $this->ModelMaster->tampildataresult("x_sesimobil",$select="",array("deleted_at" => null),array("id" => "ASC"),$group = "");


		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Master Data',
			'title' => 'Data Sesi Mobil',
			'query' => $query,
		];

		return view('Modules\Master\Views\sesimobil',$data);
	}
	public function tambahdata()
	{

		$rules = [
			'sesi' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Sesi Mobil</b> harus di isi !!!',
				]
			],
			'status' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Sesi</b> harus di pilih !!!',
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
        'random'       => $random,
        'sesi'       => filterdata($this->request->getPost('sesi')),
        'status'       => filterdata($this->request->getPost('status')),     
        'created_at'   => date("Y-m-d H:i:s"),
    );
    $status = $this->ModelMaster->datatambah($table="x_sesimobil",$data);

    if ($status) {
      $this->logdata("x_sesimobil","1",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Sesi Mobil !' );
  		return redirect()->to('/manage-sesi-mobil');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Sesi Mobil !' );
  		return redirect()->to('/manage-sesi-mobil');
    }

  }


}
public function updatedata()
{

  $rules = [
    'sesi' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Sesi Mobil</b> harus di isi !!!',
      ]
    ],
    'status' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Status Sesi</b> harus di pilih !!!',
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
        'random'       => $random,
        'sesi'       => filterdata($this->request->getPost('sesi')), 
        'status'       => filterdata($this->request->getPost('status')),     
        'updated_at'   => date("Y-m-d H:i:s"),
    );
    $status = $this->ModelMaster->dataedit($table="x_sesimobil",["random"=>$random],$data);

    if ($status) {
      $this->logdata("x_sesimobil","2",array("random" => $random));
      $this->session->setFlashdata('sukses', 'Melakukan Edit Data Sesi Mobil !' );
      return redirect()->to('/manage-sesi-mobil');
    }else{
      $this->session->setFlashdata('gagal', 'Melakukan Edit Data Sesi Mobil !' );
      return redirect()->to('/manage-sesi-mobil');
    }

  }


}

  public function deletedata()
  {

    $random = $this->request->getPost('random');
    $data = array(
        "deleted_at" => date("Y-m-d H:i:s"),
    );
    $where = array("random" => $random);
  	$status = $this->ModelMaster->dataedit($table="x_sesimobil",$where,$data);
    if ($status) {
      $this->logdata("x_sesimobil","3",array("random" => $random));
      $this->session->setFlashdata('sukses', 'Melakukan Delete Data Sesi Mobil !' );
      return redirect()->to('/manage-sesi-mobil');
    }else{
      $this->session->setFlashdata('gagal', 'Melakukan Delete Data Sesi Mobil !' );
      return redirect()->to('/manage-sesi-mobil');
    }
  }

}
