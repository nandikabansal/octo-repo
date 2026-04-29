<?php
session_start();

$timeout=300; //5 minutes
$file="sessions.txt";

/* create file if not exists */
if(!file_exists($file))
{
file_put_contents($file,serialize([]));
}

/* load active sessions */
$data=unserialize(file_get_contents($file));

$current=time();


/* Remove expired sessions */
foreach($data as $sid=>$lasttime)
{
if(($current-$lasttime)>$timeout)
{
unset($data[$sid]);
}
}


/* User Login Simulation */
if(isset($_POST['login']))
{

if(!isset($_SESSION['loggedin']))
{

if(count($data) >=3)
{
echo "Maximum 3 concurrent sessions reached";
}
else
{
$_SESSION['loggedin']=true;

$_SESSION['last_activity']=$current;

$data[session_id()]=$current;

file_put_contents(
$file,
serialize($data)
);

echo "Login Successful";
}

}
}


/* Update session activity */
if(isset($_SESSION['loggedin']))
{

if(($current-$_SESSION['last_activity'])>$timeout)
{
session_destroy();

unset($data[session_id()]);

file_put_contents(
$file,
serialize($data)
);

echo "Session Expired";
exit;
}
else
{
$_SESSION['last_activity']=$current;

$data[session_id()]=$current;

file_put_contents(
$file,
serialize($data)
);
}
}



/* Logout */
if(isset($_POST['logout']))
{
unset($data[session_id()]);

file_put_contents(
$file,
serialize($data)
);

session_destroy();

header("Location: session_limit.php");
}

?>

<html>
<body>

<h2>Concurrent Session Control</h2>

<?php
if(isset($_SESSION['loggedin']))
{
?>

Logged In <br><br>

<form method="post">
<input
type="submit"
name="logout"
value="Logout">
</form>

<?php
}
else
{
?>

<form method="post">
<input
type="submit"
name="login"
value="Login">
</form>

<?php
}
?>

<br>

Active Sessions:
<?php echo count($data); ?>

<br>
(Session timeout 5 mins)

</body>
</html>