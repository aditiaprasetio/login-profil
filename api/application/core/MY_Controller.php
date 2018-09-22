<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller{
	public function __construct(){
		parent::__construct();
		$this->load->driver('session');
		$this->load->helper('url');
		
	}
	
	public function isLogin(){
		$this->load->library('user_agent');
		if ($this->agent->is_referral()){
			$redirect_url= $this->agent->referrer();
		}else{
			$redirect_url= 'beranda';
		}
		
		if($this->session->userdata('id')==null){
			redirect(site_url('auth?go='.$redirect_url));
		}
	}

	public function isLogout(){
		if($this->session->userdata('id')!=null){
			redirect(site_url('beranda'));
		}
	}
	function html_cut($text, $max_length)
	{
		$tags   = array();
		$result = "";

		$is_open   = false;
		$grab_open = false;
		$is_close  = false;
		$in_double_quotes = false;
		$in_single_quotes = false;
		$tag = "";

		$i = 0;
		$stripped = 0;

		$stripped_text = strip_tags($text);

		while ($i < strlen($text) && $stripped < strlen($stripped_text) && $stripped < $max_length)
		{
			$symbol  = $text{$i};
			$result .= $symbol;

			switch ($symbol)
			{
			   case '<':
					$is_open   = true;
					$grab_open = true;
					break;

			   case '"':
				   if ($in_double_quotes)
					   $in_double_quotes = false;
				   else
					   $in_double_quotes = true;

				break;

				case "'":
				  if ($in_single_quotes)
					  $in_single_quotes = false;
				  else
					  $in_single_quotes = true;

				break;

				case '/':
					if ($is_open && !$in_double_quotes && !$in_single_quotes)
					{
						$is_close  = true;
						$is_open   = false;
						$grab_open = false;
					}

					break;

				case ' ':
					if ($is_open)
						$grab_open = false;
					else
						$stripped++;

					break;

				case '>':
					if ($is_open)
					{
						$is_open   = false;
						$grab_open = false;
						array_push($tags, $tag);
						$tag = "";
					}
					else if ($is_close)
					{
						$is_close = false;
						array_pop($tags);
						$tag = "";
					}

					break;

				default:
					if ($grab_open || $is_close)
						$tag .= $symbol;

					if (!$is_open && !$is_close)
						$stripped++;
			}

			$i++;
		}

		while ($tags)
			$result .= "</".array_pop($tags).">";

		return $result;
	}
	
	public function buatslug($text){
	  // replace non letter or digits by -
	  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

	  // transliterate
	  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

	  // remove unwanted characters
	  $text = preg_replace('~[^-\w]+~', '', $text);

	  // trim
	  $text = trim($text, '-');

	  // remove duplicate -
	  $text = preg_replace('~-+~', '-', $text);

	  // lowercase
	  $text = strtolower($text);
	  $text = trim($text,'-');
	  if (empty($text)) {
		return 'n-a';
	  }

	  return $text;
	}
	
	public function enkripsi($text){
		return sha1($text);
	}
	public function enkripsifile($text){
		return sha1($text);
	}
	public function kirimemail($subject, $message){
		$email=$this->session->userdata('email');
		$this->load->library('email');

		$this->email->initialize(array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'wemo.kampusgo.xyz',
		  'smtp_user' => 'no-reply@wemo.kampusgo.xyz',
		  'smtp_pass' => 't~w+obBb27nu',
		  'smtp_port' => 465,
		  'crlf' => "\r\n",
		  'newline' => "\r\n",
		  'mailtype'=>'html',
		  'smtp_crypto'=>'tls'
		));
		
		$this->email->from('no-reply@wemo.kampusgo.xyz', 'WeMo Weather Monitoring');
		$this->email->to($email);

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();

		echo $this->email->print_debugger();
	}
	public function kirimemail_nologin($to, $subject, $message){
		$this->load->library('email');
		$from='no-reply@wemo.kampusgo.xyz';
		
		$config = array(
			'protocol'  => 'smtp',
			'smtp_host' => 'ssl://wemo.kampusgo.xyz',
			'smtp_port' => 465,
			'smtp_user' => $from,
			'smtp_pass' => 't~w+obBb27nu',
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$this->email->initialize($config);
		$this->email->set_mailtype("html");
		$this->email->set_newline("\r\n");
		
		$this->email->from($from, 'WeMo Weather Monitoring');
		$this->email->to($to);
		$this->email->reply_to($from, 'Weather Monitoring');
		// $this->email->cc('another@another-example.com');
		// $this->email->bcc('them@their-example.com');

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();
	}
	public function kirimemail_keadmin($subject, $message){
		$email='info.jihadstory@gmail.com';
		$this->load->library('email');

		$this->email->initialize(array(
		  'protocol' => 'smtp',
		  'smtp_host' => 'mx1.hostinger.co.id',
		  'smtp_user' => 'info@jihadstory.com',
		  'smtp_pass' => 'mlYug2sE5O5b',
		  'smtp_port' => 587,
		  'crlf' => "\r\n",
		  'newline' => "\r\n",
		  'mailtype'=>'html'
		  // 'smtp_crypto'=>'tls'
		));
		
		$this->email->from('info@jihadstory.com', 'Jihad Story');
		$this->email->to($email);

		$this->email->subject($subject);
		$this->email->message($message);

		$this->email->send();

		echo $this->email->print_debugger();
	}
	public function uploadfile($file, $name_attr, $dir, $allowed_type, $max_size='2548'){
		$id=$this->session->userdata('id');
		// upload gambar
		if(isset($file[$name_attr]) && $file[$name_attr]['name']!=''){
			$ekstensi=explode('.',$file[$name_attr]['name']);
			$ekstensi=$ekstensi[1];
			$config2['upload_path'] = $dir;
			//preview_konten
			$fileName2 = sha1($name_attr.$id."-".gmdate("d-m-y-H-i-s", time()+3600*7)).".".$ekstensi;
			
			$config2['allowed_types'] = $allowed_type;
			$config2['max_size'] = $max_size;
			$config2['file_name'] = $fileName2;	
			$this->load->library('upload',$config2);
			$this->upload->initialize($config2);
			if($this->upload->do_upload($name_attr)){
				// create small image
				$configimage['image_library'] = 'gd';
				$configimage['source_image'] = $config2['upload_path'].$fileName2;
				$configimage['create_thumb'] = TRUE;
				$configimage['maintain_ratio'] = TRUE;
				$configimage['width']         = 300;
				$configimage['height']       = 300;

				$this->load->library('image_lib', $configimage);

				$this->image_lib->resize();
				
				$result=array(
						'error'=>false,
						'result'=>$fileName2
					);
				return $result;
			}else{
				$result=array(
						'error'=>true,
						'message'=>$this->upload->display_errors()
					);
				return $result;
			}
		}
	}
	function test_input($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}
}
?>