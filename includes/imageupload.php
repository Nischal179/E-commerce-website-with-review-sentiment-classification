<?php
/**
* Function Name: cwUpload()
* $field_name => Input file field name.
* $target_folder => Folder path where the image will be uploaded.
* $file_name => Custom thumbnail image name. Leave blank for default image name.
* $thumb => TRUE for create thumbnail. FALSE for only upload image.
* $thumb_folder => Folder path where the thumbnail will be stored.
* $thumb_width => Thumbnail width.
* $thumb_height => Thumbnail height.
*
**/
function imageUpload($field_name = '', $target_folder = '', $file_name = ''){
	//folder path setup
	$target_path = $target_folder;
	
	//file name setup
	$filename_err = explode(".",$_FILES[$field_name]['name']);
	$filename_err_count = count($filename_err);
	$file_ext = $filename_err[$filename_err_count-1];
	if($file_name != '')
	{
		$fileName = $file_name.'.'.$file_ext;
	}
	else
	{
		$fileName = $_FILES[$field_name]['name'];
	}
	
	//upload image path
	$upload_image = $target_path.basename($fileName);
	
	//upload image
	if(move_uploaded_file($_FILES[$field_name]['tmp_name'],$upload_image))
	{
		return $fileName;
	}
	else
	{
		return false;
	}
}



?>
