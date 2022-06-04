
<?php
function number_abbr($number)
{
    $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];

    foreach ($abbrevs as $exponent => $abbrev) {
        if (abs($number) >= pow(10, $exponent)) {
            $display = $number / pow(10, $exponent);
            $decimals = ($exponent >= 3 && round($display) < 100) ? 1 : 0;
            $number = number_format($display, $decimals).$abbrev;
            break;
        }
    }

    return $number;
}
function gcd($a, $b) {
    if ($a == 0 || $b == 0)
        return abs(max(abs($a), abs($b)));
    $r = $a % $b;
    return ($r != 0) ? gcd($b, $r) : abs($b);
}

function gcd_array($array, $a = 0) {
    $b = array_pop($array);
    return ($b === null) ? (int) $a : gcd_array($array, gcd($a, $b));
}
function generate_string($input, $strength = 16) {
    $input_length = strlen($input);
    $random_string = '';
    for($i = 0; $i < $strength; $i++) {
        $random_character = $input[mt_rand(0, $input_length - 1)];
        $random_string .= $random_character;
    }

    return $random_string;
}
function cek_tabel($tabel){
  
  if($tabel == "sosmedofficial"){
    $hasil = "Sosmed Official";
  }elseif($tabel == "x_akunsosmed"){
    $hasil = "Akun Sosmed";
  }elseif($tabel == "x_d3fasttrack"){
    $hasil = "Data Sekolah";
  }elseif($tabel == "x_pendaftarpmb"){
    $hasil = "Data Pendaftar PMB";
  }elseif($tabel == "x_videotiktok"){
    $hasil = "Data Video TikTok / IG";
  }else{
    $hasil = "";
  }
  return $hasil;
 }
function carikarakter($tekss,$karakter){

$hasil = 0;
$jml_kata = count($karakter);

  for ($i=0;$i<$jml_kata;$i++){
  if (stristr($tekss,$karakter[$i])){
    $hasil=1; }
  }
return $hasil;
}
function cek_link($tekss){

  $karakter = array('https','http');
  $hasil = 0;
  $jml_kata = count($karakter);

    for ($i=0;$i<$jml_kata;$i++){
    if (stristr($tekss,$karakter[$i])){
      $hasil=1; }
    }
  return $hasil;
 }
 function cek_manage_group_menu($tekss){

   $karakter = array('#');
   $hasil = 0;
   $jml_kata = count($karakter);

     for ($i=0;$i<$jml_kata;$i++){
     if (stristr($tekss,$karakter[$i])){
       $hasil=1; }
     }
   return $hasil;
  }
  function cek_manage_menu($tekss){

    $karakter = array('**');
    $hasil = 0;
    $jml_kata = count($karakter);

      for ($i=0;$i<$jml_kata;$i++){
      if (stristr($tekss,$karakter[$i])){
        $hasil=1; }
      }
    return $hasil;
   }

function setPassword(string $password)
	{
        $config = config('Auth');

        if (
            (defined('PASSWORD_ARGON2I') && $config->hashAlgorithm == PASSWORD_ARGON2I)
                ||
            (defined('PASSWORD_ARGON2ID') && $config->hashAlgorithm == PASSWORD_ARGON2ID)
            )
        {
            $hashOptions = [
                'memory_cost' => $config->hashMemoryCost,
                'time_cost'   => $config->hashTimeCost,
                'threads'     => $config->hashThreads
                ];
        }
        else
        {
            $hashOptions = [
                'cost' => $config->hashCost
                ];
        }

        $pass = password_hash(
            base64_encode(
                hash('sha384', $password, true)
            ),
            $config->hashAlgorithm,
            $hashOptions
        );
        return $pass;
        /*
            Set these vars to null in case a reset password was asked.
            Scenario:
                user (a *dumb* one with short memory) requests a
                reset-token and then does nothing => asks the
                administrator to reset his password.
            User would have a new password but still anyone with the
            reset-token would be able to change the password.
        */
        // $this->attributes['reset_hash'] = null;
        // $this->attributes['reset_at'] = null;
        // $this->attributes['reset_expires'] = null;
	}

