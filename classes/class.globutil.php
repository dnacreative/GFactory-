<?php

// Define Globutil class
class Globutil {
	//= Properties
	//////////////////////////////////////////////////////////////////////////////
	private $galleries = array(); 

	//= Methods
	//////////////////////////////////////////////////////////////////////////////
	/* Populates galleries array
	 * @return Array
	 */
	public function glob_path($path) { 
		if ($path) {
			// Main path immediate files
			$files = glob($path.'/'.'{*.jpg,*.jpeg,*.png,*.gif}', GLOB_BRACE);

			// Get gallery folders within the main folder
			$galleries = glob($path."\/*/", GLOB_ONLYDIR);

			// If we have multiple gallery folders
			if ($galleries) {
				foreach ($galleries as $gallery_path) : 
					// Make array of directories leading to each gallery path and filter out empty values
					$gal_path_split = array_filter(explode('/', $gallery_path), function($item) {
						return !empty($item);
					});	

					// Assume gallery folder name as the last index on the gal_path_split array
					$gallery_name = end($gal_path_split);	

					/* OLD version assumed that the main directory would be placed in the 
					 * root of the app, hence it would produce non-friendly gallery names
					 *///Remoce once verified
					// Retrieve gallery folder name 
					//$gallery_name = strstr($gallery_path, '/');
					//$gallery_name = str_replace('/', '', $gallery_name);

					// Create a new Gallery instance for each gallery folder
					$gallery = new Gallery($gallery_name);

					// Find immediate files under each gallery folder
					$gallery->files = glob($gallery_path.'{*.jpg,*.jpeg,*.png,*.gif}', GLOB_BRACE);

					// Find category folders if any
					if ($galCategories = glob($gallery_path.'*/', GLOB_ONLYDIR)) {
						foreach ($galCategories as $category_path) :
							// Split category path on: '/' 
							// Remove empty elements on the split array
							$path_split = array_filter(explode('/', $category_path), function($elem) {
								return !empty($elem);
							});		

							// Assume the category name as the last index of the split array 
							$cfolder_name = end($path_split);	
												
							$gallery->categories[$cfolder_name] = glob($category_path.'{*.jpg,*.jpeg,*.png,*.gif}', GLOB_BRACE);
						endforeach;
					}

					// Add all galleries to the property array
					$this->galleries[$gallery_name] = $gallery;
				endforeach;
			}

			return array(
				'files' => $files, 
				'galleries' => $this->galleries
			);
		}
	}	
}