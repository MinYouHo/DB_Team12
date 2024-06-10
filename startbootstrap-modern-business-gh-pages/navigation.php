<!-- Navigation-->
<?php session_start(); ?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container px-5">
        <a class="navbar-brand" href="index.php">MainPage</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="pricing.php">Pricing</a></li>
                <li class="nav-item"><a class="nav-link" href="faq.php">FAQ</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownBlog" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Blog</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownBlog">
                        <li><a class="dropdown-item" href="blog-home.php">Blog Home</a></li>
                        <li><a class="dropdown-item" href="blog-post.php">Blog Post</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownPortfolio" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownPortfolio">
                        <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']): ?>
                            <!-- If user is logged in, show logout link -->
                            <li><label class="dropdown-item">Hi~ <?php echo $_SESSION['username'] ?></label></li>
                            <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                        <?php else: ?>
                            <!-- 登入&註冊表單 -->
                            <div class="login-register-form" id="login-register-form">
                                <form action="login_register.php" method="post">
                                    <label for="userID">UserID:</label>
                                    <input type="text" id="userID" name="userID" required>
                                    <label for="username">UserName:</label>
                                    <input type="text" id="username" name="username" required>
                                    <label for="password">Password:</label>
                                    <input type="password" id="password" name="password" required>
                                    <label for="email">Email:</label>
                                    <input type="text" id="email" name="email">
                                    <button type="submit" name="action" value="login">登入</button>
                                    <button type="submit" name="action" value="register">註冊</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>