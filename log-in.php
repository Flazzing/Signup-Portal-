<?php # Script 9.5 - log-in.php #2
// This script performs select query to authenticate user login credential

$page_title = 'login';

$content = ""; // Variable to store & print the status of login

// Check for form submission:
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	define('DB_USER', '');
    define('DB_PASSWORD', '');
    define('DB_HOST', '');
    define('DB_NAME', '');

// Make the connection:
$cser = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die('Could not connect to MySQL: ' . mysqli_connect_error() );


if(isset($_POST['sub']))
{
$uname = $_POST['uname']; // retrieving username
$upassword = $_POST['upassword'];   // retrieving password

// Make the query to get the password of the user
$sql = "Select password_hash FROM Users where username = '$uname'";
    
$result = $cser->query($sql);
$dbpass = "";
    // This section get password to variable
    
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        $dbpass = $row["password_hash"];
    }
    $res = mysqli_query($cser,"select * from Users where username='$uname'");
    $result=mysqli_fetch_array($res);
    if(password_verify($upassword, $dbpass)){
        if($result) {
            $content = "Authenticated";
            print_r(htmlspecialchars($content)); // print/update value            
            echo '</br><a href="list-users.php">List user</a> ';

            }
        } else {
    $content = "failed to authenticate";
    print_r(htmlspecialchars($content));// print/update value
    mysqli_close($cser); // Close the database 
    }
}
    else {
    $content = "failed to authenticate";
    print_r(htmlspecialchars($content));// print/update 
    }

    

// Executing according to the login status
    
        
}
}// End of the main Submit conditional.

?>

<html>
<body>
    
    
    <h1>Authenticate to log in</h1>    
<form action="log-in.php" method="POST">

 <p>Username: <input type="text" name="uname" size="15" maxlength="20" value="<?php if (isset($_POST['username'])) echo $_POST['username']; ?>"></p>
<p>Password: <input type="password" name="upassword" size="10" maxlength="20" value="<?php if (isset($_POST['pass1'])) echo $_POST['pass1']; ?>" ></p>
	

<input type="submit" name="sub" value="Login">

<form>
</body>
</html>
