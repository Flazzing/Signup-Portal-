<?php # Script 9.6 - view_users.php #2
// This script retrieves all the records from the users table.

$page_title = 'View the Current Users';


// Page header:
echo '<h1>List of Registered Users</h1>';

// Set the database access information as constants:
define('DB_USER', '');
define('DB_PASSWORD', '');
define('DB_HOST', '');
define('DB_NAME', '');

// Make the connection:
echo "<table style='border: solid 1px black;'>";

 echo "<tr style='border: solid 1px black;'><th style='border: solid 1px black;'>Username</th><th style='border: solid 1px black;'>Firstname</th><th style='border: solid 1px black;'>Lastname</th><th style='border: solid 1px black;'>Email</th><th style='border: solid 1px black;'>Age</th></tr>";

class TableRows extends RecursiveIteratorIterator { 
    function __construct($it) { 
        parent::__construct($it, self::LEAVES_ONLY); 
    }

    function current() {
        return "<td style='width: 150px; border: 1px solid black;'>" . parent::current(). "</td>";
    }

    function beginChildren() { 
        echo "<tr>"; 
    } 

    function endChildren() { 
        echo "</tr>" . "\n";
    } 
} 

$servername = "";
$username = "";
$password = "";
$dbname = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $stmt = $conn->prepare("SELECT username, firstName, lastName, email, age FROM Users"); 
    $stmt->execute();

    // set the resulting array to associative
    $result = $stmt->setFetchMode(PDO::FETCH_ASSOC); 

    foreach(new TableRows(new RecursiveArrayIterator($stmt->fetchAll())) as $k=>$v) { 
        echo $v;
    }
}
catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
$conn = null;
echo "</table>";
echo '</br><a href="sign-up.php">Sign up another user</a> ';


?>