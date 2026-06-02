<?php
include 'db_connect.php';

if(isset($_GET['booking_id'])){

    $b_id = intval($_GET['booking_id']);

    $query = "SELECT b.*, v.VenueName 
              FROM booking b 
              JOIN venue v ON b.VenueID = v.VenueID 
              WHERE b.BookingID = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $b_id);
    $stmt->execute();

    $data = $stmt->get_result()->fetch_assoc();

}else{

    header("Location: MainPage.php");
    exit();
}

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $b_id = $_POST['b_id'];
    $amount = $_POST['amount'];

    $fullname = $_POST['fullname'];
$method = $_POST['method'];

$cardnumber = isset($_POST['cardnumber']) ? $_POST['cardnumber'] : '';
$expiry = isset($_POST['expiry']) ? $_POST['expiry'] : '';
$cvv = isset($_POST['cvv']) ? $_POST['cvv'] : '';

$gcash = isset($_POST['gcash']) ? $_POST['gcash'] : '';

$bankaccount = isset($_POST['bankaccount']) ? $_POST['bankaccount'] : '';

    // SAVE PAYMENT
    $sql = "INSERT INTO payment
(
    BookingID,
    Amount,
    PaymentMethod,
    FullName,
    CardNumber,
    ExpiryDate,
    CVV,
    GCashNumber,
    BankAccountNumber,
    PaymentStatus,
    PaidDate
)
VALUES
(
    ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Paid', NOW()
)";

    $stmt = $conn->prepare($sql);

   $stmt->bind_param(
    "idsssssss",
    $b_id,
    $amount,
    $method,
    $fullname,
    $cardnumber,
    $expiry,
    $cvv,
    $gcash,
    $bankaccount
);

    if ($stmt->execute()) {
        $invoice_sql = "
INSERT INTO invoice
(
    BookingID,
    TotalAmount,
    PaymentStatus
)
VALUES
(
    ?,
    ?,
    'Paid'
)
";

$invoice_stmt = $conn->prepare($invoice_sql);
$invoice_stmt->bind_param(
    "id",
    $b_id,
    $amount
);
$invoice_stmt->execute();

    $conn->query("UPDATE booking
                  SET BookingStatus='Confirmed'
                  WHERE BookingID=$b_id");

    header("Location: PrintInvoice.php?booking_id=".$b_id);
    exit();
}

}
?>

<!DOCTYPE html>
<html>

<head>

<title>Payment Details</title>

<style>

body{
    margin:0;
    background:#fff7f7;
    font-family:'Segoe UI', sans-serif;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
}

.payment-card{
    width:450px;
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    border-top:5px solid #ff5a5f;
}

h2{
    margin-top:0;
    color:#222;
}

.amount-box{
    background:#fff2f2;
    border:2px dashed #ff5a5f;
    padding:18px;
    border-radius:12px;
    text-align:center;
    margin:20px 0;
}

.amount-box h1{
    margin:0;
    color:#ff5a5f;
}

label{
    display:block;
    margin-top:15px;
    font-size:12px;
    font-weight:bold;
    color:#555;
    text-transform:uppercase;
}

input,
select{
    width:100%;
    padding:12px;
    margin-top:5px;
    border:1px solid #ddd;
    border-radius:10px;
    box-sizing:border-box;
    font-size:15px;
}

input:focus,
select:focus{
    outline:none;
    border-color:#ff5a5f;
    box-shadow:0 0 5px rgba(255,90,95,0.3);
}

.row{
    display:flex;
    gap:10px;
}

.btn-pay{
    width:100%;
    padding:15px;
    margin-top:30px;
    background:#ff5a5f;
    color:white;
    border:none;
    border-radius:10px;
    font-size:16px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn-pay:hover{
    background:#e0484d;
    transform:translateY(-2px);
}

</style>

</head>

<body>

<div class="payment-card">

    <h2>Payment Details</h2>

    <p>
        Venue:
        <strong>
            <?php echo $data['VenueName']; ?>
        </strong>
    </p>

    <div class="amount-box">

        <h1>
            ₱<?php echo number_format($data['TotalBudget'],2); ?>
        </h1>

    </div>

    <form method="POST">

        <input
        type="hidden"
        name="b_id"
        value="<?php echo $b_id; ?>"
        >

        <input
        type="hidden"
        name="amount"
        value="<?php echo $data['TotalBudget']; ?>"
        >

        <label>Full Name</label>

        <input
        type="text"
        name="fullname"
        required
        >

        <label>Payment Method</label>

<select name="method" id="paymentMethod" onchange="togglePaymentFields()" required>

    <option value="Credit Card">
        Credit Card
    </option>

    <option value="GCash">
        GCash
    </option>

    <option value="Bank Transfer">
        Bank Transfer
    </option>

</select>

        <div id="cardFields">

    <label>Card Number</label>

    <input
    type="text"
    name="cardnumber"
    maxlength="16"
    >

    <div class="row">

        <div style="flex:1;">

            <label>Expiry Date</label>

            <input
            type="text"
            name="expiry"
            placeholder="MM/YY"
            >

        </div>

        <div style="flex:1;">

            <label>CVV</label>

            <input
            type="password"
            name="cvv"
            maxlength="3"
            >

        </div>

    </div>

</div>

<div id="gcashFields" style="display:none;">

    <label>GCash Number</label>

    <input
    type="text"
    name="gcash"
    placeholder="09XXXXXXXXX"
    >

</div>

<div id="bankFields" style="display:none;">

    <label>Bank Account Number</label>

    <input
    type="text"
    name="bankaccount"
    placeholder="Enter Account Number"
    >

</div>

        <button
        type="submit"
        class="btn-pay"
        >
            Complete Payment
        </button>

    </form>

</div>
<script>

function togglePaymentFields(){

    let method = document.getElementById("paymentMethod").value;

    document.getElementById("cardFields").style.display = "none";
    document.getElementById("gcashFields").style.display = "none";
    document.getElementById("bankFields").style.display = "none";

    if(method == "Credit Card"){

        document.getElementById("cardFields").style.display = "block";

    }

    else if(method == "GCash"){

        document.getElementById("gcashFields").style.display = "block";

    }

    else if(method == "Bank Transfer"){

        document.getElementById("bankFields").style.display = "block";

    }
}

window.onload = togglePaymentFields;

</script>
</body>
</html>