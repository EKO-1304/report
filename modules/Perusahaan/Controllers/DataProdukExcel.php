<?php

namespace Modules\Produk\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DataProdukExcel extends BaseController
{
	protected $session;
    protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}

	public function tambahdata()
	{ 
        $file_excel = $this->request->getFile('fileexcel');
        // dd($file_excel);
      
        $ext = $file_excel->getClientExtension();
        if($ext == 'xls') {
          $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
          $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_excel);
    
        $dataexcel = $spreadsheet->getActiveSheet()->toArray();

        $truecount = 0;
        $falsecount = 0;
        $no = 1;
        for($i = 3;$i < count($dataexcel);$i++)
	      {
            if($dataexcel[$i][1] <> null){ 
                $dts = str_replace("http://","https://",$dataexcel[$i][1]);
                $urlshopee = fetch_shopee($dts);

                if($urlshopee["status"] <> "gagal"){ 

                    $shopeetitle = $urlshopee["title"];
                    $slugtitle_s = url_title(strtolower($urlshopee["title"]));
                    $desc_s = $urlshopee["description"];
                    $url_s = str_replace("http://","https://",$urlshopee["url"]);
                    $hrg_s = $urlshopee["price"];
                    $urlimg_s = $urlshopee["image"];

                }else{
                    $shopeetitle = "";
                    $slugtitle_s = ""; 
                    $desc_s = "";
                    $url_s = ""; 
                    $hrg_s = ""; 
                    $urlimg_s = "";
                }

            }else{ 
                $urlshopee = ""; 
                $shopeetitle = "";
                $slugtitle_s = ""; 
                $desc_s = "";
                $url_s = ""; 
                $hrg_s = ""; 
                $urlimg_s = "";
            }
            if($dataexcel[$i][2] <> null){ $cs_s = $dataexcel[$i][2]; }else{ $cs_s = ""; }
            if($dataexcel[$i][3] <> null){ 
                $dtt = str_replace("http://","https://",$dataexcel[$i][3]);
                $urltokopedia = fetch_tokopedia($dtt);

                if($urltokopedia["status"] <> "gagal"){ 

                    $tokopediatitle = $urltokopedia["title"];
                    $slugtitle_t = url_title(strtolower($urltokopedia["title"]));
                    $desc_t = $urltokopedia["description"];
                    $url_t = str_replace("http://","https://",$urltokopedia["url"]);
                    $hrg_t = $urltokopedia["price"];
                    $urlimg_t = $urltokopedia["image"];
                }else{
                    $tokopediatitle = "";
                    $slugtitle_t = ""; 
                    $desc_t = "";
                    $url_t = ""; 
                    $hrg_t = ""; 
                    $urlimg_t = "";

                }
            }else{ 
                $urltokopedia = ""; 
                $tokopediatitle = "";
                $slugtitle_t = ""; 
                $desc_t = "";
                $url_t = ""; 
                $hrg_t = ""; 
                $urlimg_t = "";
            }
            if($dataexcel[$i][4] <> null){ $cs_t = $dataexcel[$i][4]; }else{ $cs_t = ""; }
            if($dataexcel[$i][5] <> null){ 
                $kat = explode("/",$dataexcel[$i][5]);
                $kategori1 = $kat[0]; 
                $kategori2 = $kat[1]; 
            }else{ 
                $kategori1 = ""; 
                $kategori2 = ""; 
            }
            if($dataexcel[$i][6] <> null){ $stat = $dataexcel[$i][6]; }else{ $stat = 0; }
      

            $random = sha1(time().rand(0,99999));


            

            $data = array(
                'random' => $random,
                'nama_s' => $shopeetitle,
                'slug_s' => $slugtitle_s,
                'desc_s' => $desc_s,
                'img_s' => $urlimg_s,
                'url_s' => $url_s,
                'price_s' => $hrg_s,
                'cashback_s' => $cs_s,
                'nama_t' => $tokopediatitle,
                'slug_t' => $slugtitle_t,
                'desc_t' => $desc_t,
                'img_t' => $urlimg_t,
                'url_t' => $url_t,
                'price_t' => $hrg_t,
                'cashback_t' => $cs_t,
                'kategori' => $kategori1,
                'kategorisub' => $kategori2,
                'status' => $stat,
                'iduser' => user()->id,
                'tanggal' => date("Y-m-d"),
                'created_at' => date("Y-m-d H:i:s"),
            );

            if($shopeetitle <> "" or $tokopediatitle <> ""){ 
                $status = $this->ModelMaster->datatambah($table="x_produktoko",$data);
                
                if($status) {
                    $truecount += 1;
                }else{
                    $falsecount += 1;
                }
            }else{
                $truecount += 0;
                $falsecount += 1;
            }
            
            
            
        $no++;
        }
        // dd($truecount);

        if($truecount > 0){
            if($falsecount == 0){
                $this->session->setFlashdata('sukses', 'Melakukan Tambah Data Produk !' );
                return redirect()->to('/produk-saya');
            }else{
                $this->session->setFlashdata('warning', 'Melakukan Tambah Data Produk : SUKSES = '.$truecount.' | GAGAL = '.$falsecount  );
                return redirect()->to('/produk-saya');
            }
        }else{
            $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Produk !' );
            return redirect()->to('/produk-saya');
        }
            
    }

	public function temptambah()
	{   
            $toko = $this->db->table("x_toko")->select("namatoko")->where("iduser",user()->id)->get()->getRowArray();

            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet()->setTitle('Data Produk');
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

            $sheet->setCellValue('A1', "DATA TAMBAH DATA : ".strtoupper($toko["namatoko"])); 
            $sheet->mergeCells('A1:F1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', 'NO');
            $sheet->setCellValue('B3', 'URL PRODUK SHOPEE');
            $sheet->setCellValue('C3', 'CASHBACK SHOPEE');
            $sheet->setCellValue('D3', 'URL PRODUK TOKOPEDIA');
            $sheet->setCellValue('E3', 'CASHBACK TOKOPEDIA');
            $sheet->setCellValue('F3', 'KATEGORI');
            $sheet->setCellValue('G3', 'STATUS ( 0 / 1 ) 0 : aktif / 1 : non aktif');

            // Buat header tabel nya pada baris ke 3
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col); 
            $sheet->getStyle('F3')->applyFromArray($style_col);
            $sheet->getStyle('G3')->applyFromArray($style_col);   
            $sheet->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            
            // Set width kolom
            $sheet->getColumnDimension('A')->setWidth(10);
            $sheet->getColumnDimension('B')->setWidth(45);
            $sheet->getColumnDimension('C')->setWidth(45);
            $sheet->getColumnDimension('D')->setWidth(45);
            $sheet->getColumnDimension('E')->setWidth(45);
            $sheet->getColumnDimension('F')->setWidth(45);
            $sheet->getColumnDimension('G')->setWidth(40);

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2 = $spreadsheet->getActiveSheet()->setTitle('Kategori Produk');
            
            $sheet2->setCellValue('A1', "DATA KATEGORI PRODUK"); 
            $sheet2->mergeCells('A1:F1');
            $sheet2->getStyle('A1')->getFont()->setBold(true);

            $sheet2->setCellValue('A3', 'NO');
            $sheet2->setCellValue('B3', 'KATEGORI');
            $sheet2->setCellValue('C3', 'KATEGORI');
            $sheet2->setCellValue('D3', 'ID COPY');

            // Buat header tabel nya pada baris ke 3
            $sheet2->getStyle('A3')->applyFromArray($style_col);
            $sheet2->getStyle('B3')->applyFromArray($style_col);
            $sheet2->getStyle('C3')->applyFromArray($style_col);
            $sheet2->getStyle('D3')->applyFromArray($style_col);
            $sheet2->getStyle('A3:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            
            $kategori = $this->db->table("x_kategoritoko")
                        ->select("x_kategoritoko.namakategori,x_kategoritoko.id,x_kategoritokosub.namakategori as namakategorisub,x_kategoritokosub.id as idsub")
                        ->join("x_kategoritokosub","x_kategoritokosub.idkategori=x_kategoritoko.id","left")
                        ->where(["x_kategoritoko.deleted_at"=>null,"x_kategoritoko.status"=>0])
                        ->get()
                        ->getResultArray();
                    
            $column = 4;
            $no = 1;
            foreach($kategori as $data) {
                $spreadsheet->setActiveSheetIndex(1)
                            ->setCellValue('A' . $column, $no)
                            ->setCellValue('B' . $column, $data['namakategori'])
                            ->setCellValue('C' . $column, $data['namakategorisub'])
                            ->setCellValue('D' . $column, $data['id'].'/'.$data['idsub']);
                $column++;
                $no++;
            }  
            // Set width kolom
            $sheet2->getColumnDimension('A')->setWidth(10);
            $sheet2->getColumnDimension('B')->setWidth(45);
            $sheet2->getColumnDimension('C')->setWidth(45);
            $sheet2->getColumnDimension('D')->setWidth(45);

            $spreadsheet->setActiveSheetIndex(0);
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Format Tambah Data Excel';
            
            $writer->save("assets/excel/".$fileName.'.xlsx');
            header("Content-Type: application/vnd.ms-excel");
            return redirect()->to(base_url()."/assets/excel/".$fileName.'.xlsx'); 
	}
  
	public function editdata()
	{ 
        $file_excel = $this->request->getFile('fileexcel');
        // dd($file_excel);
      
        $ext = $file_excel->getClientExtension();
        if($ext == 'xls') {
          $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
        } else {
          $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        }
        $spreadsheet = $render->load($file_excel);
    
        $dataexcel = $spreadsheet->getActiveSheet()->toArray();

        $truecount = 0;
        $falsecount = 0;
        $no = 1;
        for($i = 3;$i < count($dataexcel);$i++)
	      {
            if($dataexcel[$i][0] <> null){ $random = $dataexcel[$i][0]; }else{ $random = ""; }
            if($dataexcel[$i][1] <> null){ 
                $dts = str_replace("http://","https://",$dataexcel[$i][1]);
                $urlshopee = fetch_shopee($dts);
                
                if($urlshopee["status"] <> "gagal"){ 

                    $shopeetitle = $urlshopee["title"];
                    $slugtitle_s = url_title(strtolower($urlshopee["title"]));
                    $desc_s = $urlshopee["description"];
                    $url_s = str_replace("http://","https://",$urlshopee["url"]);
                    $hrg_s = $urlshopee["price"];
                    $urlimg_s = $urlshopee["image"];
                
                }else{

                    $shopeetitle = "";
                    $slugtitle_s = ""; 
                    $desc_s = "";
                    $url_s = ""; 
                    $hrg_s = ""; 
                    $urlimg_s = "";

                }

            }else{ 
                $urlshopee = ""; 
                $shopeetitle = "";
                $slugtitle_s = ""; 
                $desc_s = "";
                $url_s = ""; 
                $hrg_s = ""; 
                $urlimg_s = "";
            }
            if($dataexcel[$i][2] <> null){ $cs_s = $dataexcel[$i][2]; }else{ $cs_s = ""; }
            if($dataexcel[$i][3] <> null){ 
                $dtt = str_replace("http://","https://",$dataexcel[$i][3]);
                $urltokopedia = fetch_tokopedia($dtt);
                if($urltokopedia["status"] <> "gagal"){ 
                    $tokopediatitle = $urltokopedia["title"];
                    $slugtitle_t = url_title(strtolower($urltokopedia["title"]));
                    $desc_t = $urltokopedia["description"];
                    $url_t = str_replace("http://","https://",$urltokopedia["url"]);
                    $hrg_t = $urltokopedia["price"];
                    $urlimg_t = $urltokopedia["image"];
                }else{
                    $tokopediatitle = "";
                    $slugtitle_t = ""; 
                    $desc_t = "";
                    $url_t = ""; 
                    $hrg_t = ""; 
                    $urlimg_t = "";
                }
            }else{ 
                $urltokopedia = ""; 
                $tokopediatitle = "";
                $slugtitle_t = ""; 
                $desc_t = "";
                $url_t = ""; 
                $hrg_t = ""; 
                $urlimg_t = "";
            }
            if($dataexcel[$i][4] <> null){ $cs_t = $dataexcel[$i][4]; }else{ $cs_t = ""; }
            if($dataexcel[$i][5] <> null){ 
                $kat = explode("/",$dataexcel[$i][5]);
                $kategori1 = $kat[0]; 
                $kategori2 = $kat[1]; 
            }else{ 
                $kategori1 = ""; 
                $kategori2 = ""; 
            }
            if($dataexcel[$i][6] <> null){ $stat = $dataexcel[$i][6]; }else{ $stat = 0; }
      

            

            $data = array(
                'nama_s' => $shopeetitle,
                'slug_s' => $slugtitle_s,
                'desc_s' => $desc_s,
                'img_s' => $urlimg_s,
                'url_s' => $url_s,
                'price_s' => $hrg_s,
                'cashback_s' => $cs_s,
                'nama_t' => $tokopediatitle,
                'slug_t' => $slugtitle_t,
                'desc_t' => $desc_t,
                'img_t' => $urlimg_t,
                'url_t' => $url_t,
                'price_t' => $hrg_t,
                'cashback_t' => $cs_t,
                'kategori' => $kategori1,
                'kategorisub' => $kategori2,
                'status' => $stat,
                'iduser' => user()->id,
                'tanggal' => date("Y-m-d"),
                'updated_at' => date("Y-m-d H:i:s"),
            );

            if($shopeetitle <> "" or $tokopediatitle <> ""){ 
                $status = $this->ModelMaster->dataedit($table="x_produktoko",["random"=>$random],$data);
                
                if($status) {
                    $truecount += 1;
                }else{
                    $falsecount += 1;
                }
            }else{
                $truecount += 0;
                $falsecount += 1;
            }
            
            
        $no++;
        }
        
        if($truecount > 0){
            if($falsecount == 0){
                $this->session->setFlashdata('sukses', 'Melakukan Edit Data Produk !' );
                return redirect()->to('/produk-saya');
            }else{
                $this->session->setFlashdata('warning', 'Melakukan Edit Data Produk : SUKSES = '.$truecount.' | GAGAL = '.$falsecount  );
                return redirect()->to('/produk-saya');
            }
        }else{
            $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Produk !' );
            return redirect()->to('/produk-saya');
        }
    }
	public function tempedit()
	{ 
            $toko = $this->db->table("x_toko")->select("namatoko")->where("iduser",user()->id)->get()->getRowArray();

            $spreadsheet = new Spreadsheet();
            $spreadsheet->setActiveSheetIndex(0);
            $sheet = $spreadsheet->getActiveSheet()->setTitle('Data Produk');;
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

            $sheet->setCellValue('A1', "DATA EDIT DATA : ".strtoupper($toko["namatoko"])); 
            $sheet->mergeCells('A1:F1');
            $sheet->getStyle('A1')->getFont()->setBold(true);

            $sheet->setCellValue('A3', 'ID (JANGAN DI HAPUS)');
            $sheet->setCellValue('B3', 'URL PRODUK SHOPEE');
            $sheet->setCellValue('C3', 'CASHBACK SHOPEE');
            $sheet->setCellValue('D3', 'URL PRODUK TOKOPEDIA');
            $sheet->setCellValue('E3', 'CASHBACK TOKOPEDIA');
            $sheet->setCellValue('F3', 'KATEGORI');
            $sheet->setCellValue('G3', 'STATUS ( 0 / 1 ) 0 : aktif / 1 : non aktif');

            // Buat header tabel nya pada baris ke 3
            $sheet->getStyle('A3')->applyFromArray($style_col);
            $sheet->getStyle('B3')->applyFromArray($style_col);
            $sheet->getStyle('C3')->applyFromArray($style_col);
            $sheet->getStyle('D3')->applyFromArray($style_col);
            $sheet->getStyle('E3')->applyFromArray($style_col); 
            $sheet->getStyle('F3')->applyFromArray($style_col);  
            $sheet->getStyle('G3')->applyFromArray($style_col);  
            $sheet->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            
            $kategori = $this->db->table("x_produktoko")->where("iduser",user()->id)->where("deleted_at",null)->get()->getResultArray();
                    
            $column = 4;
            $no = 1;
            foreach($kategori as $data) {
                $spreadsheet->setActiveSheetIndex(0)
                            ->setCellValue('A' . $column, $data['random'])
                            ->setCellValue('B' . $column, $data['url_s'])
                            ->setCellValue('C' . $column, $data['cashback_s'])
                            ->setCellValue('D' . $column, $data['url_t'])
                            ->setCellValue('E' . $column, $data['cashback_t'])
                            ->setCellValue('F' . $column, $data['kategori'].'/'.$data['kategorisub'])
                            ->setCellValue('G' . $column, $data['status']);
                $column++;
                $no++;
            }  
            // Set width kolom
            $sheet->getColumnDimension('A')->setWidth(45);
            $sheet->getColumnDimension('B')->setWidth(65);
            $sheet->getColumnDimension('C')->setWidth(45);
            $sheet->getColumnDimension('D')->setWidth(65);
            $sheet->getColumnDimension('E')->setWidth(45);
            $sheet->getColumnDimension('F')->setWidth(45);
            $sheet->getColumnDimension('G')->setWidth(40);

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2 = $spreadsheet->getActiveSheet()->setTitle('Kategori Produk');
            
            $sheet2->setCellValue('A1', "DATA KATEGORI PRODUK"); 
            $sheet2->mergeCells('A1:F1');
            $sheet2->getStyle('A1')->getFont()->setBold(true);

            $sheet2->setCellValue('A3', 'NO');
            $sheet2->setCellValue('B3', 'KATEGORI');
            $sheet2->setCellValue('C3', 'KATEGORI');
            $sheet2->setCellValue('D3', 'ID COPY');

            // Buat header tabel nya pada baris ke 3
            $sheet2->getStyle('A3')->applyFromArray($style_col);
            $sheet2->getStyle('B3')->applyFromArray($style_col);
            $sheet2->getStyle('C3')->applyFromArray($style_col);
            $sheet2->getStyle('D3')->applyFromArray($style_col);
            $sheet2->getStyle('A3:D3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('00b050'); 
            
            $kategori = $this->db->table("x_kategoritoko")
                        ->select("x_kategoritoko.namakategori,x_kategoritoko.id,x_kategoritokosub.namakategori as namakategorisub,x_kategoritokosub.id as idsub")
                        ->join("x_kategoritokosub","x_kategoritokosub.idkategori=x_kategoritoko.id","left")
                        ->where(["x_kategoritoko.deleted_at"=>null,"x_kategoritoko.status"=>0])
                        ->get()
                        ->getResultArray();
                    
            $column = 4;
            $no = 1;
            foreach($kategori as $data) {
                $spreadsheet->setActiveSheetIndex(1)
                            ->setCellValue('A' . $column, $no)
                            ->setCellValue('B' . $column, $data['namakategori'])
                            ->setCellValue('C' . $column, $data['namakategorisub'])
                            ->setCellValue('D' . $column, $data['id'].'/'.$data['idsub']);
                $column++;
                $no++;
            }  
            // Set width kolom
            $sheet2->getColumnDimension('A')->setWidth(10);
            $sheet2->getColumnDimension('B')->setWidth(45);
            $sheet2->getColumnDimension('C')->setWidth(45);
            $sheet2->getColumnDimension('D')->setWidth(45);

            $spreadsheet->setActiveSheetIndex(0);
            $writer = new Xlsx($spreadsheet);
            $fileName = 'Format Edit Data Excel';
            
            $writer->save("assets/excel/".$fileName.'.xlsx');
            header("Content-Type: application/vnd.ms-excel");
            return redirect()->to(base_url()."/assets/excel/".$fileName.'.xlsx'); 
	}
	
}
