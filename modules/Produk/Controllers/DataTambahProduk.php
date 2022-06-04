<?php

namespace Modules\Produk\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelMaster;
use CodeIgniter\I18n\Time;

class DataTambahProduk extends BaseController
{
	protected $session;
  protected $db;

	public function __construct(){
		$this->session = service('session');

    $this->ModelMaster = new ModelMaster();
    $this->db = \Config\Database::connect();

	}


	public function index()
	{
    // $kategori = $this->db->table("x_kategoritoko")->select("namakategori,id")->where(["deleted_at"=>null,"status"=>0])->get()->getResultArray();
    $kategori = $this->db->table("x_kategoritoko")
                ->select("x_kategoritoko.namakategori,x_kategoritoko.id,x_kategoritokosub.namakategori as namakategorisub,x_kategoritokosub.id as idsub")
                ->join("x_kategoritokosub","x_kategoritokosub.idkategori=x_kategoritoko.id","left")
                ->where(["x_kategoritoko.deleted_at"=>null,"x_kategoritoko.status"=>0])
                ->get()
                ->getResultArray();
		$data = [
			'seg' => $this->request->uri->getSegments(),
			'pretitle' => 'Produk',
			'title' => 'Tambah Produk Baru',
      'kategori' => $kategori,
		];

		return view('Modules\Produk\Views\tambahproduk',$data);
	}
  
