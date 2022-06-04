<?php
namespace App\Models;

use CodeIgniter\Model;

class ModelMaster extends Model
{

  public $db;
  public $builder;

  public function __construct()
  {
      parent::__construct();
      $this->db = \Config\Database::connect();
  }

  protected function datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table)->where('deleted_at',null);

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
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function datatables($table, $column_order, $column_search, $order)
    {
        $this->datatables_query($table, $column_order, $column_search, $order);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);

        $query = $this->builder->get();
        return $query->getResult();
    }

    public function countfiltered($table, $column_order, $column_search, $order)
    {
      $this->datatables_query($table, $column_order, $column_search, $order);
      return $this->builder->countAllResults();
    }
    public function countall($table)
    {
        return   $this->db->table($table)->where('deleted_at',null)->countAllResults();
    }


    protected function datatables_query_user($table, $column_order, $column_search, $order,$id_user)
    {
        $this->builder = $this->db->table($table)->where('deleted_at',null)->where("id_user", $id_user);

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
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function datatables_user($table, $column_order, $column_search, $order,$id_user)
    {
        $this->datatables_query_user($table, $column_order, $column_search, $order,$id_user);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);

        $query = $this->builder->get();
        return $query->getResult();
    }

    public function countfiltered_user($table, $column_order, $column_search, $order,$id_user)
    {
      $this->datatables_query_user($table, $column_order, $column_search, $order,$id_user);
      return $this->builder->countAllResults();
    }
    public function countall_user($table,$id_user)
    {
        return   $this->db->table($table)->where('deleted_at',null)->where("id_user", $id_user)->countAllResults();
    }

    //tanpa deleted at
    protected function _get_datatables_query($table, $column_order, $column_search, $order)
    {
        $this->builder = $this->db->table($table);

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

    public function get_datatables($table, $column_order, $column_search, $order)
    {
        $this->_get_datatables_query($table, $column_order, $column_search, $order);
        if ($_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);

        $query = $this->builder->get();
        return $query->getResult();
    }

    public function count_filtered($table, $column_order, $column_search, $order)
    {
      $this->_get_datatables_query($table, $column_order, $column_search, $order);
      return $this->builder->countAllResults();
    }
    public function count_all($table)
    {
        $this->builder->from($table);
        return $this->builder->countAll();
    }

    //View Data
    public function tampildataresult($table,$select="",$where="",$order="",$group="")
    {
      $this->builder = $this->db->table($table);
      if($select <> null){
        $this->builder->select($select);
      }else{
        $this->builder->select("*");
      }
      if($where <> null){
        $this->builder->where($where);
      }
      if($order <> null){
        $this->builder->orderBy(key($order), $order[key($order)]);
      }
      // if($group <> null){
        $this->builder->groupBy($group);
      // }
      $query = $this->builder->get();
      return $query->getResultArray();

    }
    public function tampildatarow($table,$select="",$where="",$order="",$group="")
    {
      $this->builder = $this->db->table($table);
      if($select <> null){
        $this->builder->select($select);
      }else{
        $this->builder->select("*");
      }
      if($where <> null){
        $this->builder->where($where);
      }
      if($order <> null){
        $this->builder->orderBy(key($order), $order[key($order)]);
      }
      if($group <> null){
        $this->builder->groupBy($group);
      }
      $query = $this->builder->get();
      return $query->getRowArray();

    }
    public function cekdata($table,$select="",$where="",$order="",$group="")
    {
      $this->builder = $this->db->table($table);
      if($select <> null){
        $this->builder->select($select);
      }else{
        $this->builder->select("*");
      }
      if($where <> null){
        $this->builder->where($where);
      }
      if($order <> null){
        $this->builder->orderBy(key($order), $order[key($order)]);
      }
      if($group <> null){
        $this->builder->groupBy($group);
      }
          return $this->builder->countAllResults();

    }
    
    //Data Total
    // public function datatotal($table,$where)
    // {
    //     $this->builder =  $this->db
    //     ->table($table)
    //     ->where($where);
    //     return $this->builder->countAllResults();
    // }

    //Tambah Data
    public function datatambah($table,$data)
    {
      return $this->db
      ->table($table)
      ->insert($data);
    }
    //Edit Data
    public function dataedit($table,$where,$data)
    {
      return $this->db
      ->table($table)
      ->where($where)
      ->update($data);
    }
    //Delete Data
    public function datadelete($table,$where)
    {
      return $this->db
      ->table($table)
      ->where($where)
      ->delete();
    }




}
