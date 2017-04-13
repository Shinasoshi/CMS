<?php
global $connection;
if (isset($_GET['p_id'])) {
    $the_post_id = $_GET['p_id'];
}

$query = "SELECT * FROM posts WHERE post_id = $the_post_id";
$select_posts_by_id = mysqli_query($connection, $query);

while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = $row['post_comment_count'];
    $post_date = $row['post_date'];
    $post_content = $row['post_content'];
    $post_views_count = $row['post_views_count'];
}

if (isset($_POST['reset_views_count'])) {

$query = "UPDATE posts SET post_views_count = 0 WHERE post_id = $the_post_id";
$reset_views_count = mysqli_query($connection, $query);
    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='post.php'>Edit More Posts.</a></p>";
}



if (isset($_POST['update_post'])) {

    $post_title = $_POST['title'];
    $post_author = $_POST['author'];
    $post_category_id = $_POST['post_category'];
    $post_status = $_POST['post_status'];

    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = $_POST['post_tags'];
    $post_content = htmlentities($_POST['post_content'], ENT_QUOTES);

    move_uploaded_file($post_image_temp, "../images/$post_image");

    if (empty($post_image)) {

        $query = "SELECT * FROM posts WHERE post_id = $the_post_id";
        $select_image = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_array($select_image)) {
            $post_image = $row['post_image'];
        }
    }

    $query = "UPDATE posts SET ";
    $query .= "post_title = '$post_title', ";
    $query .= "post_category_id = '$post_category_id', ";
    $query .= "post_date = now(), ";
    $query .= "post_author = '$post_author', ";
    $query .= "post_status = '$post_status', ";
    $query .= "post_tags = '$post_tags', ";
    $query .= "post_content = '$post_content', ";
    $query .= "post_image = '$post_image' ";
    $query .= "WHERE post_id = '$the_post_id'";

    $update_post = mysqli_query($connection, $query);
    confirm($update_post);
    echo "<p class='bg-success'>Post Updated. <a href='../post.php?p_id={$the_post_id}'>View Post </a> or <a href='post.php'>Edit More Posts.</a></p>";

}

?>


<form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
        <label for="title">Post Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $post_title; ?>">
    </div>

    <div class="form-group">
        <label for="title">Post Category</label>
        <select name="post_category" class="btn btn-default" id="">

            <?php


            $query = "SELECT * FROM categories";
            $select_categories = mysqli_query($connection, $query);

            confirm($select_categories);

            while ($row = mysqli_fetch_assoc($select_categories)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<option value='$cat_id'>$cat_title</option>";
            }
            ?>


        </select>
    </div>

    <div class=" form-group">
        <label for="title">Post Author</label>
        <input type="text" class="form-control" name="author" value="<?php echo $post_author; ?>">
    </div>

    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" id="" class="btn btn-default">

            <?php

            echo "<option value='{$post_status}'>{$post_status}</option>";

            if ($post_status == 'published') {

                echo "<option value='draft'>draft</option>";
            } else {
                echo "<option value='published'>publish</option>";
            }
            ?>


        </select>
    </div>

    <div class=" form-group">
        <label for="post_image">Post Image</label>
        <img width="500px" src="../images/<?php echo $post_image ?>" alt="">
        <input type="file" name="image" >

    </div>

    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php echo $post_tags; ?>">
    </div>

    <div class=" form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" id="" cols="30" rows="10" class="form-control"><?php echo $post_content; ?>
        </textarea>
    </div>

    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="update_post" value="Publish Post">
    </div>
    <div class="form-group">
        <input type="submit" class="btn btn-primary" name="reset_views_count" value="Reset Views Count">
    </div>

</form>