<?php
    include('view/header.php');
    include('model/admin_db.php'); 
    require('model/database.php');
?>

<main>
    <section>
        <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") { 
                $username = filter_input(INPUT_POST, 'username');
                $password = filter_input(INPUT_POST, 'password');
                if(empty($username)) {
                    $error = "Something is wrong with the username. Check all fields and try again.";
                    include('errors/error.php');
                } else if (empty($password)) {
                    $error = "Something is wrong with the password. Check all fields and try again.";
                    include('errors/error.php');
                } else if(is_valid($username, $password) == FALSE) {
                    $error = "Passwords do not match what is on file. Check all fields and try again.";
                    include('errors/error.php');
                } else {
                    session_start();
                    $_SESSION['is_valid_admin'] = TRUE;
                    header("Location: zua-admin.php?action=admin_list");
                }
            }
        ?>
        <h1>Log into admin account</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden">
                <label>Username</label>
                <input type="text" name="username" required />
                <br>
                <label>Password</label>
                <input type="text" name="password" required />
                <br>
                <input type="submit" value="Login" />
                <br>
            </form>
    </section>
</main>
<?php include('view/footer.php'); ?>