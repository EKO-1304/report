<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataTujuanMobil extends BaseController
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
    $query = $this->ModelMaster->tampildataresult("x_tujuanmobil",$select="",array("deleted_at" => null),array("jenis" => "ASC"),$group = "");

    // $kota = $this->db->table("wilayah_kabupaten")->where("provinsi_id","33")->get()->getResultArray();
    // $no = 1;
    // foreach($kota as $k){
      
    //   $data = array(
    //       'random'       => sha1(time().$no++.rand(0,9999)),
    //       'tujuan'       => $k["nama"],
    //       'jenis'        => "luar",   
    //       'status'       => 0,     
    //       'created_at'   => date("Y-m-d H:i:s"),
    //   );
    //   $status = $this->ModelMaster->datatambah($table="x_tujuanmobil",$data);
    // }/
    
    // $kec = $this->db->table("wilayah_kecamatan")->where("kabupaten_id","3322")->get()->getResultArray();
    // // $kec = $this->db->table("wilayah_kecamatan")->where("kabupaten_id","3374")->get()->getResultArray();
    // $no = 1;
    // foreach($kec as $k){
      
    //   $data = array(
    //       'random'       => sha1(time().$no++.rand(0,9999)),
    //       'tujuan'       => "Kab. Semarang, Kec. ".$k["nama"],
    //       // 'tujuan'       => "Kota. Semarang, Kec. ".$k["nama"],
    //       'jenis'        => "dalam",   
    //       'status'       => 0,     
    //       'created_at'   => date("Y-m-d H:i:s"),
    //   );
    //   $status = $this->ModelMaster->datatambah($table="x_tujuanmobil",$data);
    // }


		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Master Data',
			'title' => 'Data Tujuan Mobil',
			'query' => $query,
		];

		return view('Modules\Master\Views\tujuanmobil',$data);
	}
	public function tambahdata()
	{

		$rules = [
			'tujuan' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Tujuan Daerah Mobil</b> harus di isi !!!',
				]
			],
			'jenis' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Jenis Tujuan</b> harus di pilih !!!',
				]
			],
			'status' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Tujuan</b> harus di pilih !!!',
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
        'tujuan'       => filterdata($this->request->getPost('tujuan')),
        'jenis'        => filterdata($this->request->getPost('jenis')),   
        'status'       => filterdata($this->request->getPost('status')),     
        'created_at'   => date("Y-m-d H:i:s"),
    );
    $status = $this->ModelMaster->datatambah($table="x_tujuanmobil",$data);

    if ($status) {
      $this->logdata("x_tujuanmobil","1",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Tujuan Daerah Mobil !' );
  		return redirect()->to('/manage-tujuan-mobil');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Tujuan Daerah Mobil !' );
  		return redirect()->to('/manage-tujuan-mobil');
    }

  }


}
public function updatedata()
{

  $rules = [
    'tujuan' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Tujuan Daerah Mobil</b> harus di isi !!!',
      ]
    ],
    'jenis' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Jenis Tujuan</b> harus di pilih !!!',
      ]
    ],
    'status' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Status Tujuan</b> harus di pilih !!!',
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
        'tujuan'       => filterdata($this->request->getPost('tujuan')),
        'jenis'        => filterdata($this->request->getPost('jenis')),   
        'status'       => filterdata($this->request->getPost('status')),     
        'updated_at'   => date("Y-m-d H:i:s"),
    );
    $status = $this->ModelMaster->dataedit($table="x_tujuanmobil",["random"=>$random],$data);

    if ($status) {
      $this->logdata("x_tujuanmobil","2",array("random" => $random));
      $this->session->setFlashdata('sukses', 'Melakukan Edit Data Tujuan Daerah Mobil !' );
      return redirect()->to('/manage-tujuan-mobil');
    }else{
      $this->session->setFlashdata('gagal', 'Melakukan Edit Data Tujuan Daerah Mobil !' );
      return redirect()->to('/manage-tujuan-mobil');
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
  	$status = $this->ModelMaster->dataedit($table="x_tujuanmobil",$where,$data);
    if ($status) {
      $this->logdata("x_tujuanmobil","3",array("random" => $random));
      $this->session->setFlashdata('sukses', 'Melakukan Delete Data Tujuan Daerah Mobil !' );
      return redirect()->to('/manage-tujuan-mobil');
    }else{
      $this->session->setFlashdata('gagal', 'Melakukan Delete Data Tujuan Daerah Mobil !' );
      return redirect()->to('/manage-tujuan-mobil');
    }
  }

}
