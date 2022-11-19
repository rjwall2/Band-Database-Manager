<html>
    <head> 
        <title> Band Management System </title>
    </head>
    
    <body>

    <h2 style ="color:green"> Edit Band Information </h2>
    <form method = "POST" action ="update-window.php">
            <input type = "hidden" id = "updateQuery" name ="updateQuery">
            Old Band Name: <input type="text" name="oldName"> <br /><br />
            New Band Name: <input type="text" name="newName"> <br /><br />
            Old Charts Rating: <input type="text" name="oldRating"> <br /><br />
            New Charts Rating: <input type="text" name="newRating"> <br /><br />
            Old Record Label Name: <input type="text" name="oldLabel"> <br /><br />
            New Record Label Name: <input type="text" name="newLabel"> <br /><br />
            <input type="submit" value = "Apply Changes" name = "Apply_Changes">
    </form>

    </body>
</html>