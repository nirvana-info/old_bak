<?php
class ISC_ADMIN_BACKUP
{

	public $Verbose = true;
	public $_DBProgress = 0;
	public $_DBTotalItems = 0;

	public $_ImageProgress = 0;
	public $_ImageTotalItems = 0;

	public $_ProductProgress = 0;
	public $_ProductTotalItems = 0;

	/**
	 * The constructor.
	 */
	public function __construct()
	{
		$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->LoadLangFile('backups');

		if(!gzte11(ISC_MEDIUMPRINT) || GetConfig('DisableBackupSettings')) {
			exit;
		}

		// If being run by cron, we don't want to show any output
		if(PHP_SAPI == "cli") {
			$this->Verbose = false;
		}
	}

	public function HandleToDo($Do)
	{
		switch (isc_strtolower($Do)) {
			case "createbackup": {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$GLOBALS["BreadcrumEntries"] = array(GetLang('Home') => "index.php", GetLang('Backups') => "index.php?ToDo=viewBackups", GetLang('CreateBackup') => "index.php?ToDo=createBackup");

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->CreateBackup();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
					die();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			}
			case "initbackup": {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$this->InitBackup();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			}
			case "cancelbackup": {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteBackup();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			}
			case "deletebackup": {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteBackup();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			}
			case "deletebackups": {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->DeleteBackups();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			}
			case "viewbackup": {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$this->ViewBackup();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			}
			case "createbackup2": {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$this->CreateBackup2();
					die();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
				break;
			}
			default: {
				if ($GLOBALS["ISC_CLASS_ADMIN_AUTH"]->HasPermission(AUTH_Manage_Backups)) {
					$GLOBALS["BreadcrumEntries"] = array(GetLang('Home') => "index.php", GetLang('Backups') => "index.php?ToDo=viewBackups");

					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$this->ManageBackups();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
				} else {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->DoHomePage(GetLang('Unauthorized'), MSG_ERROR);
				}
			}
		}
	}

	public function ManageBackups($MsgDesc = "", $MsgStatus = "")
	{
		if(isset($_GET['complete'])) {
			$MsgStatus = MSG_SUCCESS;
			if($_GET['complete'] == "remote") {
				$MsgDesc = GetLang('RemoteBackupComplete');
			} else {
				$MsgDesc = sprintf(GetLang('LocalBackupComplete'), $_GET['complete']);
			}
		}
		else if(isset($_GET['failed'])) {
			$MsgStatus = MSG_ERROR;
			if($_GET['failed'] == 'local') {
				$MsgDesc = GetLang('LocalBackupFailed');
			} else {
				$MsgDesc = GetLang('RemoteBackupFailed');
			}
		}

		if($MsgDesc != "") {
			$GLOBALS["Message"] = MessageBox($MsgDesc, $MsgStatus);
		}

		$dir = realpath(ISC_BACKUP_DIRECTORY);
		$dir = isc_substr($dir, isc_strpos($dir, realpath(ISC_BASE_PATH)));

		$backups = $this->_GetBackupList();
		$GLOBALS['BackupGrid'] = '';

		// Loop through all of the existing backups
		foreach($backups as $file => $details) {
			$GLOBALS['FileName'] = isc_html_escape($file);
			$GLOBALS['ModifiedTime'] = NiceTime($details['mtime']);
			if(isset($details['directory'])) {
				$GLOBALS['FileSize'] = "N/A";
				$GLOBALS['DownloadOpen'] = GetLang('OpenBackup');
				$GLOBALS['BackupImage'] = "backup_folder";
				$GLOBALS['BackupType'] = GetLang('BackupFolder');
				$GLOBALS['ViewLink'] = "backups/" . $GLOBALS['FileName'];
			}
			else {
				$GLOBALS['FileSize'] = NiceSize($details['size']);
				$GLOBALS['DownloadOpen'] = GetLang('DownloadBackup');
				$GLOBALS['BackupImage'] = "backup";
				$GLOBALS['BackupType'] = GetLang('BackupFile');
				$GLOBALS['ViewLink'] = "index.php?ToDo=viewBackup&file=" . $GLOBALS['FileName'];
			}

			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("backup.manage.row");
			$GLOBALS["BackupGrid"] .= $GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate(true);
		}

		if($GLOBALS['BackupGrid'] == "") {
			$GLOBALS['DisplayGrid'] = "none";

			$GLOBALS["Message"] = MessageBox(GetLang('NoBackups'), MSG_SUCCESS);
			$GLOBALS["DisableDelete"] = "DISABLED";
		}

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("backups.manage");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}

