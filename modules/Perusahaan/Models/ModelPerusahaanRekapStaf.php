<?php
namespace Modules\Perusahaan\Models;

use CodeIgniter\Model;

class ModelPerusahaanRekapStaf extends Model
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
      $column_order   = array('','fullname','total');
      $column_search  = array('fullname','total');
      $order = array('');
      
      

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


      if($statuslap == "iduser"){

        if($bulan <> "semua" and $tahun == "semua"){
          
          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");

          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");

          }


        }elseif($bulan == "semua" and $tahun <> "semua"){

          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");

          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
            
          }

          
        }elseif($bulan <> "semua" and $tahun <> "semua"){
          
          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
            
          }

        }else{

          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");            
          }

        }
      }else{
        
        if($bulan <> "semua" and $tahun == "semua"){
          
          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");            
          }

        }elseif($bulan == "semua" and $tahun <> "semua"){

          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");            
          }

          
        }elseif($bulan <> "semua" and $tahun <> "semua"){
          
          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");            
          }

        }else{

          if($minggu <> "semua"){
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");
          }else{
            $this->builder = $this->db->table("users");
            $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and deleted_at is null group by iduser) as total');
            $this->builder->where("jenisuser","staf");            
          }

        }

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


  if($statuslap == "iduser"){

    if($bulan <> "semua" and $tahun == "semua"){
      
      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");

      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");

      }


    }elseif($bulan == "semua" and $tahun <> "semua"){

      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");

      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
        
      }

      
    }elseif($bulan <> "semua" and $tahun <> "semua"){
      
      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
        
      }

    }else{

      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and x_laporan.iduser = '.user()->id.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");            
      }

    }
  }else{
    
    if($bulan <> "semua" and $tahun == "semua"){
      
      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");            
      }

    }elseif($bulan == "semua" and $tahun <> "semua"){

      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");            
      }

      
    }elseif($bulan <> "semua" and $tahun <> "semua"){
      
      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and month(x_laporan.tanggal) = '.$bulan.' and year(x_laporan.tanggal) = '.$tahun.' and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");            
      }

    }else{

      if($minggu <> "semua"){
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where day(x_laporan.tanggal) >= '.$tgl1.' and day(x_laporan.tanggal) <= '.$tgl2.' and  users.id = x_laporan.iduser and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");
      }else{
        $this->builder = $this->db->table("users");
        $this->builder->select('fullname,(select count(*) from x_laporan where users.id = x_laporan.iduser and deleted_at is null group by iduser) as total');
        $this->builder->where("jenisuser","staf");            
      }

    }

  }
      return $this->builder->countAllResults();
  }



}
