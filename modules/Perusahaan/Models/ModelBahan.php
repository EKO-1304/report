<?php
namespace Modules\Perusahaan\Models;

use CodeIgniter\Model;

class ModelBahan
 extends Model
{

  public $db;
  public $builder;

  public function __construct()
  {
      parent::__construct();
      $this->db = \Config\Database::connect();
  }
  protected function _get_datatables_query($statuslap)
  {
      $column_order   = array('','namabahan','fullname','tanggal','');
      $column_search  = array('namabahan','fullname','tanggal','file');
      $order = array('');
      
      $this->builder = $this->db->table("x_bahanpresentasi");
      $this->builder->select('x_bahanpresentasi.random,x_bahanpresentasi.iduser,namabahan,x_bahanpresentasi.tanggal,fullname,x_bahanpresentasi.file');     
      $this->builder->join('users',"users.id=x_bahanpresentasi.iduser","left");    
      $this->builder->where('x_bahanpresentasi.deleted_at',null);  
      if($statuslap <> ""){
          $this->builder->where('x_bahanpresentasi.iduser',$statuslap);
      }   
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

  public function get_datatables($statuslap)
  {
      $this->_get_datatables_query($statuslap);
      if ($_POST['length'] != -1)
          $this->builder->limit($_POST['length'], $_POST['start']);
      $query = $this->builder->get();
      return $query->getResult();
  }

  public function count_filtered($statuslap)
  {
      $this->_get_datatables_query($statuslap);
      return $this->builder->countAllResults();
  }

  public function count_all($statuslap)
  {
    $this->builder = $this->db->table("x_bahanpresentasi");
    $this->builder->select('namabahan,x_bahanpresentasi.tanggal,fullname,x_bahanpresentasi.file');     
    $this->builder->join('users',"users.id=x_bahanpresentasi.iduser","left");    
    $this->builder->where('x_bahanpresentasi.deleted_at',null);  
    if($statuslap <> ""){
        $this->builder->where('x_bahanpresentasi.iduser',$statuslap);
    }   
    return $this->builder->countAllResults();
  }



}
