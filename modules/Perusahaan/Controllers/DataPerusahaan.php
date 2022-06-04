<?php

namespace Modules\Perusahaan\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\Perusahaan\Models\ModelPerusahaan;
use CodeIgniter\I18n\Time;

class DataPerusahaan extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->ModelPerusahaan = new ModelPerusahaan();
    $this->db = \Config\Database::connect();

	}

	public function inputlaporan()
	{
        $broker = $this->db->table("users")->where(["deleted_at"=>null])->get()->getResultArray();
        $senior = $this->db->table("users")->where(["deleted_at"=>null])->get()->getResultArray();
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Laporan',
			'title' => 'Tambah Laporan Nasabah Baru',
            'broker' => $broker,
            'senior' => $senior,
		];

		return view('Modules\Perusahaan\Views\tambahlaporan',$data);
	}
	public function inputlaporansave()
	{
        $rules = [
        'namabroker' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nama Broker</b> harus di pilih !!!',
        	]
        ],
        'namanasabah' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nama Calon Nasabah</b> harus di isi !!!',
        	]
        ],
        'pekerjaan' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Pekerjaan</b> harus di isi !!!',
        	]
        ],
        'alamat' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Alamat</b> harus di isi !!!',
        	]
        ],
        'hasil' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Hasil</b> harus di isi !!!',
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
                'broker' => filterdata($this->request->getPost("namabroker")),
                'pendamping' => filterdata($this->request->getPost("namapendamping")),
                'namanasabah' => filterdata($this->request->getPost("namanasabah")),
                'pekerjaan' => filterdata($this->request->getPost("pekerjaan")),
                'alamat' => filterdata($this->request->getPost("alamat")),
                'hasil' => filterdata($this->request->getPost("hasil")),
                'iduser' => user()->id,
                'tanggal' => date("Y-m-d"),
                'created_at' => date("Y-m-d H:i:s"),
            );
            $status = $this->ModelMaster->datatambah($table="x_laporan",$data);

            if ($status) {
                $this->logdata("x_laporan","1",array("random" => $random));
                $this->session->setFlashdata('sukses', 'Melakukan Tambah Data Laporan !' );
                return redirect()->to('/manage-input-laporan');
            }else{
                $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Laporan !' );
                return redirect()->to('/manage-input-laporan');
            }
        }

	}

	public function datanasabah()
	{ 
        
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => '',
			'title' => '',
		];

		return view('Modules\Perusahaan\Views\datanasabah',$data);
	}
  

	public function datanasabahjson()
	{
    $data_model = $this->ModelPerusahaan;
    $list = $data_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $lists) {
        $random = $lists->random;
        $no++;
        $row    = array();
        $row[]  = $no;
        $row[]  = "";
        $row[]  = "";
        $row[]  = $lists->namanasabah;
        $row[]  = $lists->alamat;
        $row[]  = $lists->pekerjaan;
        $action = "";
        $action .= '
                  <div class="dropdown">
                    <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                      <i class="dw dw-more"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                      <a class="dropdown-item" href="'.base_url("edit-produk/".$random).'" ><i class="dw dw-edit2"></i> Edit</a>
                      <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal"  data-backdrop="static" data-target="#delete'.$random.'"><i class="dw dw-delete-3"></i> Delete</a>
                    </div>
                  </div>
                    <div class="modal fade" id="delete'.$random.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content  text-white">
                            <div class="modal-body bg-danger text-center " style="border-top-left-radius:5px;border-top-right-radius:5px;">
                                <h4 class="text-white mb-15"><i class="fa fa-exclamation-triangle"></i> Apakah anda yakin ?</h4>
                                <p>Apakah anda benar-benar ingin menghapus data ini? Apa yang telah anda lakukan tidak dapat dibatalkan.</p>
                            </div>
                            <div class="modal-footer mx-auto py-1">
                                    <button type="button" class="mr-3 btn btn-sm btn-secondary" data-dismiss="modal">Cancel</button>
                                    <a href="javascript:void(0)" id="'.$random.'" onclick="deleteproduk(this.id)" class="ml-3 btn btn-sm btn-danger">Delete</a>
                            </div>
                            </div>
                        </div>
                    </div>';

        $row[]  = $action;

        $data[] = $row;
    }
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $data_model->count_all(),
        "recordsFiltered" => $data_model->count_filtered(),
        "data" => $data,
    );

    $output[csrf_token()] = csrf_hash();
    echo json_encode($output);  

	}
    
	public function updateprodukstatus()
	{
        $dt = explode("/",$this->request->getPost("random"));
        $random = $dt[0];
        $status = $dt[1];
        

        $data = array(
            "status"=> $status,
        );

        $this->ModelMaster->dataedit("x_produktoko",["random"=>$random],$data);
        
        

        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
        
    }

	public function deleteproduk()
	{
        $random = $this->request->getPost("random");
        
        $data = array(
            "deleted_at"=> date("Y-m-d H:i:s"),
        );

        $status = $this->ModelMaster->dataedit("x_produktoko",["random"=>$random],$data);
        if($status){         
            $output = array(
                "status" => true,
                "pesan"  => 'Melakukan Delete Data Produk !',
            );
        }else{            
            $output = array(
                "status" => false,
                "pesan"  => 'Melakukan Delete Data Produk !',
            );
        }
        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
    }
}
