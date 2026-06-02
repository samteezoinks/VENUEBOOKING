<?php
session_start();
include 'db_connect.php';

if(isset($_SESSION['uid'])) {
    $uid = $_SESSION['uid'];
} else {
    die("User not logged in.");
}
$sql = "SELECT b.BookingID, v.VenueName, b.EventStartDateTime, b.BookingStatus 
        FROM booking b 
        JOIN venue v ON b.VenueID = v.VenueID 
        WHERE b.CustomerID = ? 
        ORDER BY b.CreatedDate DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $uid);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <style>

body{
    font-family:'Segoe UI', sans-serif;
    padding:40px;
    background:#fff7f7;
    margin:0;
}

.container{
    max-width:1000px;
    margin:auto;
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
}

h1{
    color:#ff5a5f;
    margin-bottom:25px;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    overflow:hidden;
    border-radius:15px;
}

th,
td{
    padding:15px;
    border-bottom:1px solid #f1f1f1;
    text-align:left;
}

th{
    background:#ff5a5f;
    color:white;
    font-size:14px;
}

tr:hover{
    background:#fff2f2;
}

.status{
    font-weight:bold;
    color:#ff5a5f;
}

.back-btn{
    display:inline-block;
    margin-top:25px;
    padding:12px 20px;
    background:#ff5a5f;
    color:white;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
    font-weight:bold;
}

.back-btn:hover{
    background:#e0484d;
    transform:translateY(-2px);
}

.invoice-btn{
    background:#ff5a5f;
    color:white;
    text-decoration:none;
    padding:8px 12px;
    border-radius:6px;
    font-size:13px;
    font-weight:bold;
}

.invoice-btn:hover{
    background:#e0484d;
}

</style>
</head>
<body>

<div class="container">
    <h1>My Reservations</h1>
    <table>
        <tr>
            <th>Booking ID</th>
            <th>Venue</th>
            <th>Date & Time</th>
            <th>Status</th>
<th>Invoice</th>
        </tr>
        <?php while($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['BookingID']; ?></td>
            <td><?php echo $row['VenueName']; ?></td>
            <td><?php echo $row['EventStartDateTime']; ?></td>
            <td class="status">
    <?php echo $row['BookingStatus']; ?>
</td>

<td>
<?php if($row['BookingStatus'] == 'Confirmed'){ ?>
    <a href="PrintInvoice.php?booking_id=<?php echo $row['BookingID']; ?>"
       class="invoice-btn"
       target="_blank">
       View Invoice
    </a>
<?php } ?>
</td>
        </tr>
        <?php endwhile; ?>
    </table>
    <br>
    <a href="MainPage.php" class="back-btn">
    ← Book Another Venue
</a>

</div>

</body>
</html>