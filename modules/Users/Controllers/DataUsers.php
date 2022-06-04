<?php

namespace Modules\Users\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\Users\Models\ModelUsers;
use CodeIgniter\I18n\Time;
use Myth\Auth\Entities\User;

class DataUsers extends BaseController
{
	protected $config;
	protected $session;
  protected $db;
	protected $ModelUsers;

	public function __construct(){
		$this->session = service('session');
		$this->config = config('Auth');

		$this->ModelUsers = new ModelUsers();
    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();
		$this->auth = service('authentication');

	}

	public function index()
	{

    $groups = $this->db->table('auth_groups')->get()->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Operator Users',
			'title' => 'Data Users',
			'groups' => $groups,
		];

		return view('Modules\Users\Views\users',$data);
	}

	public function user_json()
	{
    $data_model = $this->ModelUsers;
    $list = $data_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $lists) {
        $random = $lists->random;
        $groupid = $lists->group_id;

        $jenisuser = $lists->jenisuser;
        if($jenisuser == 'adm'){
          $actjenisuser = '<span class="badge badge-success text-light text-uppercase">'.$jenisuser.'</span>';
        }elseif($jenisuser == 'aspri'){
          $actjenisuser = '<span class="badge badge-warning text-dark text-uppercase">'.$jenisuser.'</span>';
        }elseif($jenisuser == 'magang'){
          $actjenisuser = '<span class="badge badge-info text-dark text-uppercase">'.$jenisuser.'</span>';
        }else{
          $actjenisuser = '';
        }

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
        if($active == null){
          $act = "Active";
          $bg = "badge-primary";
        }else{
          $act = "Non Active";
          $bg = "badge-danger";
        }

        $no++;
        $row    = array();
        $row[]  = $no;
        $row[]  = $lists->fullname;
        $row[]  = $lists->description;
        $row[]  = $jenisuser;
        $row[]  = $nomorwa;
        $row[]  = '<span class="badge text-light badge-pill '.$bg.'">'.$act.'</span>';

        $action = '';
        $action .= '
                  <div class="dropdown">
                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                      <i class="dw dw-more"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                      <a class="dropdown-item" href="'.base_url('manage-users/profile/'.$random).'"><i class="icon-copy dw dw-user-12"></i> Profile</a>
                      <a class="dropdown-item" href="'.base_url('manage-users/edit/'.$random).'"><i class="dw dw-edit2"></i> Edit</a>
                      <a class="dropdown-item" href="#" id="'.$random.'"  onclick="deletedata(this.id)" ><i class="dw dw-delete-3"></i> Delete</a>
                    </div>

                  </div>
        ';

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
	public function tambahusers()
	{

    $groups = $this->db->table('auth_groups')->get()->getResultArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Operator Users',
			'title' => 'Form Tambah Data Users',
			'groups' => $groups,
		];

		return view('Modules\Users\Views\tambahusers',$data);
	}
	public function tambah_users()
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

      $jsuser = $this->request->getPost('jenisuser');
      if($jsuser == "lain"){
        $jsuserdt = "";
      }else{
        $jsuserdt = $this->request->getPost('jenisuser');
      }

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
          'jenisuser' 		=> $gr["name"],
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

    		$this->session->setFlashdata('sukses', 'Melakukan Tambah Data User !' );
    		return redirect()->to('/manage-users');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Tambah Data User !' );
    		return redirect()->to('/manage-users');
      }
    }

	}

	public function editusers($random)
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
			'pretitle' => 'Operator Users',
			'title' => 'Form Edit Data Users',
			'groups' => $groups,
			'users' => $users,
		];

		return view('Modules\Users\Views\editusers',$data);
	}
  public function edit_users()
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
            'jenisuser' 		=> $gr["name"],
      			'updated_at' 	=> date('Y-m-d h:i:s'),
        );
      }else{
        $data = array(
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'username' => $this->request->getPost('username'),
            'status' => $activeuser,
            'jenisuser' 		=> $gr["name"],
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
        
    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data User !' );
    		return redirect()->to('/manage-users');
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data User !' );
    		return redirect()->to('/manage-users');
      }
    }

  }

	public function delete_users()
	{
    $random = $this->request->getPost('random');
    $data = array(
        "active" => 0,
        "deleted_at" => date("Y-m-d H:i:s"),
    );
    $where = array("random" => $random);
    $status = $this->ModelMaster->dataedit("users",$where,$data);

    if ($status) {

      $this->logdata("users","3",array("random" => $random));
      
  		$this->session->setFlashdata('sukses', 'Melakukan Hapus Data User !' );
  		return redirect()->to('/manage-users');
    }else{
  		$this->session->setFlashdata('gagal', 'Melakukan Hapus Data User !' );
  		return redirect()->to('/manage-users');
    }
	}

	public function profile($random)
	{
    $where = array("deleted_at" => null);
		$jenis_kelamin = $this->ModelMaster->tampildataresult("jenis_kelamin",$select="",$where,$order="",$group="");

    $query = $this->db
      ->table('users')
      ->select('password_hash,users.random as random_users,users.id as usersid,tanggal_lahir, username, email,user_image,alamat,no_telp,fullname,jenis_kelamin.jenis_kelamin,auth_groups.description,jenis_kelamin.id as idjenis_kelamin')
      ->join('profile_user', 'profile_user.random = users.random', 'left')
      ->join('jenis_kelamin','jenis_kelamin.id=profile_user.jenis_kelamin','left')
      ->join('auth_groups_users','auth_groups_users.user_id=users.id','left')
      ->join('auth_groups','auth_groups.id=auth_groups_users.group_id','left')
      ->where('users.random', $random)
      ->get()
      ->getRowArray();
   

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Profile',
			'title' => 'Data Profile Users',
			'jenis_kelamin' => $jenis_kelamin,
			'random' => $random,
			'profile' => $query,
		];

    return view('Modules\Users\Views\profile',$data);
	}
	public function edit_profile()
	{
		$rules = [
			'username' => [
				'rules'  => 'required|is_unique[users.username,username,{username}]',
				'errors' => [
					'required'  => '<b>Username</b> harus di isi !!!',
					'is_unique' => '<b>Username</b> <b>{value}</b> sudah terdaftar !!!'
				]
			],
			'fullname'=> [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Password</b> harus di isi !!!',
				]
			],
			'tanggallahir'=> [
				'rules'  => 'required',
				'errors' => [
					'required'  => '<b>Tanggal Lahir</b> harus di isi !!!',
				]
			],
			'jeniskelamin'=> [
				'rules'  => 'required|numeric',
				'errors' => [
					'required'  => '<b>Jenis Kelamin</b> harus di pilih !!!',
					'numeric'   => '<b>Jenis Kelamin</b> harus di angka tidak boleh karakter !!!',
				]
			],
			'alamat'=> [
				// 'rules'  => 'required|min_length[20]|max_length[150]',
				'rules'  => 'required|max_length[150]',
				'errors' => [
					'required'  => '<b>Alamat</b> harus di isi !!!',
					// 'min_length'  => '<b>Alamat</b> minimal 20 karakter !!!',
					'max_length'  => '<b>Alamat</b> maksimal 150 karakter !!!',
				]
			],
			'email'=> [
				'rules'  => 'required|is_unique[users.email,email,{email}]|valid_email',
				'errors' => [
					'required'  => '<b>Email</b> harus di isi !!!',
					'is_unique' => '<b>Email</b> <b>{value}</b> sudah terdaftar !!!',
					'valid_email'  => 'harus email !!!',
				]
			],
			'nomortelp'=> [
				'rules'  => 'required|numeric|min_length[10]|max_length[15]',
				'errors' => [
					'required'  => '<b>Nomor Telp</b> harus di isi !!!',
					'numeric'   => '<b>Nomor Telp</b> harus di angka tidak boleh karakter !!!',
					'min_length'  => '<b>Nomor Telp</b> minimal 10 angka !!!',
					'max_length'  => '<b>Nomor Telp</b> maksimal 15 angka !!!',
				]
			],
		];

    $random = $this->request->getPost('random');
    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('tapprofile', 'setting');
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
    }else{

      $where = array("random" => $random);
      $cek = $this->ModelMaster->tampildatarow("profile_user",$select="",$where,$order="",$group="");

      if($cek){
        $data = array(
            'no_telp' => $this->request->getPost('nomortelp'),
            'jenis_kelamin' => $this->request->getPost('jeniskelamin'),
            'tanggal_lahir' => date("Y-m-d", strtotime($this->request->getPost('tanggallahir'))),
            'alamat' => $this->request->getPost('alamat'),
            'updated_at' => date("Y-m-d H:i:s"),
        );
        $where = array("random" => $random);
        $status = $this->ModelMaster->dataedit("profile_user",$where,$data);

        $data = array(
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'updated_at' => date("Y-m-d H:i:s"),
        );
        $where = array("random" => $random);
        $status = $this->ModelMaster->dataedit("users",$where,$data);
      }else{
        $data = array(
            'random' => $random,
            'no_telp' => $this->request->getPost('nomortelp'),
            'jenis_kelamin' => $this->request->getPost('jeniskelamin'),
            'tanggal_lahir' => date("Y-m-d", strtotime($this->request->getPost('tanggallahir'))),
            'alamat' => $this->request->getPost('alamat'),
            'created_at' => date("Y-m-d H:i:s"),
        );
        $status = $this->ModelMaster->datatambah("profile_user",$data);

        $data = array(
            'username' => $this->request->getPost('username'),
            'fullname' => $this->request->getPost('fullname'),
            'email' => $this->request->getPost('email'),
            'updated_at' => date("Y-m-d H:i:s"),
        );
        $where = array("random" => $random);
        $status = $this->ModelMaster->dataedit("users",$where,$data);
      }

      if ($status) {

        $this->logdata("users","2",array("random" => $random));

    		$this->session->setFlashdata('sukses', 'Melakukan Edit Data Profile !' );
    		return redirect()->to('/manage-users/profile/'.$random);
      }else{
    		$this->session->setFlashdata('gagal', 'Melakukan Edit Data Profile !' );
    		return redirect()->to('/manage-users/profile/'.$random);
      }
    }

	}
  public function imguseredit()
  {
    
		$rules = [
			'user_image'=> [
				'rules'  => 'max_size[user_image,200kb]|is_image[user_image]|mime_in[user_image,image/jpg,image/jpeg,image/png]',
				'errors' => [
					'max_size'  => 'ukuran <b>{field}</b> anda terlalu besar !!!',
					'is_image'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
					'mime_in'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
				]
			]
		];
    
    if (! $this->validate($rules))
    {
      $this->session->setFlashdata('KetForm', 'modalimguser');
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());    
    }else{

        $random = $this->request->getPost('random');

        $img = $this->request->getPost('img');
        if($img <> 'default.jpg'){
          if(file_exists('assets/images/profile/'.$img)){
            unlink('assets/images/profile/'.$img);
          }
        }

        $foto_profile = $this->request->getFile('user_image');
        $nama_foto = $foto_profile->getRandomName();
        $image = \Config\Services::image()
        ->withFile($foto_profile)
        ->fit(150, 150, 'center')
        ->save(FCPATH .'/assets/images/profile/'. $nama_foto);

        $foto_profile->move(WRITEPATH . 'uploads');

        $data = array(
            "user_image" => $nama_foto,
        );

        $where = array("random" => $random);
        $status = $this->ModelMaster->dataedit("users",$where,$data);

        if ($status) {

          $this->logdata("users","2",array("random" => $random));

          $this->session->setFlashdata('sukses', 'Melakukan Edit Foto Profile !' );
          return redirect()->to('/manage-users/profile/'.$random);
        }else{
          $this->session->setFlashdata('gagal', 'Melakukan Edit Foto Profile !' );
          return redirect()->to('/manage-users/profile/'.$random);
        }
    }

  }

	public function gantipassword()
	{

		$rules = [
			// 'passwordlama' => [
			// 	'rules'  => 'required|matches[passlama]',
			// 	'errors' => [
			// 		'required'  => '<b>Password Lama</b> harus di isi !!!',
			// 		'matches'  => '<b>Password Lama</b> tidak sama  !!!',
			// 	]
			// ],
			'passwordbaru'=> [
				'rules'  => 'required|min_length[8]',
				'errors' => [
					'required'  => '<b>Password Baru</b> harus di isi !!!',
					'min_length' => '<b>Password Baru</b> minimal 8 karakter !!!'
				]
			],
			'confirmpasswordbaru'=> [
				'rules'  => 'required|matches[passwordbaru]',
				'errors' => [
					'required'  => '<b>Confirm Password</b> harus di isi !!!',
					'matches'  => '<b>Confirm Password</b> tidak sama  !!!',
				]
			]

		];

		if (! $this->validate($rules))
		{
      $this->session->setFlashdata('tapprofile', 'gantipassword');
			return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
		}

    $random		= filterdata($this->request->getPost('random'));
		$password_baru  = setPassword($this->request->getPost('passwordbaru'));

    $data = array(
        "password_hash" => $password_baru
    );
    $where = array("random" => $random);
    $status = $this->ModelMaster->dataedit("users",$where,$data);
    

    if ($status) {
      
      $this->logdata("users","3",array("random" => $random));

      $this->session->setFlashdata('sukses', 'Melakukan Edit Password !' );
      return redirect()->to('/manage-users/profile/'.$random);
    }else{
      $this->session->setFlashdata('gagal', 'Melakukan Edit Password !' );
      return redirect()->to('/manage-users/profile/'.$random);
    }

	}



}
