<?php 
/**
 * File utilities
 * @author Miller Medeiros
 * @version 0.2 (2010/01/12)
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
	
}
?>