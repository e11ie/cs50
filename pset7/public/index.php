<?php

    // configuration
    require("../includes/config.php"); 
    
    $positions = [];
    // select only from this id when SQL -ing the symbol and the shares
    $rows = query("SELECT * FROM stocks WHERE id = ?", $_SESSION["id"]);
    // select the cash from this id from diff tbl
    $cash_row = query("SELECT cash FROM users WHERE id = ?", $_SESSION["id"]);
    $cash = $cash_row[0]["cash"];
        
    // if query failed or no stocks
    if ($rows === false)
    {
        apologize("Profile inquery failed.");
    }
    
    
    // looping through $rows and adding the value to $positions
    foreach ($rows as $row) 
    {
        $stock = lookup($row["symbol"]);
        
        if ($stock !== false) // if empty (aka no stocks) still display starting cash! 
        {
            $positions[] = [
                "name" => $stock["name"],
                "price" => $stock["price"],
                "shares" => $row["shares"],
                "symbol" => strtoupper ($row["symbol"])
            ];
        }
    }
    
    // render portfolio
    render("portfolio.php", ["positions" => $positions, "cash" => $cash, "title" => "Portfolio"]);
    

?>
