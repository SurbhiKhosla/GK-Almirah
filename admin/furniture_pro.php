<?php 
 require_once('include/header.php');
 
 if(!isset($_SESSION['email'])){
  header('location: signin.php');
}
if(isset($_SESSION['email'])){
    $session_id = $_SESSION['id'];
    $session_email = $_SESSION['email'];
    $session_name = $_SESSION['name'];
}
?>

<div class="container-fluid mt-2">
    <script src="ckeditor/ckeditor.js"></script>
      <div class="row">
        <div class="col-md-3 col-lg-3">
            <?php require_once('include/sidebar.php'); ?>
        </div>
        
        <div class="col-md-9 col-lg-9">
          <form method="post" enctype="multipart/form-data">
             <?php
                    if(isset($_POST['submit'])){ 
                    $title      = $_POST['product_name'];
                    $size       = $_POST['product_size'];
                    $price      = $_POST['product_price'];
                    //$date       = date("d-m-Y");
                    //$status     = $_POST['status'];
                    $category   = $_POST['product_cat'];
                    $detail     = $_POST['product_detail'];
                    $image      = $_FILES['upload']['name'];
                    $tmp_image  = $_FILES['upload']['tmp_name'];
                        
                    if(!empty($title) && !empty($size) && !empty($price) && !empty($category) && !empty($detail) && !empty($image)){
                        $query = "INSERT INTO furniture_product(`product_name`, `product_cat`, `product_size`, `product_price`, `product_detail`, `product_img1');
                        VALUES('$title',$category,'$size',$price,'$detail','$image')";
                        
                        if(mysqli_query($con,$query)){
                            $path = "img/".$image;
                            
                            if(move_uploaded_file($tmp_image,$path) == true){
                                copy($path,"../".$path);
                              
                                $_SESSION['message'] = "Furniture Product Has Been Published";
                            } else {
                                $_SESSION['error'] = "Failed to upload image";
                            }
                        } else {
                            $_SESSION['error'] = "Failed to add product";
                        }    
                    } else {
                        $_SESSION['error'] = "All fields are required";
                    }
                    
                    header('Location: ' . $_SERVER['PHP_SELF']);
                    exit();
                }

                if(isset($_SESSION['message'])){
                    echo "<span class='mt-3 mb-4' style='color:green; font-weight:bold;'><i style='color:green; font-weight:bold;' class='fas fa-smile'></i> {$_SESSION['message']}</span>";
                    unset($_SESSION['message']);
                }
                if(isset($_SESSION['error'])){
                    echo "<span style='color:red; font-weight:bold;'><i style='color:red; font-weight:bold;' class='fas fa-frown'></i> {$_SESSION['error']}</span>";
                    unset($_SESSION['error']);
                }
            ?>
       
            <div class="row">
                <?php if(isset($message)){
                        echo "<p style='color:green; font-weight:bold;'>$message</p>";
                    } else if(isset($error)){
               echo "<span style='color:red; font-weight:bold;'><i style='color:red; font-weight:bold;' class='fas fa-frown'></i> $error</span>";
                    }?>
                    <!-- Grid column -->
                    <div class="col-md-12">
                      <div class="form-group">
                       <label for="furniture">Furniture Product Title:</label>
                       <input type="text" class="form-control" name="title" id="inputEmail4MD" placeholder="Title">
                      </div>
                    </div>
                  
            </div>
                  
              <div class="row">
                    <div class="col-md-3">
                      <label for="category">Category:</label>
                      <select class="form-control" name="category" placeholder="Category">
                        <?php
                       $cat_query = "SELECT * FROM categories ORDER BY id ASC";
                       $cat_run   = mysqli_query($con,$cat_query);
                        if(mysqli_num_rows($cat_run) > 0){
                          While($cat_row = mysqli_fetch_array($cat_run)){
                            $cat_id   = $cat_row['id']; 
                            $cat_name = ucfirst($cat_row['category']);
                            echo "<option value='$cat_id'>$cat_name</option>";
                          }

                        }
                        else{
                          echo " <option> No Category </option>";
                        }
                        ?>
                         
                       </select>
                      
                    </div>
                    <!-- Grid column -->
                    <div class="col-md-3">
                      <div class="form-group">
                      <label for="size">Product Size:</label>
                       <input type="text" class="form-control" name="size"  placeholder="Size: w X h">
                      </div>
                    </div>
                    <!-- Grid column -->
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="size">Product Price:</label>
                        <input type="text" class="form-control" name="price"  placeholder="Price in Rs">
                      </div>
                    </div>

                    <div class="col-md-3">
                     <label for="size">Product Status:</label>
                      <select class="form-control" name="status">
                        <option value="publish" selected>Publish</option>
                        <option value="draft">Draft</option>
                      </select>
                    </div>
                    
              </div> 
                       
              <div class="row">
                <div class="col-md-12">
                  <textarea name="detail" ></textarea>
                </div>
              </div>
                  
              <div class="row mt-3">
                <div class="col-md-6">      
                  <span>Choose files</span>
                     <input type="file" name="upload" class="form-control-file border" >
                </div>

                <div class="col-md-6">
                  <img src="img/<?php echo $image;?>" min-width="50%"  height="100px">
                </div>
              </div>
              
              <input type="submit" name="submit" class=" mt-3 btn btn-primary btn-md" value="Submit">
                  
            </form>
        </div>
        
     </div>
        
<script>
 CKEDITOR.replace('detail', {
    filebrowserBrowseUrl: '/brows.php',
    filebrowserUploadUrl: '/upload.php'
});
</script>
      </div>
      <?php 
 require_once('include/footer.php');
?>
