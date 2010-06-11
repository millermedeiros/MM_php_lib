<?php

/**
 * Helper for simple HTML form field items
 * @author Miller Medeiros
 * @version 0.1 (2010/06/03)
 */
class HTMLForm {

	//static class
	private function __construct(){}
	
	/**
	 * Echo HTML <option>
	 * @param string $value	Value attr
	 * @param string $text	Text
	 * @param string $compare [optional]	Value when selected
	 */
	public static function outputOption($value, $text, $compare = NULL){
		echo '<option value="'. $value .'"';
		echo (isset($compare) && $value == $compare)? ' selected="selected"' : '';
		echo '>'. $text .'</option>';
	}
	
	/**
	 * Echo HTML <input type="checkbox" />
	 * @param string $name	Input name attribute
	 * @param bool $is_checked [optional] 
	 * @param string $value [optional] Defines the result of the input element when clicked
	 * @param string $attributes [optional]	Atributes to be appended inside the <input> tag (e.g. 'class="lorem" id="foo"')
	 * @return 
	 */
	public static function outputCheckBox($name, $is_checked = FALSE, $value = 'on', $attributes = NULL){
		if($is_checked){
			$attributes = isset($attributes)? $attributes .' checked="checked"' : 'checked="checked"';  
		}
		self::outputInput($name, 'checkbox', $value, $attributes);
	}
	
	/**
	 * Echo HTML <input />
	 * @param string $name	Input name attribute
	 * @param string $type [optional]	Input type
	 * @param string $value [optional]	Input value attribute (if $type == 'file' won't be used)
	 * @param string $attributes [optional]	Atributes to be appended inside the <input> tag (e.g. 'class="lorem" id="foo"')
	 */
	public static function outputInput($name, $type = 'text', $value = NULL, $attributes = NULL){
		echo '<input type="'. $type .'" name="'. $name .'"';
		echo isset($attributes)? ' '. $attributes : '';
		
		//checkbox and radio requires the value property
		if(($type == 'checkbox' || $type == 'radio') && !isset($value)){
			$value = '1';
		}
		
		echo (isset($value) && $type != 'file')? ' value="'. $value .'"' : ''; //type file cannot have value
		echo ' />';
	}
	
}
?>