<?php

/**
 * Helper Class to load (include) external files [static class]
 * @author Miller Medeiros
 * @version 0.8.0 (2011/10/19)
 */
class Loader {

    private function __construct() {}


    /**
     * Load external file and assign variables
     * @param string $file_path Path to the desired file
     * @param array $data [optional]    Array or Object with data that should be passed to the loaded file [ex: $data = array('foo' => 'lorem', 'bar' => 'ipsum')]
     */
    public static function load($file_path, $data = NULL){
        if(isset($data)){
            foreach($data as $key=>$value){
                $$key = $value; //set variables inside this method scope (same scope as the included file)
            }
        }
        include $file_path;
    }

    /**
     * Load Simple Template File
     * - replace variables wrapped in '{{}}' with the $data item with same key or
     * global variable.
     * - if you need loops and conditionals just use regular PHP and set '$execute_php' to TRUE
     * (default behavior).
     * - useful since `<?= ?>` can be disabled if `short_open_tag` is disabled (PHP < 5.4)
     * @param string $file_path Path to the desired file
     * @param array $data [optional]    Array or Object with data that should be passed to the loaded file [ex: $data = array('foo' => 'lorem', 'bar' => 'ipsum')]
     * @param bool  $execute_php [optional] If PHP code inside template should be executed.
     * @param bool  $escape_html [optional] If strings should be html escaped.
     */
    public static function loadTemplate($file_path, $data = NULL, $execute_php = TRUE, $escape_html = TRUE){
        if($execute_php){
            ob_start();
            self::load($file_path, $data);
            $output = ob_get_clean();
        }else{
            $output = file_get_contents($file_path);
        }

        $n_matches = preg_match_all('/\{\{([\-\_\w\d]+)\}\}/', $output, $keys);
        $data = (array) $data; //expect data to be an array for replacements
        $val;

        if($n_matches){
            foreach($keys[1] as $key){
                if( isset($data[$key]) && ( is_string($data[$key]) || is_numeric($data[$key]) ) ){
                    $val = $data[$key];
                } else if ( isset($$key) && ( is_string($$key) || is_numeric($$key) ) ) {
                    $val = $$key;
                } else if ( @constant($key) ) {
                    $val = constant($key);
                } else {
                    $val = '';
                }
                if($escape_html){
                    $val = htmlspecialchars($val);
                }
                $output = preg_replace("/\{\{$key\}\}/", $val, $output);
            }
        }

        echo $output;
    }

}
?>
