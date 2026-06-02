<?php
session_start();
include 'db_connect.php';

// CHECK LOGIN
if (!isset($_SESSION['uid'])) {
    header("Location: LoginPage.php");
    exit();
}

// ADD VENUE
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

    </style>

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

</div>

</body>
</html>