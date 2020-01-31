<?php
    
    //$visitorName = filter_input(INPUT_POST, 'custName');

    /* echo "Fields: " . $visitorName . $visitorEmail;  */

            if (!isset($employee_id)) {
                $employee_id = filter_input(INPUT_GET, 'employee_id', 
                        FILTER_VALIDATE_INT);
                if ($employee_id == NULL || $employee_id == FALSE) {
                    $employee_id = 1;
                }
            }
    
            $dsn = 'mysql:host=localhost;dbname=photography';
            $username = 'root';
            $password = 'Pa$$w0rd';

            try {
                $db = new PDO($dsn, $username, $password);

            } catch (PDOException $e) {
                $error_message = $e->getMessage();
                /* include('database_error.php'); */
                echo "DB Error: " . $error_message; 
                exit();
            }

            // Read the employees from the database  
            $query = 'SELECT employeeID, firstName FROM employee ORDER BY employeeID';
            $statement = $db->prepare($query);
            $statement->execute();
            //$statement->closeCursor();
            $employees = $statement;
            /* echo "Fields: " . $visitor_name . $visitor_email . $visitor_msg; */
            
            // Read the employees from the database  
            $query2 = 'SELECT * FROM visitor WHERE employeeID = :employeeID ORDER BY visitorEmail';
            $statement2 = $db->prepare($query2);
            $statement2->bindValue(":employeeID", $employee_id);
            $statement2->execute();
            $visitors = $statement2;
            /* echo "Fields: " . $visitor_name . $visitor_email . $visitor_msg; */



?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" /> 
    <meta name="description" content="Premier Photo Productions, a Boise Idaho local company. We have affordable rates for all our photographs.">
    <title>Contact Us</title>
<!-- font style -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet"> 
<!-- External Style Sheet -->
    <link href="css/styles.css" rel="stylesheet" media="screen"/>
    <link href="css/print.css" rel="stylesheet" media="print"/>   
    
<!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="images/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16x16.png">
</head>
<!-- Main Body-->
<body>

    <nav class="horizontal" id="links">
        <a id="navicon" href="#"><img src="images/navicon.png"/></a>
        <ul>
            <li><a href="Landing.html">Home</a></li>
            <li><a href="About.html">About</a></li>
            <li><a href="Gallery.html">Gallery</a></li>
            <li><a href="Orders.html">Orders</a></li>
        </ul>
    </nav>
    <h1>Admin</h1>
    
    <aside>
        <!-- display a list of categories -->
        <h2>Employees</h2>
        <nav>
        <ul>
            <?php foreach ($employees as $employee) : ?>
            <li><a href="admin.php?employee_id=<?php echo $employee['employeeID']; ?>">
                    <?php echo $employee['firstName']; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        </nav>          
    </aside>
    
    <table>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th class="right">Phone</th>
                <th>&nbsp;</th>
            </tr>

            <?php foreach ($visitors as $visitor) : ?>
            <tr>
                <td><?php echo $visitor['visitorName']; ?></td>
                <td><?php echo $visitor['visitorEmail']; ?></td>
                <td class="right"><?php echo $visitor['visitorPhone']; ?></td>
                <td><form action="delete_product.php" method="post">
                    <input type="hidden" name="visitor_id"
                           value="<?php echo $visitor['visitorID']; ?>">
                    <input type="hidden" name="employee_id"
                           value="<?php echo $visitor['employeeID']; ?>">
                    <input type="submit" value="Delete">
                </form></td>
            </tr>
            <?php endforeach; ?>
        </table>
    
    <footer>
        &#169; Premier Photo Productions. <br>
        This website is for educational purposes and has no affiliation with any company.<br/><br/>
        <a href="https://instagram.com/" target="_blank"><img src="images/iconmonstr-instagram-1-48.png" alt="social icon for instagram"></a>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
        <a href="https://www.twitter.com/" target="_blank"><img src="images/iconmonstr-twitter-3-48.png" alt="social icon for twitter"></a>
    </footer>
</body>