	public function DeleteBackup()
	{
		if(!isset($_GET['file'])) {
			$this->ManageBackups(GetLang('InvalidBackup'), MSG_ERROR);
		}
		else {
			$backupFile = str_replace("..", "", basename($_GET['file']));
			if(!file_exists(ISC_BACKUP_DIRECTORY . "/" . $backupFile)) {
				$this->ManageBackups(GetLang('InvalidBackup'), MSG_ERROR);
			}
			else {
				if(is_dir(ISC_BACKUP_DIRECTORY . "/" . $backupFile)) {
					$this->_DeleteBackupDirectory(ISC_BACKUP_DIRECTORY . "/" . $backupFile);
				}
				else {
					unlink(ISC_BACKUP_DIRECTORY . "/" . $backupFile);
				}
			}

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction();

			if($_GET['ToDo'] == "CancelBackup") {
				$this->ManageBackups(GetLang('BackupCancelled'), MSG_SUCCESS);
			}
			else {
				$this->ManageBackups(GetLang('BackupDeleted'), MSG_SUCCESS);
			}
		}
	}

	public function ViewBackup()
	{
		if(!isset($_GET['file'])) {

			$this->ManageBackups(GetLang('InvalidBackup'), MSG_ERROR);
		}
		else {
			$backupFile = str_replace("..", "", basename($_GET['file']));
			if(!file_exists(ISC_BACKUP_DIRECTORY . "/" . $backupFile)) {
				$this->ManageBackups(GetLang('InvalidBackup'), MSG_ERROR);
			}

			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($backupFile);

			// Backup browser!
			if(is_dir(ISC_BACKUP_DIRECTORY . "/" . $backupFile)) {
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintHeader();
					$GLOBALS['ISC_CLASS_ADMIN_ENGINE']->PrintFooter();
			}
			// One file backup, download it
			else {
				$size = filesize(ISC_BACKUP_DIRECTORY . $backupFile);
				ob_end_clean();

				header("Pragma: public");
				header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				header("Content-Type: application/force-download");
				header("Content-Type: application/octet-stream");
				header("Content-Type: application/download");
				header("Content-Disposition: attachment; filename=\"".$backupFile."\";");
				header("Content-Transfer-Encoding: binary");
				header("Content-Length: " . $size);

				// Spill the contents
				$fp = fopen(ISC_BACKUP_DIRECTORY . $backupFile, "rb");
				while(!feof($fp)) {
					echo fread($fp, 8192);
				}
				fclose($fp);
				exit;
			}
		}
	}

	public function DeleteBackups()
	{
		if(isset($_POST['backup'])) {
			foreach($_POST['backup'] as $backupFile) {
				$file = str_replace("..", "", basename($backupFile));
				if(is_dir(ISC_BACKUP_DIRECTORY . "/" . $backupFile)) {
					$this->_DeleteBackupDirectory(ISC_BACKUP_DIRECTORY . "/" . $backupFile);
				}
				else {
					@unlink(ISC_BACKUP_DIRECTORY . "/" . $backupFile);
				}
				// Log this action
				$GLOBALS['ISC_CLASS_LOG']->LogAdminAction(count($_POST['backup']));
			}

			$this->ManageBackups(GetLang('SelectedBackupsDeleted'), MSG_SUCCESS);
		}
		else {
			$this->ManageBackups();
		}
	}

