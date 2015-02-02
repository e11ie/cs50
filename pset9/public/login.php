<?php

    // configuration
    require("../includes/config.php"); 
    
    // TODO
    
    // change variable names
    if(!empty($_POST["username"]) && !empty($_POST["password"]))
    {
        $post_username = $_POST["username"];
        $post_password = $_POST["password"];
    }
    
    // if form was submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($post_username))
        {
            apologize("You must provide your username.");
        }
        else if (empty($post_password))
        {
            apologize("You must provide your password.");
        }

        // query database for user
                
        // connect to db
        $m = connect();
        $db = $m->$dbname;
        
	    // Get the users collection
	    $c_users = $db->users;
        
        // check username and password
        $regex1 = new MongoRegex("/$post_username/");
        $regex2 = new MongoRegex("/$post_password/");  
        $username_count = $c_users->count(array('username' => $regex1) ); // count usernames with the same name 
        $result_count = $c_users->count(array('username' => $regex1, 'password' => $regex2));
                
        if ($result_count == 1)
        {
            
            // remember that user's now logged in by storing user's ID in session
            $_SESSION["id"] = $c_users->findOne(array('username' => $regex1, 'password' => $regex2), array('_id'));
            $_SESSION["username"] = $post_username;
            
            // redirect to profile
            redirect("/");
        }
        if ($username_count > 1)
        {
            apologize("there are multiple users with this username!");
        }
        
        // disconnect from server
        $m->close();
        
        
        // else apologize
        apologize("Invalid username and/or password.");
    }
    else
    {
        // else render form
        render("login_form.php", ["title" => "Log In"]);
    }

?>
