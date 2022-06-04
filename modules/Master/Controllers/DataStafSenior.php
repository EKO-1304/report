<?php

namespace Modules\Master\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataKategoriProduk extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}

	public function kategori()
	{
    $query = $this->ModelMaster->tampildataresult("x_kategoritoko",$select="",array("deleted_at" => null),array("namakategori" => "ASC"),$group = "");

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Master Data',
			'title' => 'Data Kategori Produk',
			'query' => $query,
		];

		return view('Modules\Master\Views\kategoriproduk',$data);
	}
	public function tambah_kategori()
	{

		$rules = [
			'namakategori' => [
				'rules'  => 'required|is_unique[x_kategoritoko.namakategori]',
				'errors' => [
					'required'  => '<b>Nama Kategori</b> harus di isi !!!',
					'is_unique' => '<b>Nama Kategori</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'statuskategori' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Kategori</b> harus di pilih !!!',
				]
			],
			'iconkategori'=> [
				'rules'  => 'uploaded[iconkategori]|max_size[iconkategori,200kb]|is_image[iconkategori]|mime_in[iconkategori,image/jpg,image/jpeg,image/png]',
				'errors' => [
					'uploaded'  => '<b>{field}</b> harus di pilih !!!',
					'max_size'  => 'ukuran <b>{field}</b> anda terlalu besar !!!',
					'is_image'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
					'mime_in'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
				]
			],
		];

  if (! $this->validate($rules))
  {
    $this->session->setFlashdata('KetForm', 'tambahdata');
    return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
  }else{
    $random = sha1(time().rand(0,9999999));

    $iconkategori = $this->request->getFile('iconkategori');
    $extensionimg = $iconkategori->getExtension();
    $namaiconkategori = url_title(strtolower(filterdata($this->request->getPost("namakampus")))).".".$extensionimg; 
    $iconkategori->move('assets/toko/images/x_kategori', $namaiconkategori); 

    $data = array(
        'random'       => $random,
        'namakategori' => $this->request->getPost('namakategori'),
        'slugkategori' => url_title(strtolower($this->request->getPost('namakategori'))),
        'icon'         => $namaiconkategori,      
        'status'       => $this->request->getPost('statuskategori'),        
        'created_at'   => date("Y-m-d H:i:s"),
    );
    $status = $this->ModelMaster->datatambah($table="x_kategoritoko",$data);

    if ($status) {
      $this->logdata("x_kategoritoko","1",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Kategori Produk !' );
  		return redirect()->to('/manage-kategori-produk');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Kategori Produk !' );
  		return redirect()->to('/manage-kategori-produk');
    }

  }


}
public function edit_kategori()
{

  $rules = [
    'namakategori' => [
      'rules'  => 'required|is_unique[x_kategoritoko.namakategori,random,{random}]',
      'errors' => [
        'required'  => '<b>Nama Kategori</b> harus di isi !!!',
        'is_unique' => '<b>Nama Kategori</b> <b>{value}</b> sudah terdaftar !!!'
      ]
    ],
			'statuskategori' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Kategori</b> harus di pilih !!!',
				]
			],
			'iconkategori'=> [
				'rules'  => 'max_size[iconkategori,200kb]|is_image[iconkategori]|mime_in[iconkategori,image/jpg,image/jpeg,image/png]',
				'errors' => [
					'max_size'  => 'ukuran <b>{field}</b> anda terlalu besar !!!',
					'is_image'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
					'mime_in'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
				]
			],
  ];

  $random = $this->request->getPost('random');

    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('KetForm', 'editdata'.$random);
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
    }else{

      $iconkategori = $this->request->getFile('iconkategori');
      if($iconkategori->getError() ==  4 ){  
        $namaiconkategori = $this->request->getPost("icon");  
      }else{

        $imglama = $this->request->getPost("icon");  
        if($imglama <> ''){
          if(file_exists('assets/toko/images/x_kategori/'.$imglama)){
            unlink('assets/toko/images/x_kategori/'.$imglama);
          }
        }

        $extensionimg = $iconkategori->getExtension();
        $namaiconkategori = url_title(strtolower(filterdata($this->request->getPost("namakampus")))).".".$extensionimg; 
        $iconkategori->move('assets/toko/images/x_kategori', $namaiconkategori); 
      }

      $data = array(
        'namakategori' => $this->request->getPost('namakategori'),
        'slugkategori' => url_title(strtolower($this->request->getPost('namakategori'))),
        'icon'         => $namaiconkategori,      
        'status'       => $this->request->getPost('statuskategori'),        
        'updated_at'   => date("Y-m-d H:i:s"),
      );
      $where = array("random" => $random);
      $status = $this->ModelMaster->dataedit($table="x_kategoritoko",$where,$data);


      if ($status) {
        $this->logdata("x_kategoritoko","2",array("random" => $random));
    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Kategori Produk !' );
    		return redirect()->to('/manage-kategori-produk');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Kategori Produk !' );
    		return redirect()->to('/manage-kategori-produk');
      }
    }

}


  public function delete_kategori()
  {
    $imglama = $this->request->getPost("icon");  
    if($imglama <> ''){
      if(file_exists('assets/toko/images/x_kategori/'.$imglama)){
        unlink('assets/toko/images/x_kategori/'.$imglama);
      }
    }

    $random = $this->request->getPost('random');
    $data = array(
        "deleted_at" => date("Y-m-d H:i:s"),
    );
    $where = array("random" => $random);
  	$status = $this->ModelMaster->dataedit($table="x_kategoritoko",$where,$data);
    if ($status) {
      $this->logdata("x_kategoritoko","3",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Kategori Produk !' );
    		return redirect()->to('/manage-kategori-produk');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Kategori Produk !' );
    		return redirect()->to('/manage-kategori-produk');
    }
  }

}
