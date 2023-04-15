<?php
/**
 * @author DoanLN
 * @date 2019-02-21
 * 
 */

namespace Crazy\Helpers;
use Mail;

/**
 * Tiện ích gửi mail
 * @method Email from($email, $name = null)
 * @method Email to($email, $name = null)
 * @method Email cc($email, $name = null)
 * @method Email bcc($email, $name = null)
 * @method Email replyTo($email, $name = null)
 * @method Email subject($subject)
 * @method Email body($blade)
 * @method Email data($data = [])
 * @method Email attachment($files = [])
 * @method bool send($to = null, $dubject = null, $body = null, $data = [], $attachments = [])
 * 
 */
class Email{
	protected $__from = null;
	protected $__to = [];
	protected $__CC = [];
	protected $__BCC = [];
	protected $__reply = null;
    protected $__subject = null;
    protected $__body = null;
    protected $__data = [];
	protected $__attachments = null;
	
	public function _sendMail($body = null, $var = [])
	{
		$data = [
			'from' => $this->__from,
			'to' => $this->__to,
			'CC' => $this->__CC,
			'BCC' => $this->__BCC,
			'reply' => $this->__reply,
			'subject' => $this->__subject,
			
		];
		Mail::send($body, $var, function ($message) use ($data){

			$from = $data['from'];
			if(is_string($from) && filter_var($from, FILTER_VALIDATE_EMAIL)){
				$message->from($from, 'Guest');
			}elseif(is_array($from)){
				foreach($from as $key => $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->from($val, $key);
					}else{
						$message->from($key, $val);
					}
				}
			}
			
			$reply = $data['reply'];
			if(is_string($reply) && filter_var($reply, FILTER_VALIDATE_EMAIL)){
				$message->replyTo($reply, 'Guest');
			}elseif(is_array($reply)){
				foreach($reply as $key => $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->replyTo($val, $key);
					}else{
						$message->replyTo($key, $val);
					}
				}
			}
			
			$to = $data['to'];
			if(is_string($to) && filter_var($to, FILTER_VALIDATE_EMAIL)){
				$message->to($to, 'Guest');
			}elseif(is_array($to)){
				foreach($to as $key => $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->to($val, $key);
					}else{
						$message->to($key, $val);
					}
				}
			}

			$CC = $data['CC'];
			
			if(is_string($CC) && filter_var($CC, FILTER_VALIDATE_EMAIL)){
				$message->cc($CC);
			}elseif(is_array($CC)){
				foreach($CC as $key => $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->cc($val, $key);
					}else{
						$message->cc($key, $val);
					}
				}
			}
			$BCC = $data['BCC'];
			if(is_string($BCC) && filter_var($BCC, FILTER_VALIDATE_EMAIL)){
				$message->bcc($BCC);
			}elseif(is_array($BCC)){
				foreach($BCC as $key => $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$message->bcc($val, $key);
					}else{
						$message->bcc($key, $val);
					}
				}
            }
            
			$message->subject($data['subject']);
			
		});

	}


	protected function _send($to=null,$subject=null,$body='', $data = [], $attachments = null) {
		if($subject){
			$this->__subject = $subject;
		}
		if(!$body) $body = $this->__body;
		$var = array_merge($this->__data,$data);
		if(is_string($to) && filter_var($to, FILTER_VALIDATE_EMAIL)){
			if(is_array($this->__to)){
                $this->__to[] = $to;
            }else{
                $this->__to = $to;
            }
		}elseif(is_array($to)){
			foreach($to as $key => $val){
				if(is_numeric($key)){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$this->__to[] = $val;
					}
				}elseif (strtolower($key) == '@cc') {//neu co CC
					$this->_cc($val);
				}elseif (strtolower($key) == '@bcc') {// neu co BCC
					$this->_bcc($val);
				}else{
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$this->__to[$val] = $key;
					}elseif(filter_var($key, FILTER_VALIDATE_EMAIL)){
						$this->__to[$key] = $val;
					}
				}
			}
		}
		$this->_sendMail($body, $var);
		return true;
	}

	

	protected function _from($email=null,$name=null)
	{
		if($email){
			if(is_array($email)){
				foreach($email as $key => $val){
					if(is_numeric($key)){
						if(filter_var($val, FILTER_VALIDATE_EMAIL)){
							$this->__from[$val] = 'Guest';
						}
					}else{
						if(filter_var($val, FILTER_VALIDATE_EMAIL)){
							$this->__from[$val] = $key;
						}elseif(filter_var($key, FILTER_VALIDATE_EMAIL)){
							$this->__from[$key] = $val;
						}
					}
				}
			}else{
				if($name){
					$this->__from = [$email=>$name];
				}else{
					$this->__from = $email;
				}
			}
		}
		return $this;
	}
	protected function _to($email=null,$name=null)
	{
		if($email){
			if(is_array($email)){
				foreach($email as $key => $val){
					if(is_numeric($key)){
						if(filter_var($val, FILTER_VALIDATE_EMAIL)){
							$this->__to[$val] = 'Guest';
						}
					}elseif (strtolower($key) == '@cc') {//neu co CC
						$this->_cc($val);
					}elseif (strtolower($key) == '@bcc') {// neu co BCC
						$this->_bcc($val);
					}else{
						if(filter_var($val, FILTER_VALIDATE_EMAIL)){
							$this->__to[$val] = $key;
						}elseif(filter_var($key, FILTER_VALIDATE_EMAIL)){
							$this->__to[$key] = $val;
						}
					}
				}
			}else{
				if($name){
					$this->__to[$email]=$name;
				}else{
					$this->__to[] = $email;
				}
			}
		}
		return $this;
	}

	protected function _cc($email=null, $name = null)
	{
		if($email){
			if(is_array($email)){
				foreach($email as $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$this->__CC[] = $email;
					}
				}
			}else{
                if($name){
					$this->__CC[$email]=$name;
				}else{
					$this->__CC[] = $email;
				}
				
			}
		}
		return $this;
	}

	protected function _bcc($email=null, $name = null)
	{
		if($email){
			if(is_array($email)){
				foreach($email as $val){
					if(filter_var($val, FILTER_VALIDATE_EMAIL)){
						$this->__BCC[] = $email;
					}
				}
			}else{
                if($name){
					$this->__BCC[$email]=$name;
				}else{
					$this->__BCC[] = $email;
				}
			}
		}
		return $this;
	}

	protected function _replyTo($email=null,$name=null)
	{
		if($email){
			if(is_array($email)){
				$this->__reply = $email;
			}else{
				if($name){
					$this->__reply = [$email=>$name];
				}else{
					$this->__reply = $email;
				}
			}
		}
		return $this;
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


    public function __call($method, $params){
		if(method_exists($this,'_'.$method)){
			return call_user_func_array([$this,'_'.$method],$params);
		}
		return $this;
	}
	public static function __callStatic($method, $params){
		$mail = new static();
		return call_user_func_array([$mail,$method],$params);
		
	}
}
