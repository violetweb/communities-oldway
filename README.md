# communities-oldway
Create custom post type and supporting metaboxes including image upload to save data to wp_postmeta.

The Old way
We use to write php to define our custom post type (or use ACF) and write code to display form metaboxes… it would probably look something like this.

 - Write php to define our custom post type
 - Write php to define our custom taxonomies
 = Write php to structure our editing interface to utilize the new custom post type:
 - Register meta boxes (add_meta_boxes hook)
 - Create form callback
 - Write function to save the post meta (save_post hook)
 - Writing functionality for image galleries and file uploads would require additional functions to hook into thickbox / (javascript functions) to upload and save images and other file uploads.
