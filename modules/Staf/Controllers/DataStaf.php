<?php

namespace Modules\Staf\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\Staf\Models\ModelStaf;
use CodeIgniter\I18n\Time;
use Myth\Auth\Entities\User;

class DataStaf extends BaseController
{
	protected $config;
	protected $session;
  protected $db;
	protected $ModelStaf;

	public function __construct(){
		$this->session = service('session');
		$this->config = config('Auth');

		$this->ModelStaf = new ModelStaf();
    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();
		$this->auth = service('authentication');

	}

	public function index()
	{

    $groups = $this->db->table('auth_groups')->get()->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Staf KPF',
			'title' => 'Data Staf KPF',
			'groups' => $groups,
		];

		return view('Modules\Staf\Views\staf',$data);
	}

	public function staf_json()
	{
    $data_model = $this->ModelStaf;
    $list = $data_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $lists) {
        $random = $lists->random;
        $groupid = $lists->group_id;

        $pro = $this->db->table("profile_user")->select("no_telp")->where("random",$random)->get()->getRowArray();
        if($pro <> null){

          $notelp1 = substr($pro["no_telp"],0,2);
          $notelp = str_replace(" ","",str_replace("+","",str_replace("-","",$pro["no_telp"])));
          if($notelp1 == '08'){
            $notelp2 = substr($pro["no_telp"],1);
            $nowa = '62'.$notelp2;
          }elseif($notelp1 == '62'){
            $notelp2 = substr($pro["no_telp"],2);
            $nowa = '62'.$notelp2;
          }else{
            $nowa = $notelp;
          }

          $nomorwa = '<a href="https://wa.me/'.$nowa.'" target="_BLANK" class="badge badge-success badge-pill"><i class="icon-copy ion-social-whatsapp"></i> '.$nowa.'</a>';
        }else{
          $nomorwa ='';
        }
        $active = $lists->status;;
        if($active <> "banned"){
          $act = "Active";
          $bg = "badge-success";
        }else{
          $act = "Non Active";
          $bg = "badge-danger";
        }

        $no++;
        $row    = array();
        $row[]  = $no;
        $row[]  = $lists->fullname;
        $row[]  = $lists->description;
        $row[]  = $nomorwa;
        $row[]  = '<span class="badge text-light badge-pill '.$bg.'">'.$act.'</span>';

        $action = '';
        $action .= '
                  <div class="">
                      <a class="btn btn-sm btn-danger px-2 py-1" href="#" id="'.$random.'"  onclick="deletedata(this.id)" ><i class="icon-copy dw dw-trash1"></i></a>
                      <a class="btn btn-sm btn-success px-2 py-1" href="'.base_url('manage-staf/edit/'.$random).'"><i class="dw dw-edit2"></i></a>
                  </div>';


        $row[]  = $action;
        
        $data[] = $row;
    }

    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $data_model->count_all(),
        "recordsFiltered" => $data_model->count_filtered(),
        "data" => $data,
    );
    
    $output[csrf_token()] = csrf_hash();

    echo json_encode($output);
    
    
	}
	public function tambahstaf()
	{

    $groups = $this->db->table('auth_groups')->get()->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Staf KPF',
			'title' => 'Form Tambah Data Staf KPF',
			'groups' => $groups,
		];

		return view('Modules\Staf\Views\tambahusers',$data);
	}
	public function tambah_staf()
	{

  		$rules = [
  			'fullname' => [
  				'rules'  => 'required|is_unique[users.fullname]',
  				'errors' => [
  					'required'  => '<b>Nama Lengkap</b> harus di isi !!!',
  					'is_unique' => 'Nama Lengkap <b>{value}</b> sudah terdaftar !!!',
  				]
  			],
  			'email' => [
  				'rules'  => 'required|valid_email|is_unique[users.email]',
  				'errors' => [
  					'required'  => '<b>E-mail</b> harus di isi !!!',
  					'is_unique' => 'E-mail <b>{value}</b> sudah terdaftar !!!',
  					'valid_email'  => '<b>E-mail</b> format bukan email !!!',
  				]
  			],
  			'username' => [
  				'rules'  => 'required|alpha_numeric|is_unique[users.username]|min_length[4]',
  				'errors' => [
  					'required'  => '<b>Username</b> harus di isi !!!',
  					'is_unique' => '<b>Username</b> <b>{value}</b> sudah terdaftar !!!',
  					'min_length'  => '<b>Username</b> minimal 4 karakter !!!',
  					'alpha_numeric'  => '<b>Username</b> selain huruf dan angka tidak boleh !!!',
  				]
  			],
  			'password' => [
  				'rules'  => 'required|min_length[8]',
  				'errors' => [
  					'required'  => '<b>Password</b> harus di isi !!!',
  					'min_length'  => '<b>Password</b> minimal 8 karakter !!!',
  				]
  			],
  			'confirm_password' => [
  				'rules'  => 'required|matches[password]',
  				'errors' => [
  					'required'  => '<b>Confirm Password</b> harus di isi !!!',
  					'matches'  => '<b>Confirm Password</b> tidak sama dengan password !!!',
  				]
  			],
  			'groups_access' => [
  				'rules'  => 'required',
  				'errors' => [
  					'required'  => '<b>Groups Access</b> harus di pilih !!!',
  				]
  			],
  			'status_user' => [
  				'rules'  => 'required',
  				'errors' => [
  					'required'  => '<b>Status Users</b> harus di pilih !!!',
  				]
  			]
  		];

		if (! $this->validate($rules))
		{
      $this->session->setFlashdata('KetForm', 'tambahdata');
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
		}else{

      $password = $this->request->getPost('password');
      $pass = setPassword($password);
      $random = sha1(time().rand(00000,99999));

      if($this->request->getPost('status_user') == 0){
          $activeuser = "banned";
      }else{
          $activeuser = null;
      }

      $gr = $this->db->table("auth_groups")->where("id",$this->request->getPost('groups_access'))->get()->getRowArray();

      $data = array(
  			  'random'		=> $random,
          'fullname' => $this->request->getPost('fullname'),
          'email' => $this->request->getPost('email'),
          'username' => $this->request->getPost('username'),
          'password_hash' => $pass,
          'status' 		=> $activeuser,
    			'user_image' 	=> 'default.jpg',
          // 'jenisuser' 		=> $gr["name"],
          'active' 		=> 1,
          'jenisuser' 		=> "staf",
    			'created_at' 	=> date('Y-m-d h:i:s'),
      );
      $status = $this->ModelMaster->datatambah("users",$data);


      $select = 'id';
      $where  = array("random" => $random);
      $queryuser = $this->ModelMaster->tampildatarow("users",$select,$where,$order="",$group="");
      $user_id = $queryuser['id'];

      $data = array(
    			'group_id'		=> $this->request->getPost('groups_access'),
    			'user_id'		=> $user_id,
      );
      $status = $this->ModelMaster->datatambah("auth_groups_users",$data);

      if ($status) {

        $this->logdata("users","1",array("random" => $random));

    		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data Staf KPF !' );
    		return redirect()->to('/manage-staf');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data Staf KPF !' );
    		return redirect()->to('/manage-staf');
      }
    }

	}

	public function editstaf($random)
	{

    $groups = $this->db->table('auth_groups')->get()->getResultArray();
    $users = $this->db->table('users')
       ->select('fullname,random,user_image, users.id as usersid, username,users.status, email, name,description,active,group_id,jenisuser')
       ->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
       ->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
       ->where(["users.random"=>$random])
       ->get()
       ->getRowArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Staf KPF',
			'title' => 'Form Edit Data Staf KPF',
			'groups' => $groups,
			'users' => $users,
		];

		return view('Modules\Staf\Views\editusers',$data);
	}
  public function edit_staf()
  {

    $password		= filterdata($this->request->getPost('password'));

    if($password <> '' ){

      $rules = [
        'fullname' => [
          'rules'  => 'required|is_unique[users.fullname,random,{random}]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'is_unique' => '{field} <b>{value}</b> sudah terdaftar !!!',
          ]
        ],
        'email' => [
          'rules'  => 'required|valid_email|is_unique[users.email,random,{random}]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'is_unique' => '{field} <b>{value}</b> sudah terdaftar !!!',
            'valid_email'  => '<b>{value}</b> format bukan email !!!',
          ]
        ],
        'username' => [
          'rules'  => 'required|alpha_numeric|is_unique[users.username,random,{random}]|min_length[4]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'is_unique' => '<b>{field}</b> <b>{value}</b> sudah terdaftar !!!',
            'min_length'  => '<b>{field}</b> minimal 4 karakter !!!',
            'alpha_numeric'  => '<b>{field}</b> selain huruf dan angka tidak boleh !!!',
          ]
        ],
        'password' => [
          'rules'  => 'required|min_length[8]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'min_length'  => '<b>{field}</b> minimal 8 karakter !!!',
          ]
        ],
        'confirm_password' => [
          'rules'  => 'required|matches[password]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'matches'  => '<b>{field}</b> tidak sama dengan password !!!',
          ]
        ],
        'groups_access' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>{field}</b> harus di pilih !!!',
          ]
        ],
  			'status_user' => [
  				'rules'  => 'required',
  				'errors' => [
  					'required'  => '<b>Status Users</b> harus di pilih !!!',
  				]
  			]
      ];

    }else{

      $rules = [
        'fullname' => [
          'rules'  => 'required|is_unique[users.fullname,random,{random}]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'is_unique' => '{field} <b>{value}</b> sudah terdaftar !!!',
          ]
        ],
        'email' => [
          'rules'  => 'required|valid_email|is_unique[users.email,random,{random}]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'is_unique' => '{field} <b>{value}</b> sudah terdaftar !!!',
            'valid_email'  => '<b>{value}</b> format bukan email !!!',
          ]
        ],
        'username' => [
          'rules'  => 'required|alpha_numeric|is_unique[users.username,random,{random}]|min_length[4]',
          'errors' => [
            'required'  => '<b>{field}</b> harus di isi !!!',
            'is_unique' => '<b>{field}</b> <b>{value}</b> sudah terdaftar !!!',
            'min_length'  => '<b>{field}</b> minimal 4 karakter !!!',
            'alpha_numeric'  => '<b>{field}</b> selain huruf dan angka tidak boleh !!!',
          ]
        ],
        'groups_access' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>{field}</b> harus di pilih !!!',
          ]
        ],
  			'status_user' => [
  				'rules'  => 'required',
  				'errors' => [
  					'required'  => '<b>Status Users</b> harus di pilih !!!',
  				]
  			]
      ];

    }

    $random = $this->request->getPost('random');

    if (! $this->validate($rules))
		{
      $this->session->setFlashdata('KetForm', 'editdata'.$random);
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
    }else{

      $password = $this->request->getPost('password');
      $pass = setPassword($password);

      if($this->request->getPost('status_user') == 0){
          $activeuser = "banned";
      }else{
          $activeuser = null;
      }
      $gr = $this->db->table("auth_groups")->where("id",$this->request->getPost('groups_access'))->get()->getRowArray();

      if($password <> ''){
        $data = array(
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'password_hash' => $pass,
            'status' => $activeuser,
            'active' 		=> 1,
            'jenisuser' 		=> $gr["name"],
      			'updated_at' 	=> date('Y-m-d h:i:s'),
        );
      }else{
        $data = array(
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'status' => $activeuser,
            // 'jenisuser' 		=> $gr["name"],
            'jenisuser' 		=> "staf",
            'active' 		=> 1,
      			'updated_at' 	=> date('Y-m-d h:i:s'),
        );
      }
      $where = array("random" => $random);
      $status = $this->ModelMaster->dataedit("users",$where,$data);

      $select = 'id';
      $where  = array("random" => $random);
      $queryuser = $this->ModelMaster->tampildatarow("users",$select,$where,$order="",$group="");
      $user_id = $queryuser['id'];

      $groups_access =$this->request->getPost('groups_access');

      $data = array(
          'group_id'		=> $groups_access,
          'user_id'		=> $user_id,
      );
      $where = array("user_id" => $user_id);
      $status = $this->ModelMaster->dataedit("auth_groups_users",$where,$data);

      if ($status) {

        $this->logdata("users","2",array("random" => $random));
        
    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Staf KPF !' );
    		return redirect()->to('/manage-staf');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Staf KPF !' );
    		return redirect()->to('/manage-staf');
      }
    }

  }

	public function delete_staf()
	{
    $random = $this->request->getPost('random');
    $data = array(
        "status" => "banned",
        "active" => 1,
        "deleted_at" => date("Y-m-d H:i:s"),
    );
    $where = array("random" => $random);
    $status = $this->ModelMaster->dataedit("users",$where,$data);

    if ($status) {

      $this->logdata("users","3",array("random" => $random));
      
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data User KPF !' );
  		return redirect()->to('/manage-staf');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data User KPF !' );
  		return redirect()->to('/manage-staf');
    }
	}


}