	public function CreateBackup()
	{
		$tables = $this->_FetchTables();

		$GLOBALS['TableCount'] = count($tables);
		$GLOBALS['RowCount'] = number_format(array_sum($tables));
		$GLOBALS['MinRowCount'] = -1;
		$GLOBALS['MaxRowCount'] = 0;
		foreach($tables as $table => $size) {
			if($size > $GLOBALS['MaxRowCount']) {
				$GLOBALS['MaxRowCount'] = $size;
				$GLOBALS['MaxRowTable'] = $table;
			}
			if($size < $GLOBALS['MinRowCount'] || $GLOBALS['MinRowCount'] == -1) {
				$GLOBALS['MinRowCount'] = $size;
				$GLOBALS['MinRowTable'] = $table;
			}
		}

		$GLOBALS['MinRowCount'] = number_format($GLOBALS['MinRowCount']);
		$GLOBALS['MaxRowCount'] = number_format($GLOBALS['MaxRowCount']);

		$query = "SELECT COUNT(imageid) AS image_count FROM [|PREFIX|]product_images";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$GLOBALS['ImageCount'] = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		$GLOBALS['ImageCount'] = number_format($GLOBALS['ImageCount']['image_count']);
		if($GLOBALS['ImageCount'] == 0) {
			$GLOBALS['HideImageBackup'] = "none";
		}

		$query = "SELECT COUNT(downloadid) AS download_count FROM [|PREFIX|]product_downloads";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$GLOBALS['DigitalProductCount'] = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
		$GLOBALS['DigitalProductCount'] = number_format($GLOBALS['DigitalProductCount']['download_count']);
		if($GLOBALS['DigitalProductCount'] == 0) {
			$GLOBALS['HideProductBackup'] = "none";
		}

		if(GetConfig('BackupsLocal') != 1) {
			$GLOBALS['HideLocalMethod'] = "none";
			$GLOBALS['FTPChecked'] = "checked='checked'";
		}
		else {
			$GLOBALS['LocalChecked'] = "checked='checked'";
		}

		if(GetConfig('BackupsRemoteFTP') != 1) {
			$GLOBALS['HideFTPMethod'] = "none";
		} else {
			$GLOBALS['RemoteFTPHost'] = GetConfig('BackupsRemoteFTPUser') . "@" . GetConfig('BackupsRemoteFTPHost');
		}

		$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("backup.create");
		$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();
	}

	public function InitBackup()
	{
		$redirectURL = '';
		foreach($_GET as $k => $v) {
			if($k == "ToDo") {
				continue;
			}
			$redirectURL .= sprintf("&%s=%s", urlencode($k), urlencode($v));
		}
		echo sprintf('<script type="text/javascript">window.onload = function() { window.location = "index.php?ToDo=CreateBackup2%s"; }</script>', $redirectURL, $redirectURL);
		exit;
	}

