<?php 
/**
 * File utilities
 * @author Miller Medeiros
 * @version 0.3 (2010/02/15)
 */
class FileUtils {
	
	/**
	 * Constructor - Static Class
	 * @private
	 */
	private function __construct(){}
	
	/**
	 * Copy folder and files recursively. 
	 * - based on: http://www.visible-form.com/blog/copy-directory-in-php/
	 * @param string $source	Source file/folder path.
	 * @param string $dest	Destination file/folder path.
	 * @param bool $ignore_config_files [optional]	Ignore files and folder that starts with '.'.
	 * @return bool	True on success or False on failure. 
	 */
    public static function copyr($source, $dest, $ignore_config_files = TRUE) {
        
		// Simple copy for a file
        if(is_file($source) && (!$ignore_config_files || !preg_match('/^\./', $source))){
            $c = copy($source, $dest);
            return $c;
        }
        // Make destination directory
        if(!is_dir($dest)){
		    mkdir($dest);
        }
        // Loop through the folder
        $dir = dir($source);
        while(false !== $entry = $dir->read()){
            // Skip pointers and check if it should skip config files
            if($entry == '.' || $entry == '..' || ($ignore_config_files && preg_match('/^\./', $entry))){
                continue;
            }
            // Deep copy directories
			$source = preg_replace('/\/$/', '', $source);
			$dest = preg_replace('/\/$/', '', $dest);
            if($dest !== "$source/$entry"){
               FileUtils::copyr("$source/$entry", "$dest/$entry");
            }
        }
        // Clean up
        $dir->close();
        return true;
    }
	
	/**
	 * Force File Download
	 * - Should be called before any output and will stop any code execution.
	 * @param string	$file_path	Path to the file.
	 * @param bool	$block_php_files	If it should block the download of PHP files. 
	 * @param bool	$block_config_files	If it should block the download of configuration files (files starting with ".").
	 */
	public static function forceDownload($file_path, $block_php_files = TRUE, $block_config_files = TRUE){
		
		//block config files download (any file starting with ".")
		if($block_config_files && preg_match('/^\./', $file_path)){
			trigger_error("Download of config files isn't allowed.", E_USER_ERROR);
			return;
		}
		
		//block PHP files download
		if($block_php_files && preg_match('/\.php$/', $file_path)){
			trigger_error("Download of PHP files isn't allowed.", E_USER_ERROR);
			return;
		}
		
		//force download if file exist (based on PHP documentation: http://php.net/manual/en/function.readfile.php)
		if(file_exists($file_path)){
			
			$mime_type = self::getMimeType($file_path);
			$mime_type = ($mime_type)? $mime_type : 'application/octet-stream'; // sets default Mime-Type if Mime-Type is undefined
			
			$base_name = basename($file_path);
			$file_size = filesize($file_path);
			
		    header('Content-Description: File Transfer');
		    header("Content-Type: $mime_type");
		    header("Content-Disposition: attachment; filename= $base_name");
		    header('Content-Transfer-Encoding: binary');
		    header('Expires: 0');
		    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		    header('Pragma: public');
		    header("Content-Length: $file_size");
		    ob_clean();
		    flush();
		    readfile($file_path);
		    exit; //stop code execution
		}else{
			trigger_error("File not found.", E_USER_ERROR);
			return;
		}
	}
	
	/**
	 * Get File Mime-Type.
	 * @param string $file_path	Path to the file.
	 * @return string|bool Mime-Type or FALSE if can't detect the Myme-Type.
	 */
	public static function getMimeType($file_path){
		$output = '';
		
		/* == (PHP 5 >= 5.3.0, PECL fileinfo >= 0.1.0) == * /
		
		$finfo = finfo_open(FILEINFO_MIME);
		$output = finfo_file($finfo, $file_path);
		finfo_close($finfo);
		
		/* */
		
		
		/* == Custom built == */
		
		// Uncomplete list of Myme-Types copied from Wikipedia ( http://en.wikipedia.org/wiki/Internet_media_type )
		$myme_types = array(
			//application
			'exe' => 'application/octet-stream',
			'pdf' => 'application/pdf',
			'xhtml' => 'application/xhtml+xml',
			'zip' => 'application/zip',
			'ogg' => 'application/ogg',
			'mp4' => 'application/mp4',
			'js' => 'application/javascript',
			'rss' => 'application/rss+xml',
			'atom' => 'application/atom+xml',
			//audio
			'aac' => 'audio/aac',
			'mp3' => 'audio/mpeg',
			'oga' => 'audio/ogg',
			'wma' => 'audio/x-ms-wma',
			'wav' => 'audio/vnd.wave',
			//images
			'gif' => 'image/gif',
			'jpg' => 'image/jpeg',
			'jpeg' => 'image/jpeg',
			'png' => 'image/png',
			'svg' => 'image/svg+xml',
			'tif' => 'image/tiff',
			'tiff' => 'image/tiff',
			'ico' => 'image/vnd.microsoft.icon',
			//text
			'css' => 'text/css',
			'csv' => 'text/csv',
			'html' => 'text/html',
			'htm' => 'text/html',
			'txt' => 'text/plain',
			'xml' => 'text/xml',
			//video
			'mpg' => 'video/mpeg',
			'mpeg' => 'video/mpeg',
			'mov' => 'video/quicktime',
			//vnd
			'odt' => 'application/vnd.oasis.opendocument.text',
			'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
			'odp' => 'application/vnd.oasis.opendocument.presentation',
			'odg' => 'application/vnd.oasis.opendocument.graphics',
			'xls' => 'application/vnd.ms-excel',
			'xlsx' => 'application/vnd.ms-excel',
			'xlsm' => 'application/vnd.ms-excel',
			'ppt' => 'application/vnd.ms-powerpoint',
			'pptx' => 'application/vnd.ms-powerpoint',
			'pps' => 'application/vnd.ms-powerpoint',
			'ppsx' => 'application/vnd.ms-powerpoint',
			'doc' => 'application/msword',
			'docx' => 'application/msword',
			'xul' => 'application/vnd.mozilla.xul+xml',
			//x
			'rar' => 'application/x-rar-compressed',
			'tar' => 'application/x-tar'
		);
		
		preg_match('/[^\.]+$/', $file_path, $matches); //get file extension
		
		$file_extension = $matches[0];
		$output = (array_key_exists($file_extension, $myme_types))? $myme_types[$file_extension] : FALSE;
		
		/* */
		
		return $output;
	}
	
}
?>