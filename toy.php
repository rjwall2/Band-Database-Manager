<html>
    <head> 
        <title> Band Management System </title>
    </head>
    
    <body>
        <h2 style ="color:red"> Add a New Band! </h2>
        <!-- <p style="color:blue; font-size:15px;"> Add a band by specifying their name </p> -->
        <form method = "POST" action = "toy.php">
            <input type="hidden" id="addBand" name="addBand">
            <label> New Band's Name: </label> <input type="text" value="type here", name="newBand"> <!-- the "NewBandName:" is not needed, name is used for identification --> 
            <input type="submit" value="Add" name="Add"> 
        </form>
        
        <hr />

        <h2 style ="color:blue"> Delete a Band </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "deleteBand" name ="deleteBand">
            Name of Band to Delete: <input type ="text" value ="type here", name = "deletedBand">
            <input type="submit" value = "Delete" name = "Delete">
        </form>

        <hr />

        <h2 style ="color:green"> Edit Band Information </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "editBand" name ="editBand">
            Name of Band to Edit: <input type ="text" name = "editedBand">
            <input type="submit" value = "Edit" name = "Edit">
        </form>

        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "updateQuery" name ="updateQuery">
            Old Band Name: <input type="text" name="oldName"> <br /><br />
            New Band Name: <input type="text" name="newName"> <br /><br />
            Old Charts Rating: <input type="text" name="oldRating"> <br /><br />
            New Charts Rating: <input type="text" name="newRating"> <br /><br />
            Old Record Label Name: <input type="text" name="oldLabel"> <br /><br />
            New Record Label Name: <input type="text" name="newLabel"> <br /><br />
            <input type="submit" value = "Apply Changes" name = "Apply Changes">
        </form>

        <hr />

        <h2 style ="color:orange"> Show Concerts That Generated Over X Dollars </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "selectionQuery" name ="selectionQuery">
            X: <input type ="text" name = "XAmount">
            <input type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2 style ="color:AB7BE5"> Show a Band's Concert History </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "projectionQuery" name ="projectionQuery">
            Name of Band: <input type ="text" name = "bandProjected">
            <input type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2 style ="color:7BBFE5"> Show Songs that a Band Never Performed in Concert </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "joinQuery" name ="joinQuery">
            Name of Band: <input type ="text" name = "bandJoined">
            <input type="submit" value = "Search" name = "Search">
        </form>
        
        <hr />

        <form method ="POST" action = "suprise.php" target="_blank">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <input type="submit" value="suprise" id ="suprise" name="suprise">
        </form>
    </body>
</html>


 
        
