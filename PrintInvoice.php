<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if(!isset($_GET['booking_id'])){
    die("Invalid Invoice");
}

$booking_id = intval($_GET['booking_id']);

$sql = "
SELECT
    b.*,
    v.VenueName,
    c.ContactPerson,
    p.PaymentMethod,
    p.PaidDate
FROM booking b
JOIN venue v ON b.VenueID = v.VenueID
JOIN customer c ON b.CustomerID = c.CustomerID
LEFT JOIN payment p ON b.BookingID = p.BookingID
WHERE b.BookingID = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $booking_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();

if(!$data){
    die("Invoice not found");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Invoice #<?php echo $booking_id; ?></title>

<style>

body{
    font-family:'Segoe UI',sans-serif;
    background:#f5f5f5;
    padding:30px;
}

.invoice{
    max-width:800px;
    margin:auto;
    background:white;
    padding:40px;
    border-radius:10px;
    box-shadow:0 0 15px rgba(0,0,0,.1);
}

.header{
    display:flex;
    justify-content:space-between;
    border-bottom:3px solid #ff5a5f;
    padding-bottom:15px;
    margin-bottom:20px;
}

.logo{
    font-size:32px;
    font-weight:bold;
}

.logo span{
    color:#ff5a5f;
}

.invoice-title{
    text-align:right;
}

.section{
    margin-top:20px;
}

table{
    width:100%;
    border-collapse:collapse;
    margin-top:15px;
}

table th,
table td{
    border:1px solid #ddd;
    padding:12px;
}

table th{
    background:#ff5a5f;
    color:white;
}

.total{
    text-align:right;
    font-size:24px;
    font-weight:bold;
    color:#ff5a5f;
    margin-top:20px;
}

.print-btn{
    background:#ff5a5f;
    color:white;
    border:none;
    padding:12px 25px;
    border-radius:8px;
    cursor:pointer;
    margin-top:20px;
}

@media print{

    .print-btn{
        display:none;
    }

    body{
        background:white;
    }

    .invoice{
        box-shadow:none;
    }
}

.back-btn{
    display:inline-block;
    background:#333;
    color:white;
    text-decoration:none;
    padding:12px 20px;
    border-radius:8px;
    margin-right:10px;
    font-weight:bold;
}

.back-btn:hover{
    background:#111;
}
</style>
</head>

<body>

<div class="invoice">

    <div class="header">

        <div class="logo">
            Tags<span>bnb</span>
        </div>

        <div class="invoice-title">
            <h2>INVOICE</h2>
            <p>Invoice #: <?php echo $booking_id; ?></p>
        </div>

    </div>

    <div class="section">

        <h3>Customer Details</h3>

        <p>
            <strong>Name:</strong>
            <?php echo $data['ContactPerson']; ?>
        </p>

        <p>
            <strong>Venue:</strong>
            <?php echo $data['VenueName']; ?>
        </p>

        <p>
            <strong>Event Date:</strong>
            <?php echo $data['EventStartDateTime']; ?>
        </p>

    </div>

    <table>

        <tr>
            <th>Description</th>
            <th>Amount</th>
        </tr>

        <tr>
            <td>Venue Reservation</td>
            <td>₱<?php echo number_format($data['TotalBudget'],2); ?></td>
        </tr>

        <?php if($data['SoundLightPrice'] > 0){ ?>
        <tr>
            <td>Sound & Light System</td>
            <td>₱<?php echo number_format($data['SoundLightPrice'],2); ?></td>
        </tr>
        <?php } ?>

        <?php if($data['HostPrice'] > 0){ ?>
        <tr>
            <td>Event Host</td>
            <td>₱<?php echo number_format($data['HostPrice'],2); ?></td>
        </tr>
        <?php } ?>

    </table>

    <div class="total">
        Total: ₱<?php echo number_format($data['TotalBudget'],2); ?>
    </div>

    <div class="section">
        <p>
            <strong>Payment Method:</strong>
            <?php echo $data['PaymentMethod']; ?>
        </p>

        <p>
            <strong>Payment Date:</strong>
            <?php echo $data['PaidDate']; ?>
        </p>

        <p>
            <strong>Status:</strong>
            <?php echo $data['BookingStatus']; ?>
        </p>
    </div>

    <div style="margin-top:20px;">
    <a href="MyBookings.php" class="back-btn">
        ← Back to My Bookings
    </a>

    <button class="print-btn" onclick="window.print()">
        Print Invoice
    </button>
    
</div>

</div>

</body>
</html>