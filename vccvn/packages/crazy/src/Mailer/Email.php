<?php
/**
 * @author DoanLN
 * @date 2019-07-16
 *
 */

namespace Crazy\Mailer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

/**
 * Tiện ích gửi mail
 * @method static Email from($email, $name = null) fake email gui di
 * @method static Email to($email, $name = null) set email nhan
 * @method static Email cc($email, $name = null) set cc
 * @method static Email bcc($email, $name = null) set bcc
 * @method static Email replyTo($email, $name = null) set dia chi reply
 * @method static Email subject($subject) set subject
 * @method static Email body($blade) set blade view
 * @method static Email data($data = []) data truyen vao view
 * @method static Email attachment($files = []) file dinh kem

 * @method Email to($email, $name = null) fake email gui di
 * @method Email cc($email, $name = null) set dia chi emai nguoi nhan
 * @method Email bcc($email, $name = null) set bcc
 * @method Email replyTo($email, $name = null) set dia chi nguoio nhn tra loi
 * @method Email subject($subject) set subject
 * @method Email body($blade) set blade view
 * @method Email data($data = []) set data truyen vao view
 * @method Email attachment($files = []) file dinh kem
 * @method bool send($to = null, $dubject = null, $body = null, $data = [], $attachments = []) gui đi
 * @method bool sendAfter(int $time = 1) gui sau n phut
 * @method bool queue(int $time = 1) gui sau n phut
 *
 */
