<?php 

//include('server.php'); 

//$regex = “([^\\s]+(\\.(?i)(jpe?g|png|gif|bmp))$)”; 
function is_image($path) {
    $a = getimagesize($path);
    $image_type = $a[2];

    if(in_array($image_type , array(IMAGETYPE_GIF , IMAGETYPE_JPEG ,IMAGETYPE_PNG , IMAGETYPE_BMP)))
    {
        return true;
    }
    return false;
}
$type = mime_content_type($filename);
if (strstr($type, 'image/'))
{
    echo 'is image';
}

//image file. PHP Documentation clearly expresses that you shouldn't use getimagesize to check that a given file is a valid image. See https://www.php.net/manual/en/function.getimagesize.php

//I use the following function to validate a image file:

    /**
     * Returns TRUE if $path is a valid Image File
     *
     * @param string $path
     * @return bool
     */
    // public static function isImage(string $path) { ###errOR
        function isImage($path){

        if (!is_readable($path)) {
            return false;
        }

        // see https://www.php.net/manual/en/function.exif-imagetype.php for Constants
        // adjust this array to your needs
        $supported = [IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG];

        $type = exif_imagetype($path);

        // $type can be valid, but not "supported"
        if (!in_array($type, $supported)) {
            return false;
        }

        // check the image content, header check is not enough
        $image = false;
        switch ($type) {
            case IMAGETYPE_GIF:
                $image = @imagecreatefromgif($path);
                break;
            case IMAGETYPE_PNG:
                $image = @imagecreatefrompng($path);
                break;
            case IMAGETYPE_JPEG:
                $image = @imagecreatefromjpeg($path);
                break;
        }
        return (!!$image);
    }
    
    
    
// <?php
//     if (exif_imagetype('image.gif') != IMAGETYPE_GIF) {
//         echo 'The picture is not a gif';
//     }
// ?>
    
 <!-- phpmailer  -->
<?php
    require 'class.phpmailer.php';
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = 'smtp';
    $mail->SMTPAuth = true;
    $mail->Host = 'smtp.gmail.com'; // "ssl://smtp.gmail.com" didn't worked
    $mail->Port = 465;
    $mail->SMTPSecure = 'ssl';
    // or try these settings (worked on XAMPP and WAMP):
    // $mail->Port = 587;
    // $mail->SMTPSecure = 'tls';


    $mail->Username = "your_gmail_user_name@gmail.com";
    $mail->Password = "your_gmail_password";

    $mail->IsHTML(true); // if you are going to send HTML formatted emails
    $mail->SingleTo = true; // if you want to send a same email to multiple users. multiple emails will be sent one-by-one.

    $mail->From = "your_gmail_user_name@gmail.com";
    $mail->FromName = "Your Name";

    $mail->addAddress("user.1@yahoo.com","User 1");
    $mail->addAddress("user.2@gmail.com","User 2");

    $mail->addCC("user.3@ymail.com","User 3");
    $mail->addBCC("user.4@in.com","User 4");

    $mail->Subject = "Testing PHPMailer with localhost";
    $mail->Body = "Hi,<br /><br />This system is working perfectly.";

    if(!$mail->Send())
        echo "Message was not sent <br />PHPMailer Error: " . $mail->ErrorInfo;
    else
        echo "Message has been sent";
