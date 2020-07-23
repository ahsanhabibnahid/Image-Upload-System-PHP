<?php include "inc/header.php" ;?>
<?php include "lib/Database.php" ;?>

<?php
  $db = new Database();
?>
<?php
  if(isset($_POST['submit'])){
    
    $permited = array('png','jpg','gif');
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];

    $div = explode('.',$file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()),0,15).'.'.$file_ext;
    $uploaded_image = "images/".$unique_image;

    if(empty($file_name)){
      echo "please select any image";
    }
    elseif($file_size>1048567){
      echo "Image size should be less then 1MB";
    }
    elseif(in_array($file_ext,$permited) === false){
      echo "you can upload only : ".implode(', ',$permited);
    }
    else{

      move_uploaded_file($file_tmp,$uploaded_image);

      $sql = "insert into image_table(image) values('$uploaded_image')";
      $result = $db->insert($sql);
      if($result){
        echo "image uploaded successfully";
      }
      else{
        echo "image not inserted";
      }
    }
  }
?>
<form action="" method="POST" enctype="multipart/form-data">
  <table>
    <tr>
      <td>Select Image</td>
      <td><input type="file" name="image"></td>
      <td></td>
    </tr>
    <tr>
      <td></td>
      <td><input type="submit" name="submit" value="Upload"></td>
    </tr>
  </table>
</form>


  
<table class="table">
  <tr>
    <th>Serial</th>
    <th>Image</th>
    <th>Action</th>
  </tr>
<?php
  if(isset($_GET['delete'])){
    $id = $_GET['delete'];

    $getQuery = "select * from image_table where id='$id'";
    $getImg = $db->select($getQuery);
    if($getImg){
      while($imgData = $getImg->fetch_assoc()){
        $delImg = $imgData['image'];
        unlink($delImg);
      }
    }

    $sql = "delete from image_table where id='$id'";
    $deleteImage = $db->delete($sql);
    if($deleteImage){
      echo "Image Delete Successfully";
    }
    else{
      echo "Image Not Deleted";
    }
  }
?>
<?php
  $sql = "select * from image_table";
  $getImage = $db->select($sql);
  if($getImage){
    $i=0;
    while($result = $getImage->fetch_assoc()){
    $i++;
?>
  <tr>
    <td><?php echo $i; ?></td>
    <td><img src="<?php echo $result['image']; ?>" width=50px; height=50px;></td>
    <td><a href="?delete=<?php echo $result['id']; ?>">Delete</a></td>
  </tr>
<?php
    }
  }
?>
</table>



          


<?php include "inc/footer.php" ;?>