	public function CreateBackup2()
	{
		@set_time_limit(0);
		@ini_set("zlib.output_compression", "Off");

		// Are we backing up only the DB? If so we don't need to create a directory
		if(isset($_REQUEST['backupdb']) && !isset($_REQUEST['backupimages']) && !isset($_REQUEST['backupdigitalproducts'])) {
			$DBBackupFile = 'backup-' . isc_date('Y-m-d-H-i-s') . '-' . isc_substr(md5(uniqid(rand(), true) . time()), 0, 20) . '.sql.gz';
			$MakeDirectory = false;
			$DirectoryName = '';
		}
		else {
			$DBBackupFile = 'database.sql.gz';
			$MakeDirectory = true;
			$DirectoryName = 'backup-' . isc_date('Y-m-d-H-i-s') . '-' . isc_substr(md5(uniqid(rand(), true) . time()), 0, 20);
		}

		if($this->Verbose != false) {
			// Log this action
			$GLOBALS['ISC_CLASS_LOG']->LogAdminAction($DBBackupFile);

			// Send the page now
			$GLOBALS['ISC_CLASS_TEMPLATE']->SetTemplate("pageheader.popup");
			$GLOBALS['ISC_CLASS_TEMPLATE']->ParseTemplate();

			$GLOBALS["ISC_CLASS_TEMPLATE"]->SetTemplate("backup.create2");
			$GLOBALS["ISC_CLASS_TEMPLATE"]->ParseTemplate();

			flush();
			ob_flush();
		}

		// We need to count out how many actual items we're backing up
		if(isset($_REQUEST['backupdb']) && $_REQUEST['backupdb'] == 1) {
			$this->_DBTotalItems = array_sum($this->_FetchTables());
		}

		if(isset($_REQUEST['backupimages']) && $_REQUEST['backupimages'] == 1) {
			$query = "SELECT COUNT(imageid) AS image_count FROM [|PREFIX|]product_images";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$imageCount = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$this->_ImageTotalItems = $imageCount['image_count'];
		}

		if(isset($_REQUEST['backupdigitalproducts']) && $_REQUEST['backupdigitalproducts'] == 1) {
			$query = "SELECT COUNT(productid) AS product_count FROM [|PREFIX|]products WHERE prodfile!=''";
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			$productCount = $GLOBALS['ISC_CLASS_DB']->Fetch($result);
			$this->_ProductTotalItems = $productCount['product_count'];
		}

		// Initialise the backup handler
		$error = 0;
		if($_REQUEST['backupmethod'] == "ftp") {
			$this->_handler = new ISC_ADMIN_BACKUP_FTP($error);
		}
		else {
			$this->_handler = new ISC_ADMIN_BACKUP_LOCAL($error);
		}

		@flush();
		@ob_flush();

		if($error > 0) {
			if($this->Verbose) {
				echo "<script type='text/javascript'>self.parent.location = 'index.php?ToDo=viewBackups&failed=1&type=" . $this->_handler->type . "</script>";
			}
			else {
				echo "Backup failed - " . $this->_handler->type;
			}

			exit;
		}

		if($MakeDirectory == true) {
			$this->_handler->CreateDirectory($DirectoryName);
			$BackupId = $DirectoryName;
			$DirectoryName .= "/";
		}
		else {
			$BackupId = $DBBackupFile;
		}

		// Run the database backup if we need to
		if(isset($_REQUEST['backupdb']) && $_REQUEST['backupdb'] == 1) {
			$error = '';
			$this->_CreateDBBackup($DirectoryName . $DBBackupFile, $error);
		}

		if(isset($_REQUEST['backupimages']) && $_REQUEST['backupimages'] == 1) {
			$this->_CreateImageBackup($DirectoryName);
		}

		if(isset($_REQUEST['backupdigitalproducts']) && $_REQUEST['backupdigitalproducts'] == 1) {
			$this->_CreateDigitalProductBackup($DirectoryName);
		}

		// We're done
		if($this->Verbose == true) {
			if($this->_handler->type == "remote") {
				$BackupId = 'remote';
			}
			$this->_UpdateProgress(GetLang('BackupStatusComplete'));
			echo "<script type='text/javascript'>\n";
			echo sprintf("self.parent.location = 'index.php?ToDo=viewBackups&complete=%s';\n", $BackupId);
			echo "</script>";
		}
	}

