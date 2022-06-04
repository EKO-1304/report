<?php

namespace Modules\Users\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;

class DataGroupsPermissions extends BaseController
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
    $order  = array("description" => "ASC");
    $permissions = $this->ModelMaster->tampildataresult("auth_permissions",$select="",$where="",$order,$group="");
    $order  = array("description" => "ASC");
    $groups = $this->ModelMaster->tampildataresult("auth_groups",$select="",$where="",$order,$group);
    $query  = $this->db
              ->table('auth_groups_permissions')
              ->select('auth_groups.description as description_groups, auth_permissions.name as name_permissions, auth_groups_permissions.group_id as g_id,permission_id')
              ->join('auth_groups', 'auth_groups.id = auth_groups_permissions.group_id')
              ->join('auth_permissions', 'auth_permissions.id = auth_groups_permissions.permission_id')
              ->groupBy('auth_groups_permissions.group_id')
              ->get()
              ->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Group Permissions Users',
			'title' => 'Data Group Permissions Users',
			'permissions' => $permissions,
			'groups' => $groups,
			'query' => $query,
		];

		return view('Modules\Users\Views\groups_permissions',$data);
	}

	public function tambah_groups_permissions()
	{


		$rules = [
			'groups' => [
				'rules'  => 'required|is_unique[auth_groups_permissions.group_id]',
				'errors' => [
					'required'  => '<b>Groups</b> harus di pilih !!!',
					'is_unique' => 'groups sudah terdaftar !!!'
				]
			],'permissions' => [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Permissions</b> harus di pilih !!!',
				]
			]
		];

		if (! $this->validate($rules))
		{
      $this->session->setFlashdata('KetForm', 'tambahdata');
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
		}else{

      $groups = $this->request->getPost('groups');
      $count = count($this->request->getPost('permissions'));
      $permissions = implode(",",$this->request->getPost('permissions'));

  		for($i=0;$i < $count;$i++){

  			$data = explode(',',$permissions);
  			$id_permissions = $data[$i];
        $data = array(
            'group_id' => $groups,
            'permission_id' => $id_permissions,
        );
        $status = $this->ModelMaster->datatambah("auth_groups_permissions",$data);

  		}

      if ($status) {
    		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Groups Permissions !' );
    		return redirect()->to('/manage-groups-permissions');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Groups Permissions !' );
    		return redirect()->to('/manage-groups-permissions');
      }
    }

	}
	public function edit_groups_permissions()
	{

    $rules = [
      'groups' => [
        'rules'  => 'required|is_unique[auth_groups_permissions.group_id,group_id,{groups}]',
        'errors' => [
          'required'  => '<b>Groups</b> harus di pilih !!!',
          'is_unique' => 'groups sudah terdaftar !!!'
        ]
      ],'permissions' => [
        'rules'  => 'required',
        'errors' => [
          'required'  => '<b>Permissions</b> harus di pilih !!!',
        ]
      ]
    ];

    $random = $this->request->getPost('random');
    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('KetForm', 'editdata'.$random);
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
    }else{

      $groups = $this->request->getPost('groups');
      $count = count($this->request->getPost('permissions'));
      $permissions = implode(",",$this->request->getPost('permissions'));

      $where = array("group_id" => $groups);
      $this->ModelMaster->datadelete("auth_groups_permissions",$where);

      for($i=0;$i < $count;$i++){

        $data = explode(',',$permissions);
        $id_permissions = $data[$i];
        $data = array(
            'group_id' => $groups,
            'permission_id' => $id_permissions,
        );
        $status = $this->ModelMaster->datatambah("auth_groups_permissions",$data);

      }

      if ($status) {
    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Groups Permissions !' );
    		return redirect()->to('/manage-groups-permissions');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Groups Permissions !' );
    		return redirect()->to('/manage-groups-permissions');
      }

    }

	}
	public function delete_groups_permissions()
	{
    $random = $this->request->getPost('random');
    $where = array("group_id" => $random);
    $hapus = $this->ModelMaster->datadelete("auth_groups_permissions",$where);

    if ($hapus) {
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data Groups Permissions !' );
  		return redirect()->to('/manage-groups-permissions');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data Groups Permissions !' );
  		return redirect()->to('/manage-groups-permissions');
    }
	}
}
