<?php

namespace Modules\Login\Controllers;

// use Config\Email;
use App\Controllers\BaseController;
use Modules\Login\Models\Model_login as MLogin;
use Myth\Auth\Entities\User;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;

class Login extends BaseController
{
	//protected $Model_login;
	protected $auth;
	protected $config;
	protected $session;

	public function __construct(){

		// Most services in this controller require
		// the session to be started - so fire it up!
		$this->session = service('session');

		$this->config = config('Auth');
		$this->auth = service('authentication');

		//$this->Model_login = new MLogin();

	}

		
	public function index($ket0,$ket1,$ket2)
	{	
		$config = $this->config;		

		$data = [
			'title' => "Login ".ucwords($ket0),
			'seg' => $this->request->uri->getSegments(),
			'config' => $config,
			'ket0' => $ket0,
			'ket1' => $ket1,
			'ket2' => $ket2,
		];

		return view('Modules\Login\Views\login',$data);
	}
	public function register($ket0,$ket1,$ket2)
	{

		$data = [
			'title' => "Pendaftaran Akun ".ucwords($ket0),
			'seg' => $this->request->uri->getSegments(),
			'ket0' => $ket0,
			'ket1' => $ket1,
			'ket2' => $ket2,
		];

		return view('Modules\Login\Views\register',$data);
	}
	public function forgot($ket0,$ket1,$ket2)
	{
		$data = [
			'title' => 'Lupa Password Anda?',
			'seg' => $this->request->uri->getSegments(),
			'ket1' => $ket1,
			'ket2' => $ket2,
		];

		return view('Modules\Login\Views\forgot',$data);
	}
	public function reset($ket0,$ket1)
	{	
		$token = $this->request->getGet("token");
		$email = $this->request->getGet("email");
		$data = [
			'title' => 'Reset Password '.ucwords($ket0),
			'seg' => $this->request->uri->getSegments(),
			'ket1' => $ket1,
			'token' => $token,
			'email' => $email,
		];

		return view('Modules\Login\Views\reset',$data);
	}

	
}
