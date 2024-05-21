<!-- all post show  -->
<?php
include 'includes/header.php';
include 'config/config.php';

$sql = "SELECT posts.id, posts.title, posts.content, posts.images, users.username, posts.created_at 
        FROM posts 
        JOIN users ON posts.user_id = users.id
        ORDER BY posts.created_at DESC";
$stmt = $connection->prepare($sql);
$stmt->execute();
$posts = $stmt->fetchAll();
?>

<div class="py-6 bg-slate-300 px-5">
    <h1 class="font-bold text-[30px] mb-3">Blog Posts</h1>
    <div class="grid grid-cols-3 p-4 gap-6">
        <?php foreach ($posts as $post): ?>
            <div class="text-justify w-[90%]">
                <h2 class="font-bold text-[20px]"><?php echo htmlspecialchars($post['title']); ?></h2>
                <p class="text-slate-600 mb-2">By : <?php echo htmlspecialchars($post['username']); ?> on <?php echo $post['created_at']; ?></p>
                <?php if($post['images']): ?>
                    <img src="<?php echo $post['images']; ?>" alt="post image">
                <?php endif ?>
                <p><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
                <a class="text-blue-900 underline" href="post.php?id=<?php echo $post['id']; ?>">Read more</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php';
 ?>