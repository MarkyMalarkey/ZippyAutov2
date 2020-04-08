<?php 
    include('view/header.php'); 
    require_once('util/valid_admin.php');
?>
<main>
    
    <!-- Displays a list of the cars -->
    <h1 id="list">Type List</h1>
    <section>
        <br>
        <!-- Displays a table of the items -->
            <table>
                <tr>
                    <th>Type </th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach ($type as $types) : ?>
                <tr>
                    <td><?php echo $types['Type']; ?></td>
                    <td><form action="zua-admin.php" method="post">
                    <input type="hidden" name="action" value="delete_type">
                    <input type="hidden" name="code" value="<?php echo $types['Code'];?>">
                    <input type="submit" value="Delete">
                    </form></td>
                </tr>
                <?php endforeach; ?>
            </table>

            <h1>Add Type</h1>
            <form action="zua-admin.php" method="POST">
                <input type="hidden" name="action" value="add_type">

                <label>Type Name</label>
                <input type="text" name="type" required />
                <br>
                <label>&nbsp;</label>
                <input type="submit" value="Submit" />
                <br>
            </form>
    </section>
    <br>
    <a href="?action=admin_list">Vehicle List</a>
    <br>
    <a href="?action=class_list">Class List</a>
    <br>
    <a href="index.php?action=car_list">Click here to access the customer list</a>
    <br>
    <a href="zua-register.php">Register a new Admin</a>
    <br>
    <a href="?action=logout">Logout</a>
</main>
<?php include('view/footer.php');