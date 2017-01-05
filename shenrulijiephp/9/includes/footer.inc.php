<!-- # footer.inc.php - Script 9.2 -->
    <div class="footerBox">
        <footer class="threeColumns">
            <article>
                <h1>Navigation</h1>
                <nav>
                    <ul>
                        <li><a href="index.php">Home</a></li><li><a href="#">Archives</a></li><li><a href="#">Contact</a></li><li><?php if ($user) { echo '<a href="logout.php">Logout</a>'; } else { echo '<a href="login.php">Login</a>'; } ?></li><li><a href="#">Register</a></li>
                    </ul>
                </nav>
            </article>
            <article>
                <h1>Advertisement:</h1>
                <img src="images/book.png" class="alignright">
                <p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>
                <p><a href="#">read more here..</a></p>
            </article>
            <article>
                <h1>Other Stuff</h1>
                <ul>
                    <?php if ($user && $user->canCreatePage()) echo '<li><a href="add_page.php">Add a New Page</a></li>'; ?>
                    <li><a href="#">This</a></li>
                    <li><a href="#">That</a></li>
                    <li><a href="#">Foo</a></li>
                    <li><a href="#">Bar</a></li>
                </ul>
            </article>
            <small>&copy; <?php echo date('Y'); ?> Tjobbe Andrews - Website design by <a href="http://www.tawd.co.uk">tawd.co.uk</a></small>
        </footer>
    </div>
</body>
</html>