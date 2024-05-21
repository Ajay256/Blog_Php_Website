<?php
include 'config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch existing post
    $sql = "SELECT * FROM posts WHERE id = ? AND user_id = ?";
    

    $stmt = $connection->prepare($sql);
    $stmt->execute([$id, $_SESSION['user_id']]);
    $post = $stmt->fetch();

    if (!$post) {
        echo "Access denied.";
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt= $connection->prepare($sql);
    $stmt->execute([$title, $content, $id]);

    header('Location: index.php');
}

?>

<form action="edit_post.php?id=<?php echo $id; ?>" method="post">
    Title: <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br>
    Content: <textarea name="content" required><?php echo htmlspecialchars($post['content']); ?></textarea><br>
    <input type="submit" value="Update Post">
</form>