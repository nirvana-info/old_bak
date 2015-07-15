<?php
	require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'class.api.php');

	class API_COUPON extends API
	{
		// {{{ Class variables
		var $fields = array (
			'couponid',
			'couponname',
			'coupontype',
			'couponamount',
			'couponminpurchase',
			'couponexpires',
			'couponenabled',
			'couponcode',
			'couponappliesto',
			'couponappliestovalues',
			'couponmaxuses'
		);

		var $pk = 'couponid';
		var $couponid = 0;
		var $couponname = '';
		var $coupontype = 0;
		var $couponamount = 0;
		var $couponminpurchase = 0;
		var $couponexpires = 0;
		var $couponenabled = 0;
		var $couponcode = '';
		var $couponappliesto = '';
		var $couponappliestovalues = '';

		// }}}

		/**
		* Create a new item in the database
		*
		* @return mixed false if failed to create, the id of the item otherwise
		*/
		function create()
		{
			$_POST['couponminpurchase'] = (int)$_POST['couponminpurchase'];
			if ($this->CouponExists($_POST['couponcode']) < 1) {
				return parent::create();
			} else {
				$this->error = GetLang('apiCouponCodeAlreadyExists');
				return false;
			}
		}

		function CouponExists($code)
		{
			if (!$this->db) {
				return -1;
			}

			if (empty($code)) {
				return 0;
			}

			$query = 'SELECT COUNT(*)
				FROM '.$this->table."
				WHERE couponcode='".$this->db->Quote($code)."'";

			return $this->db->FetchOne($query);
		}

	}

?>