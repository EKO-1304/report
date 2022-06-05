<?php

namespace Modules\Perusahaan\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\Perusahaan\Models\ModelPerusahaan;
use Modules\Perusahaan\Models\ModelPerusahaanRekap;
use Modules\Perusahaan\Models\ModelPerusahaanRekapStaf;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataPerusahaan extends BaseController
{
	protected $session;
    protected $db;
    protected $builder;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->ModelPerusahaan = new ModelPerusahaan();
    $this->ModelPerusahaanRekap = new ModelPerusahaanRekap();
    $this->ModelPerusahaanRekapStaf = new ModelPerusahaanRekapStaf();
    $this->db = \Config\Database::connect();

	}

	public function inputlaporan()
	{
       $data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Laporan',
			'title' => 'Tambah Laporan Nasabah Baru',
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
        'nomorwa' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nomor Wa</b> harus di isi !!!',
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
        'dokumentasi'=> [
            'rules'  => 'uploaded[dokumentasi]|max_size[dokumentasi,200kb]|is_image[dokumentasi]|mime_in[dokumentasi,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'uploaded'  => '<b>{field}</b> harus di pilih !!!',
                'max_size'  => 'ukuran <b>{field}</b> anda terlalu besar !!!',
                'is_image'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
                'mime_in'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
            ]
        ]
      ];

        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }else{

            $imgdokumentasi = $this->request->getFile('dokumentasi');
            $namaimgdokumentasi = $imgdokumentasi->getRandomName();
            $image = \Config\Services::image()
            ->withFile($imgdokumentasi)
            ->save(FCPATH .'/assets/images/dokumentasi/'. $namaimgdokumentasi);
        
            $imgdokumentasi->move(WRITEPATH . 'uploads');

            $random = sha1(time().rand(0,9999999));
            $data = array(
                'random' => $random,
                'broker' => filterdata($this->request->getPost("namabroker")),
                'pendamping' => filterdata($this->request->getPost("namapendamping")),
                'namanasabah' => filterdata($this->request->getPost("namanasabah")),
                'pekerjaan' => filterdata($this->request->getPost("pekerjaan")),
                'alamat' => filterdata($this->request->getPost("alamat")),
                'hasil' => filterdata($this->request->getPost("hasil")),
                'nomorwa' => filterdata($this->request->getPost("nomorwa")),
                'dokumentasi' => $namaimgdokumentasi,
                'iduser' => user()->id,
                'tanggal' => date("Y-m-d"),
                'created_at' => date("Y-m-d H:i:s"),
            );
            $status = $this->ModelMaster->datatambah($table="x_laporan",$data);

            if ($status) {
                $this->logdata("x_laporan","1",array("random" => $random));
                $this->session->setFlashdata('sukses', 'Melakukan Tambah Data Laporan !' );
                // return redirect()->to('/manage-input-laporan');
                return redirect()->to('/manage-nasabah');
            }else{
                $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Laporan !' );
                // return redirect()->to('/manage-input-laporan');
                return redirect()->to('/manage-nasabah');
            }
        }

	}

	public function datanasabah()
	{ 
        $tahun = $this->db->table("x_laporan")->select("tanggal")->groupBy("year(tanggal)")->get()->getResultArray();
		
        $bulan = $this->db->table("x_laporan")->select("tanggal")->groupBy("month(tanggal)")->get()->getResultArray();
		
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Laporan',
			'title' => 'Data Nasabah',
			'bulan' => $bulan,
			'tahun' => $tahun,
		];

		return view('Modules\Perusahaan\Views\datanasabah',$data);
	}
  

	public function datanasabahjson()
	{

    if(in_groups("bcsbc")){
        $statuslap = "iduser";
    }elseif(in_groups("bsm")){
        $statuslap = "";
    }elseif(in_groups("leader")){
        $statuslap = "";        
    }else{
        $statuslap = "";
    }

    $data_model = $this->ModelPerusahaan;
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
        $row[]  = '<a class="btn-link" href="'.base_url('manage-nasabah/view/'.$random).'" >'.$lists->namanasabah.'</a>';
        $row[]  = $lists->fullname;
        $row[]  = tanggal_indonesia_pendek($lists->tanggal);
        $action = "";
        $action .= '
                  <div class="">
                      <a class="btn btn-sm btn-warning text-dark px-2 py-1" href="'.base_url('manage-nasabah/view/'.$random).'" ><i class="icon-copy dw dw-view"></i></a>
                      <a class="'.$disabled.' btn btn-sm btn-success px-2 py-1" href="'.base_url("manage-nasabah/edit/".$random).'" ><i class="dw dw-edit2"></i></a>
                      <a class="'.$disabled.' btn btn-sm btn-danger px-2 py-1" href="javascript:void(0)" id="'.$random.'" onclick="deletemodal(this.id)"><i class="icon-copy dw dw-trash1"></i></a>
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
    
	public function rekapdatanasabah()
	{ 
        $tahun = $this->db->table("x_laporan")->select("tanggal")->groupBy("year(tanggal)")->orderBy("tanggal","desc")->limit(10)->get()->getResultArray();
		
        // $bulan = $this->db->table("x_laporan")->select("tanggal")->groupBy("month(tanggal)")->get()->getResultArray();
		
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Laporan',
			'title' => 'Data Nasabah',
			// 'bulan' => $bulan,
			'tahun' => $tahun,
		];

		return view('Modules\Perusahaan\Views\rekapdatanasabah',$data);
	}
	
	public function rekapdatanasabahjson()
	{

    $tahun = filterdata($this->request->getPost("tahun"));
    $bulan = filterdata($this->request->getPost("bulan"));
    $minggu = filterdata($this->request->getPost("minggu"));

    if(in_groups("bcsbc")){
        $statuslap = "iduser";
    }elseif(in_groups("bsm")){
        $statuslap = "";
    }elseif(in_groups("leader")){
        $statuslap = "";        
    }else{
        $statuslap = "";
    }

    $data_model = $this->ModelPerusahaanRekap;
    $list = $data_model->get_datatables($statuslap,$tahun,$bulan,$minggu);
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
        $row[]  = '<a class="btn-link" href="'.base_url('rekap-data-nasabah/view/'.$random).'">'.$lists->namanasabah.'</a>';
        $row[]  = $lists->fullname;
        $row[]  = tanggal_indonesia_pendek($lists->tanggal);
        $row[]  = '<a class="btn btn-sm btn-warning text-dark px-2 py-1" href="'.base_url('rekap-data-nasabah/view/'.$random).'"><i class="icon-copy dw dw-view"></i></a>';


        

       

        $data[] = $row;
    }
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $data_model->count_all($statuslap,$tahun,$bulan,$minggu),
        "recordsFiltered" => $data_model->count_filtered($statuslap,$tahun,$bulan,$minggu),
        "data" => $data,
    );

    $output[csrf_token()] = csrf_hash();
    echo json_encode($output);  

	}
	public function rekapdatastaf()
	{ 
        $tahun = $this->db->table("x_laporan")->select("tanggal")->groupBy("year(tanggal)")->orderBy("tanggal","desc")->limit(10)->get()->getResultArray();
		
        // $bulan = $this->db->table("x_laporan")->select("tanggal")->groupBy("month(tanggal)")->get()->getResultArray();
		
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Laporan',
			'title' => 'Rekap Data Staf',
			// 'bulan' => $bulan,
			'tahun' => $tahun,
		];

		return view('Modules\Perusahaan\Views\rekapdatastaf',$data);
	}
	
	public function rekapdatastafjson()
	{

    $tahun = filterdata($this->request->getPost("tahun"));
    $bulan = filterdata($this->request->getPost("bulan"));
    $minggu = filterdata($this->request->getPost("minggu"));

    if(in_groups("bcsbc")){
        $statuslap = "iduser";
    }elseif(in_groups("bsm")){
        $statuslap = "";
    }elseif(in_groups("leader")){
        $statuslap = "";        
    }else{
        $statuslap = "";
    }

    $data_model = $this->ModelPerusahaanRekapStaf;
    $list = $data_model->get_datatables($statuslap,$tahun,$bulan,$minggu);
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $lists) {
        if($lists->total < 1){
            $total = 0;
        }else{
            $total = $lists->total;
        }
        $no++;
        $row    = array();
        $row[]  = $no;
        $row[]  = $lists->fullname;
        $row[]  = $total;

        $data[] = $row;
    }
    $output = array(
        "draw" => $_POST['draw'],
        "recordsTotal" => $data_model->count_all($statuslap,$tahun,$bulan,$minggu),
        "recordsFiltered" => $data_model->count_filtered($statuslap,$tahun,$bulan,$minggu),
        "data" => $data,
    );

    $output[csrf_token()] = csrf_hash();
    echo json_encode($output);  

	}
	public function editlaporan($random)
	{
        $laporan = $this->db->table("x_laporan")->where("random",$random)->get()->getRowArray();

		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Laporan',
			'title' => 'Edit Laporan Nasabah Baru',
            'lap' => $laporan,
		];

		return view('Modules\Perusahaan\Views\editlaporan',$data);
	}

	public function updatelaporansave()
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
        'nomorwa' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Nomor Wa</b> harus di isi !!!',
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
        'dokumentasi'=> [
            'rules'  => 'max_size[dokumentasi,200kb]|is_image[dokumentasi]|mime_in[dokumentasi,image/jpg,image/jpeg,image/png]',
            'errors' => [
                'max_size'  => 'ukuran <b>{field}</b> anda terlalu besar !!!',
                'is_image'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
                'mime_in'  => '<b>{field}</b> yang anda pilih bukan gambar !!!',
            ]
        ]
      ];

        if (! $this->validate($rules))
        {
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }else{

            $imgdokumentasiedit = $this->request->getPost("imgdokumentasiedit");
            $imgdokumentasi = $this->request->getFile('dokumentasi');
            
            if($imgdokumentasi->getError() ==  4 ){        
              $namaimgdokumentasi = $imgdokumentasiedit;
            }else{
              if($imgdokumentasiedit <> ''){
                if(file_exists('assets/images/dokumentasi/'.$imgdokumentasiedit)){
                  unlink('assets/images/dokumentasi/'.$imgdokumentasiedit);
                }
              }
              $namaimgdokumentasi = $imgdokumentasi->getRandomName();
              $image = \Config\Services::image()
              ->withFile($imgdokumentasi)
              ->save(FCPATH .'/assets/images/dokumentasi/'. $namaimgdokumentasi);
      
            }

            $random = filterdata($this->request->getPost("random"));
            $data = array(
                'random' => $random,
                'broker' => filterdata($this->request->getPost("namabroker")),
                'pendamping' => filterdata($this->request->getPost("namapendamping")),
                'namanasabah' => filterdata($this->request->getPost("namanasabah")),
                'pekerjaan' => filterdata($this->request->getPost("pekerjaan")),
                'alamat' => filterdata($this->request->getPost("alamat")),
                'hasil' => filterdata($this->request->getPost("hasil")),
                'nomorwa' => filterdata($this->request->getPost("nomorwa")),
                'dokumentasi' => $namaimgdokumentasi,
                // 'iduser' => user()->id,
                // 'tanggal' => date("Y-m-d"),
                'updated_at' => date("Y-m-d H:i:s"),
            );
            $status = $this->ModelMaster->dataedit($table="x_laporan",["random"=>$random],$data);

            if ($status) {
                $this->logdata("x_laporan","2",array("random" => $random));
                $this->session->setFlashdata('sukses', 'Melakukan Edit Data Laporan !' );
                // return redirect()->to('/manage-input-laporan');
                return redirect()->to('/manage-nasabah');
            }else{
                $this->session->setFlashdata('gagal', 'Melakukan Edit Data Laporan !' );
                // return redirect()->to('/manage-input-laporan');
                return redirect()->to('/manage-nasabah');
            }
        }

	}
	public function deletelaporansave()
	{
        $random = $this->request->getPost("random");
        
        $data = array(
            "deleted_at"=> date("Y-m-d H:i:s"),
        );

        $status = $this->ModelMaster->dataedit("x_laporan",["random"=>$random],$data);
        if($status){         
            $output = array(
                "status" => true,
                "pesan"  => 'Melakukan Delete Data Laporan !',
            );
        }else{            
            $output = array(
                "status" => false,
                "pesan"  => 'Melakukan Delete Data Laporan !',
            );
        }
        $output[csrf_token()] = csrf_hash();
        echo json_encode($output);  
    }

    public function cetakexcel()
	{
        $rules = [
        'minggu' => [
            'rules'  => 'required',
            'errors' => [
                'required'  => '<b>Minggu</b> harus di pilih !!!',
            ]
        ],
        'bulan' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Bulan</b> harus di pilih !!!',
        	]
        ],
        'tahun' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Tahun</b> harus di pilih !!!',
        	]
        ],
      ];

        if (! $this->validate($rules))
        {
            $this->session->setFlashdata('KetForm', 'cetakexcel');
            return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
        }else{
            $minggu = filterdata($this->request->getPost("minggu"));
            $bulan = filterdata($this->request->getPost("bulan"));
            $tahun = filterdata($this->request->getPost("tahun"));

            $this->builder = $this->db->table("x_laporan");
            if($bulan <> "semua"){
                $this->builder->where("month(tanggal)",$bulan);
            }
            if($tahun <> "semua"){
                $this->builder->where("year(tanggal)",$tahun);
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
            $this->builder->where("deleted_at",null);
            $this->builder->orderBy("tanggal","desc");
            $query = $this->builder->get();
            $laporan = $query->getResultArray();

            
            $this->builder = $this->db->table("x_laporan");
            $this->builder->select("iduser,count(iduser) as total");
            if($bulan <> "semua"){
                $this->builder->where("month(tanggal)",$bulan);
            }
            if($tahun <> "semua"){
                $this->builder->where("year(tanggal)",$tahun);
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
            $this->builder->where("deleted_at",null);
            $this->builder->groupBy("iduser");
            $this->builder->orderBy("total","desc");
            $query = $this->builder->get();
            $rekap = $query->getResultArray();

            if($bulan <> "semua" and $tahun <> "semua" and $minggu <> "semua"){

                $textfilename = "Minggu Ke ".$minggu." ".bulan_panjang($bulan)." ".$tahun;

            }else{

                $textfilename = "Semua";

            }
            
            
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet()->setTitle('Data Nasabah');
            // tulis header/nama kolom 

            $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
            ];    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
            ];

            $sheet->setCellValue('A1', "Data Laporan Nasabah : ".$textfilename); 
            $sheet->mergeCells('A1:J1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', 'NO');
            $sheet->setCellValue('B3', 'NAMA STAF KPF');
            $sheet->setCellValue('C3', 'NAMA BROKER');
            $sheet->setCellValue('D3', 'NAMA PENDAMPING');
            $sheet->setCellValue('E3', 'NAMA NASABAH');
            $sheet->setCellValue('F3', 'NOMOR WA/TELP');
            $sheet->setCellValue('G3', 'PEKERJAAN');
            $sheet->setCellValue('H3', 'ALAMAT');
            $sheet->setCellValue('I3', 'HASIL');
            $sheet->setCellValue('J3', 'TANGGAL');

            // Buat header tabel nya pada baris ke 3
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col); 
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col); 
            $sheet->getStyle('H3')->applyFromArray($style_col); 
            $sheet->getStyle('I3')->applyFromArray($style_col);  
            $sheet->getStyle('J3')->applyFromArray($style_col);     
            $sheet->getStyle('A3:J3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            

            $column = 4;
            $no = 1;
            foreach($laporan as $data) {
                $us = $this->db->table("users")->select("fullname")->where("id",$data["iduser"])->get()->getRowArray();
                $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A' . $column, $no)
                            ->setCellValue('B' . $column, $us["fullname"])
                            ->setCellValue('C' . $column, $data['broker'])
                            ->setCellValue('D' . $column, $data['pendamping'])
                            ->setCellValue('E' . $column, $data['namanasabah'])
                            ->setCellValue('F' . $column, $data['nomorwa'])
                            ->setCellValue('G' . $column, $data['pekerjaan'])
                            ->setCellValue('H' . $column, $data['alamat'])
                            ->setCellValue('I' . $column, $data['hasil'])
                            ->setCellValue('J' . $column, $data['tanggal']);
                $column++;
                $no++;
            }  
            // Set width kolom
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(35);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(35);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(40);
            $sheet->getColumnDimension('I')->setWidth(65);
            $sheet->getColumnDimension('J')->setWidth(25);

            
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2 = $spreadsheet->getActiveSheet()->setTitle('Rekap Laporan Staf');
           
            $sheet2->setCellValue('A1', "Rekap Laporan Staf : ".$textfilename); 
            $sheet2->mergeCells('A1:I1');
            $sheet2->getStyle('A1')->getFont()->setBold(true);

            $sheet2->setCellValue('A3', 'NO');
            $sheet2->setCellValue('B3', 'NAMA STAF KPF');
            $sheet2->setCellValue('C3', 'TOTAL NASABAH');

            // Buat header tabel nya pada baris ke 3
            $sheet2->getStyle('A3')->applyFromArray($style_col);
            $sheet2->getStyle('B3')->applyFromArray($style_col);
            $sheet2->getStyle('C3')->applyFromArray($style_col);   
            $sheet2->getStyle('A3:C3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            

            $column = 4;
            $no = 1;
            foreach($rekap as $data) {
                $us = $this->db->table("users")->select("fullname")->where("id",$data["iduser"])->get()->getRowArray();
                $spreadsheet->setActiveSheetIndex(1)
                            ->setCellValue('A' . $column, $no)
                            ->setCellValue('B' . $column, $us["fullname"])
                            ->setCellValue('C' . $column, $data['total']);
                $column++;
                $no++;
            }  
            // Set width kolom
            $sheet2->getColumnDimension('A')->setWidth(10);
            $sheet2->getColumnDimension('B')->setWidth(35);
            $sheet2->getColumnDimension('C')->setWidth(35);

            $spreadsheet->setActiveSheetIndex(0);
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Data Laporan Nasabah '.$textfilename;
            
            $writer->save("assets/excel/".$fileName.'.xlsx');
            header("Content-Type: application/vnd.ms-excel");
            return redirect()->to(base_url()."/assets/excel/".$fileName.'.xlsx'); 

        }

	}
    public function cetak_excel()
	{
       
            $bulan = filterdata($this->request->getGet("bulan"));
            $tahun = filterdata($this->request->getGet("tahun"));
            $minggu = filterdata($this->request->getGet("minggu"));

            $this->builder = $this->db->table("x_laporan");
            if($bulan <> "semua"){
                $this->builder->where("month(tanggal)",$bulan);
            }
            if($tahun <> "semua"){
                $this->builder->where("year(tanggal)",$tahun);
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
            $this->builder->where("deleted_at",null);
            $this->builder->orderBy("tanggal","desc");
            $query = $this->builder->get();
            $laporan = $query->getResultArray();

            
            $this->builder = $this->db->table("x_laporan");
            $this->builder->select("iduser,count(iduser) as total");
            if($bulan <> "semua"){
                $this->builder->where("month(tanggal)",$bulan);
            }
            if($tahun <> "semua"){
                $this->builder->where("year(tanggal)",$tahun);
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
            $this->builder->where("deleted_at",null);
            $this->builder->groupBy("iduser");
            $this->builder->orderBy("total","desc");
            $query = $this->builder->get();
            $rekap = $query->getResultArray();

            if($bulan <> "semua" and $tahun <> "semua" and $minggu <> "semua"){

                $textfilename = "Minggu Ke ".$minggu." ".bulan_panjang($bulan)." ".$tahun;

            }else{

                $textfilename = "Semua";

            }
            
            
            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet()->setTitle('Data Nasabah');
            // tulis header/nama kolom 

            $style_col = [
            'font' => ['bold' => true], // Set font nya jadi bold
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
            ];    // Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
            $style_row = [
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
            ],
            'borders' => [
                'top' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                'right' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                'bottom' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                'left' => ['borderStyle'  => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
            ]
            ];

            $sheet->setCellValue('A1', "Data Laporan Nasabah : ".$textfilename); 
            $sheet->mergeCells('A1:I1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', 'NO');
            $sheet->setCellValue('B3', 'NAMA STAF KPF');
            $sheet->setCellValue('C3', 'NAMA BROKER');
            $sheet->setCellValue('D3', 'NAMA PENDAMPING');
            $sheet->setCellValue('E3', 'NAMA NASABAH');
            $sheet->setCellValue('F3', 'NOMOR WA/TELP');
            $sheet->setCellValue('G3', 'PEKERJAAN');
            $sheet->setCellValue('H3', 'ALAMAT');
            $sheet->setCellValue('I3', 'HASIL');
            $sheet->setCellValue('J3', 'TANGGAL');

            // Buat header tabel nya pada baris ke 3
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col); 
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col); 
            $sheet->getStyle('H3')->applyFromArray($style_col); 
            $sheet->getStyle('I3')->applyFromArray($style_col); 
            $sheet->getStyle('J3')->applyFromArray($style_col);       
            $sheet->getStyle('A3:J3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            

            $column = 4;
            $no = 1;
            foreach($laporan as $data) {
                $us = $this->db->table("users")->select("fullname")->where("id",$data["iduser"])->get()->getRowArray();
                $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A' . $column, $no)
                            ->setCellValue('B' . $column, $us["fullname"])
                            ->setCellValue('C' . $column, $data['broker'])
                            ->setCellValue('D' . $column, $data['pendamping'])
                            ->setCellValue('E' . $column, $data['namanasabah'])
                            ->setCellValue('F' . $column, $data['nomorwa'])
                            ->setCellValue('G' . $column, $data['pekerjaan'])
                            ->setCellValue('H' . $column, $data['alamat'])
                            ->setCellValue('I' . $column, $data['hasil'])
                            ->setCellValue('J' . $column, $data['tanggal']);
                $column++;
                $no++;
            }  
            // Set width kolom
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(35);
            $sheet->getColumnDimension('C')->setWidth(35);
            $sheet->getColumnDimension('D')->setWidth(35);
            $sheet->getColumnDimension('E')->setWidth(35);
            $sheet->getColumnDimension('F')->setWidth(25);
            $sheet->getColumnDimension('G')->setWidth(30);
            $sheet->getColumnDimension('H')->setWidth(40);
            $sheet->getColumnDimension('I')->setWidth(65);
            $sheet->getColumnDimension('J')->setWidth(25);

            
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2 = $spreadsheet->getActiveSheet()->setTitle('Rekap Laporan Staf');
           
            $sheet2->setCellValue('A1', "Rekap Laporan Staf : ".$textfilename); 
            $sheet2->mergeCells('A1:I1');
            $sheet2->getStyle('A1')->getFont()->setBold(true);

            $sheet2->setCellValue('A3', 'NO');
            $sheet2->setCellValue('B3', 'NAMA STAF KPF');
            $sheet2->setCellValue('C3', 'TOTAL NASABAH');

            // Buat header tabel nya pada baris ke 3
            $sheet2->getStyle('A3')->applyFromArray($style_col);
            $sheet2->getStyle('B3')->applyFromArray($style_col);
            $sheet2->getStyle('C3')->applyFromArray($style_col);   
            $sheet2->getStyle('A3:C3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            

            $column = 4;
            $no = 1;
            foreach($rekap as $data) {
                $us = $this->db->table("users")->select("fullname")->where("id",$data["iduser"])->get()->getRowArray();
                $spreadsheet->setActiveSheetIndex(1)
                            ->setCellValue('A' . $column, $no)
                            ->setCellValue('B' . $column, $us["fullname"])
                            ->setCellValue('C' . $column, $data['total']);
                $column++;
                $no++;
            }  
            // Set width kolom
            $sheet2->getColumnDimension('A')->setWidth(10);
            $sheet2->getColumnDimension('B')->setWidth(35);
            $sheet2->getColumnDimension('C')->setWidth(35);

            $spreadsheet->setActiveSheetIndex(0);
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Data Laporan Nasabah '.$textfilename;
            
            $writer->save("assets/excel/".$fileName.'.xlsx');
            header("Content-Type: application/vnd.ms-excel");
            return redirect()->to(base_url()."/assets/excel/".$fileName.'.xlsx'); 

        }
       
	public function viewnasabah($random)
	{
       $dt = $this->db->table("x_laporan")
       ->select("broker,dokumentasi,nomorwa,pendamping,alamat,pekerjaan,hasil,x_laporan.iduser,x_laporan.random,namanasabah,x_laporan.tanggal,alamat,pekerjaan,fullname")
       ->join("users","users.id=x_laporan.iduser","left")
       ->where("x_laporan.random",$random)
       ->get()->getRowArray();
       $data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Data Nasabah',
			'title' => 'View Data Nasabah',
			'dt' => $dt,
		];

		return view('Modules\Perusahaan\Views\viewlaporan',$data);
	}
}
