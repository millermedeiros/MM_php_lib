<?php

require_once 'SuperglobalsHelper.php';

/**
 * Helper Class for form validation (just abstraction of a form, no visual/markup code)
 * - wasn't properly tested and/or finished yet
 * @author Miller Medeiros
 * @version 0.3 (2010/06/05)
 */
class Form {
	
	//TODO: improve way validation works (maybe create a validation class with constants)
	//TODO: add option to return all fields that has errors and also error types
	//TODO: add option to process data before returning value (eg: trim)
	
	/**
	 * @var	bool	If Form was submitted 
	 */
	public $is_submitted = FALSE;
	
	/**
	 * @var array	Fields of the form (array of stdClass)
	 */
	protected $fields;
	
	/**
	 * @var string	HTTP Request Method
	 */
	protected $http_method;
	
	/**
	 * Construct a new form field
	 * @param bool $is_submitted	If form was submitted
	 * @param string $http_method [optional]	'get' or 'post'
	 */
	function __construct($is_submitted, $http_method = 'post') {
		$this->is_submitted = $is_submitted;
		$this->fields = array();
		$this->http_method = $http_method;
	}
	
	/**
	 * Create and Register a new field into the Form
	 * @param string $field_name	Field name (should match the html name property)
	 * @param bool $is_required [optional]	If field is required
	 * @param string $default_value [optional]	Default field value
	 * @param array $ignore_values [optional]	Values that should be not be counted when checking if field was filled. (case-sensitive)
	 * @param string $validation_pattern [optional]	PEARL style RegExp
	 * @return 
	 */
	public function createField($field_name, $is_required = FALSE, $default_value = NULL, $ignore_values = NULL, $validation_pattern = NULL){
		$field = new stdClass();
		$field->name = $field_name;
		$field->default_value = $default_value;
		$field->is_required = $is_required;
		$field->ignore_values = $ignore_values;
		$field->validation_pattern = $validation_pattern;
		$this->fields[$field_name] = $field;
	}

	
	/**
	 * Retrieves field value
	 * - Will return field default value if not submitted.
	 * @param string $field_name
	 * @return string	Field value
	 */
	public function getValue($field_name){
		if($this->is_submitted){
			return $this->getSubmittedValue($field_name);
		}else{
			return $this->fields[$field_name]->default_value;
		}
	}
	
	/**
	 * Retrieves field submitted value.
	 * @param string $field_name
	 * @return string	Submitted value or NULL if form wasn't submitted or value not found.
	 */
	public function getSubmittedValue($field_name){
		if(! $this->is_submitted){
			return NULL;
		}
		$request = ($this->http_method == 'post')? SuperglobalsHelper::post($field_name) : SuperglobalsHelper::get($field_name);
		return ($request)? $request : NULL;
	}
	
	/**
	 * Retrieves all form data (calls getValue for all fields) 
	 * @return stdClass	$key = $field->name | $value = getValue($field->name)
	 */
	public function getFormData(){
		$form_data = new stdClass();
		foreach($this->fields as $field){
			$name = $field->name;
			$form_data->$name = $this->getValue($field->name);
		}
		return $form_data;
	}
	
	/**
	 * Check if field is valid
	 * - always return true if form wasn't submitted yet
	 * @param string $field_name
	 * @return bool
	 */
	public function checkField($field_name){
		if(! $this->is_submitted){
			return TRUE;
		}
		
		$field = $this->fields[$field_name];
		$value = $this->getSubmittedValue($field_name);
		if($field->is_required && ( !isset($value) || ( isset($field->ignore_values) && in_array($value, $field->ignore_values) ) )){
			//echo "$field_name is required."; //used for debug
			return FALSE;
		}
		if(isset($field->validation_pattern)){
			//echo (preg_match($field->validation_pattern, $value))? '' : "$field_name isn't valid."; //used for debug
			return (bool) preg_match($field->validation_pattern, $value);
		}
		return TRUE;
	}
	
	/**
	 * Check if whole form is valid
	 * - will return false if any field isn't valid (stop check at first error)
	 * @return bool
	 */
	public function checkForm(){
		if(! $this->is_submitted){
			return TRUE;
		}
		
		foreach($this->fields as $field){
			if(! $this->checkField($field->name)){
				return FALSE;
			}
		}
		return TRUE;
	}
	
}

?>