<?php

/**
 * Helper for converting array/object/iterable into a simple HTML table.
 * @author Miller Medeiros
 * @version 0.1 (2010/06/03)
 */
class HTMLTable {
	
	/**
	 * @var string	Properties that should be appended to the <table> opening tag (e.g. 'class="lorem" id="ipsum" style="border:1px solid red"' )
	 */
	public $properties;
	
	/**
	 * @var array	Array with all the column names (will go inside <thead>)
	 */
	public $cols_name;
	
	/**
	 * @var	array	Array with all the rows (will go inside <tbody> if table has <thead>)
	 */
	public $rows;
	
	/**
	 * @var array	Array with all the rows that should go inside <tfooter>
	 */
	public $footer;
	
	/**
	 * Creates new HTML table
	 * @param array $rows [optional]
	 * @param array $cols_name [optional]
	 * @param string $properties [optional]
	 */
	public function __construct($rows = NULL, $cols_name = NULL, $properties = NULL) {
		$this->rows = isset($rows)? $rows : array();
		$this->cols_name = $cols_name;
		$this->properties = $properties;
	}
	
	/**
	 * Add single row
	 * @param array $row
	 */
	public function addRow($row){
		array_push($this->rows, $row);
	}
	
	/**
	 * Add multiple rows
	 * @param array $rows
	 */
	public function addRows($rows){
		$this->rows = array_merge($this->rows, $rows);
	}
	
	/**
	 * outputs table 
	 */
	public function output(){
		$props = isset($this->properties)? ' '. $this->properties : '';
		$use_tbody = isset($this->cols_name) || isset($this->footer);
		
		echo '<table'. $props .'>';
		
		//cols name
		if(isset($this->cols_name)){
			echo '<thead>';
				echo '<tr>';
					foreach($this->cols_name as $cell){
						echo '<th>'. $cell . '</th>';
					}
				echo '</tr>';
			echo '</thead>';
		}
		
		//footer (should always come before tbody)
		if(isset($this->footer)){
			echo '<tfooter>';
				$this->outputRows($this->footer);
			echo '</tfooter>';
		}
		
			//content
			echo ($use_tbody)? '<tbody>' : ''; //goes inside <tbody> only if has <thead> or <tfooter>
				foreach($this->rows as $row){
					echo '<tr>';
						foreach($row as $cell){
							echo '<td>' . $cell . '</td>';
						}
					echo '</tr>';
				}
			echo ($use_tbody)? '</tbody>' : '';
			
		echo '</table>';
	}
	
}
?>