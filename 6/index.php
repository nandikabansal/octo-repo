<?php
$bill="";
$units="";

if(isset($_POST['calculate']))
{
$units=$_POST['units'];

if($units<=50)
{
$bill=$units*3.5;
}

else if($units<=150)
{
$bill=(50*3.5)+(($units-50)*4.0);
}

else if($units<=250)
{
$bill=(50*3.5)+(100*4.0)+(($units-150)*5.2);
}

else
{
$bill=(50*3.5)+(100*4.0)+(100*5.2)+(($units-250)*6.5);
}
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Electricity Bill Calculator</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.container{
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 10px gray;
width:350px;
text-align:center;
}

input{
width:90%;
padding:10px;
margin:10px;
}

button{
background:green;
color:white;
padding:10px 20px;
border:none;
cursor:pointer;
}

button:hover{
background:darkgreen;
}

h2{
color:#333;
}

.result{
margin-top:20px;
font-size:20px;
font-weight:bold;
}

@media(max-width:500px){
.container{
width:90%;
}
}

</style>
</head>

<body>

<div class="container">

<h2>Electricity Bill Calculator</h2>

<form method="post">

Enter Units Consumed:

<input type="number"
name="units"
value="<?php echo $units; ?>"
required>

<button type="submit"
name="calculate">
Calculate
</button>

</form>

<?php
if($bill!="")
{
echo "<div class='result'>";
echo "Total Bill = Rs. ".$bill;
echo "</div>";
}
?>

<br>

<h3>Tariff Rates</h3>

First 50 Units : Rs 3.50/unit <br>
Next 100 Units : Rs 4.00/unit <br>
Next 100 Units : Rs 5.20/unit <br>
Above 250 Units : Rs 6.50/unit

</div>

</body>
</html>