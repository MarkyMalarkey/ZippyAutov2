<?php 
    require('model/database.php');
    require('model/vehicles_db.php');
    require('model/types_db.php');
    require('model/classes_db.php');
    $time = 60 * 60 * 24 * 365;
    session_set_cookie_params($time, '/');
    session_start();

    //Shows the list of cars available
    $action = filter_input(INPUT_POST, 'action');
    if ($action == NULL) {
        $action = filter_input(INPUT_GET, 'action');
        if ($action == NULL) {
            $action = 'car_list';
        }
    }
 
/*-------------------------------------------------- SORTING OPTIONS -----------------------------------------------------------------*/
    if ($action == 'car_list') { //Automatically displays the list by descending price order
        $vehicle = get_vehicles_desc();
        $make = get_distinct_makes();
        $type = get_types();
        $classes = get_classes();
        include('car_list.php');
    } else if($action == 'sort_by' ) { //Sorts the list by the user chosen option
        $sortBy = filter_input(INPUT_POST, 'sortOption');
        if ($sortBy == 'PriceA') { //Price ASC
            $vehicle = get_vehicles_asc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('car_list.php');
        } else if ($sortBy == 'PriceD') { //Price DESC
            $vehicle = get_vehicles_desc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('car_list.php');
        } else if ($sortBy == 'YearA') { //Year ASC
            $vehicle = get_vehicles_year_asc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('car_list.php');
        } else if ($sortBy == 'YearD') { //Year DESC
            $vehicle = get_vehicles_year_desc();
            $type = get_types();
            $classes = get_classes();
            $make = get_distinct_makes();
            include('car_list.php');
        }
/*-------------------------------------------------- FILTERING OPTIONS -----------------------------------------------------------------*/
//I should mention that I'm under the impression that the filter for this assignment is make, type, OR class. Meaning, the customer chooses one filter type
// and not aany combination of the three. 
    
    } else if ($action == 'filter_by') {
        /*The way I implement this filtering is admittedly half-assed (at best), so I have to check to see which table (types, classes, or makes) the name belongs to.
        The reason for this method is based on a issue I run into if I use the code int numbers to identify the type or class. The problem is my program won't 
        be able to tell if it is a type or class with just the code number, this is because each table uses codes 1-4 and maybe even more if Zippy adds more items. 
        To combat this, I use the name (Luxury, SUV, Sports, etc.) instead. I pass the name then turn it into the code ID then pass that to my 
        vehicle database so it can process the filter. Thanks for coming to my TED talk. -- Update 2 days later -- I just realized that I could just add a primary key to the classes and types
        table so I could implement this better, if time permits, I will change this.*/
        $filterBy = filter_input(INPUT_POST, 'filterOption');
        if(type_name($filterBy) == NULL  && get_make($filterBy) == NULL) { //I check to see if this name belongs to the type table, if it doesn't then it might belong to the classes table
            $classID = get_classID($filterBy);
            $vehicle = get_vehicles_by_classID($classID);
            $make = get_distinct_makes();
            $type = get_types();
            $classes = get_classes();
            include('car_list.php');
        } else if (class_name($filterBy) == NULL && get_make($filterBy) == NULL) { //Checks to see if it belongs to the classes table, if not then it must belong to the vehicles Make table
            $typeID = get_typeID($filterBy);
            $vehicle = get_vehicles_by_typeID($typeID);
            $make = get_distinct_makes();
            $type = get_types();
            $classes = get_classes();
            include('car_list.php');
        } else { //If the last two if's don't work above, then it assumes that the given filter is a make.
            $vehicle = get_make($filterBy);
            $make = get_distinct_makes();
            $type = get_types();
            $classes = get_classes();
            include('car_list.php');
        }
/*----------------------------------------- Register -------------------------------*/
    } else if ($action == 'register') {
        $fname = filter_input(INPUT_POST, 'fname');
        if ($fname == NULL) {
            $error = "Invalid name. Try again.";
            include('errors/error.php');
        } else {
            $_SESSION['firstname'] = $fname;
            include('register.php');
        }
    } else if ($action == 'logout') {
        $username = $_SESSION['firstname'];
        unset($_SESSION['firstname']);
        session_destroy();
        $name = session_name();
        $expire = strtotime('-1 year');
        setcookie($name, '', $expire);
        include('logout.php');
    }


?>