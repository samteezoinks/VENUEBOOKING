<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['uid'])) {
    header("Location: LoginPage.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_venue'])) {

    $name = $_POST['vname'];
    $type = $_POST['vtype'];
    $loc = $_POST['vloc'];
    $city = "Tagaytay";
    $cap = $_POST['vcap'];
    $price = $_POST['vprice'];
    $desc = $_POST['vdesc'];

    $catering = $_POST['catering'];
    $soundlight = $_POST['soundlight'];
    $amenities = $_POST['amenities'];

    $sql = "INSERT INTO venue
    (
        VenueName,
        VenueType,
        Location,
        City,
        Capacity,
        BasePrice,
        Description,
        CateringAvailable,
        SoundLightSystem,
        Amenities,
        CreatedDate
    )
    VALUES
    (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param(
        "ssssidssss",
        $name,
        $type,
        $loc,
        $city,
        $cap,
        $price,
        $desc,
        $catering,
        $soundlight,
        $amenities
    );

    $stmt->execute();
}

// FETCH VENUES
$venues = $conn->query("SELECT * FROM venue");

// FETCH BOOKINGS
$bookings = $conn->query("
SELECT b.*, v.VenueName
FROM booking b
JOIN venue v ON b.VenueID = v.VenueID
ORDER BY b.BookingID DESC
");
?>
<?php

// BOOKINGS PER VENUE
$venueChart = $conn->query("
SELECT v.VenueName, COUNT(b.BookingID) AS TotalBookings
FROM venue v
LEFT JOIN booking b ON v.VenueID = b.VenueID
GROUP BY v.VenueID
");

$venueNames = [];
$bookingCounts = [];

while($row = $venueChart->fetch_assoc()){
    $venueNames[] = $row['VenueName'];
    $bookingCounts[] = $row['TotalBookings'];
}

// STATUS COUNTS
$statusChart = $conn->query("
SELECT BookingStatus, COUNT(*) AS Total
FROM booking
GROUP BY BookingStatus
");

$statusLabels = [];
$statusTotals = [];

while($row = $statusChart->fetch_assoc()){
    $statusLabels[] = $row['BookingStatus'];
    $statusTotals[] = $row['Total'];
}

// MONTHLY REVENUE
$revenueChart = $conn->query("
SELECT
DATE_FORMAT(PaidDate,'%b') AS Month,
SUM(Amount) AS Revenue
FROM payment
WHERE PaymentStatus='Paid'
GROUP BY MONTH(PaidDate)
ORDER BY MONTH(PaidDate)
");

$months = [];
$revenues = [];

while($row = $revenueChart->fetch_assoc()){
    $months[] = $row['Month'];
    $revenues[] = $row['Revenue'];
}

?>
<!DOCTYPE html>
<html>

<head>

    <title>Admin Panel</title>

    <style>

        body{
            font-family:'Segoe UI', sans-serif;
            background:#fff7f7;
            padding:30px;
            margin:0;
        }

        .admin-container{
            max-width:1200px;
            margin:auto;
            background:white;
            padding:35px;
            border-radius:18px;
            box-shadow:0 5px 18px rgba(0,0,0,0.08);
        }

        h1{
            color:#ff5a5f;
            margin-bottom:30px;
        }

        h2{
            margin-top:50px;
            color:#333;
        }

        .form-group{
            display:grid;
            grid-template-columns:1fr 1fr;
            gap:15px;
            margin-bottom:20px;
        }

        input,
        textarea,
        select{
            padding:12px;
            border:1px solid #ddd;
            border-radius:10px;
            font-size:15px;
            width:100%;
            box-sizing:border-box;
        }

        input:focus,
        textarea:focus,
        select:focus{
            outline:none;
            border-color:#ff5a5f;
            box-shadow:0 0 5px rgba(255,90,95,0.3);
        }

        textarea{
            min-height:90px;
        }

        .btn{
            background:#ff5a5f;
            color:white;
            border:none;
            padding:15px;
            border-radius:10px;
            cursor:pointer;
            font-size:16px;
            font-weight:bold;
            grid-column:span 2;
            transition:0.3s;
        }

        .btn:hover{
            background:#e0484d;
            transform:translateY(-2px);
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:20px;
            background:white;
            border-radius:15px;
            overflow:hidden;
        }

        th,
        td{
            padding:15px;
            border-bottom:1px solid #eee;
            text-align:left;
        }

        th{
            background:#ff5a5f;
            color:white;
        }

        tr:hover{
            background:#fff2f2;
        }

        .charts{
    display:grid;
    grid-template-columns:1fr 1fr;
    gap:20px;
    margin-top:30px;
}

.chart-card{
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 4px 10px rgba(0,0,0,.08);
}

.chart-card.full{
    grid-column:span 2;
}

canvas{
    width:100% !important;
    height:350px !important;
}

    </style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

<div class="admin-container">

    <h1>Admin Panel</h1>

    <form method="POST">

        <div class="form-group">

            <input type="text" name="vname" placeholder="Venue Name" required>

            <select name="vtype" required>
                <option value="Garden">Garden</option>
                <option value="Hotel">Hotel</option>
                <option value="Resort">Resort</option>
                <option value="Events">Events Place</option>
            </select>

            <input type="text" name="vloc" placeholder="Location" required>

            <input type="number" name="vcap" placeholder="Capacity" required>

            <input type="number" step="0.01" name="vprice" placeholder="Base Price" required>

            <select name="catering">
                <option value="Yes">Catering Available</option>
                <option value="No">No Catering</option>
            </select>

            <select name="soundlight">
                <option value="Yes">With Sound & Light System</option>
                <option value="No">No Sound & Light System</option>
            </select>

            <textarea name="amenities" placeholder="Amenities (WiFi, Parking, Pool, Aircon, etc.)"></textarea>

            <textarea name="vdesc" placeholder="Venue Description"></textarea>

            <button type="submit" name="add_venue" class="btn">
                Add Venue
            </button>

        </div>

    </form>

    <h2>Current Venues</h2>

    <table>

        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Type</th>
            <th>Price</th>
            <th>Catering</th>
            <th>Sound & Light</th>
        </tr>

        <?php while($v = $venues->fetch_assoc()): ?>

        <tr>

            <td><?php echo $v['VenueID']; ?></td>

            <td><?php echo $v['VenueName']; ?></td>

            <td><?php echo $v['VenueType']; ?></td>

            <td>
                ₱<?php echo number_format($v['BasePrice'],2); ?>
            </td>

            <td><?php echo $v['CateringAvailable']; ?></td>

            <td><?php echo $v['SoundLightSystem']; ?></td>


        </tr>

        <?php endwhile; ?>

    </table>

    <h2>Manage Bookings</h2>

    <table>

        <tr>
            <th>Booking ID</th>
            <th>Venue</th>
            <th>Guests</th>
            <th>Total Budget</th>
            <th>Status</th>
        </tr>

        <?php while($b = $bookings->fetch_assoc()): ?>

        <tr>

            <td><?php echo $b['BookingID']; ?></td>

            <td><?php echo $b['VenueName']; ?></td>

            <td><?php echo $b['ExpectedGuests']; ?></td>

            <td>
                ₱<?php echo number_format($b['TotalBudget'],2); ?>
            </td>

            <td><?php echo $b['BookingStatus']; ?></td>

        </tr>

        <?php endwhile; ?>

    </table>
<h2>Analytics Dashboard</h2>

<div class="charts">

    <div class="chart-card">
        <h3>Bookings Per Venue</h3>
        <canvas id="venueChart"></canvas>
    </div>

    <div class="chart-card">
        <h3>Booking Status</h3>
        <canvas id="statusChart"></canvas>
    </div>

    <div class="chart-card full">
        <h3>Monthly Revenue</h3>
        <canvas id="revenueChart"></canvas>
    </div>

</div>
</div>
<script>

// BOOKINGS PER VENUE
new Chart(document.getElementById('venueChart'), {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($venueNames); ?>,
        datasets: [{
            label: 'Bookings',
            data: <?php echo json_encode($bookingCounts); ?>,
            backgroundColor: '#ff5a5f'
        }]
    }
});

// STATUS PIE
new Chart(document.getElementById('statusChart'), {
    type: 'pie',
    data: {
        labels: <?php echo json_encode($statusLabels); ?>,
        datasets: [{
            data: <?php echo json_encode($statusTotals); ?>,
            backgroundColor: [
                '#ff5a5f',
                '#4CAF50',
                '#FFC107',
                '#2196F3'
            ]
        }]
    }
});

// MONTHLY REVENUE
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: <?php echo json_encode($months); ?>,
        datasets: [{
            label: 'Revenue (₱)',
            data: <?php echo json_encode($revenues); ?>,
            borderColor: '#ff5a5f',
            fill: false,
            tension: 0.3
        }]
    }
});

</script>
</body>
</html>