	public function _CreateDBBackup($file, &$error)
	{
		$time = isc_date('dS F Y \a\t H:i', time());
		$contents = sprintf("-- Database Backup\n-- Generated: %s\n-- -------------------------------------\n\n", $time);

		if(!function_exists('gzopen')) {
			$error = 'PHP is not compiled with ZLIB support';
			return false;
		}

		$progress = 0;

		$tables = $this->_FetchTables();

		foreach($tables as $table => $rowCount) {
			$this->_UpdateProgress(sprintf(GetLang('BackupStatusTable'), $table));

			$fields = $this->_FetchTableFields($table);
			$fields = implode("`,`", $fields);

			$contents .= "\n\n".$this->_ShowCreateTable($table).";\n\n";

			// Now fetch out all of the data
			$query = sprintf("SELECT * FROM %s", $table);
			$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while($row = $GLOBALS['ISC_CLASS_DB']->Fetch($Result)) {
				$values = '';
				foreach($row as $k => $v) {
					if(is_null($v)) {
						$values .= 'NULL,';
					}
					else {
						$values .= "'".$GLOBALS['ISC_CLASS_DB']->Quote($v)."',";
					}
				}
				$values = rtrim($values,",");
				$insert = sprintf("INSERT INTO %s (`%s`) VALUES (%s);\n", $table, $fields, $values);

				$contents .= $insert;

				if(isc_strlen($contents) > BACKUP_BUFFER_SIZE) {
					$this->_handler->WriteCompressedFile($file, $contents);
					$contents = '';
				}
			}
			if($this->Verbose) {
				$this->_DBProgress += $rowCount;
			}
		}

		// Write any remaining data
		$this->_handler->WriteCompressedFile($file, $contents);
		if($this->_handler->type == "remote") {
			$this->_UpdateProgress(GetLang('BackupStatusUploading'));
		}
		$this->_handler->CloseFile($file);
	}

	public function _CreateImageBackup($path)
	{
		if($this->_ImageTotalItems == 0) {
			return;
		}

		$this->_UpdateProgress(GetLang('BackupStatusImages'));

		// Create our nested directory
		$path .= "/product_images";
		$this->_handler->CreateDirectory($path);

		// Fetch all of the product images from the database
		$query = sprintf("SELECT imagefile FROM [|PREFIX|]product_images");
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($image = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			// And copy
			if(!$image['imagefile']) {
				continue;
			}
			$this->_handler->CopyFile(ISC_BASE_PATH."/".GetConfig('ImageDirectory')."/".$image['imagefile'], $path."/".$image['imagefile']);
			++$this->_ImageProgress;
			if($this->_ImageProgress % 100 == 0) {
				$this->_UpdateProgress(sprintf(GetLang('BackupStatusImageX'), $this->_ImageProgress, $this->_ImageTotalItems));
			}
		}
	}

	public function _CreateDigitalProductBackup($path)
	{
		if($this->_ProductTotalItems == 0) {
			return;
		}

		$this->_UpdateProgress(GetLang('BackupStatusDownloads'));

		// Create our nested directory
		$path .= "/product_downloads";
		$this->_handler->CreateDirectory($path);

		// Fetch all of the product downloads from the database
		$query = sprintf("SELECT downfile FROM [|PREFIX|]product_downloads");
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($download = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			// And copy
			if(!$download['downfile']) {
				continue;
			}
			$this->_handler->CopyFile(ISC_BASE_PATH."/".GetConfig('DownloadDirectory')."/".$download['downfile'], $path."/".$download['downfile']);
			++$this->_ProductProgress;
			if($this->_ProductProgress % 100 == 0) {
				$this->_UpdateProgress(sprintf(GetLang('BackupStatusDownload'), $this->_ProductProgress, $this->_ProductTotalItems));
			}
		}
	}

	public function _UpdateProgress($message = '')
	{
		if(!$this->Verbose) {
			return;
		}
		$total = $done = 0;
		if($this->_DBTotalItems != 0) {
			$total += $this->_DBTotalItems;
			$done += $this->_DBProgress;
		}

		if($this->_ImageTotalItems != 0) {
			$total += $this->_ImageTotalItems;
			$done += $this->_ImageProgress;
		}

		if($this->_ProductTotalItems != 0) {
			$total += $this->_ProductTotalItems;
			$done += $this->_ProductProgress;
		}

		$percentage = ceil($done/$total*100);
		echo sprintf("<script type=\"text/javascript\">updateProgress('%s', '%s');</script>\n", $percentage, $message);
		ob_flush();
		flush();
	}

