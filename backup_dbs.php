<?php

error_reporting( E_ALL );

// Load file path
if (DIRECTORY_SEPARATOR=='/'){
  $path = dirname(__FILE__).'/';
}else{
	$path = str_replace('\\', '/', dirname(__FILE__)).'/';
	}

date_default_timezone_set('Asia/Colombo');
$dt2 = date('Y-m-d');
$dt1 = date('Y-m-d_H:i:s');
$ip = $_SERVER['REMOTE_ADDR'];

// Initialize default settings
$MYSQL_PATH = '/usr/bin';
//$MYSQL_PATH = 'D:\xampp\mysql\bin';
$MYSQL_HOST = 'localhost';
$MYSQL_USER = 'northpon_usr';
$MYSQL_PASSWD = 'w~&b=02A}?Pk';
$MYSQL_DB = 'northpony_eib';
$BACKUP_DEST = $path.'db_backups';
$BACKUP_TEMP = $path.'tmp/backup_temp';
$BACKUP_LOG = $path.'log';
$VERBOSE = true;
$BACKUP_NAME = 'VPS_backup_' . $dt2;
$LOG_FILE = $BACKUP_NAME . '.log';
$ERR_FILE = $BACKUP_NAME . '.err';
$COMPRESSOR = 'bzip2';
//$COMPRESSOR = 'zip';
$EMAIL_BACKUP = false;
$DEL_AFTER = false;
$EMAIL_FROM = 'Backup Script';
$EMAIL_SUBJECT = 'SQL Backup for ' . date('Y-m-d') . ' at ' . date('H:i');
$EMAIL_ADDR = 'geethupendra@gmail.com';
$ERROR_EMAIL = 'geethupendra@gmail.com';
$ERROR_SUBJECT = 'ERROR: ' . $EMAIL_SUBJECT;
$EXCLUDE_DB = 'northpon_pcil, northpony_micro, northpony_mygrade_tmp, northpony_mygrade_tmp, information_schema';
$MAX_EXECUTION_TIME = 18000;
$USE_NICE = 'nice -n 19';
$FLUSH = false;
$OPTIMIZE = false;

//CHK THE IP
//if($ip == '50.116.9.254' || $ip == '74.207.250.230' || $ip == '173.255.210.98' || $ip == '173.237.189.192' || $ip == '45.33.48.85' || $ip == '174.136.29.112' || $ip == '188.166.172.238' || $ip == '104.236.19.221' || $ip == '139.59.251.210' || $ip == '159.203.13.156' || $ip == '188.166.164.125' || $ip == '178.62.217.102' || $ip == '159.203.208.188' || $ip == '138.197.13.215' || $ip == '138.197.3.1' || $ip == '192.241.167.220' || $ip == '192.81.211.213' || $ip == '192.241.128.56' || $ip == '45.56.80.102' || $ip == '45.33.32.18' || $ip == '45.33.56.14' || $ip == '45.33.26.30' || $ip == '97.107.135.107'){

// Load configuration file
$current_path = dirname(__FILE__);
if( file_exists( $current_path.'/backup_dbs_config.php' ) ) {
	require( $current_path.'/backup_dbs_config.php' );
} else {
	echo 'No configuration file [backup_dbs_config.php] found. Please check your installation.';
	exit;
}



################################
# functions
################################
/**
 * Write normal/error log to a file and output if $VERBOSE is active
 * @param string	$msg
 * @param boolean	$error
 */
function writeLog( $msg, $error = false ) {

	// add current time and linebreak to message
	$fileMsg = date( 'Y-m-d H:i:s: ') . trim($msg) . "\n";

	// switch between normal or error log
	$log = ($error) ? $GLOBALS['f_err'] : $GLOBALS['f_log'];

	if ( !empty( $log ) ) {
		// write message to log
		fwrite($log, $fileMsg);
	}

	if ( $GLOBALS['VERBOSE'] ) {
		// output to screen
		echo $msg . "\n";
		flush();
	}
} // function

/**
 * Checks the $error and writes output to normal and error log.
 * If critical flag is set, execution will be terminated immediately
 * on error.
 * @param boolean	$error
 * @param string	$msg
 * @param boolean	$critical
 */
function error( $error, $msg, $critical = false ) {

	if ( $error ) {
		// write error to both log files
		writeLog( $msg );
		writeLog( $msg, true );

		// terminate script if this error is critical
		if ( $critical ) {
			die( $msg );
		}

		$GLOBALS['error']	= true;
	}
} // function



################################
# main
################################

// set header to text/plain in order to see result correctly in a browser
header( 'Content-Type: text/plain; charset="UTF-8"' );
header( 'Content-disposition: inline' );

// set execution time limit
if( ini_get( 'max_execution_time' ) < $MAX_EXECUTION_TIME ) {
	set_time_limit( $MAX_EXECUTION_TIME );
}

