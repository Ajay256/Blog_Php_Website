<?php
include 'config/config.php';
include 'includes/header.php';
// session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = '';
    $user_id = $_SESSION['user_id'];

    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "./uploads/";
        $target_file = $target_dir.basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // $check = getimagesize($_FILES['image']['tmp_name']);
        // echo $check;

        
        if (move_uploaded_file( $_FILES['image']['tmp_name'], $target_file)) {
            $image = $target_file."vdfgv";
        }
        else {
            echo'Sorry there was an error uploading your file';
        }
        
    }

    $sql = "INSERT INTO posts (user_id, title, content, images) VALUES (?, ?, ?, ?)";
    $stmt= $connection->prepare($sql);
    $stmt->execute([$user_id, $title, $content, $image]);

    header('Location: index.php');
}

?>

<!-- <form action="create_post.php" method="post">
    Title: <input type="text" name="title" required><br>
    Content: <textarea name="content" required></textarea><br>
    Image: <input type="file" name="image" accept="image/jpeg"> <br>
    <input type="submit" value="Create Post">
</form> -->


<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-sm">
    <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">Create Post</h2>
  </div>

  <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
    <form class="space-y-6" action="create_post.php" method="POST">
      <div>
        <label class="block text-sm font-medium leading-6 text-gray-900">Title</label>
        <div class="mt-2">
          <input name="title" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium leading-6 text-gray-900">Content</label>
        <div class="mt-2">
          <textarea name="content" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
        </div>
      </div>

      <div>

      <div>
        <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create Post</button>
      </div>
    </form>

  </div>
</div>