<?php
namespace Modules\Perusahaan\Models;

use CodeIgniter\Model;

class ModelPerusahaanRekap extends Model
{

  public $db;
  public $builder;

  public function __construct()
  {
      parent::__construct();
      $this->db = \Config\Database::connect();
  }
  protected function _get_datatables_query($statuslap,$tahun,$bulan,$minggu)
  {
      $column_order   = array('','namanasabah','fullname','tanggal','');
      $column_search  = array('namanasabah','fullname','tanggal');
      $order = array('');
      
      $this->builder = $this->db->table("x_laporan");
      $this->builder->select('broker,hasil,dokumentasi,nomorwa,pendamping,x_laporan.iduser,x_laporan.random,namanasabah,x_laporan.tanggal,alamat,pekerjaan,fullname');     
      $this->builder->join("users","users.id=x_laporan.iduser","left");
      if($statuslap == "iduser"){
        $this->builder->where(["x_laporan.deleted_at"=>null,"x_laporan.iduser"=>user()->id]);
      }else{
        $this->builder->where(["x_laporan.deleted_at"=>null]);
      }
      if($bulan <> "semua"){
        $this->builder->where("month(x_laporan.tanggal)",$bulan);
      }
      if($tahun <> "semua"){
        $this->builder->where("year(x_laporan.tanggal)",$tahun);
      }
      if($minggu <> "semua"){

        if($minggu == 1){
          $tgl1 = 1;
          $tgl2 = 7;
        }elseif($minggu == 2){
          $tgl1 = 8;
          $tgl2 = 14;
        }elseif($minggu == 3){
          $tgl1 = 15;
          $tgl2 = 21;
        }else{
          $tgl1 = 22;
          $tgl2 = 31;
        }

        $this->builder->where("day(x_laporan.tanggal) >=",$tgl1);
        $this->builder->where("day(x_laporan.tanggal) <=",$tgl2);
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

  public function get_datatables($statuslap,$tahun,$bulan,$minggu)
  {
      $this->_get_datatables_query($statuslap,$tahun,$bulan,$minggu);
      if ($_POST['length'] != -1)
          $this->builder->limit($_POST['length'], $_POST['start']);
      $query = $this->builder->get();
      return $query->getResult();
  }

  public function count_filtered($statuslap,$tahun,$bulan,$minggu)
  {
      $this->_get_datatables_query($statuslap,$tahun,$bulan,$minggu);
      return $this->builder->countAllResults();
  }

  public function count_all($statuslap,$tahun,$bulan,$minggu)
  {
      $this->builder = $this->db->table("x_laporan");
      $this->builder->select('broker,dokumentasi,nomorwa,pendamping,x_laporan.iduser,x_laporan.random,namanasabah,x_laporan.tanggal,alamat,pekerjaan,fullname');     
      $this->builder->join("users","users.id=x_laporan.iduser","left");
      if($statuslap == "iduser"){
        $this->builder->where(["x_laporan.deleted_at"=>null,"x_laporan.iduser"=>user()->id]);
      }else{
        $this->builder->where(["x_laporan.deleted_at"=>null]);
      }
      if($bulan <> "semua"){
        $this->builder->where("month(x_laporan.tanggal)",$bulan);
      }
      if($tahun <> "semua"){
        $this->builder->where("year(x_laporan.tanggal)",$tahun);
      }
      if($minggu <> "semua"){

        if($minggu == 1){
          $tgl1 = 1;
          $tgl2 = 7;
        }elseif($minggu == 2){
          $tgl1 = 8;
          $tgl2 = 14;
        }elseif($minggu == 3){
          $tgl1 = 15;
          $tgl2 = 21;
        }else{
          $tgl1 = 22;
          $tgl2 = 31;
        }

        $this->builder->where("day(x_laporan.tanggal) >=",$tgl1);
        $this->builder->where("day(x_laporan.tanggal) <=",$tgl2);
      }
      return $this->builder->countAllResults();
  }



}
