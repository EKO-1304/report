<?php

namespace Modules\Perusahaan\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\Perusahaan\Models\ModelBahan;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataBahan extends BaseController
{
	protected $session;
    protected $db;
    protected $builder;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->ModelBahan = new ModelBahan();
    $this->db = \Config\Database::connect();

	}

	public function bahanpresentasi()
	{
       $data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Presentasi',
			'title' => 'Data Bahan Presentasi',
		];

		return view('Modules\Perusahaan\Views\bahanpresentasi',$data);
	}
    public function bahanpresentasijson()
	{

    if(in_groups("bcsbc")){
        // $statuslap = user()->id;
        $statuslap = "";
    }elseif(in_groups("bsm")){
        $statuslap = "";
    }elseif(in_groups("leader")){
        $statuslap = "";        
    }else{
        $statuslap = "";
    }

    $data_model = $this->ModelBahan;
    $list = $data_model->get_datatables($statuslap);
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $lists) {
        $random = $lists->random;

        if($lists->iduser == user()->id){
            $disabled = "";
        }else{
            $disabled = "disabled";
        }

        $tgl = explode("-",$lists->tanggal);


        $no++;
        $row    = array();
        $row[]  = $no;
        $row[]  = $lists->namabahan;
        $row[]  = $lists->fullname;
        $row[]  = tanggal_indonesia_pendek($lists->tanggal);
        $action = "";
        $action .= '
                  <div class="">
                      <a class="btn btn-sm btn-warning text-dark px-2 py-1" href="'.base_url("assets/bahan/".$lists->file).'"><i class="icon-copy dw dw-download1"></i></a>
                      <a class="'.$disabled.' btn btn-sm btn-success px-2 py-1" href="'.base_url("manage-bahan-presentasi/edit/".$random).'" ><i class="dw dw-edit2"></i></a>
                      <a class="'.$disabled.' btn btn-sm btn-danger px-2 py-1" href="javascript:void(0)" id="'.$random.'" onclick="deletemodal(this.id)"><i class="icon-copy dw dw-trash1"></i></a>
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
                                    <a href="javascript:void(0)" id="'.$random.'" onclick="deletebahan(this.id)" class="ml-3 btn btn-sm btn-danger">Delete</a>
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
  
	public function bahanpresentasitambah()
	{
       $data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Presentasi',
			'title' => 'Tambah Data Bahan Presentasi',
		];

		return view('Modules\Perusahaan\Views\tambahbahanpresentasi',$data);
	}
	public function bahanpresentasisave()
	{
        
        $rules = [
            'namabahan' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '<b>Nama Bahan</b> harus di isi !!!',
                ]
            ],
            'dokumentasi'=> [
                'rules'  => 'uploaded[dokumentasi]|max_size[dokumentasi,1000kb]|ext_in[dokumentasi,pdf,jpg,png,jpeg,xls,xlsx]',
                'errors' => [
                    'uploaded'  => '<b>Dokumen Bahan Presentasi</b> harus di pilih !!!',
                    'max_size'  => 'ukuran <b>Dokumen Bahan Presentasi</b> anda terlalu besar !!!',
                    'ext_in'  => '<b>Dokumen Bahan Presentasi</b> yang anda pilih tidak sesuai !!!',
                ]
            ]
        ];

        
        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());

        }else{

            $dokumentasi	= $this->request->getFile('dokumentasi');

            $nama_file = $dokumentasi->getRandomName();
            $dokumentasi->move('assets/bahan', $nama_file);

            $random = sha1(time().rand(0,9999999));
            $data = array(
                'random' => $random,
                'namabahan' => filterdata($this->request->getPost("namabahan")),
                'file' => $nama_file,
                'iduser' => user()->id,
                'tanggal' => date("Y-m-d"),
                'created_at' => date("Y-m-d H:i:s"),
            );
            $status = $this->ModelMaster->datatambah($table="x_bahanpresentasi",$data);

            if ($status) {
                $this->logdata("x_bahanpresentasi","1",array("random" => $random));
                $this->session->setFlashdata('sukses', 'Melakukan Tambah Data Bahan Presentasi !' );
                return redirect()->to('/manage-bahan-presentasi');
            }else{
                $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Bahan Presentasi !' );
                return redirect()->to('/manage-bahan-presentasi');
            }

        }
	}

	public function bahanpresentasiedit($random)
	{
       $dt = $this->db->table("x_bahanpresentasi")->where("random",$random)->get()->getRowArray();
       $data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Presentasi',
			'title' => 'Edit Data Bahan Presentasi',
			'dt' => $dt,
		];

		return view('Modules\Perusahaan\Views\editbahanpresentasi',$data);
	}
	public function bahanpresentasiupdate()
	{
        
        $rules = [
            'namabahan' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => '<b>Nama Bahan</b> harus di isi !!!',
                ]
            ],
            'dokumentasi'=> [
                'rules'  => 'max_size[dokumentasi,1000kb]|ext_in[dokumentasi,pdf,jpg,png,jpeg,xls,xlsx]',
                'errors' => [
                    'max_size'  => 'ukuran <b>Dokumen Bahan Presentasi</b> anda terlalu besar !!!',
                    'ext_in'  => '<b>Dokumen Bahan Presentasi</b> yang anda pilih tidak sesuai !!!',
                ]
            ]
        ];

        
        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());

        }else{

            $dokumentasi	= $this->request->getFile('dokumentasi');

            if($dokumentasi->getError() ==  4 ){        
                $nama_file = filterdata($this->request->getPost('dokumen'));
            }else{
                $namafile = filterdata($this->request->getPost('dokumen'));
                if(file_exists('assets/bahan/'.$namafile)){
                    unlink('assets/bahan/'.$namafile);
                }
                $nama_file = $dokumentasi->getRandomName();
                $dokumentasi->move('assets/bahan', $nama_file);
            }



            $random = filterdata($this->request->getPost("random"));
            $data = array(
                'random' => $random,
                'namabahan' => filterdata($this->request->getPost("namabahan")),
                'file' => $nama_file,
                // 'iduser' => user()->id,
                // 'tanggal' => date("Y-m-d"),
                'updated_at' => date("Y-m-d H:i:s"),
            );
            $status = $this->ModelMaster->dataedit($table="x_bahanpresentasi",["random"=>$random],$data);

            if ($status) {
                $this->logdata("x_bahanpresentasi","2",array("random" => $random));
                $this->session->setFlashdata('sukses', 'Melakukan Edit Data Bahan Presentasi !' );
                return redirect()->to('/manage-bahan-presentasi');
            }else{
                $this->session->setFlashdata('gagal', 'Melakukan Edit Data Bahan Presentasi !' );
                return redirect()->to('/manage-bahan-presentasi');
            }

        }
	}
	public function bahanpresentasidelete()
    {
        $random = $this->request->getPost("random");
        $dt = $this->db->table("x_bahanpresentasi")->where("random",$random)->get()->getRowArray();
        
        if(file_exists('assets/bahan/'.$dt['file'])){
			unlink('assets/bahan/'.$dt['file']);
		}

        $data = array(
            "deleted_at"=> date("Y-m-d H:i:s"),
        );

        $status = $this->ModelMaster->dataedit("x_bahanpresentasi",["random"=>$random],$data);
        if($status){         
            $output = array(
                "status" => true,
                "pesan"  => 'Melakukan Delete Data Bahan Presentasi !',
            );
        }else{            
            $output = array(
                "status" => false,
                "pesan"  => 'Melakukan Delete Data Bahan Presentasi !',
            );
        }
        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
	}
       
}
