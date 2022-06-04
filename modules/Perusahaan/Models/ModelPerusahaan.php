<?php
namespace Modules\Perusahaan\Models;

use CodeIgniter\Model;

class ModelPerusahaan extends Model
{

  public $db;
  public $builder;

  public function __construct()
  {
      parent::__construct();
      $this->db = \Config\Database::connect();
  }
  protected function _get_datatables_query()
  {
      $column_order   = array('','','','namanasabah','alamat','pekerjaan');
      $column_search  = array('namanasabah','alamat','pekerjaan');
      $order = array('');
      
      $this->builder = $this->db->table("x_laporan");
      $this->builder->select('*');     
      $this->builder->where(["x_laporan.deleted_at"=>null,"x_laporan.iduser"=>user()->id]);
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
      $this->builder = $this->db->table("x_laporan");
      $this->builder->select('*');     
      $this->builder->where(["x_laporan.deleted_at"=>null,"x_laporan.iduser"=>user()->id]);
      return $this->builder->countAllResults();
  }



}
