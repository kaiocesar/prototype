<?
/*
************************************************************************
* © Sloppycode.net All rights reserved.
*
* This is a standard copyright header for all source code appearing
* at sloppycode.net. This application/class/script may be redistributed,
* as long as the above copyright remains intact. 
* Comments to sloppycode@sloppycode.net
************************************************************************
*/
/**
 * Upload class - wrapper for uploading files. See accompanying docs
 *
 * @author C.Small <sloppycode@sloppycode.net>
 *
 * More features and better error checking will come in the next version
 */
Class Upload
{
	var $maxupload_size;
	
	var $HTTP_POST_FILES;
	var $errors;
	
	function Upload($HTTP_POST_FILES)
	{
		$this->HTTP_POST_FILES = $HTTP_POST_FILES;
		$this->isPosted = false;
	}
	
	function save($directory, $field, $overwrite,$mode=0777)
	{
		$this->isPosted = true;
		if ($this->HTTP_POST_FILES[$field]['size'] < $this->maxupload_size && $this->HTTP_POST_FILES[$field]['size'] >0)
		{
			$noerrors = true;
			$this->isPosted = true;
			// Get names
			$tempName  = $this->HTTP_POST_FILES[$field]['tmp_name'];
			$file      = $this->HTTP_POST_FILES[$field]['name'];
			$all       = $directory.$file;

			// Copy to directory
			if (file_exists($all))
			{
				if ($overwrite)
				{
					@unlink($all)         || $noerrors=false; $this->errors  = "Upload class save error: unable to overwrite ".$all."<BR>";
					@copy($tempName,$all) || $noerrors=false; $this->errors .= "Upload class save error: unable to copy to ".$all."<BR>";
					@chmod($all,$mode)    || $ernoerrorsrors=false; $this->errors .= "Upload class save error: unable to change permissions for: ".$all."<BR>";
				}
			} else{
				@copy($tempName,$all)   || $noerrors=false;$this->errors  = "Upload class save error: unable to copy to ".$all."<BR>";
				@chmod($all,$mode)      || $noerrors=false;$this->errors .= "Upload class save error: unable to change permissions for: ".$all."<BR>";
			}
			return $noerrors;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] > $this->maxupload_size) {
			$this->errors = "File size exceeds maximum file size of ".$this->maxuploadsize." bytes";
			return false;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] == 0) {
			$this->errors = "File size is 0 bytes";
			return false;
		}
	}
	
	function saveAs($filename, $directory, $field, $overwrite,$mode=0777)
	{
		$this->isPosted = true;
		if ($this->HTTP_POST_FILES[$field]['size'] < $this->maxupload_size && $this->HTTP_POST_FILES[$field]['size'] >0)
		{
			$noerrors = true;

			// Get names
			$tempName  = $this->HTTP_POST_FILES[$field]['tmp_name'];
			$all       = $directory.$filename;
			
			// Copy to directory
			if (file_exists($all))
			{
				if ($overwrite)
				{
					@unlink($all)         || $noerrors=false; $this->errors  = "Upload class saveas error: unable to overwrite ".$all."<BR>";
					@copy($tempName,$all) || $noerrors=false; $this->errors .= "Upload class saveas error: unable to copy to ".$all."<BR>";
					@chmod($all,$mode)    || $noerrors=false; $this->errors .= "Upload class saveas error: unable to copy to".$all."<BR>";
				}
			} else{
				@copy($tempName,$all)   || $noerrors=false; $this->errors  = "Upload class saveas error: unable to copy to ".$all."<BR>";
				@chmod($all,$mode)      || $noerrors=false; $this->errors .= "Upload class saveas error: unable to change permissions for: ".$all."<BR>";
			}
			return $noerrors;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] > $this->maxupload_size) {
			$this->errors = "File size exceeds maximum file size of ".$this->maxuploadsize." bytes";
			return false;
		} elseif ($this->HTTP_POST_FILES[$field]['size'] == 0) {
			$this->errors = "File size is 0 bytes";
			return false;
		}
	}
	
	function getFilename($field)
	{
		return $this->HTTP_POST_FILES[$field]['name'];
	}
	
	function getFileMimeType($field)
	{
		return $this->HTTP_POST_FILES[$field]['type'];
	}
	
	function getFileSize($field)
	{
		return $this->HTTP_POST_FILES[$field]['size'];
	}

}

?>