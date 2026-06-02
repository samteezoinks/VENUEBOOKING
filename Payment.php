<?php
include 'db_connect.php';

if(isset($_GET['booking_id'])) {
    $b_id = intval($_GET['booking_id']);
    
    // Pull the calculated transaction amount safely using a quick inner link query
    $query = "SELECT b.*, v.VenueName FROM BOOKING b JOIN VENUE v ON b.VenueID = v.VenueID WHERE b.BookingID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $b_id);
    $stmt->execute();
    $data = $stmt->get_result()->fetch_assoc();
} else {
    header("Location: MainPage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $b_id = $_POST['b_id'];
    $amount = $_POST['amount'];
    $method = $_POST['method']; 

    // Insert structural tracking record straight into the PAYMENT transaction history map
    $sql = "INSERT INTO PAYMENT (BookingID, Amount, PaymentType, PaymentStatus, PaidDate) VALUES (?, ?, ?, 'Paid', NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ids", $b_id, $amount, $method);

    if ($stmt->execute()) {
        // Synchronize the status variable state to Confirmed
        $conn->query("UPDATE BOOKING SET BookingStatus = 'Confirmed' WHERE BookingID = $b_id");
        echo "<script>alert('Transaction Finalized Successfully!'); window.location='MyBookings.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Checkout Invoice</title>
    <style>

body{
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    background:#fff7f7;
    font-family:'Segoe UI', sans-serif;
    margin:0;
}

.invoice-card{
    background:white;
    border-top:5px solid #ff5a5f;
    padding:40px;
    border-radius:18px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    width:420px;
}

h2{
    color:#222;
    margin-bottom:10px;
}

p{
    color:#555;
}

.total-box{
    background:#fff2f2;
    border:2px dashed #ff5a5f;
    padding:18px;
    border-radius:12px;
    text-align:center;
    margin:25px 0;
}

.total-box h3{
    margin:0;
    color:#ff5a5f;
    font-size:30px;
}

label{
    font-size:11px;
    font-weight:bold;
    color:#666;
    text-transform:uppercase;
}

select,
button{
    width:100%;
    padding:13px;
    margin-top:10px;
    border-radius:10px;
    border:1px solid #ddd;
    box-sizing:border-box;
    font-size:15px;
}

select:focus{
    outline:none;
    border-color:#ff5a5f;
    box-shadow:0 0 5px rgba(255,90,95,0.3);
}

button{
    background:#ff5a5f;
    color:white;
    font-weight:bold;
    border:none;
    cursor:pointer;
    margin-top:25px;
    transition:0.3s;
}

button:hover{
    background:#e0484d;
    transform:translateY(-2px);
}

</style>
</head>
<body>
    <div class="invoice-card">
        <h2>B2B Invoice Receipt</h2>
        <p>Logistics Location: <strong><?php echo htmlspecialchars($data['VenueName']); ?></strong></p>
        <p>Allocated Grand Total (Venue + Catering Bundle):</p>
        
        <div class="total-box">
            <h3>₱<?php echo number_format($data['TotalBudget'], 2); ?></h3>
        </div>
        
        <form action="PaymentDetails.php" method="GET">

    <input
    type="hidden"
    name="booking_id"
    value="<?php echo $b_id; ?>"
    >

    <button type="submit">
        Proceed to Payment Details
    </button>

</form>
    </div>
</body>
</html>