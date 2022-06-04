<?php
namespace Modules\Users\Models;

use CodeIgniter\Model;

class ModelUsers extends Model
{
    public $db;
    public $builder;

    public function __construct(){
		$this->db = \Config\Database::connect();

	}
  protected function _get_datatables_query()
  {

      $column_order   = array('','fullname','description','jenisuser');
      $column_search  = array('fullname','description','jenisuser');
      $order = array('jenisuser' => 'ASC');

        $this->builder =  $this->db->table('users');
        $this->builder->select('fullname,random,user_image, users.id as usersid, username,users.status, email, name,description,active,group_id,jenisuser');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.deleted_at', null);
        $this->builder->orderBy(key($order), $order[key($order)]);

      $i = 0;

      foreach ($column_search as $item) {
          if ($_POST['search']['value']) {

              if ($i === 0) {
                  $this->builder->groupStart();
                  $this->builder->like($item, $_POST['search']['value']);
              } else {
                  $this->builder->orLike($item, $_POST['search']['value']);
              }

              if (count($column_search) - 1 == $i)
                  $this->builder->groupEnd();
          }
          $i++;
      }

      if (isset($_POST['order'])) {
          $this->builder->orderBy($column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
      } else if (isset($order)) {
          $order = $order;
          $this->builder->orderBy(key($order), $order[key($order)]);
      }
  }

  public function get_datatables()
  {
      $this->_get_datatables_query();
      if ($_POST['length'] != -1)
          $this->builder->limit($_POST['length'], $_POST['start']);
      $query = $this->builder->get();
      return $query->getResult();
  }

  public function count_filtered()
  {
      $this->_get_datatables_query();
      return $this->builder->countAllResults();
  }

  public function count_all()
  {
      $this->builder =  $this->db->table('users');
      $this->builder->select('fullname,random,user_image, users.id as usersid,users.status username, email, name,description,active,group_id,jenisuser');
      $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
      $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
      $this->builder->where('users.deleted_at', null);

      return $this->builder->countAllResults();
  }

  public function get_groups(){
    return $this->db
    ->table('auth_groups')
    ->get()
    ->getResultArray();
  }
  public function get_users_edit($random){
	return $this->db
	->table('users')
	->select('username,random,group_id,fullname,email,user_image,active')
	->join('auth_groups_users','auth_groups_users.user_id=users.id','left')
  ->where('random', $random)
	->get()
	->getRowArray();

  }

  public function get_users_profile($id_rand){
  return $this->db
  ->table('users')
  ->select('users.random as random_users,users.id as usersid,tanggal_lahir, username, email,user_image,alamat,no_telp,fullname,jenis_kelamin.jenis_kelamin,auth_groups.description,jenis_kelamin.id as idjenis_kelamin')
  ->join('profile_user', 'profile_user.random = users.random', 'left')
  ->join('jenis_kelamin','jenis_kelamin.id=profile_user.jenis_kelamin','left')
  ->join('auth_groups_users','auth_groups_users.user_id=users.id','left')
  ->join('auth_groups','auth_groups.id=auth_groups_users.group_id','left')
  ->where('users.random', $id_rand)
  ->get()
  ->getRowArray();

  }

    public function get_users_profile_mahasiswa($id_rand){
		return $this->db
		->table('users')
		->select('*,users.random as random_users,users.nim as nim_mhs')
		->join('mahasiswa', 'mahasiswa.nim = users.nim', 'left')
        ->where('users.random', $id_rand)
		->get()
		->getRowArray();


    }
    public function get_groups_users(){
		return $this->db
		->table('users')
		->select('random, users.id as usersid, username, email, name')
		->join('auth_groups_users', 'auth_groups_users.user_id = users.id')
		->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id')
		->where('users.deleted_at', null)
		->get()
		->getResultArray();

    }

    public function get_cek_users_($rand){
		return $this->db
		->table('users')
		->where('random',$rand)
		->get()
		->getRowArray();

    }
    public function get_cek_users($id_rand){
		return $this->db
		->table('profile_user')
		->where('random',$id_rand)
		->countAllResults();

    }

    public function get_jenis_kelamin(){
		return $this->db
		->table('jenis_kelamin')
		->orderBy('id','asc')
		->get()
		->getResultArray();

    }

	//SAVE DATA

    public function save_profile_users($id_rand,$tanggal_lahir,$jenis_kelamin,$alamat,$no_telp){

		return $this->db
		->table('profile_user')
		->insert([
			'random'		=> $id_rand,
			'tanggal_lahir'	=> $tanggal_lahir,
			'jenis_kelamin' => $jenis_kelamin,
			'alamat' 		=> $alamat,
			'no_telp' 		=> $no_telp,
			'updated_at' 	=> date('Y-m-d h:i:s'),
		]);

    }

	//EDIT DATA
    public function edit_groups_users($groups_access,$user_id){

		return $this->db
		->table('auth_groups_users')
		->where('user_id',$user_id)
		->update([
			'group_id'		=> $groups_access,
			'user_id'		=> $user_id,
		]);

    }

	//DELETE DATA
    public function delete_permissions($id_permissions){

		return $this->db
		->table('auth_permissions')
		->where('id', $id_permissions)
		->delete();

		return $this->db
		->table('auth_groups_permissions')
		->where('permission_id', $id_permissions)
		->delete();

    }
    public function delete_groups($id_groups){

		return $this->db
		->table('auth_groups')
		->where('id', $id_groups)
		->delete();

		return $this->db
		->table('auth_groups_permissions')
		->where('group_id', $id_groups)
		->delete();

    }



    public function edit_password($id_rand,$password_baru){

    return $this->db
    ->table('users')
    ->where('random', $id_rand)
    ->update([
      'password_hash'	=> $password_baru,
      'updated_at' 	=> date('Y-m-d h:i:s'),
    ]);

    }
    public function edit_profile_users($id_rand,$tanggal_lahir,$jenis_kelamin,$alamat,$no_telp){

    return $this->db
    ->table('profile_user')
    ->where('random', $id_rand)
    ->update([
      'tanggal_lahir'	=> $tanggal_lahir,
      'jenis_kelamin' => $jenis_kelamin,
      'alamat' 		=> $alamat,
      'no_telp' 		=> $no_telp,
      'updated_at' 	=> date('Y-m-d h:i:s'),
    ]);

    }
    public function edit_profile_users_mahasiswa($nim,$prodi,$angkatan,$fakultas,$tanggal_lahir,$jenis_kelamin,$alamat,$no_telp){

    return $this->db
    ->table('mahasiswa')
    ->where('nim', $nim)
    ->update([
      'prodi'			=> $prodi,
      'angkatan'		=> $angkatan,
      'fakultas'		=> $fakultas,
      'tanggal_lahir'	=> $tanggal_lahir,
      'jenis_kelamin' => $jenis_kelamin,
      'alamat' 		=> $alamat,
      'no_telp' 		=> $no_telp,
      'updated_at' 	=> date('Y-m-d h:i:s'),
    ]);

    }
    public function edit_users_image($id_rand,$username,$fullname,$email,$nama_foto){

    return $this->db
    ->table('users')
    ->where('random', $id_rand)
    ->update([
      'username'	=> $username,
      'fullname'	=> $fullname,
      'email'		=> $email,
      'user_image'=> $nama_foto,
      'updated_at'=> date('Y-m-d h:i:s'),
    ]);

    }
    public function edit_users_no_image($id_rand,$username,$fullname,$email){

    return $this->db
    ->table('users')
    ->where('random', $id_rand)
    ->update([
      'username'	=> $username,
      'fullname'	=> $fullname,
      'email'		=> $email,
      'updated_at'=> date('Y-m-d h:i:s'),
    ]);

    }
}
