<?php

    // configuration
    require("../includes/config.php"); 
    
    
    $history = [];
    $rows = query("SELECT dateTime, buySell, symbol, shares, price FROM history WHERE id = ? ORDER BY dateTime DESC", $_SESSION["id"]);
    // look up stock name and put it in there
    if (empty($rows))
    {
        apologize("You currently have no history.");
    }
    
    foreach ($rows as $row) 
    {
        $stock = lookup($row["symbol"]);
        
        if ($stock !== false)
        {
            $history[] = [
                "dateTime" => $row["dateTime"],
                "buySell" => $row["buySell"],
                "name" => $stock["name"],
                "price" => $row["price"],
                "shares" => $row["shares"],
                "symbol" => strtoupper ($row["symbol"])
            ];
        }
    }
    
    // render form
    render("history_form.php", ["history" => $history, "title" => "History"]);
        
?>
