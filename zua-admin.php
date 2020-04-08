<?php 
    require('model/database.php');
    require('model/vehicles_db.php');
    require('model/types_db.php');
    require('model/classes_db.php');
    require('model/admin_db.php');
    session_start();

    //Shows the list of cars available
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == NULL) {
            $action = 'admin_list';
        }
    }
 
/*-------------------------------------------------- ADMINISTRATOR PAGE AND OPTIONS -----------------------------------------------------------------*/
//A link is require to reach these pages
    if ($action == 'admin_list') {
        $type = get_types();
        $classes = get_classes();
        $vehicle = get_vehicles_desc();
        include('admin_list.php');
    } else if ($action == 'add_car') { //Adds a vehicle to the table
        $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
        $make = filter_input(INPUT_POST, 'make');
        $model = filter_input(INPUT_POST, 'model');
        $price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_INT);
        $typeID = filter_input(INPUT_POST, 'typeID', FILTER_VALIDATE_INT);
        $classID = filter_input(INPUT_POST, 'classID', FILTER_VALIDATE_INT);
        if ($year == NULL || $year == FALSE || $make == NULL || $model == NULL || 
        $price == NULL || $price == FALSE || $typeID == NULL || $typeID == FALSE
        || $classID == NULL || $classID == FALSE  ) {
            $error = "Invalid item field. Check all fields and try again.";
            include('errors/error.php');
        } else {
            add_car($year, $make, $model, $price, $typeID, $classID);
            header("Location: zua-admin.php?action=admin_list");
        }
    } else if ($action == 'delete_car') { //Deletes using the private key
        $Pkey = filter_input(INPUT_POST, 'Pkey', FILTER_VALIDATE_INT);
        if ($Pkey == NULL || $Pkey == FALSE  ) {
            $error = "Invalid item field. Check all fields and try again.";
            include('errors/error.php');
        } else {
            delete_car($Pkey);
            header("Location: zua-admin.php?action=admin_list");
        }
    } else if ($action == 'class_list') { //Shows the list of classes
        $class = get_classes();
        include('class_list.php');
    } else if ($action == 'add_class') { //Adds a class
        $class = filter_input(INPUT_POST, 'class');
        if ($class == NULL) {
            $error = "Invalid item field. Check all fields and try again.";
            include('errors/error.php');
        } else {
            add_class($class);
            header("Location: zua-admin.php?action=class_list");
        }
    } else if ($action == 'delete_class') { //Deletes a class
        $code = filter_input(INPUT_POST, 'code', FILTER_VALIDATE_INT);
        if ($code == NULL || $code == FALSE) {
            $error = "Invalid item field. Check all fields and try again.";
            include('errors/error.php');
        } else {
            delete_class($code);
            header("Location: zua-admin.php?action=class_list");
        }
    } else if($action == 'type_list') { //Shows the list of types
        $type = get_types();
        include('type_list.php');
    } else if ($action == 'add_type') { //Adds a type
        $type = filter_input(INPUT_POST, 'type');
        if ($type == NULL) {
            $error = "Invalid item field. Check all fields and try again.";
            include('errors/error.php');
        } else {
            add_type($type);
            header("Location: zua-admin.php?action=type_list");
        }
    } else if ($action == 'delete_type') { //Deletes a type
        $code = filter_input(INPUT_POST, 'code', FILTER_VALIDATE_INT);
        if ($code == NULL || $code == FALSE) {
            $error = "Invalid item field. Check all fields and try again.";
            include('errors/error.php');
        } else {
            delete_type($code);
            header("Location: zua-admin.php?action=type_list");
        }
    } else if($action == 'sort_by_admin' ) { //Sorts the list by the user chosen option in the admin menu
        $sortBy = filter_input(INPUT_POST, 'sortOption');
        if ($sortBy == 'PriceA') { //Price ASC
            $vehicle = get_vehicles_asc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('admin_list.php');
        } else if ($sortBy == 'PriceD') { //Price DESC
            $vehicle = get_vehicles_desc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('admin_list.php');
        } else if ($sortBy == 'YearA') { //Year ASC
            $vehicle = get_vehicles_year_asc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('admin_list.php');
        } else if ($sortBy == 'YearD') { //Year DESC
            $vehicle = get_vehicles_year_desc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('admin_list.php');
        }
    } else if ($action == 'filter_by_admin') {
        $filterBy = filter_input(INPUT_POST, 'filterOption');
        if(type_name($filterBy) == NULL  && get_make($filterBy) == NULL) { //I check to see if this name belongs to the type table, if it doesn't then it might belong to the classes table
            $classID = get_classID($filterBy);
            $vehicle = get_vehicles_by_classID($classID);
            $make = get_distinct_makes();
            $type = get_types();
            $classes = get_classes();
            include('admin_list.php');
        } else if (class_name($filterBy) == NULL && get_make($filterBy) == NULL) { //Checks to see if it belongs to the classes table, if not then it must belong to the vehicles Make table
            $typeID = get_typeID($filterBy);
            $vehicle = get_vehicles_by_typeID($typeID);
            $make = get_distinct_makes();
            $type = get_types();
            $classes = get_classes();
            include('admin_list.php');
        } else { //If the last two if's don't work above, then it assumes that the given filter is a make.
            $vehicle = get_make($filterBy);
            $make = get_distinct_makes();
            $type = get_types();
            $classes = get_classes();
            include('admin_list.php');
        }
    } else if ($action == 'logout') {
            $_SESSION = array();
            session_destroy();
            header("Location: zua-login.php");
    } else if ($action == 'register') {
        include('zua-register.php');
    }
?>