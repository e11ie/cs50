<?php

    // configuration
    require("../includes/config.php");

    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide a username.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide a password.");
        }
        else if ($_POST["password"] !== $_POST["confirmation"])
        {
            apologize("Your password and confirmation must match.");
        }
        
        //prepare variables
        $post_username = $_POST["username"];
        $post_password = $_POST["password"]; 
        $regex1 = new MongoRegex("/$post_username/");
        $regex2 = new MongoRegex("/$post_password/");       
        // connect to db
        $m = connect();
        $db = $m->$dbname;
	    // Get the users collection
	    $c_users = $db->users;
	    // count usernames with the same name 
	    $username_count = $c_users->count(array('username' => $regex1) ); 
	    // if no users with the same name
	    if ($username_count == 0)
	    {
	          
            // insert into db
            $data = array("username" => $post_username, "password" => $post_password);
            $c_users->insert($data);
	        
	        // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $c_users->findOne(array('username' => $regex1, 'password' => $regex2), array('_id'));
            $_SESSION["username"] = $post_username;
            print_r($_SESSION["id"]);
            // redirect to profile
            redirect("/");
	    }
	    else
	    {
	        apologize("There is someone else with the same username, please pick another.");   
	    }
        
        
        // the INSERT failed?
        apologize("Insert into database failed. Please try again.");

    }
    else
    {
        // else render form
        render("register_form.php", ["title" => "Register"]);
    }

?>