function format_rupiah($angka){
  $rupiah='Rp. '. number_format($angka,0,',','.');
  return $rupiah;
}


function fetch_headers($url){
  // Initialize curl
  $ch = curl_init();
  
  // URL for Scraping
  curl_setopt($ch, CURLOPT_URL,$url);
  
  // Return Transfer True
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
  $output = curl_exec($ch);
  
  // Closing cURL
  curl_close($ch);
  return $output;
}
function fetch_toko($url)
{
    $data = file_get_contents($url);
    $dom = new DomDocument;
    @$dom->loadHTML($data);
     
    $xpath = new DOMXPath($dom);
    # query metatags dengan prefix og
    $metas1 = $xpath->query('//*/script');

    $og = array();

    foreach($metas1 as $meta){
        # ambil nama properti tanpa menyertakan og
        // $property = $meta->getAttribute('data-rh');
        # ambil konten dari properti tersebut
        $content = $meta->image;
        $og[$property] = $content;
    }
    return $og;
}
function fetch_shopee($url)
{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$result_data = curl_exec($ch);
		curl_close($ch);

    $dom = new DomDocument;
    @$dom->loadHTML($result_data);
     
    $xpath = new DOMXPath($dom);
    # query metatags dengan prefix og
    $metas1 = $xpath->query('//*/meta[starts-with(@property, \'og:\')]');
    $metas2 = $xpath->query('//*/meta[starts-with(@itemprop, \'price\')]');

    $og = array();

    foreach($metas1 as $meta){
        # ambil nama properti tanpa menyertakan og
        $property = str_replace('og:', '', $meta->getAttribute('property'));
        # ambil konten dari properti tersebut
        $content = $meta->getAttribute('content');
        $og[$property] = $content;
    }
    foreach($metas2 as $meta){
      $og["price"] = $meta->getAttribute('content');
    }
    if(count($og) > 3){
      $data = array(
        "title" => $og["title"],
        "description" => $og["description"],
        "image" => $og["image"],
        "url" => $og["url"],
        "price" => round($og["price"]),
        "status" => "sukses",
      );
    }else{
      $data = array(
        "status" => "gagal",
      );
    }
    return $data;
}
function fetch_shopee_($url)
{
    $data = file_get_contents($url);
    $dom = new DomDocument;
    @$dom->loadHTML($data);
     
    $xpath = new DOMXPath($dom);
    # query metatags dengan prefix og
    $metas1 = $xpath->query('//*/meta[starts-with(@property, \'og:\')]');
    $metas2 = $xpath->query('//*/meta[starts-with(@itemprop, \'price\')]');

    $og = array();

    foreach($metas1 as $meta){
        # ambil nama properti tanpa menyertakan og
        $property = str_replace('og:', '', $meta->getAttribute('property'));
        # ambil konten dari properti tersebut
        $content = $meta->getAttribute('content');
        $og[$property] = $content;
    }
    foreach($metas2 as $meta){
      $og["price"] = $meta->getAttribute('content');
    }
    $data = array(
      "title" => $og["title"],
      "description" => $og["description"],
      "image" => $og["image"],
      "url" => $og["url"],
      "price" => round($og["price"]),
    );
    return $data;
}
function fetch_tokopedia($url)
{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		$result_data = curl_exec($ch);
		curl_close($ch);

    $dom = new DomDocument;
    @$dom->loadHTML($result_data);
     
    $xpath = new DOMXPath($dom);
    # query metatags dengan prefix og
    $metas1 = $xpath->query('//*/meta[starts-with(@property, \'\')]');
    $metas2 = $xpath->query('shopName');
    $og = array();

    foreach($metas1 as $meta){
        # ambil nama properti tanpa menyertakan og
        $property = str_replace('og:', '', $meta->getAttribute('property'));
        # ambil konten dari properti tersebut
        $content = $meta->getAttribute('content');
        $og[$property] = $content;
    }
    if(count($og) > 3){
      $data = array(
        "title" => str_replace(" | Tokopedia","",$og["title"]),
        "description" => $og["description"],
        "image" => $og["image"],
        "url" => $og["url"],
        "price" => $og["product:price:amount"],
        "status" => "sukses",
      );
    }else{
      $data = array(
        "status" => "gagal",
      );
    }
    return $data;
}
function fetch_tokopedia_($url)
{
    $data = file_get_contents($url);
    
    $dom = new DomDocument;
    @$dom->loadHTML($data);
     
    $xpath = new DOMXPath($dom);
    # query metatags dengan prefix og
    $metas1 = $xpath->query('//*/meta[starts-with(@property, \'\')]');
    $metas2 = $xpath->query('shopName');
    $og = array();

    foreach($metas1 as $meta){
        # ambil nama properti tanpa menyertakan og
        $property = str_replace('og:', '', $meta->getAttribute('property'));
        # ambil konten dari properti tersebut
        $content = $meta->getAttribute('content');
        $og[$property] = $content;
    }
    $data = array(
      "title" => str_replace(" | Tokopedia","",$og["title"]),
      "description" => $og["description"],
      "image" => $og["image"],
      "url" => $og["url"],
      "price" => $og["product:price:amount"],
    );
    return $data;
}

