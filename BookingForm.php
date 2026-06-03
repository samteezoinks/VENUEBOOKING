<?php
session_start();
include 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['uid'])) {
    header("Location: LoginPage.php");
    exit();
}

$uid = $_SESSION['uid']; 
// Grab the venue parameter safely from the URL string
$venue_id = isset($_GET['id']) ? intval($_GET['id']) : 1; 

// Fetch basic venue profile rates
$res = $conn->query("SELECT * FROM VENUE WHERE VenueID = $venue_id");
$venue = $res->fetch_assoc();

// SQL WHERE clause matches the catering options directly to the selected venue
$catering_res = $conn->query("SELECT * FROM CATERING_PACKAGE WHERE VenueID = $venue_id");

// Process order submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_start = $_POST['event_start_date'] . ' ' . $_POST['event_start_time'];
    $event_end = $_POST['event_end_date'] . ' ' . $_POST['event_end_time'];
    $guests = intval($_POST['guests']);
    $package_id = intval($_POST['package_id']);
    $sound_price = isset($_POST['sound_light']) ? 10000 : 0;
$host_price = isset($_POST['host']) ? 5000 : 0;

    // Fetch pricing metadata for the chosen food plan
    $package_price = 0.00;
    if ($package_id > 0) {
        $p_res = $conn->query("SELECT BasePrice FROM CATERING_PACKAGE WHERE PackageID = $package_id");
        $package_data = $p_res->fetch_assoc();
        $package_price = $package_data ? $package_data['BasePrice'] : 0.00;
    }
$sound_price = isset($_POST['soundlight']) ? 10000 : 0;

$host_price = isset($_POST['host']) ? 5000 : 0;
    // Mathematical formula calculation
    $venue_price = $venue['BasePrice'];
    $total_budget =
    $venue_price +
    ($package_price * $guests) +
    $sound_price +
    $host_price;

    // SQL Step 1: Record main event logs in the BOOKING destination table
    $booking_sql = "INSERT INTO BOOKING (
    CustomerID,
    VenueID,
    EventStartDateTime,
    EventEndDateTime,
    EventType,
    ExpectedGuests,
    SoundLightPrice,
    HostPrice,
    TotalBudget,
    BookingStatus,
    CreatedDate
) VALUES (
    '$uid',
    '$venue_id',
    '$event_start',
    '$event_end',
    'Corporate Event',
    '$guests',
    '$sound_price',
    '$host_price',
    '$total_budget',
    'Pending',
    NOW()
)";

    if ($conn->query($booking_sql)) {
        $new_booking_id = $conn->insert_id;

        // SQL Step 2: Map the catering line item variables to your BOOKING_PACKAGE link table
        if ($package_id > 0) {
            $link_sql = "INSERT INTO BOOKING_PACKAGE (BookingID, PackageID, Quantity, PackagePrice, AddedDate) 
                         VALUES ('$new_booking_id', '$package_id', '$guests', '$package_price', NOW())";
            $conn->query($link_sql);
        }

        // Route the transaction over to the payment invoice gateway
        header("Location: Payment.php?booking_id=" . $new_booking_id);
        exit();
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Venue - Tagaytay Logistics</title>
    <style>

    body{
        font-family:'Segoe UI', sans-serif;
        padding:40px;
        background:#fff7f7;
        display:flex;
        justify-content:center;
    }

    .booking-container{
    background:white;
    padding:35px;
    border-radius:18px;
    box-shadow:0 5px 18px rgba(0,0,0,0.08);
    width:500px;
    border-top:5px solid #ff5a5f;
}

    h2{
        color:#222;
        margin-bottom:10px;
    }

    p{
        color:#555;
    }

    label{
        display:block;
        margin-top:15px;
        font-weight:bold;
        font-size:12px;
        color:#444;
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

    .btn{
    flex:2;
    background:#ff5a5f;
    color:white;
    border:none;
    padding:14px;
    border-radius:10px;
    font-weight:bold;
    cursor:pointer;
    transition:0.3s;
}

.btn:hover{
    background:#e0484d;
}

    .btn-submit:hover{
        background:#e0484d;
        transform:translateY(-2px);
    }

    hr{
        border:1px solid #f1f1f1;
        margin:20px 0;
    }
.button-group{
    display:flex;
    gap:10px;
    margin-top:20px;
}

.back-btn{
    flex:1;
    background:white;
    color:#ff5a5f;
    text-decoration:none;
    text-align:center;
    padding:14px;
    border-radius:10px;
    font-weight:bold;
    border:2px solid #ff5a5f;
    transition:0.3s;
}

.back-btn:hover{
    background:#ff5a5f;
    color:white;
}
</style>
</head>
<body>
    <div class="booking-container">
        <h2>Procurement Allocation</h2>
        <p><strong>Selected Venue:</strong> <?php echo htmlspecialchars($venue['VenueName']); ?></p>
        <p><strong>Venue Base Rate:</strong> ₱<?php echo number_format($venue['BasePrice'], 2); ?></p>
        <hr style="border:1px solid #f4f7f6; margin: 20px 0;">

        <form method="POST">
            <div style="display: flex; gap: 10px;">
    <div style="flex: 1;">
        <label>Start Date</label>
        <input type="date" name="event_start_date" required>
    </div>

    <div style="flex: 1;">
        <label>Start Time</label>
        <select name="event_start_time" required>
            <?php
            for($h = 0; $h < 24; $h++) {
                $time = sprintf("%02d:00", $h);
                $display = date("h:i A", strtotime($time));
                echo "<option value='$time'>$display</option>";
            }
            ?>
        </select>
    </div>
</div>

<div style="display:flex; gap:10px;">

    <div style="flex:1;">
        <label>End Date</label>
        <input type="date" name="event_end_date" required>
    </div>

    <div style="flex:1;">
        <label>End Time</label>
        <select name="event_end_time" required>
            <?php
            for($h = 0; $h < 24; $h++) {
                $time = sprintf("%02d:00", $h);
                $display = date("h:i A", strtotime($time));
                echo "<option value='$time'>$display</option>";
            }
            ?>
        </select>
    </div>

</div>

            <label>Expected Guests</label>
            <input type="number" name="guests" max="<?php echo $venue['Capacity']; ?>" required>

            <label>Catering Bundles Available at this Venue</label>
            <select name="package_id" required>
                <option value="0">No Catering / Venue Only (₱0.00)</option>
                <?php while($row = $catering_res->fetch_assoc()): ?>
                    <option value="<?php echo $row['PackageID']; ?>">
                        <?php echo htmlspecialchars($row['PackageName']); ?> (₱<?php echo number_format($row['BasePrice'], 2); ?>/head)
                    </option>
                <?php endwhile; ?>
            </select>
            <label>Sound & Light System</label>

<select name="soundlight_price" required>
    <option value="0">No Sound & Light System</option>
    <option value="10000">With Sound & Light System (+₱10,000)</option>
</select>
<label>Event Host</label>

<select name="host_price" required>
    <option value="0">No Host</option>
    <option value="5000">With Host (+₱5,000)</option>
</select>
    <div class="button-group">

    <a href="MainPage.php" class="back-btn">
        ← Back
    </a>

    <button type="submit" class="btn">
        Submit Reservation Request
    </button>

</div>
        </form>
    </div>
</body>
</html>