// initialize error control
$error = false;

// guess and set host operating system
if( strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN' ) {
	$os			= 'unix';
	$backup_mime	= 'application/x-tar';
	$BACKUP_NAME	.= '.tar';
} else {
	$os			= 'windows';
	$backup_mime	= 'application/zip';
	$BACKUP_NAME	.= '.zip';
}


// create directories if they do not exist
if( !is_dir( $BACKUP_DEST ) ) {
	$success = mkdir( $BACKUP_DEST );
	error( !$success, 'Backup directory could not be created in ' . $BACKUP_DEST, true );
}
if( !is_dir( $BACKUP_TEMP ) ) {
	$success = mkdir( $BACKUP_TEMP );
	error( !$success, 'Backup temp directory could not be created in ' . $BACKUP_TEMP, true );
}

// prepare standard log file
$log_path = $BACKUP_LOG . '/' . $LOG_FILE;
($f_log = fopen($log_path, 'w')) || error( true, 'Cannot create log file: ' . $log_path, true );

// prepare error log file
$err_path = $BACKUP_LOG . '/' . $ERR_FILE;
($f_err = fopen($err_path, 'w')) || error( true, 'Cannot create error log file: ' . $err_path, true );

// Start logging
writeLog( "GDC Executing MySQL Backup Script v1.4" );
writeLog( "Processing Databases.." );

echo "\n";

################################
# DB dumps
################################
$excludes	= array();
if( trim($EXCLUDE_DB) != '' ) {
	$excludes	= array_map( 'trim', explode( ',', $EXCLUDE_DB ) );
}

// Loop through databases
//$db_conn	= @mysql_connect( $MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWD ) or error( true, mysql_error(), true );
$db_conn	= mysqli_connect( $MYSQL_HOST, $MYSQL_USER, $MYSQL_PASSWD ) or error( true, mysqli_error($db_conn), true );
//$db_result = mysql_query("SHOW DATABASES");
$db_result = mysqli_query($db_conn, "SHOW DATABASES");
$db_auth	= " --host=\"$MYSQL_HOST\" --user=\"$MYSQL_USER\" --password=\"$MYSQL_PASSWD\"";
while ($db_row = mysqli_fetch_assoc($db_result)) {
//while ($db_row = mysql_fetch_object($db_result)) {
	//$db = $db_row->Database;
	$db = $db_row['Database'];

	if( in_array( $db, $excludes ) ) {
		// excluded DB, go to next one
		continue;
	}

	// dump db
	unset( $output );
	exec( "$MYSQL_PATH/mysqldump $db_auth --opt $db 2>&1 >$BACKUP_TEMP/$db.sql", $output, $res);
	if( $res > 0 ) {
		error( true, "DUMP FAILED\n".implode( "\n", $output) );
	} else {
		writeLog( "Dumped DB: " . $db );

		if( $OPTIMIZE ) {
			unset( $output );
			exec( "$MYSQL_PATH/mysqlcheck $db_auth --optimize $db 2>&1", $output, $res);
			if( $res > 0 ) {
				error( true, "OPTIMIZATION FAILED\n".implode( "\n", $output) );
			} else {
				writeLog( "Optimized DB: " . $db );
			}
		} // if
	} // if

	// compress db
	unset( $output );
	if( $os == 'unix' ) {
		exec( "$USE_NICE $COMPRESSOR $BACKUP_TEMP/$db.sql 2>&1" , $output, $res );
	} else {
		exec( "zip -mj $BACKUP_TEMP/$db.sql.zip $BACKUP_TEMP/$db.sql 2>&1" , $output, $res );
	}
	if( $res > 0 ) {
		error( true, "COMPRESSION FAILED\n".implode( "\n", $output) );
	} else {
		writeLog( "Compressed DB: " . $db );
	}

	if( $FLUSH ) {
		unset( $output );
		exec("$MYSQL_PATH/mysqladmin $db_auth flush-tables 2>&1", $output, $res );
		if( $res > 0 ) {
			error( true, "Flushing tables failed\n".implode( "\n", $output) );
		} else {
			writeLog( "Flushed Tables" );
		}
	} // if

} // while

mysqli_free_result($db_result);
mysqli_close($db_conn);


################################
# Archiving
################################

// TAR the files
echo "\n";
writeLog( "Archiving files.. " );
chdir( $BACKUP_TEMP );
unset( $output );
if( $os	== 'unix' ) {
	exec("cd $BACKUP_TEMP ; $USE_NICE tar cf $BACKUP_DEST/$BACKUP_NAME * 2>&1", $output, $res);
} else {
	exec("zip -j -0 $BACKUP_DEST/$BACKUP_NAME * 2>&1", $output, $res);
}
if ( $res > 0 ) {
	error( true, "FAILED\n".implode( "\n", $output) );
} else {
	writeLog( "Backup complete!" );	
	echo "\n";
}

