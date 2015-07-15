<?php
	require_once(dirname(__FILE__).DIRECTORY_SEPARATOR.'class.api.php');

	class API_NEWS extends API
	{
		// {{{ Class variables
		var $fields = array (
			'newsid',
			'newstitle',
			'newscontent',
			'newsdate',
			'newsvisible',
		);

		var $newsid = 0;
		var $newstitle = '';
		var $newscontent = '';
		var $newsdate = 0;
		var $newsvisible = 0;

		// }}}

		// {{{ setupDatabase()
		/**
		* Setup the connection to the database and some other database
		* properties
		*
		* @return void
		*/
		function setupDatabase()
		{
			$this->db = $GLOBALS['ISC_CLASS_DB'];
			$tableSuffix = 'news';
			$this->table = '[|PREFIX|]'.$tableSuffix;
			$this->tablePrefix = '[|PREFIX|]';
		}
		// }}}

	}

?>