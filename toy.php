<html>
    <head> 
        <title> Band Management System </title>
    </head>
    
    <body>

    <h2 style ="color:green"> Please Login to DataBase </h2>
        <form method = "POST" action = "toy.php">
            <input type = "hidden" id="login" name = "login">
            <label> Username: </label> <input type = "text" value ="ora_cwl" name = "username"><br />
            <label> Password:  </label> <input type = "password" name = "password">
            <input type = "submit" value = "login" name = "login submit">
        </form>

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

        <?php
        // now doing php
        $db_connect_identifier = NULL; //database connection identifier, or false
        $show_alert_messages = TRUE; //change to false if don't want to show error messages

        // creates an error message of whatever the parameter is
        function alert_message($message){
            global $show_alert_messages;

            if($show_alert_messages){
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        //handles connecting to database using the login info, assigns database connection identifier code to global variable
        function connect_to_database (){
            global $db_connect_identifier;

            $username = $_POST['username'];
            $password = $_POST['password'];

            $db_connect_identifier = OCIlogon($username, $password, "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_connect_identifier) {
                alert_messages("Connected to database successfully!");
        
            }
            else{
                alert_messages("Could not connect, try re-entering information");
                $error = OCI_Error(); // creates error object that contains information on the last error, in this case error from login failure
                echo htmlentities($error['message']); //converts characters in message to html entities
            
            }
        }

        //runs plain sql statements inputted
        function runPlainSQL($SQLcommand){
            global $db_connect_identifier;

            $SQLcommandparsed = OCIParse($db_connect_identifier, $SQLcommand); //parses the SQL command inputted

            //checks if SQL command was parsed successfullly 
            if (!$SQLcommandparsed) {
                echo "<br>Cannot parse the following command: " . $SQLcommand . "<br>";
                $error = OCI_Error($db_connect_identifier); // For OCIParse errors pass the connection handle
                echo htmlentities($error['message']);
            }

            $SQLexecution = OCIExecute($SQLcommandparsed, OCI_DEFAULT); //executes the parsed SQL command

            //checks if parsed SQL command executed successfully
            if (!$SQLexecution) {
                echo "<br>Cannot execute the following command: " . $SQLcommand . "<br>";
                $error = oci_error($SQLcommandparsed); // For OCIExecute errors pass the statementhandle
                echo htmlentities($error['message']);
            }

            return $SQLcommandparsed;
        }

        //runs bound sql statements, use for adding tuples
        function executeBoundSQL($SQLcommand, $list) {

			global $db_connect_identifier;

            $SQLcommandparsed = OCIParse($db_connect_identifier, $SQLcommand); //parses the SQL command inputted

            //checks if SQL command was parsed successfullly 
            if (!$SQLcommandparsed) {
                echo "<br>Cannot parse the following command: " . $SQLcommand . "<br>";
                $error = OCI_Error($db_connect_identifier); // For OCIParse errors pass the connection handle
                echo htmlentities($error['message']);
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($SQLcommandparsed, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $SQLexecution = OCIExecute($SQLcommandparsed, OCI_DEFAULT); //executes the parsed SQL command

                //checks if parsed SQL command executed successfully
                if (!$SQLexecution) {
                    echo "<br>Cannot execute the following command: " . $SQLcommand . "<br>";
                    $error = OCI_ERROR($SQLcommandparsed); // For OCIExecute errors pass the statementhandle
                    echo htmlentities($error['message']);
                    echo "<br>";
                }
            }
        }

        ?>
    </body>
</html>


 
        