	public function _FetchTables()
	{
		$tables = array();
		$prefix = $GLOBALS['ISC_CLASS_DB']->TablePrefix;
		$prefix = str_replace("_", '\_', $prefix);
		$query = "SHOW TABLE STATUS LIKE '".$prefix."%'";
		$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($table = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {
			$tables[$table['Name']] = $table['Rows'];
		}
		return $tables;
	}

	public function _FetchTableFields($table)
	{
		$fields = array();
		$query = sprintf("SHOW FIELDS FROM %s", $table);
		$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		while($field = $GLOBALS['ISC_CLASS_DB']->Fetch($Result)) {
			$fields[] = $field['Field'];
		}
		return $fields;
	}

	public function _ShowCreateTable($table)
	{
		$query = sprintf("SHOW CREATE TABLE %s", $table);
		$Result = $GLOBALS['ISC_CLASS_DB']->Query($query);
		$structure = $GLOBALS['ISC_CLASS_DB']->Fetch($Result);
		return $structure['Create Table'];
	}

	public function _GetBackupList()
	{
		$backups = array();

		if(!is_dir(ISC_BACKUP_DIRECTORY)) {
			@mkdir(ISC_BACKUP_DIRECTORY, 0777);
		}

		if(is_dir(ISC_BACKUP_DIRECTORY)) {
			$dh = opendir(ISC_BACKUP_DIRECTORY);
			if($dh) {
				while(($file = readdir($dh)) !== false) {
					if(isc_substr($file, 0, 6) == "backup") {
						$backups[$file] = array(
							"size" => filesize(ISC_BACKUP_DIRECTORY . $file),
							"mtime" => filemtime(ISC_BACKUP_DIRECTORY . $file)
						);
						if(!is_file(ISC_BACKUP_DIRECTORY . $file)) {
							$backups[$file]['directory'] = 1;
						}
					}
				}
			}
		}

		return $backups;
	}

	public function _DeleteBackupDirectory($directory)
	{
		if(!is_dir($directory)) {
			return false;
		}

		$directories = array($directory);
		while($dir = array_pop($directories)) {
			if(@rmdir($dir)) {
				continue;
			}
			$directories[] = $dir;
			$dh = opendir($dir);
			while(($file = readdir($dh)) !== false) {
				if($file == "." || $file == "..") {
					continue;
				}
				$file = $dir . "/" . $file;
				if(is_dir($file)) {
					$directories[] = $file;
				} else {
					unlink($file);
				}
			}
		}
	}
}

class ISC_ADMIN_BACKUP_LOCAL
{
	public $_open_files = array();
	public $_open_gz_files = array();
	public $type = "local";

	public function __construct(&$error)
	{
		$error = 0;
		$this->pwd = ISC_BACKUP_DIRECTORY;
	}

	public function CreateDirectory($directory)
	{
		return mkdir($this->pwd . "/" . $directory, 0777);
	}

	public function WriteFile($filename, $contents)
	{
		// File is not open, open it
		if(!isset($this->_open_files[$filename])) {
			$this->_open_files[$filename] = @fopen($this->pwd . "/" . $filename, "wb");
			if(!$this->_open_files[$filename]) {
				return false;
			}
		}
		fwrite($this->_open_files[$filename], $contents);
	}

	public function WriteCompressedFile($filename, $contents)
	{
		// File is not open, open it
		if(!isset($this->_open_files[$filename])) {
			$this->_open_files[$filename] = gzopen($this->pwd . "/" . $filename, "w9");
			if(!$this->_open_files[$filename]) {
				return false;
			}
			$this->_open_gz_files[$filename] = 1;
		}
		gzwrite($this->_open_files[$filename], $contents);
	}

	public function CloseFile($filename)
	{
		if(isset($this->_open_gz_files[$filename])) {
			gzclose($this->_open_files[$filename]);
			unset($this->_open_gz_files[$filename]);
		}
		else {
			fclose($this->_open_files[$filename]);
		}
		unset($this->_open_files[$filename]);
	}