// first error check, so we can add a message to the backup email in case of error
if ( $error ) {
	$msg	= "\n*** ERRORS DETECTED! ***";
	if( $ERROR_EMAIL ) {
		$msg	.= "\nCheck your email account $ERROR_EMAIL for more information!\n\n";
	} else {
		$msg	.= "\nCheck the error log {$err_path} for more information!\n\n";
	}

	writeLog( $msg );
}
"\n";

################################
# post processing
################################

// do we email the backup file?
if ($EMAIL_BACKUP) {
	writeLog( "Emailing backup to " . $EMAIL_ADDR . " .. " );

	$headers = "From: " . $EMAIL_FROM . " <root@localhost>";
	// Generate a boundary string
	$rnd_str = md5(time());
	$mime_boundary = "==Multipart_Boundary_x{$rnd_str}x";

	// Add headers for file attachment
	$headers .= "\nMIME-Version: 1.0\n" .
		"Content-Type: multipart/mixed;\n" .
		" boundary=\"{$mime_boundary}\"";

	// Add a multipart boundary above the plain message
	$body = "This is a multi-part message in MIME format.\n\n" .
		"--{$mime_boundary}\n" .
		"Content-Type: text/plain; charset=\"iso-8859-1\"\n" .
		"Content-Transfer-Encoding: 7bit\n\n" .
		file_get_contents($log_path) . "\n\n";

	// make Base64 encoding for file data
	$data = chunk_split(base64_encode(file_get_contents($BACKUP_DEST.'/'.$BACKUP_NAME)));

	// Add file attachment to the message
	$body .= "--{$mime_boundary}\n" .
		"Content-Type: {$backup_mime};\n" .
		" name=\"{$BACKUP_NAME}\"\n" .
		"Content-Disposition: attachment;\n" .
		" filename=\"{$BACKUP_NAME}\"\n" .
		"Content-Transfer-Encoding: base64\n\n" .
		$data . "\n\n" .
		"--{$mime_boundary}--\n";

	$res = mail( $EMAIL_ADDR, $EMAIL_SUBJECT, $body, $headers );
	if ( !$res ) {
		error( true, 'FAILED to email mysql dumps.' );
	}
}


// do we delete the backup file?
if ( $DEL_AFTER && $EMAIL_BACKUP ) {
	writeLog( "Deleting file.. " );

	if ( file_exists( $BACKUP_DEST.'/'.$BACKUP_NAME ) ) {
		$success = unlink( $BACKUP_DEST.'/'.$BACKUP_NAME );
		error( !$success, "FAILED\nUnable to delete backup file" );
	}
}

// see if there were any errors to email
if ( ($ERROR_EMAIL) && ($error) ) {
	writeLog( "\nThere were errors!" );
	writeLog( "Emailing error log to " . $ERROR_EMAIL . " .. " );

	$headers = "From: " . $EMAIL_FROM . " <root@localhost>";
	$headers .= "MIME-Version: 1.0\n";
	$headers .= "Content-Type: text/plain; charset=\"iso-8859-1\";\n";
	$body = "\n".file_get_contents($err_path)."\n";

	$res = mail( $ERROR_EMAIL, $ERROR_SUBJECT, $body, $headers );
	if( !$res ) {
		error( true, 'FAILED to email error log.' );
	}
}


################################
## Database for backups
################################

//Date & time 
date_default_timezone_set('Asia/Colombo');
$dful = date( 'Y-m-d H:i:s' );
$dn = date('Y-m-d');

//user ID details
$usn = @$_GET['fuid'];
//$id = mysql_real_escape_string($usn);
$id = 'auto';

//Key Details
$fl_loc = $BACKUP_NAME;
$ip = $_SERVER['REMOTE_ADDR'];
if($usn == ""){ 
	$bk_m = "0"; } else { 
		$bk_m = "1";}
		
//MYSQL
//$t = mysql_query("SELECT version() AS ve");
//echo mysql_error();
//$r = mysql_fetch_object($t);
//$dt_msql = substr($r->ve,0,6);


//MYsql database size
$db_server = 'localhost'; 
$db_user = 'northpon_usr';
$db_pwd = 'w~&b=02A}?Pk';
$db_name = 'northpony_eib';
$db_link = @mysql_connect($db_server, $db_user, $db_pwd) 
 or exit('Could not connect: ' . mysql_error()); 
$db = @mysql_select_db($db_name, $db_link) 
 or exit('Could not find the database: ' . mysql_error()); 

// Calculate DB size by adding table size + index size: 
$rows = mysql_query("SHOW TABLE STATUS"); 
$dbsize = 0; 
while ($row = mysql_fetch_array($rows)) { 
 $dbsize += $row["Data_length"] + $row["Index_length"];
}

