<?php

namespace Modules\Menu\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataMenu extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}

	public function menu()
	{
    $select = "id,random,nama_group,no_urut,manage";
    $where  = array("deleted_at" => null);
    $order  = array("no_urut" => "ASC");
    $group_menu = $this->ModelMaster->tampildataresult("menu_group",$select,$where,$order,$group = "");

    $order = array('menu_group.nama_group' => 'ASC');
    $query = $this->db
            ->table('menu')
            ->select('nama_group,menu.manage,id_group,nama_menu,menu.random,link_menu,slug_menu,menu.status,menu.no_urut,menu.id,menu.new')
            ->join('menu_group','menu_group.id=menu.id_group','left')
            ->where('menu.deleted_at', null)
            ->orderBy(key($order), $order[key($order)])
            ->get()
            ->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Menu',
			'title' => 'Data Menu',
			'group_menu' => $group_menu,
			'query' => $query,
		];

		return view('Modules\Menu\Views\menu',$data);
	}
	public function tambah_menu()
	{

		$rules = [
			'namamenu' => [
				'rules'  => 'required|is_unique[menu.nama_menu]',
				'errors' => [
					'required'  => '<b>Nama Menu</b> harus di isi !!!',
					'is_unique' => '<b>Nama Menu</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'linkmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Link Menu</b> harus di isi !!!',
				]
			],
			'namagroups' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Nama Groups Menu</b> harus di pilih !!!',
				]
			],
			'statusmenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Status Menu</b> harus di isi !!!',
				]
			],
			'managemenu' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Menu</b> harus di isi !!!',
				]
			],
			'new' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Manage Menu</b> harus di pilih !!!',
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
        'nama_menu' => $this->request->getPost('namamenu'),
        'slug_menu' => url_title(strtolower($this->request->getPost('namamenu'))),
        'id_group' => $this->request->getPost('namagroups'),
        'link_menu' => $this->request->getPost('linkmenu'),
        'manage' => $this->request->getPost('managemenu'),
        'status' => $this->request->getPost('statusmenu'),
        'no_urut' => $this->request->getPost('nourut'),
        'new' => $this->request->getPost('new'),
        'created_at' => date("Y-m-d H:i:s"),
    );
    $status = $this->ModelMaster->datatambah($table="menu",$data);

    if ($status) {
      $this->logdata("menu","1",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Menu !' );
  		return redirect()->to('/manage-menu');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Menu !' );
  		return redirect()->to('/manage-menu');
    }

  }


}
public function edit_menu()
{

  $rules = [
    'namamenu' => [
      'rules'  => 'required|is_unique[menu.nama_menu,random,{random}]',
      'errors' => [
        'required'  => '<b>Nama Menu</b> harus di isi !!!',
        'is_unique' => '<b>Nama Menu</b> <b>{value}</b> sudah terdaftar !!!'
      ]
    ],
    'linkmenu' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Link Menu</b> harus di isi !!!',
      ]
    ],
    'namagroups' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Nama Groups Menu</b> harus di pilih !!!',
      ]
    ],
    'managemenu' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Status Menu</b> harus di isi !!!',
      ]
    ],
    'statusmenu' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Status Menu</b> harus di isi !!!',
      ]
    ],
    'new' => [
      'rules'  => 'required',
      'errors' => [
        'required'  => '<b>Manage Menu</b> harus di pilih !!!',
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
          'nama_menu' => $this->request->getPost('namamenu'),
          'slug_menu' => url_title(strtolower($this->request->getPost('namamenu'))),
          'id_group' => $this->request->getPost('namagroups'),
          'link_menu' => $this->request->getPost('linkmenu'),
          'manage' => $this->request->getPost('managemenu'),
          'status' => $this->request->getPost('statusmenu'),
          'no_urut' => $this->request->getPost('nourut'),
          'new' => $this->request->getPost('new'),
          'updated_at' => date("Y-m-d H:i:s"),
      );
      $where = array("random" => $random);
      $status = $this->ModelMaster->dataedit($table="menu",$where,$data);


      if ($status) {
        $this->logdata("menu","2",array("random" => $random));
    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Menu !' );
    		return redirect()->to('/manage-menu');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Menu !' );
    		return redirect()->to('/manage-menu');
      }
    }

}


  public function delete_menu()
  {
    $random = $this->request->getPost('random');
    $data = array(
        "deleted_at" => date("Y-m-d H:i:s"),
    );
    $where = array("random" => $random);
  	$status = $this->ModelMaster->dataedit($table="menu",$where,$data);
    if ($status) {
      $this->logdata("menu","3",array("random" => $random));
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Menu !' );
  		return redirect()->to('/manage-menu');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Menu !' );
  		return redirect()->to('/manage-menu');
    }
  }

}
