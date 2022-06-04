<?php
namespace Modules\Produk\Models;

use CodeIgniter\Model;

class ModelProdukSaya extends Model
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
      $column_order   = array('','nama_s','x_kategoritoko.namakategori','url_s','price_s','cashback_s','url_t','price_t','cashback_t','x_produktoko.status');
      $column_search  = array('nama_s','x_kategoritoko.namakategori','url_s','price_s','cashback_s','url_t','price_t','cashback_t','x_produktoko.status');
      $order = array('');
      
      $this->builder = $this->db->table("x_produktoko");
      $this->builder->select('x_produktoko.id,x_produktoko.random,nama_s,slug_s,desc_s,img_s,url_s,price_s,cashback_s,nama_t,slug_t,desc_t,img_t,url_t,price_t,cashback_t,kategori,x_produktoko.status,x_produktoko.tanggal,x_produktoko.view,x_produktoko.iduser,x_kategoritoko.namakategori,x_kategoritokosub.namakategori as namakategorisub');   
      $this->builder->join('x_kategoritoko','x_kategoritoko.id=x_produktoko.kategori','left');   
      $this->builder->join('x_kategoritokosub','x_kategoritokosub.id=x_produktoko.kategorisub','left');   
      $this->builder->where(["x_produktoko.deleted_at"=>null,"x_produktoko.iduser"=>user()->id]);
      $this->builder->groupBy("x_produktoko.id");
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
      $this->builder = $this->db->table("x_produktoko");
      $this->builder->select('x_produktoko.id,x_produktoko.random,nama_s,slug_s,desc_s,img_s,url_s,price_s,cashback_s,nama_t,slug_t,desc_t,img_t,url_t,price_t,cashback_t,kategori,x_produktoko.status,x_produktoko.tanggal,x_produktoko.view,x_produktoko.iduser,x_kategoritoko.namakategori,x_kategoritokosub.namakategori as namakategorisub');   
      $this->builder->join('x_kategoritoko','x_kategoritoko.id=x_produktoko.kategori','left');   
      $this->builder->join('x_kategoritokosub','x_kategoritokosub.id=x_produktoko.kategorisub','left');   
      $this->builder->where(["x_produktoko.deleted_at"=>null,"x_produktoko.iduser"=>user()->id]);
      $this->builder->groupBy("x_produktoko.id");
      return $this->builder->countAllResults();
  }



}