	public function saveproduk()
	{
    if($this->request->getPost("linkprodukshopee") <> "" and $this->request->getPost("linkproduktokopedia") == ""){

      $rules = [
        'linkprodukshopee' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Link Produk Shopee</b> harus di isi !!!',
        	]
        ],
        'cashbackprodukshopee' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Cashback Produk Shopee</b> harus di isi !!!',
        	]
        ],
        'kategoriproduk' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>Kategori Produk</b> harus di pilih !!!',
          ]
        ],
      ];
    }elseif($this->request->getPost("linkprodukshopee") == "" and $this->request->getPost("linkproduktokopedia") <> ""){

      $rules = [
        'linkproduktokopedia' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>Link Produk Tokopedia</b> harus di isi !!!',
          ]
        ],
        'cashbackproduktokopedia' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>Cashback Produk Tokopedia</b> harus di isi !!!',
          ]
        ],
        'kategoriproduk' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>Kategori Produk</b> harus di pilih !!!',
          ]
        ],
      ];
    }elseif($this->request->getPost("linkprodukshopee") <> "" and $this->request->getPost("linkproduktokopedia") <> ""){

      $rules = [
        'linkprodukshopee' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Link Produk Shopee</b> harus di isi !!!',
        	]
        ],
        'cashbackprodukshopee' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Cashback Produk Shopee</b> harus di isi !!!',
        	]
        ],
        'linkproduktokopedia' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>Link Produk Tokopedia</b> harus di isi !!!',
          ]
        ],
        'cashbackproduktokopedia' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>Cashback Produk Tokopedia</b> harus di isi !!!',
          ]
        ],
        'kategoriproduk' => [
          'rules'  => 'required',
          'errors' => [
            'required'  => '<b>Kategori Produk</b> harus di pilih !!!',
          ]
        ],
      ];
    }else{
      $rules = [
        'linkprodukshopee' => [
        	'rules'  => 'required',
        	'errors' => [
        		'required'  => '<b>Salah Satu Link Shopee atau Tokopedia </b> harus di isi !!!',
        	]
        ],
      ];

    }

    if (! $this->validate($rules))
    {
      return redirect()->back()->withInput()->with('errors', service('validation')->getErrors());
    }else{
      $random = sha1(time().rand(0,9999999));
      $kategori = explode("/",$this->request->getPost("kategoriproduk"));

        // $urlshopee = fetch_shopee($this->request->getPost("linkprodukshopee"));
      // SHOPEE ONLY
      if($this->request->getPost("linkprodukshopee") <> "" and $this->request->getPost("linkproduktokopedia") == ""){
        $urlshopee = fetch_shopee(str_replace("http://","https://",$this->request->getPost("linkprodukshopee")));

        if($urlshopee["status"] == "gagal"){     
          $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Produk! URL SHOPEE Produk Salah/Produk Tidak Ditemukan' );
          return redirect()->back()->withInput();
        }

        $slugtitle = url_title(strtolower($urlshopee["title"]));

        // imageshopee
        $urlimg = $urlshopee["image"];
        // if($urlimg <> ""){
        //   $namaimage = $slugtitle.'-shopee.jpg';
        //   $img = FCPATH.'/assets/images/fotoproduk/'.$namaimage;
        //   // Save image
        //   $ch = curl_init($urlimg);
        //   $fp = fopen($urlimg, 'wb');
        //   curl_setopt($ch, CURLOPT_FILE, $fp);
        //   curl_setopt($ch, CURLOPT_HEADER, 0);
        //   curl_exec($ch);
        //   curl_close($ch);
        //   fclose($fp);
        // }else{
        //   $namaimage = "";
        // }

        $data = array(
            'random' => $random,
            'nama_s' => $urlshopee["title"],
            'slug_s' => $slugtitle,
            'desc_s' => $urlshopee["description"],
            'img_s' => $urlimg,
            'url_s' => $urlshopee["url"],
            'price_s' => $urlshopee["price"],
            'cashback_s' => filterdata($this->request->getPost("cashbackprodukshopee")),
            'kategori' => $kategori[0],
            'kategorisub' => $kategori[1],
            'iduser' => user()->id,
            'tanggal' => date("Y-m-d"),
            'created_at' => date("Y-m-d H:i:s"),
        );
        $status = $this->ModelMaster->datatambah($table="x_produktoko",$data);
      }

      // TOKOPEDIA ONLY
      if($this->request->getPost("linkprodukshopee") == "" and $this->request->getPost("linkproduktokopedia") <> ""){
        $urltokopedia = fetch_tokopedia(str_replace("http://","https://",$this->request->getPost("linkproduktokopedia")));
        
        if($urltokopedia["status"] == "gagal"){     
          $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Produk! URL TOKOPEDIA Produk Salah/Produk Tidak Ditemukan' );
          return redirect()->back()->withInput();
        }

        $slugtitle = url_title(strtolower($urltokopedia["title"]));

        // imagestokopedia
        $urlimg = $urltokopedia["image"];
        // if($urlimg <> ""){
        //   $namaimage = $slugtitle.'-tokopedia.jpg';
        //   $img = FCPATH.'/assets/images/fotoproduk/'.$namaimage;
        //   // Save image
        //   $ch = curl_init($urlimg);
        //   $fp = fopen($urlimg, 'wb');
        //   curl_setopt($ch, CURLOPT_FILE, $fp);
        //   curl_setopt($ch, CURLOPT_HEADER, 0);
        //   curl_exec($ch);
        //   curl_close($ch);
        //   fclose($fp);
        // }else{
        //   $namaimage = "";
        // }

        $data = array(
            'random' => $random,
            'nama_t' => $urltokopedia["title"],
            'slug_t' => $slugtitle,
            'desc_t' => $urltokopedia["description"],
            'img_t' => $urlimg,
            'url_t' => $urltokopedia["url"],
            'price_t' => $urltokopedia["price"],
            'cashback_t' => filterdata($this->request->getPost("cashbackproduktokopedia")),
            'kategori' => $kategori[0],
            'kategorisub' => $kategori[1],
            'iduser' => user()->id,
            'tanggal' => date("Y-m-d"),
            'created_at' => date("Y-m-d H:i:s"),
        );
        $status = $this->ModelMaster->datatambah($table="x_produktoko",$data);
        
      }

      // SHOPEE & TOKOPEDIA
      if($this->request->getPost("linkprodukshopee") <> "" and $this->request->getPost("linkproduktokopedia") <> ""){
        $urlshopee = fetch_shopee(str_replace("http://","https://",$this->request->getPost("linkprodukshopee")));

        if($urlshopee["status"] == "gagal"){     
          $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Produk! URL SHOPEE Produk Salah/Produk Tidak Ditemukan' );
          return redirect()->back()->withInput();
        }
        $slugtitle_s = url_title(strtolower($urlshopee["title"]));

        $urltokopedia = fetch_tokopedia(str_replace("http://","https://",$this->request->getPost("linkproduktokopedia")));       

        if($urltokopedia["status"] == "gagal"){     
          $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Produk! URL TOKOPEDIA Produk Salah/Produk Tidak Ditemukan' );
          return redirect()->back()->withInput();
        } 
        $slugtitle_t = url_title(strtolower($urltokopedia["title"]));

        // imageshopee
        $urlimg_s = $urlshopee["image"];
        // if($urlimg_s <> ""){
        //   $namaimage_s = $slugtitle.'-shopee.jpg';
        //   $img = FCPATH.'/assets/images/fotoproduk/'.$namaimage_s;
        //   // Save image
        //   $ch = curl_init($urlimg_s);
        //   $fp = fopen($urlimg_s, 'wb');
        //   curl_setopt($ch, CURLOPT_FILE, $fp);
        //   curl_setopt($ch, CURLOPT_HEADER, 0);
        //   curl_exec($ch);
        //   curl_close($ch);
        //   fclose($fp);
        // }else{
        //   $namaimage_s = "";
        // }

        // imagestokopedia
        $urlimg_t = $urltokopedia["image"];
        // if($urlimg_t <> ""){
        //   $namaimage_t = $slugtitle.'-tokopedia.jpg';
        //   $img = FCPATH.'/assets/images/fotoproduk/'.$namaimage_t;
        //   // Save image
        //   $ch = curl_init($urlimg_t);
        //   $fp = fopen($urlimg_t, 'wb');
        //   curl_setopt($ch, CURLOPT_FILE, $fp);
        //   curl_setopt($ch, CURLOPT_HEADER, 0);
        //   curl_exec($ch);
        //   curl_close($ch);
        //   fclose($fp);
        // }else{
        //   $namaimage_t = "";
        // }

        $data = array(
            'random' => $random,
            'nama_s' => $urlshopee["title"],
            'slug_s' => $slugtitle_s,
            'desc_s' => $urlshopee["description"],
            'img_s' => $urlimg_s,
            'url_s' => $urlshopee["url"],
            'price_s' => $urlshopee["price"],
            'cashback_s' => filterdata($this->request->getPost("cashbackprodukshopee")),
            'nama_t' => $urltokopedia["title"],
            'slug_t' => $slugtitle_t,
            'desc_t' => $urltokopedia["description"],
            'img_t' => $urlimg_t,
            'url_t' => $urltokopedia["url"],
            'price_t' => $urltokopedia["price"],
            'cashback_t' => filterdata($this->request->getPost("cashbackproduktokopedia")),
            'kategori' => $kategori[0],
            'kategorisub' => $kategori[1],
            'iduser' => user()->id,
            'tanggal' => date("Y-m-d"),
            'created_at' => date("Y-m-d H:i:s"),
        );
        $status = $this->ModelMaster->datatambah($table="x_produktoko",$data);
      }

      if ($status) {
        $this->logdata("x_produktoko","1",array("random" => $random));
        $this->session->setFlashdata('sukses', 'Melakukan Tambah Data Produk !' );
        return redirect()->to('/tambah-produk-baru');
      }else{
        $this->session->setFlashdata('gagal', 'Melakukan Tambah Data Produk !' );
        return redirect()->to('/tambah-produk-baru');
      }

    }


  }

}
