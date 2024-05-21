    <!-- Header part -->
    <header class="px-5 py-3 bg-cyan-800 text-white">
        <nav class="flex justify-between items-center ">
            <div class="font-bold text-[30px] ">Blogger</div>
            
            <ul class="flex gap-10 font-bold text-slate-100">
                <li class="hover:text-slate-300 hover:underline"><a href="index.php">Home</a></li>
                
                <?php session_start(); if(isset($_SESSION['user_id'])):?>
                    <li class="hover:text-slate-300 hover:underline"><a href="create_post.php">Create Post</a></li>
                    <li class="hover:text-slate-300 hover:underline"><a href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="hover:text-slate-300 hover:underline"><a href="login.php">Login</a></li>
                    <li class="hover:text-slate-300 hover:underline"><a href="register.php">Register</a></li>
                <?php endif;?>
            </ul>
        </nav>
    </header>