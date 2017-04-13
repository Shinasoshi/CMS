<?php

$modal_type ="post";
include ("delete_modal.php");


if (isset($_POST['checkBoxArray'])) {

    foreach ($_POST['checkBoxArray'] as $postValueID) {

        $bulk_options = $_POST['bulk_options'];

        switch ($bulk_options) {

            case 'published':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueID}'";

                $update_to_published_status = mysqli_query($connection, $query);
                confirm($update_to_published_status);
                break;

            case 'draft':
                $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = '{$postValueID}'";

                $update_to_draft_status = mysqli_query($connection, $query);
                confirm($update_to_draft_status);
                break;

            case 'delete':
                $query = "DELETE  FROM posts WHERE post_id = '{$postValueID}'";

                $update_to_delete_status = mysqli_query($connection, $query);
                confirm($update_to_delete_status);
                break;

            case 'clone':


                $query = "SELECT * FROM posts WHERE post_id = '{$postValueID}'";
                $select_post_query = mysqli_query($connection, $query);

                while ($row = mysqli_fetch_assoc($select_post_query)) {

                    $post_author = $row['post_author'];
                    $post_title = $row['post_title'];
                    $post_category_id = $row['post_category_id'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_date = $row['post_date'];
                    $post_content = $row['post_content'];
                }
                $query = "INSERT INTO posts(post_category_id, post_title, post_author, post_date, post_image, post_content, post_tags, post_status) ";
                $query .= "VALUES('{$post_category_id}', '{$post_title}', '{$post_author}', now(), '{$post_image}', '{$post_content}', '{$post_tags}', '{$post_status}')";
                $copy_query = mysqli_query($connection, $query);
                if (!$copy_query) {
                    die("QUERY FAILED" . mysqli_error($connection));
                }
                break;
        }

    }
}
?>


<form action="" method="post">


    <div class="col-xs-4" id="bulkOptionsContainer">


        <select name="bulk_options" id="" class="form-control">


            <option value="">Select Options</option>
            <option value="published">Publish</option>
            <option value="draft">Draft</option>
            <option value="delete">Delete</option>
            <option value="clone">Clone</option>


        </select>

    </div>
    <div class="col-xs-4">
        <input type="submit" name="submit" class="btn btn-success" value="Apply">
        <a href="post.php?source=add_post" class="btn btn-primary">Add New</a>

    </div>


    <table class="table table-bordered table-hover">


        <thead>
        <tr>
            <th><input type="checkbox" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>Author</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View Post</th>
            <th>Edit</th>
            <th>Delete</th>
            <th>Post Views Count</th>

        </tr>
        </thead>
        <tbody>
        <?php

        $query = "SELECT * FROM posts ORDER BY post_id DESC";
        $select_posts = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_posts)) {
            $post_id = $row['post_id'];
            $post_author = $row['post_author'];
            $post_title = $row['post_title'];
            $post_category_id = $row['post_category_id'];
            $post_status = $row['post_status'];
            $post_image = $row['post_image'];
            $post_tags = $row['post_tags'];
            $post_comment_count = $row['post_comment_count'];
            $post_date = $row['post_date'];
            $post_views_count = $row['post_views_count'];

            echo "<tr>";

            echo "<td><input type='checkbox' class='checkBoxes' name='checkBoxArray[]' value='$post_id'></td>";


            echo "<td> $post_id  </td>";
            echo "<td> <a href='../author_posts.php?author=$post_author'>$post_author</a></td>";
            echo "<td> $post_title  </td>";

            $query = "SELECT * FROM categories WHERE cat_id = $post_category_id";
            $select_categories_id = mysqli_query($connection, $query);

            while ($row = mysqli_fetch_assoc($select_categories_id)) {
                $cat_id = $row['cat_id'];
                $cat_title = $row['cat_title'];

                echo "<td> $cat_title  </td>";
            }

            echo "<td> $post_status  </td>";
            echo "<td> <img width='100px' src='../images/$post_image' alt='image' </td>";
            echo "<td> $post_tags  </td>";


            $query="SELECT * FROM comments WHERE comment_post_id = $post_id";
            $send_comment_query=mysqli_query($connection,$query);
            $count_comments=mysqli_num_rows($send_comment_query);


            echo "<td> $count_comments</td>";




            echo "<td> $post_date  </td>";
            echo "<td> <a href='../post.php?p_id=$post_id'> View Post </a></td>";
            echo "<td> <a href='post.php?source=edit_post&p_id=$post_id'> Edit </a></td>";
//            echo "<td> <a onclick=\"javascript: return confirm('Are you sure you want to delete posts?');\" href='post.php?delete=$post_id'> Delete </a></td>";
            echo "<td> <a class='delete_post_link' href='javascript:void(0)' rel='$post_id'> Delete </a></td>";
            echo "<td> $post_views_count  </td>";
            echo "</tr>";
        }


        ?>

        </tbody>
    </table>
</form>


<?php
if (isset($_GET['delete'])) {

    $the_post_id = $_GET['delete'];
    $query = "DELETE FROM posts WHERE post_id = $the_post_id";
    $delete_query = mysqli_query($connection, $query);
    header("Location: post.php");

}
?>

<script>

    $(document).ready(function () {

        $(".delete_post_link").on('click', function () {

            var id = $(this).attr("rel");
            var delete_url = "post.php?delete="+ id +"";

            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');


        });


    });


</script>







