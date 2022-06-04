<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;


use Modules\Users\Models\ModelUsers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */

class BaseController extends Controller
{
	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['auth','my_helpers'];
	protected $db;

	public function __construct(){
		$this->ModelMaster = new ModelMaster();
		$this->db = \Config\Database::connect();
	}
	/**
	 * Constructor.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param LoggerInterface   $logger
	 */
	public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.: $this->session = \Config\Services::session();
	}
	public function logdata($table,$status,$where)
	{
		$this->builder = $this->db->table($table);
		$this->builder->select("*");
		$this->builder->where($where);
		$query = $this->builder->get();
		$dt = $query->getRowArray();
		$logfield = json_encode($dt);

		$data = array(
			"random"     => sha1(time().rand(0,9999999999)),
			"id_user"    => user()->id,
			"ip"         => $this->request->getIPAddress(),
			"browser"    => (string)$this->request->getUserAgent(),
			"tabel"      => $table,
			"idtabel"    => $dt['id'],
			"status"     => $status,
			"keterangan" => $logfield,
			"created_at" => date("Y-m-d H:i:s"),
		);
	    $this->db->table("logdata")->insert($data);
	}
	
	public function notif($table,$where,$bagian,$keterangan,$notif,$ket)
	{
		$this->builder = $this->db->table($table);
		$this->builder->select("*");
		$this->builder->where($where);
		$query = $this->builder->get();
		$dt = $query->getRowArray();
		$iduser = $dt["$ket"];

		$cek = $this->db->table("x_notif")->where(["tabel"=>$table,"iduser"=>$iduser,"bagian"=>$bagian])->countAllResults();

		if($cek > 0){
			$data = array(
				"random"     => sha1(time().rand(0,9999999999)),
				"tabel"     =>  $table,
				"iduser"     =>  $iduser,
				"idnotif"    => user()->id,
				"bagian" =>  $bagian,
				"keterangan" =>  $keterangan,
				"notif" =>  $notif,
				"tanggal" => date("Y-m-d"),
				"created_at" => date("Y-m-d H:i:s"),
			);
			$this->db->table("x_notif")->where(["tabel"=>$table,"iduser"=>$iduser,"bagian"=>$bagian])->update($data);
		}else{
			$data = array(
				"random"     => sha1(time().rand(0,9999999999)),
				"tabel"     =>  $table,
				"iduser"     =>  $iduser,
				"idnotif"    => user()->id,
				"bagian" =>  $bagian,
				"keterangan" =>  $keterangan,
				"notif" =>  $notif,
				"tanggal" => date("Y-m-d"),
				"created_at" => date("Y-m-d H:i:s"),
			);
			$this->db->table("x_notif")->insert($data);
		}

	}


	public function siakadmahasiswa($kode,$group)
	{
	
		$url_data ='https://siakad.stekom.ac.id/loginsiakad/infomahasiswa';
		$data_ku = array(
			'apikey' => 'Sf7a21a268b09b42a1bee75329591170612c207256Ed',
			'secretkey' => 'Veeacfcc23746de1057bdba20cfc69c66fc3ebb43Gw',
			'nim' => $kode); 
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url_data);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_ku);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$result_data = curl_exec($ch);
		curl_close($ch);
		$dd=json_decode($result_data);
		
		if($dd->status==1)
		{
			$nim = $dd->nim;
			$username = str_replace('-','',url_title(strtolower($dd->nama))).''.rand(000,999);
			$nama_lengkap = strtoupper($dd->nama);
			$programstudi = $dd->programstudi;
			$email = $dd->email;
			$thnangkatan = $dd->thnangkatan;
			$prestasisekolah = $dd->prestasisekolah;
			$foto = $dd->foto;
			$nomorwa = $dd->nomorwa;
			$statusmahasiswa = $dd->statusmahasiswa;
			$status = $dd->status;
			$kampus = $dd->kampus;
			$kodefakultas = $dd->kodefakultas;
			
			if($kodefakultas == 88){
			    $kampusku = "stie";
			}elseif($kodefakultas == 55){
			    $kampusku = "politama";
			}elseif($kodefakultas == 77){
			    $kampusku = "amik";
			}else{
			    $kampusku = "stekom";
			}
			

			$pass	= setPassword($nim);	

			$db = \Config\Database::connect();

			$cek = $db
			->table('users')
			->select('kode')
			->where('kode', $nim)
			->countAllResults();

			if($cek > 0){

				$id = $db->table('users')->select('random')->where('kode',$nim)->get()->getRowArray();
				$random = $id["random"];
				
				$db->table('users')
				->where('kode', $nim)
				->update([
				// 	'random' => sha1(time().rand(11111111,99999999)),
					'kode' => $nim,
					// 'username'+ => $username,
					'fullname' => $nama_lengkap,
					'password_hash' => $pass,
				// 	'email' => $email,
					'active' => 1,
					'jenisuser' => "mahasiswa",
					'updated_at' => date('Y-m-d H:i:s'),
				]);
				
				$id = $db->table('users')->select('id')->where('kode',$nim)->get()->getRowArray();
            
				$db->table('auth_groups_users')
				->insert([
					'group_id' => $group,
					'user_id' => $id['id'],
				]);

				$db->table('x_mahasiswa')
				->where('nim', $nim)
				->update([
					'nim' => $nim,
					'nama' => $nama_lengkap,
					'prodi' => $programstudi,
					'nowa' => $nomorwa,
					'prestasi' => $prestasisekolah,
					'angkatan' => $thnangkatan,
					'kampus' => $kampusku,
					'imgprofile' => $nim.".png",
					'imgqrcode' => $nim.".png",
					'status' => $status,
					'updated_at' => date("Y-m-d H:i:s"),
				]);
				
                
                if("https://stekom.ac.id/images/mahasiswa/bsr/" == $foto){
                    
                    
                    $namaimg = $nim.'.png';
                    $image = \Config\Services::image()
                    ->withFile(FCPATH .'/assets/images/kta/default.jpg')
                    ->fit(500, 500, 'top')
                    ->save(FCPATH .'/assets/images/kta/user/'.$namaimg);
                }else{
                
                    $url = $foto;
        			$img = FCPATH.'/assets/images/kta/user/'.$nim.'.png';
                    // Save image
                    $ch = curl_init($url);
                    $fp = fopen($img, 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);
                    
                    $namaimg = $nim.'.png';
                    $image = \Config\Services::image()
                    ->withFile(FCPATH .'/assets/images/kta/user/'.$namaimg)
                    ->fit(500, 500, 'top')
                    ->save(FCPATH .'/assets/images/kta/user/'.$namaimg);
                    
                }
                

			}else{
                
                $random = sha1(time().rand(11111111,99999999));
                
				$id = $db->table('users')->where(['fullname'=>$nama_lengkap,"email"=>$email])->get()->getRowArray();
				
				if($id <> null){
				    
    				$db->table('users')
    				->insert([
    					'random' => $random,
    					'kode' => $nim,
    					'username' => $nim,
    					'fullname' => $nama_lengkap,
    					'email' => "email-2-".$email,
    					'password_hash' => $pass,
    					'active' => 1,
    					'jenisuser' => "mahasiswa",
    					'created_at' => date('Y-m-d H:i:s')
    				]);
    				
				}else{
				    
    				$db->table('users')
    				->insert([
    					'random' => $random,
    					'kode' => $nim,
    					'username' => $nim,
    					'fullname' => $nama_lengkap,
    					'email' => $email,
    					'password_hash' => $pass,
    					'active' => 1,
    					'jenisuser' => "mahasiswa",
    					'created_at' => date('Y-m-d H:i:s')
    				]);
    				
    				
				}
                

					
				$id = $db->table('users')->select('id')->where('kode',$nim)->get()->getRowArray();
            
				$db->table('auth_groups_users')
				->insert([
					'group_id' => $group,
					'user_id' => $id['id'],
				]);
				
				
				$db->table('x_mahasiswa')
				->insert([
					'random' => $random,
					'nim' => $nim,
					'nama' => $nama_lengkap,
					'prodi' => $programstudi,
					'nowa' => $nomorwa,
					'prestasi' => $prestasisekolah,
					'angkatan' => $thnangkatan,
					'kampus' => $kampusku,
					'imgprofile' => $nim.".png",
					'imgqrcode' => $nim.".png",
					'status' => $status,
					'created_at' => date("Y-m-d H:i:s"),
				]);
                
                if("https://stekom.ac.id/images/mahasiswa/bsr/" == $foto){
                    
                    
                    $namaimg = $nim.'.png';
                    $image = \Config\Services::image()
                    ->withFile(FCPATH .'/assets/images/kta/default.jpg')
                    ->fit(500, 500, 'top')
                    ->save(FCPATH .'/assets/images/kta/user/'.$namaimg);
                }else{
                
                    $url = $foto;
        			$img = FCPATH.'/assets/images/kta/user/'.$nim.'.png';
                    // Save image
                    $ch = curl_init($url);
                    $fp = fopen($img, 'wb');
                    curl_setopt($ch, CURLOPT_FILE, $fp);
                    curl_setopt($ch, CURLOPT_HEADER, 0);
                    curl_exec($ch);
                    curl_close($ch);
                    fclose($fp);
                    
                    $namaimg = $nim.'.png';
                    $image = \Config\Services::image()
                    ->withFile(FCPATH .'/assets/images/kta/user/'.$namaimg)
                    ->fit(500, 500, 'top')
                    ->save(FCPATH .'/assets/images/kta/user/'.$namaimg);
                    
                }
					 
			}	


			return $output = 1;
		}else{
			return $output = 0;
		}
	

	}
		
  public function cekuser($random,$kode,$id)
  {
	if($kode <> ""){
        $user = $this->db->table("users")->select("id,fullname")->where("kode",$kode)->get()->getRowArray(); 
	}elseif($random <> ""){
        $user = $this->db->table("users")->select("id,fullname")->where("random",$random)->get()->getRowArray(); 
	}else{
        $user = $this->db->table("users")->select("id,fullname")->where("id",$id)->get()->getRowArray(); 
	}
    if($user <> null){    
	  return $output = $user;
    }else{       
	  return $output = "error";
    }
  }	

  
	public function visitor($text,$link)
	{
		
		$ip = $this->request->getIPAddress();
		$agent = $this->request->getUserAgent();
		if ($agent->isBrowser()) {
			$currentAgent = $agent->getBrowser() . ' ' . $agent->getVersion();
		} elseif ($agent->isRobot()) {
			$currentAgent = $agent->getRobot();
		} elseif ($agent->isMobile()) {
			$currentAgent = $agent->getMobile();
		} else {
			$currentAgent = 'Unidentified User Agent';
		}
		$datenow = date("Y-m-d");
		$cek = $this->db->table("x_visitor")->where(["ip_address"=>$ip,"date(date)"=>$datenow,"dari"=>$text,"link"=>$link])->countAllResults(); 
		
		if($cek == 0){
			$dt = array(
				"ip_address"=> $ip,
				"browser"	=> $currentAgent,
				"date"		=> date("Y-m-d H:i:s"),
				"dari"	=> $text,
				"link"	=> $link,
			);
			$this->db->table("x_visitor")->insert($dt);

		}
	}
  
}
