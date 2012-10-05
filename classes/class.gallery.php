<?php 

// Define Gallery class
class Gallery {
	//= Propreties
	//////////////////////////////////////////////////////////////////////////////
	// Name that a user sees 
	public $friendly_name;

	// Immediate files under the gallery directory
	public $files = array();

	// All files under the gallery's category directory
	public $categories = array();

	//TODO
	//$category_files = array();

	//= Methods
	//////////////////////////////////////////////////////////////////////////////	
	public function __construct($gallery_name) {
		$this->friendly_name = $this->make_friendly($gallery_name);
	}

	public function make_friendly($name) {
		$name = str_replace('-', ' ', $name); //fix dash
		$name = str_replace('_', ' ', $name); //fix underscore
		$name = ucwords($name);

		return $name;
	}

	/* @param $filename {String} A filename that should match an equivalent filename directly under a gallery directory
	 * @return {Array} or {String}
	 */
	public function files($filename = null) {
		if (!empty($this->files)) {
			if ($filename) {
				// Return an immediate file reference from a gallery instance
				foreach ($this->files as $key => $file_path) {
					if (basename($file_path) == $filename) {
						return $file_path;
					}
				}
			} else {
				// Return array of all the files in a gallery
				return $this->files;
			}
		}
	}

	/* @param $category {String} A category name that should match an equivalent category under a gallery directory
	 * @return {Array} 
	 */
	public function categories($category = null) {
		if (!empty($this->categories)) {
			if ($category) {
				// Return a specific-category array
				return $this->categories[$category] ? $this->categories[$category] : 'Category does not exist!';
			} else {
				// Return array of category arrays
				return $this->categories;			
			}
		}
	}

	//TODO: It should allow to retrieve a specific file under a category from this Gallery instance
	public function category_files($category_name, $filename) {
		return; // NOT IMPLEMENTED
	}	
}