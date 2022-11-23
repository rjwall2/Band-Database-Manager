<?php
ini_set('session.gc_maxlifetime', 600);
session_set_cookie_params(600);
session_start(); // will allow us to save login information on the server
?>

<html>
    <head> 
        <title> Band Management System </title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
        <style>
        <?php include 'style.css'; ?>
        </style>
    </head>

    <body>
    
    <header class="main">
            <h1> Band Management System </h1>
    </header>

        <h2> Please Login to Database </h2>
            <form method = "POST" action = "toy.php">
                <input type = "hidden" id="login" name = "login">
                <label> Username: </label> 
                    <input id="inputField" type = "text" value ="ora_cwl" name = "username"><br />
                <label> Password:  </label> 
                    <input id="inputField" type = "password" name = "password">
                <input id="submit" type = "submit" value = "Login" name = "login_submit">
            </form>

        <hr />

        <h2> Add a New Band </h2>
        <!-- <p style="color:blue; font-size:15px;"> Add a band by specifying their name </p> -->
        <form method = "POST" action = "toy.php">
            <input type="hidden" id="addBand" name="addBand">
            <label> New Band's Name: </label> 
                <input id="inputField" type="text" name="newBand" required> <!-- the "NewBandName:" is not needed, name is used for identification --> 
            <input id="submit" type="submit" value="Add" name="Add"> 
        </form>
        
        <hr />

        <h2> Delete a Band </h2>
        <!-- FOR DEMO OF FIRST INSERT, DELETE, AND EDIT QUERIES -->
        <!-- can be removed if not needed -->
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "deleteBand" name ="deleteBand">
            <label> Name of Band to Delete: </label>
                <input id="inputField" type ="text" name = "deletedBand" required>
            <input id="submit" type="submit" value = "Delete" name = "Delete">
        </form>

        <hr />

        <h2> Edit Band Information </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "editBand" name ="editBand">
            <label> Name of Band to Edit: </label>
                <input id="inputField" type ="text" name = "editedBand" required><br /><br />
            <!-- &nbsp;&nbsp;
            <label> New Band Name: </label>
                <input id="inputField" type="text" name="newName" required> <br /><br /> -->
            <label> New Charts Rating: </label>
                <input id="inputField" type="text" name="newRating"> <br /><br />
            <label for="newLabel">New Record Label Name:</label>
            <select name="newLabel" id="dropDown" required>
                <option value="">Please select an option.</option>
                <option value="Atlantic Records">Altlantic Records</option>
                <option value="EMI">EMI</option>
                <option value="Apple Records">Apple Records</option>
                <option value="Warner Records">Warner Records</option>
                <option value="Interscope Records">Interscope Records</option>
            </select>
            <input id="submit" type="submit" value = "Apply Changes" name = "Apply_Changes">
        </form>

        <hr />

        <!-- <h2> Display Bands </h2> -->
        <form style ="background:none;border:0px;padding:0px" method = "POST" action ="toy.php">
            <input type = "hidden" id = "displayBands" name ="displayBands">
            <input id="submit" type="submit" value = "Click Here To Display Bands" name = "Display">
        </form>

        <hr />

        <h2> Show Songs, Albums, or Concerts That Generated Over X Dollars </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "selectionQuery" name ="selectionQuery">
            
            <label for="selectTableButton">Choose between Songs, Albums, or Concerts:</label>
            <select name="selectTableButton" id="dropDown" required>
                <option value="">Please select an option.</option>
                <option value="Songs">Songs</option>
                <option value="Albums">Albums</option>
                <option value="Concerts">Concerts</option>
            </select>
            <br><br>

            <label for="selectAttributeButton">Choose detail to view:</label>
            <select name="selectAttributeButton" id="dropDown" required>
                <option value="">Please select an option.</option>
            <optgroup label="Song Details">
                <option value="SongName">Name</option>
                <option value="ReleaseDate">Release Date</option>
                <option value="TotalSalesRevenue">Revenue</option>
                <option value="Band">Band</option>
                <option value="Album">Album</option>
            </optgroup>
            <optgroup label="Album Details">
                <option value="AlbumName">Name</option>
                <option value="ReleaseDate">Release Date</option>
                <option value="TotalSalesRevenue">Revenue</option>
                <option value="Band">Band</option>
            </optgroup>
            <optgroup label="Concert Details">
                <option value="DatePlayed">Date</option>
                <option value="Time">Time</option>
                <option value="Venue">Venue</option>
                <option value="BandPlayed">Band</option>
                <option value="TicketsSold">Number of Tickets Sold</option>
                <option value="PricePerTicket">Ticket Price</option>
            </optgroup>
            </select>
            <br><br>

            <label>Input an X value:</label>
                <input id="inputField" type ="text" name = "XAmount" required>

            <input id="submit" type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2> Show a Band's Concert History </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "projectionQuery" name ="projectionQuery">
            <label> Name of Band: </label>
                <input id="inputField" type ="text" name = "bandProjected" required> <br />
            <input type="checkbox" id="dateplayed" name="dateplayed" value="p2.DatePlayed,">
                <label for="dateplayed"> DatePlayed </label><br>
            <input type="checkbox" id="venue" name="venue" value="p2.Venue,">
                <label for="venue"> Venue </label><br>   
            <input type="checkbox" id="ticketssold" name="ticketssold" value="p1.TicketsSold,">
                <label for="ticketssold"> TicketsSold </label><br>   
            <input type="checkbox" id="concertrevenue" name="concertrevenue" value="p1.ConcertRevenue,">  
                <label for="concertrevenue"> ConcertRevenue </label><br>   
            <input id="submit" type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2> Show Songs that a Band Never Performed in Concert </h2>
        <form method = "POST" action = "toy.php">
            <input type = "hidden" id = "joinQuery" name ="joinQuery">
            <label> Name of Band: </label>
                <input id="inputField" type ="text" name = "bandJoined" required>
            <input id="submit" type="submit" value = "Search" name = "Search">
        </form>

        <hr />
        
        <h2> Show Revenue of Every Band's Top Grossing Album or Top Grossing Song </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "groupByAggregateQuery" name ="groupByAggregateQuery">
            <input type="radio" id = "Song" value = "Songs" name = "groupbyButton" required>
            <label for = "Song" > Top Grossing Songs </label><br>
            <input type="radio" id = "Albums" value = "Albums" name = "groupbyButton">
            <label for = "Albums" > Top Grossing Albums </label><br><br>
            <input id="submit" type="submit" value = "Search" name = "Search">
        </form>
        
        <hr />

        <h2> Bands That Have Earned More than Y Dollars From Total Concert Revenue  </h2>
        <form method = "POST" action ="toy.php">
            <input type = "hidden" id = "havingAggregateQuery" name ="havingAggregateQuery" required>
            <label> Input a Y Value: </label>
                <input id="inputField" type ="text" name = "YAmount" required>
            <input id="submit" type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2> Cool Search 1: Find the total sales revenue of albums for each band where the total <br> sales revenue is greater than the average sales revenue across all band albums  </h2>
        <form style ="background:none;border:0px;padding:0px" method = "POST" action ="toy.php">
            <input type = "hidden" id = "nestedGroupByAggregateQuery" name ="nestedGroupByAggregateQuery">
            <input id="submit" type="submit" value = "Search" name = "Search">
        </form>

        <hr />

        <h2> Cool Search 2: Find the bands that stream on all streaming platforms  </h2>
        <form style ="background:none;border:0px;padding:0px" method = "POST" action ="toy.php">
            <input type = "hidden" id = "divisionQuery" name ="divisionQuery">
            <input id="submit" type="submit" value = "Search" name = "Search">
        </form>
        
        <hr />


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
                } else if (array_key_exists('editBand', $_POST)){
                    editBand(); 
                } else if (array_key_exists('displayBands', $_POST)){
                    displayBands();
                } else if (array_key_exists('selectionQuery', $_POST)){
                    selectConcerts();
                } else if (array_key_exists("projectionQuery", $_POST)){
                    concertHistory();
                } else if (array_key_exists("joinQuery", $_POST)){
                    songsNeverPlayed();
                } else if (array_key_exists("divisionQuery", $_POST)) {
                    bandsOnAllStreamingPlatforms(); 
                } else if (array_key_exists("nestedGroupByAggregateQuery", $_POST)) {
                    nestedGroupByAggregate();
                } else if (array_key_exists("havingAggregateQuery", $_POST)) {
                    bandsHaving();
                } else if (array_key_exists("groupByAggregateQuery", $_POST)) {
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
                alert_messages("Added ".$newBand." to database");
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
                alert_messages("Successfully removed ".$delete_name." from the database");
            } else {
                alert_messages("Could not remove ".$delete_name." from the database");
            }
        }

        function editBand(){
            global $current_db_identifier;

            $bandName = $_POST['editedBand'];
            // $newBandName = $_POST['newName'];
            $newChartsRating = $_POST['newRating'];
            $newRecordLabel = $_POST['newLabel'];

            $success = runPlainSQL("UPDATE Band SET ChartsRating ='".$newChartsRating."', RecordLabel ='".$newRecordLabel."' WHERE BandName ='".$bandName. "'");
            if ($success['executionstatus']){
                oci_commit($current_db_identifier);
                alert_messages("Edit successful");
            } else {
                alert_messages("Edit unsuccessful");
            }
        }

        function displayBands(){

            $results = runPlainSQL("SELECT * FROM Band");
       
            echo "<br>Retrieved Data:<br><br>";
            echo "<table>";
            echo "<tr><th>BandName</th><th>ChartsRating</th><th>RecordLabel</th></tr>";

            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] ."</td></tr>"; 
            }

            echo "</table>";
        }

        function selectConcerts(){

            $tableValue = $_POST['selectTableButton'];
            $attributeValue = $_POST['selectAttributeButton'];
            $concertRevenueThreshold = $_POST['XAmount'];

            if ($tableValue == "Albums" && $attributeValue == "Album") {
                alert_messages("Invalid choice. Try again.");
            } else if ($tableValue == "Songs" || $tableValue == "Albums") {
                if ($attributeValue == "DatePlayed" || $attributeValue == "Time" || $attributeValue == "Venue" || $attributeValue == "BandPlayed" || $attributeValue == "TicketsSold" || $attributeValue == "PricePerTicket") {
                    alert_messages("Invalid choice. Try again.");
                } else {
                    $results = runPlainSQL("SELECT $attributeValue FROM $tableValue WHERE TotalSalesRevenue > ". $concertRevenueThreshold);

                    if ($results['executionstatus']){
                        alert_messages("Success!");
                    } else {
                        alert_messages("Error. Try again.");
                    }
                    
                    echo htmlspecialchars($_POST['selectTableButton']) . ' that generated over ' . htmlspecialchars($_POST['XAmount']) . ' dollars:';
                    echo "<table>";
                    echo "<tr><th>" . htmlspecialchars($_POST['selectAttributeButton']) . "</th></tr>";
                    
                    while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                        echo "<tr><td>" . $row[0] . "</td></tr>"; 
                    }
                
                    echo "</table>";
                }
            } else {
                if ($attributeValue == "DatePlayed" || $attributeValue == "Time" || $attributeValue == "Venue" || $attributeValue == "BandPlayed" || $attributeValue == "TicketsSold" || $attributeValue == "PricePerTicket") {
                    $results = runPlainSQL("SELECT $attributeValue FROM Past_Concerts_1 p1, Past_Concerts_2 p2 WHERE p1.TicketsSold = p2.TicketsSold and p1.PricePerTicket = p2.PricePerTicket and p1.ConcertRevenue > ". $concertRevenueThreshold);
                    
                    if ($results['executionstatus']){
                        alert_messages("Success!");
                    } else {
                        alert_messages("Error. Try again.");
                    }

                    echo htmlspecialchars($_POST['selectTableButton']) . ' that generated over ' . htmlspecialchars($_POST['XAmount']) . ' dollars:';
                    echo "<table>";
                    echo "<tr><th>" . htmlspecialchars($_POST['selectAttributeButton']) . "</th></tr>";
                    
                    while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                        echo "<tr><td>" . $row[0] . "</td></tr>"; 
                    
                    }

                    echo "</table>";
                } else {
                    alert_messages("Invalid choice. Try again.");
                }
            }
        }

        function concertHistory(){

            $bandName = $_POST['bandProjected'];

            $DatePlayed = $_POST['dateplayed'];
            $Venue = $_POST['venue'];
            $TicketsSold = $_POST['ticketssold'];
            $ConcertRevenue = $_POST['concertrevenue'];
            
            $projections = array($DatePlayed, $Venue, $TicketsSold, $ConcertRevenue);

            $filtered_projections = array_values(array_filter($projections));

            $filtered_projections[count($filtered_projections)-1] = rtrim($filtered_projections[count($filtered_projections)-1], ",");

            $string ="";

            foreach ($filtered_projections as $element){
                $string = $string."".$element;
            }

            $results = runPlainSQL("SELECT ".$string." FROM Past_Concerts_1 p1, Past_Concerts_2 p2 WHERE p1.TicketsSold = p2.TicketsSold and p1.PricePerTicket = p2.PricePerTicket and p2.BandPlayed = '".$bandName."' ");

            $var_0;
            $var_1;
            $var_2;
            $var_3;

            extract($filtered_projections, EXTR_PREFIX_ALL,"var" );

        
            echo "<br>Past Concerts<br>";
            echo "<table>";
            echo "<tr><th>".$var_0."</th><th>".$var_1."</th><th>".$var_2."</th><th>".$var_3."</th></tr>";

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
                alert_messages("Success!");
            }else{
                alert_messages("Error. Try again.");
            }

            echo "<br>Songs that a band has never played in concert:<br>";
            echo "<table>";
            echo "<tr><th>Song Name</th></tr>";
            
            while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] ."</td></tr>"; 
            }
            echo "</table>";
        }


        function groupByAggregate(){

            $radioValue = $_POST["groupbyButton"];

            if($radioValue == "Albums") {
                $results = runPlainSQL("SELECT Band, MAX(TotalSalesRevenue) FROM Albums GROUP BY Band");

                if ($results['executionstatus']){
                    alert_messages("Success!");
                } else {
                    alert_messages("Error. Try again.");
                }

                echo "<br>Each band's top grossing album:<br>";
                echo "<table>";
                echo "<tr><th>Band</th><th>Total Sales Revenue</th></tr>";

                while ($row = OCI_Fetch_Array($results['parsed'], OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
                }

                echo "</table>";
            }else {
                $results = runPlainSQL("SELECT Band, MAX(TotalSalesRevenue)
                FROM Songs
                GROUP BY Band");
                
                if ($results['executionstatus']){
                    alert_messages("Success!");
                } else {
                    alert_messages("Error. Try again.");
                }
                
                echo "<br>Each band's top grossing song:<br>";
                echo "<table>";
                echo "<tr><th>Band</th><th>Total Sales Revenue</th></tr>";

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

            if ($results['executionstatus']){
                alert_messages("Success!");
            } else {
                alert_messages("Error. Try again.");
            }
                
            echo 'Bands that have earned more than ' . htmlspecialchars($_POST['YAmount']) . ' dollars from total concert revenue:';
            echo "<table>";
            echo "<tr><th>Band</th><th>Total Concert Revenue</th></tr>";

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

            if ($results['executionstatus']){
                alert_messages("Success!");
            } else {
                alert_messages("Error. Try again.");
            }
                
            echo "<br>Total sales revenue of albums for each band where the total revenue<br>is greater than the average sales revenue across all band albums:<br>";
            echo "<table>";
            echo "<tr><th>Band</th><th>Total Sales Revenue</tr>";
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

            if ($results['executionstatus']){
                alert_messages("Success!");
            } else {
                alert_messages("Error. Try again.");
            }
                
            echo "<br>Bands that stream on all platforms:<br>";
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

        if (isset($_POST['Add']) || isset($_POST['Delete']) || isset($_POST['Edit']) || isset($_POST['Apply_Changes']) || isset($_POST['Search']) || isset($_POST['Display'])) {
            POSTRequestRedirect();
        }

        ?>
    </body>
</html>