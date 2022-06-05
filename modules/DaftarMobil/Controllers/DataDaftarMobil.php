<?php

namespace Modules\DaftarMobil\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\DaftarMobil\Models\ModelDaftarMobil;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataDaftarMobil extends BaseController
{
	protected $session;
    protected $db;
    protected $builder;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->ModelDaftarMobil = new ModelDaftarMobil();
    $this->db = \Config\Database::connect();

	}
    
	public function tujuanmobiljson()
	{
        $jenis = filterdata($this->request->getPost("jenis"));
        $daerah = $this->db->table("x_tujuanmobil")->where(["jenis"=>$jenis,"deleted_at"=>null,"status"=>0])->get()->getResultArray();
        
        $daerahtujuan='<option>---Pilih Daerah---</option>';
        foreach($daerah as $da){
            $daerahtujuan .= '<option value="'.$da['id'].'">'.$da['tujuan'].'</option>';
        }
        
        echo $daerahtujuan;
    }
	public function tujuanmobiljson2()
	{
        $jenis = filterdata($this->request->getPost("jenis"));
        $id_daerah = filterdata($this->request->getPost("daerah"));
        $daerah = $this->db->table("x_tujuanmobil")->where(["jenis"=>$jenis,"deleted_at"=>null,"status"=>0])->get()->getResultArray();
        
        $daerahtujuan='<option>---Pilih Daerah---</option>';
        foreach($daerah as $da){
            if($id_daerah == $da['id']){
                $daerahtujuan .= '<option value="'.$da['id'].'" selected>'.$da['tujuan'].'</option>';
            }else{
                $daerahtujuan .= '<option value="'.$da['id'].'">'.$da['tujuan'].'</option>';
            }
        }
        
        echo $daerahtujuan;
    }

	public function inputmobil()
	{
       $sesi = $this->db->table("x_sesimobil")->where(["deleted_at"=>null,"status"=>0])->get()->getResultArray();
       $data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Daftar Mobil',
			'title' => 'Tambah Data Daftar Mobil',
			'sesi' => $sesi,
		];

		return view('Modules\DaftarMobil\Views\tambahdaftarmobil',$data);
	}
	public function inputmobilsave()
	{
        $rules = [
        'sesi' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Sesi Mobil</b> harus di pilih !!!',
        	]
        ],
        'tujuan' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Tujuan Mobil</b> harus di pilih !!!',
        	]
        ],
        'daerah' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Daerah Tujuan</b> harus di pilih !!!',
        	]
        ],
        'tanggal' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Tanggal</b> harus di pilih !!!',
        	]
        ],
        'namabroker' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nama Broker</b> harus di isi !!!',
        	]
        ],
        'namanasabah' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nama Nasabah</b> harus di isi !!!',
        	]
        ],
        'alamat' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Alamat</b> harus di isi !!!',
        	]
        ],
        'status' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Status</b> harus di pilih !!!',
        	]
        ],
      ];

        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }else{


            $random = sha1(time().rand(0,9999999));
            $data = array(
                'random' => $random,
                'sesi' => filterdata($this->request->getPost("sesi")),
                'tujuan' => filterdata($this->request->getPost("tujuan")),
                'daerah' => filterdata($this->request->getPost("daerah")),
                'broker' => filterdata($this->request->getPost("namabroker")),
                'pendamping' => filterdata($this->request->getPost("namapendamping")),
                'calnas' => filterdata($this->request->getPost("namanasabah")),
                'alamat' => filterdata($this->request->getPost("alamat")),
                'tanggal' => filterdata($this->request->getPost("tanggal")),
                'iduser' => user()->id,
                'created_at' => date("Y-m-d H:i:s"),
            );
            $status = $this->ModelMaster->datatambah($table="x_daftarmobil",$data);

            if ($status) {
                $this->logdata("x_daftarmobil","1",array("random" => $random));
                $this->session->setFlashdata('sukses', 'Melakukan Tambah Data Pengajuan Mobil !' );
                return redirect()->to('/manage-mobil');
            }else{
                $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Pengajuan Mobil !' );
                return redirect()->to('/manage-mobil');
            }
        }

	}

	public function datamobil()
	{ 
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Daftar Mobil',
			'title' => 'Data Daftar Mobil',
		];

		return view('Modules\DaftarMobil\Views\daftarmobil',$data);
	}
  

	public function datamobiljson()
	{

    if(in_groups("bcsbc")){
        $statuslap = "";
    }elseif(in_groups("bsm")){
        $statuslap = "";
    }elseif(in_groups("leader")){
        $statuslap = "";        
    }else{
        $statuslap = "";
    }

    if(in_groups("resepsionis")){
        $resepsionis = 1;
    }else{
        $resepsionis = 0;
    }

    $data_model = $this->ModelDaftarMobil;
    $list = $data_model->get_datatables($statuslap);
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $lists) {
        $random = $lists->random;


        $tgl = explode(" ",$lists->tanggal);

        if($lists->status == 0){
            $stat = '<span class="badge badge-warning text-dark badge-pill p-2">Pending</span>';
            if($lists->iduser == user()->id){
                $disabled = "";
            }else{
                $disabled = "disabled";
            }
        }elseif($lists->status == 1){
            $stat = '<span class="badge badge-primary badge-pill p-2">Di Jalan</span>';
            $disabled = "disabled";
        }elseif($lists->status == 2){
            $stat = '<span class="badge badge-success badge-pill p-2">Selesai</span>';
            $disabled = "disabled";
        }else{
            $stat = '<span class="badge badge-danger badge-pill p-2">Di Batalkan</span>';
            
            if($lists->iduser == user()->id){
                $disabled = "";
            }else{
                $disabled = "disabled";
            }
        }

        $no++;
        $row    = array();
        $row[]  = $no;
        $row[]  = '<a class="btn-link" href="javascript:void(0)" data-toggle="modal"  data-backdrop="static" data-target="#view'.$random.'">'.$lists->fullname.'</a>';
        $row[]  = $lists->sesi;
        $row[]  = $lists->tujuan;
        $row[]  = tanggal_indonesia_lengkap($tgl[0]).' '.$tgl[1];
        $row[]  = $stat;
        $action = "";

        if($resepsionis == 1){
            if($lists->status == 0){

                $action .= '
                <div class="">
                  <a class="btn btn-sm btn-warning text-dark px-2 py-1" href="javascript:void(0)" id="'.$random.'" onclick="serahkanmodal(this.id)"><i class="icon-copy dw dw-key1"></i></a>
                </div>';

            }elseif($lists->status == 1){
                
                $action .= '
                <div class="">
                  <a class="btn btn-sm btn-success text-light px-2 py-1" href="javascript:void(0)"  id="'.$random.'" onclick="selesaimodal(this.id)"><i class="icon-copy dw dw-checked"></i></a>
                  <a class="btn btn-sm btn-danger text-light px-2 py-1" href="javascript:void(0)"  id="'.$random.'" onclick="batalmodal(this.id)"><i class="icon-copy dw dw-cancel"></i></a>
                </div>';

            }else{
                
            }
        }else{
        $action .= '
                    <div class="">
                      <a class="btn btn-sm btn-warning text-dark px-2 py-1" href="javascript:void(0)" data-toggle="modal"  data-backdrop="static" data-target="#view'.$random.'"><i class="icon-copy dw dw-view"></i></a>
                      <a class="'.$disabled.' btn btn-sm btn-success px-2 py-1" href="'.base_url("manage-mobil/edit/".$random).'" ><i class="dw dw-edit2"></i></a>
                      <a class="'.$disabled.' btn btn-sm btn-danger px-2 py-1" href="javascript:void(0)" id="'.$random.'" onclick="deletemodal(this.id)"><i class="dw dw-delete-3"></i></a>
                    </div>';
        }
        $action .= '
                    <div class="modal fade" id="view'.$random.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                           
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myLargeModalLabel">View Data Pengajuan Mobil : '.$lists->fullname.'</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body text-left">
                                    <div class="row">
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Staf</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->fullname.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Broker</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->broker.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Pendamping</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->pendamping.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Nama Nasabah</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->calnas.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Hari, Tanggal - Jam</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.tanggal_indonesia_lengkap($tgl[0]).' '.$tgl[1].'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Alamat</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->alamat.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Sesi</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->sesi.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Tujuan</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$lists->tujuan.'</span>
                                        </div>
                                        <div class="col-sm-3 mb-1">
                                            <span class="font-weight-bold">Status</span>
                                        </div>
                                        <div class="col-sm-9 mb-1">
                                            <span>: '.$stat.'</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                 </div>
                            </div>

                        </div>
                    </div>';

        $row[]  = $action;

        $data[] = $row;
    }
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $data_model->count_all($statuslap),
        "recordsFiltered" => $data_model->count_filtered($statuslap),
        "data" => $data,
    );

    $output[csrf_token()] = csrf_hash();
    echo json_encode($output);  

	}
    
	public function editmobil($random)
	{       
       $dt = $this->db->table("x_daftarmobil")->where(["deleted_at"=>null,"random"=>$random])->get()->getRowArray();
       $sesi = $this->db->table("x_sesimobil")->where(["deleted_at"=>null,"status"=>0])->get()->getResultArray();
       $data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Daftar Mobil',
			'title' => 'Edit Data Daftar Mobil',
			'sesi' => $sesi,
			'dt' => $dt,
		];

		return view('Modules\DaftarMobil\Views\editdaftarmobil',$data);
	}
	public function editmobiludpate()
	{
        $rules = [
        'sesi' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Sesi Mobil</b> harus di pilih !!!',
        	]
        ],
        'tujuan' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Tujuan Mobil</b> harus di pilih !!!',
        	]
        ],
        'daerah' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Daerah Tujuan</b> harus di pilih !!!',
        	]
        ],
        'tanggal' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Tanggal</b> harus di pilih !!!',
        	]
        ],
        'namabroker' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nama Broker</b> harus di isi !!!',
        	]
        ],
        'namanasabah' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nama Nasabah</b> harus di isi !!!',
        	]
        ],
        'alamat' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Alamat</b> harus di isi !!!',
        	]
        ],
        'status' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Status</b> harus di pilih !!!',
        	]
        ],
      ];

        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }else{


            $random = filterdata($this->request->getPost("random"));
            $data = array(
                'random' => $random,
                'sesi' => filterdata($this->request->getPost("sesi")),
                'tujuan' => filterdata($this->request->getPost("tujuan")),
                'daerah' => filterdata($this->request->getPost("daerah")),
                'broker' => filterdata($this->request->getPost("namabroker")),
                'pendamping' => filterdata($this->request->getPost("namapendamping")),
                'calnas' => filterdata($this->request->getPost("namanasabah")),
                'alamat' => filterdata($this->request->getPost("alamat")),
                'tanggal' => filterdata($this->request->getPost("tanggal")),
                'iduser' => user()->id,
                'updated_at' => date("Y-m-d H:i:s"),
            );
            $status = $this->ModelMaster->dataedit($table="x_daftarmobil",["random"=>$random],$data);

            if ($status) {
                $this->logdata("x_daftarmobil","2",array("random" => $random));
                $this->session->setFlashdata('sukses', 'Melakukan Edit Data Pengajuan Mobil !' );
                return redirect()->to('/manage-mobil');
            }else{
                $this->session->setFlashdata('gagal', 'Melakukan Edit Data Pengajuan Mobil !' );
                return redirect()->to('/manage-mobil');
            }
        }

	}
	public function serahkan()
	{
        $random = $this->request->getPost("random");
        
        $data = array(
            "status"=> 1,
        );

        $status = $this->ModelMaster->dataedit("x_daftarmobil",["random"=>$random],$data);
        if($status){         
            $output = array(
                "status" => true,
                "pesan"  => 'Melakukan Penyerahaan Kunci Mobil !',
            );
        }else{            
            $output = array(
                "status" => false,
                "pesan"  => 'Melakukan Penyerahaan Kunci Mobil !',
            );
        }
        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
    }
	public function selesai()
	{
        $random = $this->request->getPost("random");
        
        $data = array(
            "status"=> 2,
        );

        $status = $this->ModelMaster->dataedit("x_daftarmobil",["random"=>$random],$data);
        if($status){         
            $output = array(
                "status" => true,
                "pesan"  => 'Selesai Mobil Telah Kembali Ke Kantor !',
            );
        }else{            
            $output = array(
                "status" => false,
                "pesan"  => 'Selesai Mobil Telah Kembali Ke Kantor !',
            );
        }
        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
    }
	public function batal()
	{
        $random = $this->request->getPost("random");
        
        $data = array(
            "status"=> 3,
        );

        $status = $this->ModelMaster->dataedit("x_daftarmobil",["random"=>$random],$data);
        if($status){         
            $output = array(
                "status" => true,
                "pesan"  => 'Melakukan Pembatalan Pengajuan Mobil !',
            );
        }else{            
            $output = array(
                "status" => false,
                "pesan"  => 'Melakukan Pembatalan Pengajuan Mobil !',
            );
        }
        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
    }
	public function mobildelete()
	{
        $random = $this->request->getPost("random");
        
        $data = array(
            "status"=> 3,
            "deleted_at"=> date("Y-m-d H:i:s"),
        );

        $status = $this->ModelMaster->dataedit("x_daftarmobil",["random"=>$random],$data);
        if($status){         
            $output = array(
                "status" => true,
                "pesan"  => 'Melakukan Delete Data Pengajuan Mobil !',
            );
        }else{            
            $output = array(
                "status" => false,
                "pesan"  => 'Melakukan Delete Data Pengajuan Mobil !',
            );
        }
        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
    }

  
}
