<?php
    include('view/header.php'); 
    require_once('util/valid_admin.php');
?>

<main>
    <section>
            <?php
            if($_SERVER["REQUEST_METHOD"] == "POST") { 
                $username = filter_input(INPUT_POST, 'username');
                $password = filter_input(INPUT_POST, 'password');
                $cpassword = filter_input(INPUT_POST, 'c_password');
                $uppercase = preg_match('@[A-Z]@', $password); //I use these instead of regex becase regex confuses the heck out of me
                $lowercase = preg_match('@[a-z]@', $password);
                $number    = preg_match('@[0-9]@', $password);
                if(empty($username) || strlen($username) < 6 || does_exist($username) == TRUE) {
                    $error = "Something is wrong with the username. Check all fields and try again.";
                    include('errors/error.php');
                } else if (empty($password) || !$uppercase|| !$lowercase || !$number || strlen($password) < 8) {
                    $error = "Something is wrong with the password. Check all fields and try again.";
                    include('errors/error.php');
                } else if($cpassword != $password) {
                    $error = "Passwords do not match. Check all fields and try again.";
                    include('errors/error.php');
                } else {
                    add_admin($username, $password);
                    header("Location: zua-admin.php?action=admin_list");
                }
            }
        ?>
        <h1>Register For Admin Account</h1>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <input type="hidden">
                <label>Username</label>
                <input type="text" name="username" required />
                <br>
                <label>Password</label>
                <input type="text" name="password" required />
                <br>
                <label>Confirm Password</label>
                <input type="text" name="c_password" required />
                <br>
                <input type="submit" value="Register" />
                <br>
            </form>
    </section>
</main>
<?php include('view/footer.php'); ?>