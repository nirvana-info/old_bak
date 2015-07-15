<?php

class ISC_SESSION
{

	private $_id = 0;
	private $_token = null;
	private $_data = null;

	public function __construct($sessionId="")
	{
		session_set_save_handler(array(&$this, "_SessionOpen"),
			array(&$this, "_SessionClose"),
			array(&$this, "_SessionRead"),
			array(&$this, "_SessionWrite"),
			array(&$this, "_SessionDestroy"),
			array(&$this, "_SessionGC")
		);

		@ini_set('url_rewriter.tags', '');
		@ini_set('session.gc_probability', 1);
		@ini_set('session.gc_divisor', 100);

		@ini_set('session.gc_maxlifetime', 86400); // 7 days
		@ini_set('session.referer_check', '');

		if (defined('FORCE_SESSION_COOKIE')) {
			@ini_set('session.use_cookies', 1);
		} else {
			@ini_set('session.use_cookies', 0);
		}

		if(defined('NO_SESSION')) {
			return;
		}
		
		// johnny add
		if (isset($_POST["_COOKIE"]))
		{ 
		   $_COOKIE = unserialize(base64_decode($_POST["_COOKIE"]));
		}

		if($sessionId != '') {
			session_id($sessionId);
		}
		else if(isset($_COOKIE['SHOP_SESSION_TOKEN'])) {
			session_id($_COOKIE['SHOP_SESSION_TOKEN']);
		}

		session_start();
	}

	public function LoadSessionByToken($token)
	{
		$query = sprintf("SELECT sessionid, sessdata FROM [|PREFIX|]sessions WHERE sessionhash='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($token));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$session = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		return @session_decode($session['sessdata']);
	}

	public function CreateSession()
	{
		$this->_token = session_id();
		$newSession = array(
			"sessionhash" => $this->_token,
			"sessdata" => "",
			"sesslastupdated" => time()
		);
		$this->_id = $GLOBALS['ISC_CLASS_DB']->InsertQuery("sessions", $newSession);
		$this->_new_session = true;
		$this->_data = array();

		ISC_SetCookie("SHOP_SESSION_TOKEN", $this->_token, time()+((int)@ini_get('session.gc_maxlifetime')));
	}

	public function _SessionOpen()
	{
		return true;
	}

	public function _SessionClose()
	{
		return true;
	}

	public function _SessionRead($token)
	{
		$this->_token = $GLOBALS['ISC_CLASS_DB']->Quote($token);
		$query = sprintf("SELECT sessionid, sessdata FROM [|PREFIX|]sessions WHERE sessionhash='%s'", $GLOBALS['ISC_CLASS_DB']->Quote($this->_token));
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$session = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		if($session['sessionid']) {
			$this->_id = $session['sessionid'];
			return $session['sessdata'];
		}
		else {
			$this->CreateSession();
		}
	}

	public function _SessionWrite($token, $data)
	{
		if(!$this->_id) {
			return false;
		}
		$updatedSession = array(
			"sessdata" => $data,
			"sesslastupdated" => time()
		);
		$where = sprintf("sessionid='%d'", $GLOBALS['ISC_CLASS_DB']->Quote($this->_id));
		$GLOBALS['ISC_CLASS_DB']->UpdateQuery("sessions", $updatedSession, $where);
		return true;
	}

	public function _SessionDestroy($token)
	{
		if($token == $this->_token) {
			$query = sprintf("DELETE FROM [|PREFIX|]sessions WHERE sessionid='%d'", $this->_id);
		}
		else {
			$token = $GLOBALS['ISC_CLASS_DB']->Quote($token);
			$query = sprintf("DELETE FROM [|PREFIX|}session WHERE sessionhash='%s'", $token);
		}
		ISC_UnsetCookie("SHOP_SESSION_TOKEN");
		return $GLOBALS['ISC_CLASS_DB']->Query($query);
	}

	public function _SessionGC($max)
	{
		$query = sprintf("DELETE FROM [|PREFIX|]sessions WHERE sesslastupdated < %d", (time()-$max));
		return $GLOBALS['ISC_CLASS_DB']->Query($query);
	}
}
?>