$db_s = $dbsize;
$fl_s = filesize($BACKUP_DEST.'/'.$BACKUP_NAME);

//MYSQL VERSON ENABLE ONLY IN SERVER
$r = mysql_get_server_info($db_link);
$dt_msql = substr($r,0,6);


$sql1 = "INSERT INTO `bakup_data`(bk_date, ip_add, bk_methd, bk_location, bk_size, db_size, bk_mysql, createby, createdate) 
		                   VALUES('$dn','$ip','$bk_m','$fl_loc','$fl_s','$db_s','$dt_msql','$id','$dful')";


if(mysql_query($sql1)){
	echo "success"."\n";
	echo $BACKUP_NAME;
	} else {
		echo "error"."\n";
		}

//---------------------
function byteFormat($bytes, $unit = "", $decimals = 2) {
  $units = array('B' => 0, 'KB' => 1, 'MB' => 2, 'GB' => 3, 'TB' => 4, 
		  'PB' => 5, 'EB' => 6, 'ZB' => 7, 'YB' => 8);

  $value = 0;
  if ($bytes > 0) {
	  if (!array_key_exists($unit, $units)) {
		  $pow = floor(log($bytes)/log(1024));
		  $unit = array_search($pow, $units);
	  }
	  $value = ($bytes/pow(1024,floor($units[$unit])));
  }

  if (!is_numeric($decimals) || $decimals < 0) {
	  $decimals = 2;
  }
  return sprintf('%.' . $decimals . 'f '.$unit, $value);
}

$fmail = 'MIME-Version: 1.0' . "\r\n";
$fmail .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
$fmail .= 'From:VPS - System Bakup : '.$dt2.' <bo@northpony.com>';

//$message = $_REQUEST["message"];
$sender =  "backup@northpony.com";
$mailadd = "geethupendra@gmail.com";

$message = "
<p>Dear Admin,</p>
<p>Your backup successfully completed.<br />
<p>Backup Name : ".$BACKUP_NAME."<br />
Backup Time : ".$dt1."<br />
Backup Size : ".byteFormat($fl_s, "MB")."<br />
Database Size : ".byteFormat($db_s, "MB")."<br /></p>

<p><em><strong>GDC Executing MySQL Backup @ GDCreations - ".$dt2."</em></p>";

$full_message =  $message;
			   
$message = $full_message;
$message = stripslashes($message); 
$sender = stripslashes($sender);
$subject = "Backup Notification - VPS";

mail($mailadd, $subject, $message, $fmail);
echo "\n\n";
echo "Mail Sent to ".$mailadd."\n----------------------------------------- \n";

//---------------------

################################
# cleanup / mr proper
################################

// close log files
fclose($f_log);
fclose($f_err);

// if error log is empty, delete it
if( !$error ) {
	unlink( $err_path );
}

// delete the log files if they have been emailed (and del_after is on)
if ( $DEL_AFTER && $EMAIL_BACKUP ) {
        if ( file_exists( $log_path ) ) {
                $success = unlink( $log_path );
                error( !$success, "FAILED\nUnable to delete log file: ".$log_path );
        }
        if ( file_exists( $err_path ) ) {
                $success = unlink( $err_path );
                error( !$success, "FAILED\nUnable to delete error log file: ".$err_path );
        }
}

// remove files in temp dir
if ($dir = @opendir($BACKUP_TEMP)) {
	while (($file = readdir($dir)) !== false) {
		if (!is_dir($file)) {
			unlink($BACKUP_TEMP.'/'.$file);
		}
	}
}
closedir($dir);

// remove temp dir
rmdir($BACKUP_TEMP);
echo "\n";

//}

// START 2 WEEKS AGO FOLDER DELETE
$date = date_create($dt2);
date_sub($date, date_interval_create_from_date_string("21 days"));
$tWeeks = date_format($date, "Y-m-d");

// guess and set host operating system
if (strtoupper(substr(PHP_OS, 0, 3)) !== 'WIN') {
    $os = 'unix';
    $backup_mime = 'application/x-tar';
    $deleNm = '.tar';
} else {
    $os = 'windows';
    $backup_mime = 'application/zip';
    $deleNm = '.zip';
}

$file = $BACKUP_DEST . '/VPS_backup_' . $tWeeks . $deleNm;
//echo $file;
// last day of last month
$month_end = new DateTime("last day of last month");
$lmld = $month_end->format('Y-m-d');

//echo  ' * ' . $lmld. ' * ' .$tWeeks;
if ($lmld != $tWeeks) {
    if (is_file($file))
        $success = unlink($file); // delete file
    error(!$success, "FAILED\nUnable to delete backup file");
}
// END 2 WEEKS AGO FOLDER DELETE

?>