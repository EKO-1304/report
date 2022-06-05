<?php
namespace Modules\Staf\Models;

use CodeIgniter\Model;

class ModelStaf extends Model
{
    public $db;
    public $builder;

    public function __construct(){
		$this->db = \Config\Database::connect();

	}
  protected function _get_datatables_query()
  {

      $column_order   = array('','fullname','description');
      $column_search  = array('fullname','description');
      $order = array('jenisuser' => 'ASC');

        $this->builder =  $this->db->table('users');
        $this->builder->select('fullname,users.random,user_image, users.id as usersid, username,users.status, email, name,description,active,group_id,jenisuser');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.deleted_at', null);
        $this->builder->where('users.jenisuser', "staf");
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
      $this->builder->where('users.jenisuser', "staf");

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



}
