<?php
ini_set('session.gc_maxlifetime', 600);
session_set_cookie_params(600);
session_start(); // will allow us to save login information on the server
?>

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
            <input type = "submit" value = "login" name = "login_submit">
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
            New Band Name: <input type="text" name="newName"> <br /><br />
            New Charts Rating: <input type="text" name="newRating"> <br /><br />
            New Record Label Name: <input type="text" name="newLabel"> <br /><br />
            <input type="submit" value = "Apply_Changes" name = "Apply_Changes">
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
        <form method = "POST" action = "toy.php">
            <input type = "hidden" id = "joinQuery" name ="joinQuery">
            Name of Band: <input type ="text" name = "bandJoined">
            <input type="submit" value = "Search" name = "Search">
        </form>

        <hr />
        
        <h2 style ="color:5C4033"> Show Revenue of Every Band's Top Grossing Album or Top Grossing Song </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "groupByAggregateQuery" name ="groupByAggregateQuery">
            <input type="radio" id = "Song" value = "Songs" name = "groupbyButton">
            <label for = "Song" > Songs </label><br>
            <input type="radio" id = "Albums" value = "Albums" name = "groupbyButton">
            <label for = "Albums" > Albums </label><br><br>
            <input type="submit" value = "Search" name = "Search">
        </form>
        
        <hr />

        <h2 style ="color:301934"> Bands That Have Earned More than Y Dollars From Total Concert Revenue  </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "havingAggregateQuery" name ="havingAggregateQuery">
            Y: <input type ="text" name = "YAmount">
            <input type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2 style ="color:FFD700"> Cool Search 1: Find the total sales revenue of albums for each band where the total sales revenue is greater than the average sales revenue across all band albums  </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "nestedGroupByAggregateQuery" name ="nestedGroupByAggregateQuery">
            <input type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2 style ="color:58f13c"> Cool Search 2: Find the bands that stream on all streaming platforms  </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "divisionQuery" name ="divisionQuery">
            <input type="submit" value = "Search" name = "Search">
        </form>
        
        <!-- <hr />

        <form method ="POST" action = "suprise.php" target="_blank">
            <input type="hidden" id="resetTablesRequest" name="resetTablesRequest">
            <input type="submit" value="suprise" id ="suprise" name="suprise">
        </form> -->

        <?php
        // now doing php
        $db_connect_identifier = NULL; //database connection identifier, or false
        $show_alert_messages = TRUE; //change to false if don't want to show error messages

        // creates an error message of whatever the parameter is
        function alert_messages($message){
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

            $db_connect_identifier = oci_connect($username, $password, "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_connect_identifier) {
                alert_messages("Connected to database successfully!");
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
        
            }
            else{
                alert_messages("Could not connect, try re-entering information");
                $error = OCI_Error(); // creates error object that contains information on the last error, in this case error from login failure
                echo htmlentities($error['message']); //converts characters in message to html entities
                $_SESSION['username'] = $_POST['username'];
                $_SESSION['password'] = $_POST['password'];
            }
        }

        //runs plain sql statements inputted
        function runPlainSQL($SQLcommand){
            global $current_db_identifier;

            $SQLcommandparsed = OCIParse($current_db_identifier, $SQLcommand); //parses the SQL command inputted

            //checks if SQL command was parsed successfullly 
            if (!$SQLcommandparsed) {
                echo "<br>Cannot parse the following command: " . $SQLcommand . "<br>";
                $error = OCI_Error($current_db_identifier); // For OCIParse errors pass the connection handle
                echo htmlentities($error['message']);
            }

            $SQLexecution = OCIExecute($SQLcommandparsed, OCI_DEFAULT); //executes the parsed SQL command

            //checks if parsed SQL command executed successfully
            if (!$SQLexecution) {
                echo "<br>Cannot execute the following command: " . $SQLcommand . "<br>";
                $error = oci_error($SQLcommandparsed); // For OCIExecute errors pass the statementhandle
                echo htmlentities($error['message']);
            }

            $results = array (
                'executionstatus' => $SQLexecution,
                'parsed' => $SQLcommandparsed
            );
            return $results;
        }

        //runs bound sql statements, use for adding tuples
        function runBoundSQL($SQLcommand, $list) {

			global $current_db_identifier;

            $SQLcommandparsed = OCIParse($current_db_identifier, $SQLcommand); //parses the SQL command inputted

            //checks if SQL command was parsed successfullly 
            if (!$SQLcommandparsed) {
                echo "<br>Cannot parse the following command: " . $SQLcommand . "<br>";
                $error = OCI_Error($current_db_identifier); // For OCIParse errors pass the connection handle
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

        function POSTRequestRedirect() {
            global $current_db_identifier;
            if ($current_db_identifier) {
                if (array_key_exists('addBand', $_POST)) {
                    addBand();
                } else if (array_key_exists('deleteBand', $_POST)) {
                    deleteBand();
                }else if (array_key_exists('editBand', $_POST)){
                    editBand(); 
                }else if (array_key_exists('selectionQuery', $_POST)){
                    selectConcerts();
                }else if (array_key_exists("projectionQuery", $_POST)){
                    concertHistory();
                }else if (array_key_exists("joinQuery", $_POST)){
                    songsNeverPlayed();
                }else if (array_key_exists("divisionQuery", $_POST)) {
                    bandsOnAllStreamingPlatforms(); 
                }else if (array_key_exists("nestedGroupByAggregateQuery", $_POST)) {
                    nestedGroupByAggregate();
                }else if (array_key_exists("havingAggregateQuery", $_POST)) {
                    bandsHaving();
                }else if (array_key_exists("groupByAggregateQuery", $_POST)) {
                    groupByAggregate();
                } else {
                    alert_messages("function not found");
                }
            }else{
                alert_messages("not connected to a database yet");
            }
                
        }
    
        function addBand(){
            global $current_db_identifier;
    
            // $tuple = array (
            //     ":bind1" => $_POST['newBand'],
            // );
    
            // $alltuples = array (
            //     $tuple
            // );
    
            $newBand = $_POST['newBand'];

            $success = runPlainSQL("INSERT INTO Band (BandName) VALUES ('".$newBand."')");
            if($success['executionstatus']){
                oci_commit($current_db_identifier);
                alert_messages("added ".$newBand." to database");
            }else{
                alert_messages("Could not add to database");
            }
    
        }

            
        function deleteBand() {
            global $current_db_identifier;

            $delete_name = $_POST['deletedBand'];

            $success = runPlainSQL("DELETE FROM Band WHERE BandName = '" . $delete_name . "'");
            if ($success['executionstatus']){
                oci_commit($current_db_identifier);
                alert_messages("successfully removed ".$delete_name." from the database");
            } else {
                alert_messages("Could not remove ".$delete_name." from the database");
            }
        }

        function editBand(){
            global $current_db_identifier;

            $currentBandName = $_POST['editedBand'];
            $newBandName = $_POST['newName'];
            $newChartsRating = $_POST['newRating'];
            $newRecordLabel = $_POST['newLabel'];

            $success = runPlainSQL("UPDATE Band SET BandName ='".$newBandName."', ChartsRating ='".$newChartsRating."', RecordLabel ='".$newRecordLabel."' WHERE BandName ='".$currentBandName. "'");
            if ($success['executionstatus']){
                oci_commit($current_db_identifier);
                alert_messages("edit successful");
            } else {
                alert_messages("edit unsuccessful");
            }
        }

        function selectConcerts(){

            $concertRevenueThreshold = $_POST['XAmount'];
            $results = runPlainSQL("SELECT p2.DatePlayed, p2.BandPlayed, p2.Venue, p1.TicketsSold, p1.ConcertRevenue FROM Past_Concerts_1 p1, Past_Concerts_2 p2 WHERE p1.TicketsSold = p2.TicketsSold and p1.PricePerTicket = p2.PricePerTicket and p1.ConcertRevenue > ". $concertRevenueThreshold);
                
            echo "<br>Selected Concerts<br>";
            echo "<table>";
            echo "<tr><th>DatePlayed</th><th>BandPlayed</th><th>Venue</th><th>NumberofTicketsSold</th><th>ConcertRevenue</th></tr>";

            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] ."</td><td>" . $row[3] ."</td><td>".$row[4]."</td></tr>"; 
            }

            echo "</table>";
        }

        function concertHistory(){

            $bandName = $_POST['bandProjected'];
            $results = runPlainSQL("SELECT p2.DatePlayed, p2.Venue, p1.TicketsSold, p1.ConcertRevenue FROM Past_Concerts_1 p1, Past_Concerts_2 p2 WHERE p1.TicketsSold = p2.TicketsSold and p1.PricePerTicket = p2.PricePerTicket and p2.BandPlayed = '".$bandName."' ");
       
      
            echo "<br>Past Concerts<br>";
            echo "<table>";
            echo "<tr><th>DatePlayed</th><th>Venue</th><th>NumberofTicketsSold</th><th>ConcertRevenue</th></tr>";

            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] ."</td><td>" . $row[3] ."</td></tr>"; 
            }

            echo "</table>";
        }
        

        function songsNeverPlayed(){

            $bandName = $_POST['bandJoined'];
            $results = runPlainSQL("SELECT s1.SongName
            FROM Songs s1
            WHERE (s1.Band = '".$bandName."' and s1.SongName 
                NOT IN 
                (SELECT s2.SongName FROM Songs s2, Played_At pa WHERE pa.BandName = s2.Band and pa.SongName = s2.SongName))");  
            if($results['executionstatus']){
                alert_messages("join success");
            }else{
                alert_messages("join fail");
            }

            echo "<br>Songs that a band has never played in a concert<br>";
            echo "<table>";
            echo "<tr><th>SONGNAME</th></tr>";
            
            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] ."</td></tr>"; 
            }
            echo "</table>";
        }


        function groupByAggregate(){

            $radioValue = $_POST["groupbyButton"];

            if($radioValue == "Albums") {
                $results = runPlainSQL("SELECT Band, MAX(TotalSalesRevenue) FROM Albums GROUP BY Band");

                echo "<br>Every bands top grossing album<br>";
                echo "<table>";
                echo "<tr><th>Band</th><th>MAX(TOTALSALESREVENUE)</th></tr>";

                while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
                }

                echo "</table>";
            }else {
                $results = runPlainSQL("SELECT Band, MAX(TotalSalesRevenue)
                FROM Songs
                GROUP BY Band");
                //echo "$radioVal"
                echo "<br>Every bands top grossing song<br>";
                echo "<table>";
                echo "<tr><th>Band</th><th>MAX(TOTALSALESREVENUE)</th></tr>";

                while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
                }

                echo "</table>";
            }
            
        }

        function bandsHaving(){

            $totalconcertRevenueThreshold = $_POST['YAmount'];
            $results = runPlainSQL("SELECT BandPlayed, SUM(ConcertRevenue)
            FROM Past_Concerts_1 pc1, Past_Concerts_2 pc2
            WHERE pc1.TicketsSold = pc2.TicketsSold and pc1.PricePerTicket = pc2.PricePerTicket
            GROUP BY pc2.BandPlayed
            HAVING SUM(ConcertRevenue) >".$totalconcertRevenueThreshold);
                
            echo "<br>Selected Bands<br>";
            echo "<table>";
            echo "<tr><th>BANDPlayed</th><th>SUM(CONCERTREVENUE)</th></tr>";

            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
            }

            echo "</table>";
        }


        function nestedGroupByAggregate(){

            $results = runPlainSQL("SELECT Band, SUM(TotalSalesRevenue)
            FROM        Albums
            GROUP BY    Band
            HAVING      (SUM(TotalSalesRevenue)) > (SELECT AVG(TotalSalesRevenue)
                                                    FROM Albums)");
                
            echo "<br>Total Sales revenus of albums for each band where total revenue > average sales revenue across all band albums:<br>";
            echo "<table>";
            echo "<tr><th>Band</th><th>SUM(TOTALSALESREVENUE)</tr>";
            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] ."</td><td>" . $row[1] . "</td></tr>"; 
            }

            echo "</table>";
        }
        

        function bandsOnAllStreamingPlatforms(){

            $results = runPlainSQL("SELECT BandName
            FROM Band B 
            WHERE NOT EXISTS(
               SELECT S.StreamingPlatformName
               FROM Streaming_Platform S
               Minus
                   SELECT r.StreamingPlatform
                   FROM Released_On r
                   WHERE r.BandName = B.BandName)");
                
            echo "<br>Bands that streamed on all platforms:<br>";
            echo "<table>";
            echo "<tr><th>BandName</th></tr>";
            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] ."</td></tr>"; 
            }

            echo "</table>";
        }
        
        //names of form submits should not have any spaces, use _ instead
        if (isset($_POST['login_submit'])){
            connect_to_database();
        }
            
        $current_db_identifier = oci_connect($_SESSION['username'], $_SESSION['password'], "dbhost.students.cs.ubc.ca:1522/stu");

        if (isset($_POST['Add']) || isset($_POST['Delete'])|| isset($_POST['Edit'])|| isset($_POST['Apply_Changes'])|| isset($_POST['Search'])) {
            POSTRequestRedirect();
        }

        ?>
    </body>
</html>