?>
    
    
    
    
<?php
if (isset($_POST["upload"])) {
    // Get Image Dimension
    $fileinfo = @getimagesize($_FILES["file-input"]["tmp_name"]);
    $width = $fileinfo[0];
    $height = $fileinfo[1];
    
    $allowed_image_extension = array(
        "png",
        "jpg",
        "jpeg",
        "ico",
        "bmp"
    );
    
    // Get image file extension
    $file_extension = pathinfo($_FILES["file-input"]["name"], PATHINFO_EXTENSION);
    
    // Validate file input to check if is not empty
    if (! file_exists($_FILES["file-input"]["tmp_name"])) {
        $response = array(
            "type" => "error",
            "message" => "Choose image file to upload."
        );
    }    // Validate file input to check if is with valid extension
    else if (! in_array($file_extension, $allowed_image_extension)) {
        $response = array(
            "type" => "error",
            "message" => "Upload valiid images. Only PNG and JPEG are allowed."
        );
        echo $result;
    }    // Validate image file size
    else if (($_FILES["file-input"]["size"] > 2000000)) {
        $response = array(
            "type" => "error",
            "message" => "Image size exceeds 2MB"
        );
    }    // Validate image file dimension
    else if ($width > "300" || $height > "200") {
        $response = array(
            "type" => "error",
            "message" => "Image dimension should be within 300X200"
        );
    } else {
        $target = "uploads/" . basename($_FILES["file-input"]["name"]);
        if (move_uploaded_file($_FILES["file-input"]["tmp_name"], $target)) {
            $response = array(
                "type" => "success",
                "message" => "Image uploaded successfully."
            );
        } else {
            $response = array(
                "type" => "error",
                "message" => "Problem in uploading image files."
            );
        }
    }
}

    
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Uploading images in CKEditor using PHP</title>
	<!-- Bootstra CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css" />

	<!-- Custom styling -->
	<link rel="stylesheet" href="main.css">
</head>
<body>
	
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2 post-div">

			<!-- Display a list of posts from database -->
			<?php foreach ($posts as $post): ?>
				<div class="post">
					<h3>
						<a href="details.php?id=<?php echo $post['id'] ?>"><?php echo $post['title']; ?></a>
					</h3>
					<p>
						<?php echo html_entity_decode(preg_replace('/\s+?(\S+)?$/', '', substr($post["body"], 0, 200))); ?>
						
					</p>
				</div>				
			<?php endforeach ?>

			<!-- Form to create posts -->
			<form action="index.php" method="post" enctype="multipart/form-data" class="post-form">
				<h1 class="text-center">Add Blog Post</h1>
				<div class="form-group">
					<label for="title">Title</label>
					<input type="text" name="title" class="form-control" >
				</div>

				<div class="form-group" style="position: relative;">
					<label for="post">Body</label>
					
					<!-- Upload image button -->
					<a href="#" class="btn btn-xs btn-default pull-right upload-img-btn" data-toggle="modal" data-target="#myModal">upload image</a>

					<!-- Input to browse your machine and select image to upload -->
					<input type="file" id="image-input" style="display: none;">

					<textarea name="body" id="body" class="form-control" cols="30" rows="5"></textarea>

					</div>
					<div class="form-group">
						<button type="submit" name="save-post" class="btn btn-success pull-right">Save Post</button>
					</div>
			</form>

			<!-- Pop-up Modal to display image URL -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			  <div class="modal-dialog" role="document">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			        <h4 class="modal-title" id="myModalLabel">Click below to copy image url</h4>
			      </div>
			      <div class="modal-body">
					<!-- returned image url will be displayed here -->
					<input 
						type="text" 
						id="post_image_url" 
						onclick="return copyUrl()" 
						class="form-control"
						>
					<p id="feedback_msg" style="color: green; display: none;"><b>Image url copied to clipboard</b></p>
			      </div>
			    </div>
			  </div>
			</div>
		</div>

	</div>
</div>

<!-- JQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<!-- CKEditor -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>

<!-- custom scripts -->
<script src="scripts.js"></script>

<script type="text/javascript">
function validateImage() {
    var formData = new FormData();

    var file = document.getElementById("img").files[0];

    formData.append("Filedata", file);
    var t = file.type.split('/').pop().toLowerCase();
    if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
        alert('Please select a valid image file');
        document.getElementById("img").value = '';
        return false;
    }
    if (file.size > 1024000) {
        alert('Max Upload size is 1MB only');
        document.getElementById("img").value = '';
        return false;
    }
    return true;
}
</script>
<!-- //// for multiple files -->
<script type="text/javascript">
function validateImage(id) {
    var formData = new FormData();
    var file = document.getElementById(id).files[0];
    formData.append("Filedata", file);
    var t = file.type.split('/').pop().toLowerCase();
    if (t != "jpeg" && t != "jpg" && t != "png" && t != "bmp" && t != "gif") {
        alert('Please select a valid image file');
        document.getElementById(id).value = '';
        return false;
    }
    if (file.size > 1024000) {
        alert('Max Upload size is 1MB only');
        document.getElementById(id).value = '';
        return false;
    }
    return true;
}
</script>

</body>
</html>