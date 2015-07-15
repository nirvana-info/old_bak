<?php

class file_cache {
	
	public $file_exist; //check whether the cache file exists or not
	var $file_dir; //which folder the cache file is in
	var $expire_time; //count as second, default is 24 hours
	var $file_name;
	var $file_extension;
	private $fhandle; //file handle
	
	function __construct($name)
	{
		$this->file_name = $name;
        $this->file_dir = $GLOBALS['ISC_CFG']["cache_file_folder"];
        $this->expire_time = $GLOBALS['ISC_CFG']["cache_file_expire_time"];
        $this->file_extension = 'php';
	}
	
	/* 
	 * input file name, extension and folder to check whether file exists or not
	 */
	function file_exist() {
		
		if(!isset($this->file_name) || !isset($this->file_extension) || !isset($this->file_dir))
		{
			return false;
		}
		
		$this->file_exist = file_exists($this->file_dir.'/'.$this->file_name.'.'.$this->file_extension);
		return $this->file_exist;
	}

	function save_cache($content)
	{		
		try
		{
			file_put_contents($this->file_dir.'/'.$this->file_name.'.'.$this->file_extension, $content);
		}
		catch (Exception $e)
		{
			//echo 'Message: '.$this->file_dir.'/'.$this->file_name.'.'.$this->file_extension.': '.$e->getMessage();
			return false;
		}
		
		return true;
	}
	
	function get_cache()
	{
		if(! $this->file_exist()){
			return false;
		}
		//check if cache expired
		try
		{
			if( isset($this->expire_time) && (strtotime("now") - filemtime($this->file_dir.'/'.$this->file_name.'.'.$this->file_extension) >= $this->expire_time ) )
			{
				throw new Exception('cache expired.');
			}
		}
		catch (Exception $e)
		{
			//echo 'Message: '.$this->file_dir.'/'.$this->file_name.'.'.$this->file_extension.': '.$e->getMessage();
			return false;
		}
		
		try 
		{
			return file_get_contents($this->file_dir.'/'.$this->file_name.'.'.$this->file_extension);
		}
		catch (Exception $e)
		{
			//echo 'Message: '.$this->file_dir.'/'.$this->file_name.'.'.$this->file_extension.': '.$e->getMessage();
			return false;
		}
	}
}

?>
