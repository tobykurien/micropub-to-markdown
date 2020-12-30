<?php 
// Micropub to markdown endpoint. Simply put this file in your web root, then you can use a client
// like Indigenous or the included post-content page to publish to your microblog. Configure your 
// post endpoint as: https://yourdomain.com/micropub.php?key=yyourAPIkey

// Config
$AUTHOR = "Your Name";
$POSTS_ROOT = '/home/user/posts';
$KEY = 'yoursupersecretAPIkey!';

// function to handle image uploads
function handleUploads($path, $name) {
 $target_dir = $path . "/images/microblog/";
 $ret = "";

 if(!isset($_POST["h"]) || !isset($_FILES["photo"])) return $ret;

 for ($i = 0; $i < count($_FILES["photo"]["name"]); $i += 1) {
  if ($_FILES["photo"]["error"][$i] !== 0) continue;

  $imageFileType = strtolower(pathinfo($_FILES["photo"]["name"][$i], PATHINFO_EXTENSION));
  $filename = $name . "-" . $i . "." . $imageFileType;
  $target_file = $target_dir . $filename;
  $uploadOk = 1;

  // Check if image file is a actual image or fake image
  $check = getimagesize($_FILES["photo"]["tmp_name"][$i]);
   if($check !== false) {
    $uploadOk = 1;
  } else {
    echo "File not an image.";
    $uploadOk = 0;
  }

  // Check if file already exists
  if (file_exists($target_file)) {
   echo "File already exists.";
   $uploadOk = 0;
  }

  // Check file size
  if ($_FILES["photo"]["size"][$i] > 10000000) {
   echo "File is too large.";
   $uploadOk = 0;
  }

  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
     && $imageFileType != "gif" ) {
   echo "File type not allowed.";
   $uploadOk = 0;
  }

  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
   //echo "Sorry, your file was not uploaded.";
   http_response_code(500);
   exit( 'Error' );
   // if everything is ok, try to upload file
  } else {
   if (move_uploaded_file($_FILES["photo"]["tmp_name"][$i], $target_file)) {
    $ret = $ret . '<img class="u-featured" alt="' . $_POST["mp-photo-alt"][$i] . '" src="/images/microblog/' . $filename . '">\n';
   } else {
    echo "Error uploading your file.";
    http_response_code(500);
    exit( 'Error' );
   }
  }
 }

 return $ret;
}

$QUERY = array();

// Debug (allows running the PHP script directly to simulate a POST)
if ($_POST == null) {
 $_POST = array();
 $_POST["h"] = "entry";
 $_POST["name"] = "Title of reposted link";
 $_POST["content"] = "Test #tree ";
 $_POST["category"] = array("test", "tree");
 $_POST["published"] = "2020-12-20T14:54:00+0200";
 $_POST["post-status"] = "published";

 // Repost example: {"h":"entry","name":"test","content":"Test, 1 2","repost-of":"http:\/\/test.com","category":["test","repost"],"published":"2020-12-22T12:10:00+0200","post-status":"published"}
 $_POST["repost-of"] = "http://test.com";

 // Reply example: {"h":"entry","content":"Reply example","in-reply-to":"http:\/\/test.com","category":["test","reply"],"published":"2020-12-22T12:14:00+0200","post-status":"published"}
 $_POST["in-reply-to"] = "http://test.com";

 $QUERY["key"] = $KEY;
} else {
 $QUERY = array();
 parse_str($_SERVER['QUERY_STRING'], $QUERY);
}

file_put_contents($POSTS_ROOT . '/debug.txt',  json_encode(array("SERVER"=>$_SERVER, "POST"=>$_POST, "FILES"=>$_FILES)));

// Authentication
if (!isset($QUERY["key"]) || $QUERY["key"] != $KEY) {
  if (!isset($_POST["key"]) || $_POST["key"] != $KEY) {
    sleep(5); // rate limit
    http_response_code(401);
    exit( 'Not authorized' );
  }
} 

$NAME = "post-" . time();
$CONTENT = "";

if (isset($_POST["title"])) {
 $CONTENT = "Title: " . $_POST["title"] . "\n";
 // TODO - $NAME needs to be a slug of title
} else {
 $CONTENT = "Title: " . $NAME . "\n";
}

$CONTENT = $CONTENT . "Author: " . $AUTHOR . "\n";
$CONTENT = $CONTENT . "Date: " . $_POST["published"] . "\n";
if (isset($_POST["category"])) $CONTENT = $CONTENT . "tags: " . implode(',',$_POST["category"]) . "\n";

$CONTENT = $CONTENT . "\n" . $_POST["content"] . "\n<br/>\n";

if (isset($_POST["name"])) $CONTENT = $CONTENT . "\n> " . $_POST["name"] . "    ";
if (isset($_POST["repost-of"])) $CONTENT = $CONTENT . "\n> [" . $_POST["repost-of"] . "](" . $_POST["repost-of"] . ")  ";

if (isset($_POST["in-reply-to"])) $CONTENT = $CONTENT . "\n> [" . $_POST["in-reply-to"] . "](" . $_POST["in-reply-to"] . ")  ";
$CONTENT = $CONTENT . handleUploads($POSTS_ROOT, $NAME);

//echo $CONTENT;

file_put_contents($POSTS_ROOT . '/microblog/' . $NAME . '.md',  $CONTENT);

// a file watcher needs to kick off the git commit/make publish routine

echo "Success!"
?>
