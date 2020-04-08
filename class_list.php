<?php 
    include('view/header.php');
    require_once('util/valid_admin.php');
 ?>
<main>
    
    <!-- Displays a list of the cars -->
    <h1 id="list">Class List</h1>
    <section>
        <br>
        <!-- Displays a table of the items -->
            <table>
                <tr>
                    <th>Class </th>
                    <th>&nbsp;</th>
                </tr>
                <?php foreach ($class as $classes) : ?>
                <tr>
                    <td><?php echo $classes['Class']; ?></td>
                    <td><form action="zua-admin.php" method="post">
                    <input type="hidden" name="action" value="delete_class">
                    <input type="hidden" name="code" value="<?php echo $classes['Code']; ?>">
                    <input type="submit" value="Delete">
                    </form>
                </td>
                </tr>
                <?php endforeach; ?>
            </table>

            <h1>Add Class</h1>
            <form action="zua-admin.php" method="POST">
                <input type="hidden" name="action" value="add_class">
                <label>Class Name</label>
                <input type="text" name="class" required/>
                <br>
                <label>&nbsp;</label>
                <input type="submit" value="Submit" />
                <br>
            </form>
    </section>
    <br>
    <a href="?action=admin_list">Vehicle List</a>
    <br>
    <a href="?action=type_list">Type List</a>
    <br>
    <a href="index.php?action=car_list">Click here to access the customer list</a>
    <br>
    <a href="zua-register.php">Register a new Admin</a>
    <br>
    <a href="?action=logout">Logout</a>
</main>
<?php include('view/footer.php');