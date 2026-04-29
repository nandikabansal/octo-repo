<?php

// Connect to MySQL database
// $conn = mysqli_connect("localhost","root","","student_db");

$conn = mysqli_connect(
"127.0.0.1", // or localhost
"root",
"",
"student_db",
3307
);

if(!$conn)
{
 die("Connection failed");
}


/* INSERT */
if(isset($_POST['insert']))
{
$name=$_POST['name'];
$email=$_POST['email'];

$sql="INSERT INTO students(name,email)
VALUES('$name','$email')";

mysqli_query($conn,$sql);
}


/* DELETE */
if(isset($_GET['delete']))
{
$id=$_GET['delete'];

mysqli_query($conn,
"DELETE FROM students WHERE id=$id");
}


/* UPDATE */
if(isset($_POST['update']))
{
$id=$_POST['id'];
$name=$_POST['name'];
$email=$_POST['email'];

$sql="UPDATE students
SET name='$name',
email='$email'
WHERE id=$id";

mysqli_query($conn,$sql);
}



/* Fetch record for editing */
$name="";
$email="";
$editid="";

if(isset($_GET['edit']))
{
$editid=$_GET['edit'];

$result=mysqli_query($conn,
"SELECT * FROM students
WHERE id=$editid");

$row=mysqli_fetch_assoc($result);

$name=$row['name'];
$email=$row['email'];
}

?>


<html>
<head>
<title>Student Database CRUD</title>
</head>
<body>

<h2>Student Form</h2>

<form method="post">

<input type="hidden"
name="id"
value="<?php echo $editid;?>">


Name:
<input type="text"
name="name"
value="<?php echo $name;?>">

<br><br>


Email:
<input type="text"
name="email"
value="<?php echo $email;?>">

<br><br>


<?php
if($editid=="")
{
?>

<input type="submit"
name="insert"
value="Insert">

<?php
}
else
{
?>

<input type="submit"
name="update"
value="Update">

<?php
}
?>

</form>

<hr>

<h2>Student Records</h2>

<table border="1">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Edit</th>
<th>Delete</th>
</tr>


<?php

$result=mysqli_query($conn,
"SELECT * FROM students");

while($row=mysqli_fetch_assoc($result))
{
?>

<tr>

<td>
<?php echo $row['id']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['email']; ?>
</td>

<td>
<a href="?edit=<?php echo $row['id']; ?>">
Edit
</a>
</td>

<td>
<a href="?delete=<?php echo $row['id']; ?>">
Delete
</a>
</td>

</tr>

<?php
}
?>

</table>

</body>
</html>