if (!function_exists('nomor')) {
  function nomor($currentPage, $perPage)
  {
      if (is_null($currentPage)) {
          $nomor = 1;
      } else {
          $nomor = 1 + ($perPage * ($currentPage - 1));
      }
      return $nomor;
  }
}

function filterdata($data=''){
    $data=strip_tags($data);
    // $data=htmlspecialchars($data);
    $data=htmlentities($data);
    return $data;
}
function batas($string, $length){
  if(strlen($string)<=($length)){
    echo $string;
  } else {
    $cetak = substr($string,0,$length). '...';
    echo $cetak;
  }
}
function limit_words($string, $word_limit){
  $words = explode(" ",$string);
  return implode(" ",array_splice($words,0,$word_limit));
}
function dt_tgl($date){

  $create = new DateTime($date);
  $date = date_format($create, 'Y-m-d');
  return $date;
}

function php_tags($str){
    return str_replace(array('<?php', '<?PHP', '<?', '?>', '<SCRIPT>' ,'<script>', '</SCRIPT>', '</script>'),  array('&lt;?php', '&lt;?PHP', '&lt;?', '?&gt;'), $str);
}

if ( ! function_exists('tanggal_indonesia')) {
  function tanggal_indonesia($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = bulan_panjang($pecahTanggal[1]);
    $tahun = $pecahTanggal[0];
    return $tanggal.' '.$bulan.' '.$tahun;
  }
}

if ( ! function_exists('bulan_indonesia')) {
  function bulan_indonesia($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = bulan_panjang($pecahTanggal[1]);
    $tahun = $pecahTanggal[0];
    return $bulan;
  }
}
if ( ! function_exists('bulan_indonesia_angka')) {
  function bulan_indonesia_angka($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = bulan_angka($pecahTanggal[1]);
    $tahun = $pecahTanggal[0];
    return $bulan;
  }
}
if ( ! function_exists('tanggal_indonesia_tahun')) {
  function tanggal_indonesia_tahun($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = $pecahTanggal[1];
    $tahun = $pecahTanggal[0];
    $namaHari = nama_hari(date('l', mktime(0, 0, 0, $bulan, $tanggal, $tahun)));
    return $tahun;
  }
}
if ( ! function_exists('tanggal_indonesia_bulan_tahun')) {
  function tanggal_indonesia_bulan_tahun($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = $pecahTanggal[1];
    $tahun = $pecahTanggal[0];
    $namaHari = nama_hari(date('l', mktime(0, 0, 0, $bulan, $tanggal, $tahun)));
    return bulan_panjang($bulan).' '.$tahun;
  }
}
if ( ! function_exists('tanggal_indonesia_lengkap')) {
  function tanggal_indonesia_lengkap($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = $pecahTanggal[1];
    $tahun = $pecahTanggal[0];
    $namaHari = nama_hari(date('l', mktime(0, 0, 0, $bulan, $tanggal, $tahun)));
    return $namaHari.', '.$tanggal.' '.bulan_panjang($bulan).' '.$tahun;
  }
}

