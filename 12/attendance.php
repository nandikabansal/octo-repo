<?php

$conn=mysqli_connect(
"127.0.0.1",
"root",
"",
"attendance_db",
3307
);


/* STUDENT REGISTRATION */

if(isset($_POST['register']))
{

$roll=$_POST['roll'];
$name=$_POST['name'];
$email=$_POST['email'];
$password=$_POST['password'];

$sql="INSERT INTO students
VALUES
('$roll','$name',
'$email','$password')";

mysqli_query($conn,$sql);

// echo "Student Registered <br>"; 
//IMPORTANT
header("Location: attendance.php");
exit();
}



/* TEACHER TAKES ATTENDANCE */

if(isset($_POST['submitAttendance']))
{

$date=date("Y-m-d");

$result=
mysqli_query($conn,
"SELECT * FROM students");

while($row=
mysqli_fetch_assoc($result))
{

$roll=$row['rollno'];
$name=$row['name'];

$status=
isset($_POST['attend'][$roll])
?
"Present"
:
"Absent";

mysqli_query(
$conn,
"INSERT INTO attendance
(rollno,name,status,date)

VALUES
('$roll',
'$name',
'$status',
'$date')"
);

}

// echo "Attendance Saved";
header("Location: attendance.php");
exit();
}

?>

<html>
<body>

<h2>Student Registration</h2>

<form method="post">

Roll No:
<input type="number"
name="roll">

<br><br>

Name:
<input type="text"
name="name">

<br><br>

Email:
<input type="text"
name="email">

<br><br>

Password:
<input type="password"
name="password">

<br><br>

<input
type="submit"
name="register"
value="Register">

</form>

<hr>

<h2>Teacher Attendance</h2>

<form method="post">

<table border="1">

<tr>
<th>Roll No</th>
<th>Name</th>
<th>Present</th>
</tr>

<?php

$result=
mysqli_query(
$conn,
"SELECT * FROM students"
);

while($row=
mysqli_fetch_assoc($result))
{
?>

<tr>

<td>
<?php echo $row['rollno']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>

<input
type="checkbox"
name="attend[<?php
echo $row['rollno'];
?>]">

</td>

</tr>

<?php
}
?>

</table>

<br>

<input
type="submit"
name="submitAttendance"
value="Submit Attendance">

</form>

<hr>

<h2>Attendance Records</h2>

<table border="1">

<tr>
<th>Roll</th>
<th>Name</th>
<th>Status</th>
<th>Date</th>
</tr>

<?php

$result=
mysqli_query(
$conn,
"SELECT * FROM attendance"
);

while($row=
mysqli_fetch_assoc($result))
{
?>

<tr>

<td>
<?php echo $row['rollno']; ?>
</td>

<td>
<?php echo $row['name']; ?>
</td>

<td>
<?php echo $row['status']; ?>
</td>

<td>
<?php echo $row['date']; ?>
</td>

</tr>

<?php
}
?>

</table>

</body>
</html>