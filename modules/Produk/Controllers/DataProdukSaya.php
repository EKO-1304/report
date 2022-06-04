<?php

namespace Modules\Produk\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use Modules\Produk\Models\ModelProdukSaya;
use CodeIgniter\I18n\Time;

class DataProdukSaya extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->ModelProdukSaya = new ModelProdukSaya();
    $this->db = \Config\Database::connect();

	}


	public function index()
	{ 
        $cek = $this->db->table("x_toko")->where(["iduser"=>user()->id])->countAllResults();
        if($cek == 0){    
            return redirect()->to(base_url("data-profil-toko"));
        }
        
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Produk',
			'title' => 'Produk Saya',
		];

		return view('Modules\Produk\Views\produksaya',$data);
	}
  

	public function produkjson()
	{
    $data_model = $this->ModelProdukSaya;
    $list = $data_model->get_datatables();
    $data = array();
    $no = $_POST['start'];
    foreach ($list as $lists) {
        $random = $lists->random;

        $nama_s = $lists->nama_s;                                               
        $nama_t = $lists->nama_t;
        if(trim($nama_s) <> ""){
            $namaproduk = $nama_s;
        }else{
            $namaproduk = $nama_t;
        }

        $slug_s = $lists->slug_s;                                               
        $slug_t = $lists->slug_t;
        if(trim($slug_s) <> ""){
            $slugproduk = $slug_s;
        }else{
            $slugproduk = $slug_t;
        }
        
        $price_s = format_rupiah($lists->price_s);                                                
        $price_t = format_rupiah($lists->price_t);
        if($lists->price_s <> 0){
            $harga = $price_s;
        }else{
            $harga = $price_t;
        }

        $url_s = $lists->url_s;  
        if(trim($url_s) <> ""){
            $urlproduk_s = '<a href="'.$url_s.'" target="_BLANK" class="btn btn-sm p-1" style="background-color:#ff6938;color:#fff;">Link</a>';
        }else{
            $urlproduk_s = "";
        }
        $url_t = $lists->url_t;  
        if(trim($url_t) <> ""){
            $urlproduk_t = '<a href="'.$url_t.'" target="_BLANK" class="btn btn-sm p-1" style="background-color:#02ac0e;color:#fff;">Link</a>';
        }else{
            $urlproduk_t = "";
        }

        $cashback_s = format_rupiah($lists->cashback_s);                                                
        $cashback_t = format_rupiah($lists->cashback_t);

        $kategori = '<span style="font-size:13px;font-weight:bold">'.$lists->namakategori.'</span> - <span class="text-primary" style="font-size:13px;font-weight:bold">'.$lists->namakategorisub.'</span>';

        $status = $lists->status; 
        if($status == 0){
            $stat = '<a href="javascript:void(0)" id="'.$random.'/1" onclick="status(this.id)" class="btn btn-success btn-sm text-light py-1"><i class="icon-copy dw dw-checked"></i></a>';
        }else{
            $stat = '<a href="javascript:void(0)" id="'.$random.'/0" onclick="status(this.id)" class="btn btn-danger btn-sm text-light py-1"><i class="icon-copy dw dw-cancel"></i></a>';
        }

        $no++;
        $row    = array();
        $row[]  = $no;
        $row[]  = $namaproduk;
        $row[]  = $kategori;
        $row[]  = $urlproduk_s;
        $row[]  = $price_s;
        $row[]  = $cashback_s;
        $row[]  = $urlproduk_t;
        $row[]  = $price_t;
        $row[]  = $cashback_t;
        $row[]  = $stat;
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
