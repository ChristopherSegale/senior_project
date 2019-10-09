<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>
  <head>
    <title>File Upload</title>
  </head>
  <body>
	<?php
		$errors = []; // Dumping array for errors
	
		$allowedExtensions = array('jpeg','jpg','png'); // File extensions allowed
	
		$fileName = $_FILES['image']['name'];
		$fileSize = $_FILES['image']['size'];
		$fileTemp = $_FILES['image']['temp_name'];
		$fileType = $_FILES['image']['type'];
		$fileExtension = strtolower (pathinfo($fileName, PATHINFO_EXTENSION));
	
		// Condition for unallowed extension upload
		if (in_array($fileExtension, allowedExtensions) === false)
		{
			$errors[] = "This file extension is not allowed, please choose a JPG or PNG file.";
		}
	
		// Condition for exceeding file size limit of 2mb
		if ($fileSize > 2000000)
		{
			$errors[] = "This file's size is greater than 2MB, please choose a smaller file within 2MB.";
		}

		// What to do if no errors encountered. Code still needs to be written, but varies depending how we want to interface with the database for image storing. Leaving this empty for now, will address later.
		if (empty($errors))
		{
		
		}	
	
		// Else statement if the errors array is not empty. Displays the errors.
		else 
		{
			foreach ($errors as $error) 
			{
				echo $error . "The following errors where encountered" . "\n";
			}
		}
    ?>
  </body>
</html> 