	public function CopyFile($source_file, $destination_file)
	{
		// Does the target directory not exist?
		if(!is_dir($this->pwd."/".dirname($destination_file))) {
			$this->CreateDirectory(dirname($destination_file));
		}

		return @copy($source_file, $this->pwd . "/" . $destination_file);
	}

}

class ISC_ADMIN_BACKUP_FTP
{
	public $_connection;
	public $_local;
	public $type = "remote";

	public function __construct(&$error)
	{
		// Connect to our FTP server
		define("BACKUP_FTP_ERR_CONNECT", 1);
		define("BACKUP_FTP_ERR_LOGIN", 2);
		define("BACKUP_FTP_ERR_PATH", 3);

		if(!function_exists('ftp_connect')) {
			return false;
		}

		@list($host, $port) = @explode(":", GetConfig('BackupsRemoteFTPHost'));

		if(!$host) {
			return false;
		}

		if(!$port) {
			$port = 21;
		}

		$this->_connection = ftp_connect($host, $port, 10);
		if(!$this->_connection) {
			$error = BACKUP_FTP_ERR_CONNECT;
			return false;
		}

		if(!@ftp_login($this->_connection, GetConfig('BackupsRemoteFTPUser'), GetConfig('BackupsRemoteFTPPass'))) {
			$error = BACKUP_FTP_ERR_LOGIN;
			return false;
		}

		@ftp_pasv($this->_connection, true);

		if(GetConfig('BackupsRemoteFTPPath') && !@ftp_chdir($this->_connection, GetConfig('BackupsRemoteFTPPath'))) {
			$error = BACKUP_FTP_ERR_PATH;
			return false;
		}

		$this->_local = new ISC_ADMIN_BACKUP_LOCAL($error);

		// We write any data for the FTP backups to te local temp directory first, then move them
		if(!empty($_ENV['TMP'])) {
			$tmp_dir = $_ENV['TMP'];
		}
		else if(!empty($_ENV['TMPDIR'])) {
			$tmp_dir = $_ENV['TMPDIR'];
		}
		else if(!empty($_ENV['TEMP'])) {
			$tmp_dir = $_ENV['TEMP'];
		}
		else {
			$tmp_dir = dirname(tempnam('', 'tmp'));
		}
		$this->_local->pwd = $tmp_dir . "/";

		// In and connected
		$error = 0;
	}

	public function CreateDirectory($directory)
	{
		return @ftp_mkdir($this->_connection, $directory);
	}

	public function WriteFile($filename, $contents)
	{
		// Pass out the writing to the local handler - we push the changes to the FTP server when we close the file
		$this->_local->WriteFile(basename($filename).".ftp-tmp", $contents);
	}

	public function WriteCompressedFile($filename, $contents)
	{
		// Pass out the writing to the local handler - we push the changes to the FTP server when we close the file
		$this->_local->WriteCompressedFile(basename($filename).".ftp-tmp", $contents);
	}

	public function CloseFile($filename)
	{
		$this->_local->CloseFile(basename($filename).".ftp-tmp");

		// Now we actual perform the ftp_put to move our temporar file
		$success = $this->CopyFile($this->_local->pwd . "/" . basename($filename).".ftp-tmp", $filename);

		// Remove temporar file
		@unlink($this->_local->pwd . "/". basename($filename).".ftp-tmp");

		return $success;
	}

	public function CopyFile($source_file, $destination_file)
	{
		// Does the target directory not exist?
		if(dirname($destination_file) != '') {
			$this->CreateDirectory(dirname($destination_file));
		}
		return @ftp_put($this->_connection, $destination_file, $source_file, FTP_BINARY);
	}

	public function __destruct()
	{
		if(is_resource($this->_connection)) {
			@ftp_close($this->_connection);
		}
	}
}
?>