if ( ! function_exists('tanggal_indonesia_medium')) {
  function tanggal_indonesia_medium($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = bulan_pendek($pecahTanggal[1]);
    $tahun = $pecahTanggal[0];
    return $tanggal.' '.$bulan.' '.$tahun;
  }
}

if ( ! function_exists('tanggal_indonesia_pendek')) {
  function tanggal_indonesia_pendek($tanggal) {
    $ubahTanggal = gmdate($tanggal, time()+60*60*8);
    $pecahTanggal = explode('-', $ubahTanggal);
    $tanggal = $pecahTanggal[2];
    $bulan = bulan_angka($pecahTanggal[1]);
    $tahun = $pecahTanggal[0];
    return $tanggal.'/'.$bulan.'/'.$tahun;
  }
}

if ( ! function_exists('bulan_panjang')) {
  function bulan_panjang($bulan) {
    switch ($bulan) {
      case 1:
        return 'Januari';
        break;
      case 2:
        return 'Februari';
        break;
      case 3:
        return 'Maret';
        break;
      case 4:
        return 'April';
        break;
      case 5:
        return 'Mei';
        break;
      case 6:
        return 'Juni';
        break;
      case 7:
        return 'Juli';
        break;
      case 8:
        return 'Agustus';
        break;
      case 9:
        return 'September';
        break;
      case 10:
        return 'Oktober';
        break;
      case 11:
        return 'November';
        break;
      case 12:
        return 'Desember';
        break;
    }
  }
}

if ( ! function_exists('bulan_pendek')) {
function bulan_pendek($bulan) {
    switch ($bulan) {
      case 1:
        return 'Jan';
        break;
      case 2:
        return 'Feb';
        break;
      case 3:
        return 'Mar';
        break;
      case 4:
        return 'Apr';
        break;
      case 5:
        return 'Mei';
        break;
      case 6:
        return 'Jun';
        break;
      case 7:
        return 'Jul';
        break;
      case 8:
        return 'Agu';
        break;
      case 9:
        return 'Sep';
        break;
      case 10:
        return 'Okt';
        break;
      case 11:
        return 'Nov';
        break;
      case 12:
        return 'Des';
        break;
    }
  }
}

if ( ! function_exists('bulan_angka')) {
  function bulan_angka($bulan) {
    switch ($bulan) {
      case 1:
        return '01';
        break;
      case 2:
        return '02';
        break;
      case 3:
        return '03';
        break;
      case 4:
        return '04';
        break;
      case 5:
        return '05';
        break;
      case 6:
        return '06';
        break;
      case 7:
        return '07';
        break;
      case 8:
        return '08';
        break;
      case 9:
        return '09';
        break;
      case 10:
        return '10';
        break;
      case 11:
        return '11';
        break;
      case 12:
        return '12';
        break;
    }
  }
}

if ( ! function_exists('nama_hari')) {
  function nama_hari($hari) {
    if ($hari == 'Sunday') {
      return 'Minggu';
    } elseif ($hari == 'Monday') {
      return 'Senin';
    } elseif ($hari == 'Tuesday') {
      return 'Selasa';
    } elseif ($hari == 'Wednesday') {
      return 'Rabu';
    } elseif ($hari == 'Thursday') {
      return 'Kamis';
    } elseif ($hari == 'Friday') {
      return 'Jumat';
    } elseif ($hari == 'Saturday') {
      return 'Sabtu';
    }
  }
}
