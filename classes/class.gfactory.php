<?php 

// Define GFactory class
class GFactory {
	//= Propreties
	//////////////////////////////////////////////////////////////////////////////
	private $GlobUtil; // Globutil instance

	// Path to the directory that includes the galleries and their categories
	private $super_path; 

	// Array will contain Gallery instances
	private $galleries = array();

	// Array will contain files that are found immediately under the $super_path directory 
	private $files = array();

	//= Methods
	//////////////////////////////////////////////////////////////////////////////	
	/* @param $path {String} Path (a.k.a. super_path) to the main directory
	 * @return void
	 */
	public function __construct($path = null) {
		if (!is_dir($path)) { exit("The directory '{$path}' does not exist!"); }

		// GlobUtil instance does all the hard work		
		$this->GlobUtil = new GlobUtil();

		// Set the main path 
		$this->super_path = $path;

		// Use the glob util to retrive array of immediate files & gallery objects
		$globGallery = $this->GlobUtil->glob_path($this->super_path);

		$this->files = $globGallery['files'];
		$this->galleries = $globGallery['galleries'];	
	}

	/* @param $gallery {String} The gallery name - it should match an equivalent directory name in the file system
	 * @return {Array}
	 */
	public function galleries($gallery = null) {
		if (!empty($this->galleries)) {
			// Return requested gallery if it exists in our galleries array
			if ($gallery) {
				return $this->galleries[$gallery] ? $this->galleries[$gallery] : "The requested gallery '{$gallery}' does not exist!";
			} else { // return all if a specific gallery isn't requested
				return $this->galleries;
			}
		}
	}

	/* @param $filename {String} A filename that should match an equivalent filename directly under the main directory (a.k.a. super_path)
	 * @return {Array} or {String}
	 */
	public function files($filename = null) {
		if (!empty($this->files)) {
			if ($filename) {
				foreach ($this->files as $key => $file_path) {
					if (basename($file_path) == $filename) {
						return $file_path;
					}
				}
			} else {
				return $this->files;
			}
		}		
	}

	/*
	 * NOT IMPLEMENTED
	 */
	public function create() {
		if (!empty($this->galleries)) {
			// TODO: create html code+gui on the fly from here...
		}		
	}
}