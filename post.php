<!-- single post show  -->

<?php
include 'config/config.php';
include 'includes/header.php';



if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment']) && isset($_SESSION['user_id'])) {
    $comment = $_POST['comment'];
    $user_id = $_SESSION['user_id'];
    $post_id = $_GET['id'];

    $sql = "INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$post_id, $user_id, $comment]);

    header("Location: post.php?id=$post_id");
    exit;
}




if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT posts.title, posts.content, users.username, posts.created_at 
            FROM posts 
            JOIN users ON posts.user_id = users.id 
            WHERE posts.id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->execute([$id]);
    $post = $stmt->fetch();

    if ($post) {
        ?>
        <div class="flex px-2">
            <div>
                <h1 class="font-bold text-[25px]"><?php echo htmlspecialchars($post['title']); ?></h1>
                <p>By <?php echo htmlspecialchars($post['username']); ?> on <?php echo $post['created_at']; ?></p>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
            </div>
            <?php if(isset($_SESSION['user_id'])):?>
                <div class="mx-1 my-2">
                    <a class="bg-orange-400 px-2 py-1 rounded-full" href="delete_post.php?id=<?php echo $id; ?>">Delete Post</a>
                </div>
                <div class="mx-1 my-2">
                    <a class="bg-orange-400 px-2 py-1 rounded-full" href="edit_post.php?id=<?php echo $id; ?>">Edit Post</a>
                </div>
            <?php endif; ?>
            
        </div>

        <!-- Comment Form -->
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="my-5 px-2">
                <form action="post.php?id=<?php echo $id; ?>" method="post">
                    <textarea class="w-[100%] border border-black pt-2 px-1 rounded" name="comment" placeholder="Add your comments..." required></textarea><br>
                    <input class="rounded-full bg-orange-500 px-2 py-1" type="submit" value="Add Comment">
                </form>
            </div>
        <?php else: ?>
            <p class="px-2 mt-3"><a class="text-blue-900 underline" href="login.php">Log in</a> to leave a comment.</p>
        <?php endif; ?>

        <!-- Display Comments -->
        <h2 class="font-bold text-[20px] mb-2 px-2">Comments</h2>
        <?php
        $sql = "SELECT comments.content, comments.created_at, users.username 
                FROM comments 
                JOIN users ON comments.user_id = users.id 
                WHERE comments.post_id = ?
                ORDER BY comments.created_at DESC";
        $stmt = $connection->prepare($sql);
        $stmt->execute([$id]);
        $comments = $stmt->fetchAll();

        foreach ($comments as $comment) {
            ?>
            <div class="px-2 mb-3">
                <p><strong><?php echo htmlspecialchars($comment['username']); ?></strong> on <?php echo $comment['created_at']; ?></p>
                <p><?php echo nl2br(htmlspecialchars($comment['content'])); ?></p>
            </div>
            <?php
        }
        ?>
        <?php
    } else {
        echo "Post not found.";
    }
}

include 'includes/footer.php';
?>