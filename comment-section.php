<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Wall</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/style.css">
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/comment-wall.css">
    <!-- Include Quill editor -->
    <link href="https://cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
</head>
<body>

    <?php if (isset($_GET['id'])) : 
        $post_id = $_GET['id'];
        $query = "SELECT * FROM comments WHERE comment_post_id=$post_id";
        $result = mysqli_query($connection, $query);
    ?>
    <div id="comment-wall" class="comment-wall">
        <?php while($comment = mysqli_fetch_assoc($result)):
            $user_id = $comment['comment_user_id'];
            $query = "SELECT * FROM users WHERE id=$user_id";
            $users = mysqli_query($connection, $query);
            $user = mysqli_fetch_assoc($users);
            $username = "{$user['firstname']} {$user['lastname']}";
            $useravatar = $user['avatar'];
            $comment_text = $comment['comment_text'];
            $comment_id = $comment['comment_id'];
            ?>
            <div class="comment">
                    <div class="user-info">
                        <img src="./images/<?= $useravatar?>" alt="User Avatar" class="user-avatar">
                        <div>
                            <span class="user-name"><?=$username?></span>
                            <span class="comment-time"><?=$comment['comment_updated_at']?></span>
                        </div>
                    </div>
                    <div class="comment-text" id="comment-editor-container">
                        <div id="block" class="block" ><?=$comment['comment_text']?></div>
                    </div>
                    
                    <form action="<?=ROOT_URL?>reaction.php" enctype="multipart/form-data" method="POST">
                        <div class="comment-actions">
                                <button type="submit" name="like" class="like-button"><i class="uil uil-thumbs-up"></i> 
                                    <?php if ($comment['comment_likes'] == 0):?> Like <?php else: echo $comment['comment_likes']?>
                                    <?php endif;?>
                                </button>
                                <input type="hidden" name="comment_id" value="<?= $comment_id ?>">
                                <input type="hidden" name="post_id" value="<?= $post_id ?>">
                        </div>
                    </form>
                    <form action="<?=ROOT_URL?>reaction.php" enctype="multipart/form-data" method="POST">
                        <div class="comment-actions">
                            <button type="submit" name="dislike" class="like-button"><i class="uil uil-thumbs-down"></i> Dislike </button>
                            <input type="hidden" name="comment_id" value="<?= $comment_id ?>">
                            <input type="hidden" name="post_id" value="<?= $post_id ?>">
                        </div>
                    </form>
                    
            </div>
        <?php endwhile; ?>
        
    <?php endif;?>
        <?php if (isset($_SESSION['user-id'])) : 
        $user_id = $_SESSION['user-id'];
        $query = "SELECT * FROM users WHERE id=$user_id";
        $users = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($users);
        $username = "{$user['firstname']} {$user['lastname']}";
        $useravatar = $user['avatar'];
        $post_id = $id;
    ?>

        <!-- Sample Comment -->
        <div class="comment">
            <div class="user-info">
                <img src="./images/<?= $useravatar?>" alt="User Avatar" class="user-avatar">
                <div>
                    <span class="user-name"><?=$username?></span>
                </div>
            </div>
            <div class="comment-text" id="comment-editor-container">
                <div id="editor" class="editor" ></div>
            </div>

            <!-- Comment Form -->
            <div class="comment-form">
                <div id="comment-form-editor"></div>
                <form action="<?=ROOT_URL?>add-comment-logic.php" enctype="multipart/form-data" method="POST">
                    <script src="./js/rich-editor.js"></script>
                    <textarea id="hidden-textarea" name="comment" style="display: none;"></textarea>
                    <input type="hidden" name="user_avatar" value="<?= $useravatar ?>">
                    <input type="hidden" name="post_id" value="<?= $post_id ?>">
                    <button type="submit" name="submit" class="submit-button">Submit</button>
                </form>
            </div>
        </div>
        </div>
        
<?php else : ?>
    <p>Login to leave a comment</p>
<?php endif; ?>


<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
<script src="./js/rich-editor.js"></script>
<script src="./js/main.js"></script>
</body>
</html>