class Email{
    protected $__subject = null;
    protected $__body = null;
    protected $__data = [];
	protected $__attachments = null;
	protected $addressData = [
		'from' => [],
		'to' => [],
		'cc' => [],
		'bcc' => [],
		'replyTo' => []
	];
	protected $config = [];
	/**
	 * khoi tao
	 */
	public function __construct(){
		if(!$this->config){
			if(get_owner_id()){
				$setting = get_mailer_setting();

				$config = [

					'driver' => $setting->mail_driver(env('MAIL_DRIVER', 'smtp')),
					'host' => $setting->mail_host(env('MAIL_HOST', 'smtp.mailgun.org')),

					'port' => $setting->mail_port(env('MAIL_PORT', 587)),
					'from' => [
						'address' => $setting->mail_from_address(env('MAIL_FROM_ADDRESS', 'hello@example.com')),
						'name' => $setting->mail_from_name(env('MAIL_FROM_NAME', 'Example')),
					],
					'encryption' => $setting->mail_encryption(env('MAIL_ENCRYPTION', 'tls')),
					'username' => $setting->mail_username(env('MAIL_USERNAME')),
					'password' => $setting->mail_password(env('MAIL_PASSWORD')),
					'sendmail' => '/usr/sbin/sendmail -bs',
					'markdown' => [
						'theme' => 'default',
						'paths' => [
							resource_path('views/vendor/mail'),
						],
					],
				];

			}else{
				$config = [

					'driver' => env('MAIL_DRIVER', 'smtp'),
					'host' => env('MAIL_HOST', 'smtp.mailgun.org'),

					'port' => env('MAIL_PORT', 587),
					'from' => [
						'address' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),
						'name' => env('MAIL_FROM_NAME', 'Example'),
					],
					'encryption' => env('MAIL_ENCRYPTION', 'tls'),
					'username' => env('MAIL_USERNAME'),
					'password' => env('MAIL_PASSWORD'),
					'sendmail' => '/usr/sbin/sendmail -bs',
					'markdown' => [
						'theme' => 'default',
						'paths' => [
							resource_path('views/vendor/mail'),
						],
					],
				];
			}

			$this->config = $config;
			Config::set('mail', $config);

		}
	}
	/**
	 * thêm địa chỉ email
	 *
	 * @param string $type
	 * @param array|string $email
	 * @param string $name
	 * @return static
	 */
	public function addAddress($type = 'to', $email = null, $name = null)
	{
		if($email && array_key_exists($type, $this->addressData)){
			if(is_array($email)){
				foreach($email as $key => $val){
					if(is_numeric($key)){
						if(filter_var($val, FILTER_VALIDATE_EMAIL)){
							$this->addressData[$type][$val] = 'Guest';
						}
					}else{
						if(filter_var($val, FILTER_VALIDATE_EMAIL)){
							$this->addressData[$type][$val] = $key;
						}elseif(filter_var($key, FILTER_VALIDATE_EMAIL)){
							$this->addressData[$type][$key] = $val;
						}
					}
				}
			}else{
				if($name){
					$this->addressData[$type][$email] = $name;
				}else{
					$this->addressData[$type][] = $email;
				}
			}
		}
		return $this;
	}

	/**
	 * gọi hàm gì đó trong message
	 *
	 * @param mixed $message
	 * @param string $method
	 * @param array|string $info
	 * @return mixed
	 */
	public function callMessageMethod($message, $method, $info)
	{
		if(is_string($info) && filter_var($info, FILTER_VALIDATE_EMAIL)){
			call_user_func_array([$message, $method], [$info, 'Guest']);
		}elseif(is_array($info)){
			foreach($info as $key => $val){
				if(filter_var($val, FILTER_VALIDATE_EMAIL)){
					call_user_func_array([$message, $method], (!is_numeric($key)) ? [$val, $key] : [$val]);
				}elseif(filter_var($key, FILTER_VALIDATE_EMAIL)){
					call_user_func_array([$message, $method], [$key, $val]);
				}
			}
		}
		return $message;
	}

	/**
	 * gửi mail
	 *
	 * @param string $body
	 * @param array $var
	 * @return void
	 */
	public function _sendMail($body = null, $var = [])
	{
		Config::set('mail', $this->config);
		Mail::send($body, $var, function ($message){
			$data = $this->addressData;
			foreach ($data as $key => $value) {
				$this->callMessageMethod($message, $key, $value);
			}
			$message->subject($this->__subject);
		});

	}


	/**
	 * gửi mail
	 *
	 * @param string|array $to địa chỉ / thông tin người nhận
	 * @param string $subject Chủ đề
	 * @param string $body blade view
	 * @param array $data sữ liệu được dùng trong mail
	 * @param array $attachments file đính kèm
	 * @return bool
	 */
	protected function _send($to=null,$subject=null,$body='', $data = [], $attachments = null) {
		if($subject){
			$this->__subject = $subject;
		}
		if(!$body) $body = $this->__body;
		$var = array_merge($this->__data,$data);
		if(is_string($to) && filter_var($to, FILTER_VALIDATE_EMAIL)){
			$this->addAddress('to', $to);
		}elseif(is_array($to)){
			foreach($to as $key => $val){
				if(is_numeric($key)){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$this->addAddress('to', $val);
					}
				}elseif (strtolower($key) == '@cc') {//neu co CC
					$this->addAddress('cc', $val);
				}elseif (strtolower($key) == '@bcc') {// neu co BCC
					$this->addAddress('bcc', $val);
				}else{
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$this->addAddress('to', $val, $key);
					}elseif(filter_var($key, FILTER_VALIDATE_EMAIL)){
						$this->addAddress('to', $key, $val);
					}
				}
			}
		}
		$this->_sendMail($body, $var);
		return true;
	}

	protected function _subject($subject=null)
	{
		$this->__subject = $subject;
		return $this;
	}

	protected function _body($body=null)
	{
		$this->__body = $body;
		return $this;
	}

	protected function _data($data=null)
	{
		$this->__data = $data;
		return $this;
	}

	protected function _queue(int $time = 1){
		Config::set('mail', $this->config);
		if(is_numeric($time) && $time >= 0){
			$body = view($this->__body, $this->__data)->render();
			$this->__data = ['body' => $body];
			$this->__body = 'mails.queue';
			$emailJob = (new Job($this))->delay(Carbon::now()->addMinutes($time));
			dispatch($emailJob);
			return true;
		}else{
			return false;
		}
	}

	protected function _sendAfter(int $time = 1){
		Config::set('mail', $this->config);
		return $this->_queue($time);
	}

    public function __call($method, $params){
		if(array_key_exists($method, $this->addressData)){
			return $this->addAddress($method, ...$params);
		}
		elseif(method_exists($this,'_'.$method)){
			return call_user_func_array([$this,'_'.$method],$params);
		}
		return $this;
	}
	public static function __callStatic($method, $params){
		$mail = new static();
		return call_user_func_array([$mail,$method],$params);
	}
}
