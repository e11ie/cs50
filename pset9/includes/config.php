<?php

    /**
     * config.php
     *
     * CS50
     * Problem Set 9: Final Project
     *
     * Configures pages.
     */

    // display errors, warnings, and notices
    ini_set("display_errors", true);
    error_reporting(E_ALL);

    // requirements
    require("constants.php");
    require("functions.php");

    // enable sessions
    session_start();

    // TODO change this!
    // require authentication for most pages like
        // user profile page (and edit user info page)
        // new pet post page (and edit pet page)
        // other user profiles? (only copy the contact into to the pet post)
        
    if (!preg_match("{(?:login|result_form|logout|register|poster_links|poster|welcome|index|search)\.php$}", $_SERVER["PHP_SELF"]))
    {
        if (empty($_SESSION["id"]))
        {
            redirect("login.php");
        }
    }

?>
