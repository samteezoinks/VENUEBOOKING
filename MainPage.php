<?php
session_start();
include 'db_connect.php';

$user = isset($_SESSION['uname']) ? $_SESSION['uname'] : "Guest";

/* =========================
   FILTER QUERY
========================= */

$type_filter = "";

if(isset($_GET['type'])){

    $type = $_GET['type'];
    $type_filter = " WHERE v.Description LIKE '%$type%'";
}

/* =========================
   VENUE + AMENITIES JOIN
========================= */

$sql = "
SELECT 
    v.*,
    GROUP_CONCAT(a.AmenityName SEPARATOR ', ') AS Amenities
FROM venue v
LEFT JOIN venue_amenity va 
    ON v.VenueID = va.VenueID
LEFT JOIN amenity a 
    ON va.AmenityID = a.AmenityID
$type_filter
GROUP BY v.VenueID
";

$res = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Tagsbnb</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Segoe UI', sans-serif;
            background:#fff7f7;
            color:#333;
        }

        /* HEADER */

        header{
            background:white;
            padding:15px 5%;
            display:flex;
            justify-content:space-between;
            align-items:center;
            border-bottom:3px solid #ff5a5f;
            box-shadow:0 3px 10px rgba(0,0,0,0.05);
        }

        .logo-area{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .logo-area img{
            width:50px;
            height:50px;
            object-fit:contain;
        }

        .logo-title{
            font-size:30px;
            font-weight:800;
            color:#222;
        }

        .logo-title span{
            color:#ff5a5f;
        }

        /* TOP ACTIONS */

        .top-actions{
            display:flex;
            align-items:center;
            gap:12px;
        }

        .welcome{
            color:#555;
            font-weight:600;
        }

        .top-btn{
            padding:10px 16px;
            border-radius:8px;
            text-decoration:none;
            color:white;
            font-size:14px;
            font-weight:bold;
            transition:0.3s;
        }

        .booking-btn{
            background:#ff5a5f;
        }

        .booking-btn:hover{
            background:#e0484d;
        }

        .logout-btn{
            background:#333;
        }

        .logout-btn:hover{
            background:#111;
        }

        /* MAIN */

        .container{
            display:flex;
            gap:25px;
            padding:25px 5%;
        }

        /* SIDEBAR */

        .sidebar{
            width:240px;
            background:white;
            padding:20px;
            border-radius:15px;
            height:fit-content;
            box-shadow:0 5px 15px rgba(0,0,0,0.06);
        }

        .sidebar h4{
            color:#ff5a5f;
            margin-bottom:20px;
            font-size:20px;
        }

        .sidebar a{
            display:block;
            padding:12px;
            margin-bottom:10px;
            text-decoration:none;
            color:#444;
            font-weight:600;
            border-radius:8px;
            transition:0.3s;
        }

        .sidebar a:hover{
            background:#fff0f0;
            color:#ff5a5f;
        }

        /* VENUE GRID */

        .venue-grid{
            display:grid;
            grid-template-columns:repeat(auto-fill, minmax(320px, 1fr));
            gap:25px;
            width:100%;
        }

        .venue-card{
            background:white;
            border-radius:18px;
            overflow:hidden;
            box-shadow:0 5px 18px rgba(0,0,0,0.08);
            transition:0.4s;
        }

        .venue-card:hover{
            transform:translateY(-8px);
            box-shadow:0 15px 30px rgba(0,0,0,0.12);
        }

        .venue-card img{
            width:100%;
            height:220px;
            object-fit:cover;
        }

        .p-15{
            padding:18px;
        }

        .p-15 h3{
            margin-bottom:8px;
            color:#222;
            font-size:24px;
        }

        .location{
            color:#888;
            font-size:14px;
            margin-bottom:12px;
        }

        .capacity{
            font-size:14px;
            margin-bottom:12px;
        }

        .details{
            margin-bottom:8px;
            font-size:14px;
        }

        .price{
            color:#ff5a5f;
            font-size:1.8rem;
            font-weight:800;
            display:block;
            margin:15px 0;
        }

        .btn{
            display:inline-block;
            width:100%;
            background:#ff5a5f;
            color:white;
            padding:14px;
            text-decoration:none;
            border-radius:10px;
            text-align:center;
            font-size:13px;
            font-weight:bold;
            text-transform:uppercase;
            transition:0.3s;
        }

        .btn:hover{
            background:#e0484d;
        }

        .no-data{
            font-size:18px;
            color:#777;
        }

    </style>

</head>

<body>

<header>

    <div class="logo-area">

    <img src="images/bnb.png" alt="Tagsbnb Logo">

    <h2 class="logo-title">
        Tags<span>bnb</span>
    </h2>

</div>

    <div class="top-actions">

        <a href="MyBookings.php" class="top-btn booking-btn">
            My Bookings
        </a>

        <span class="welcome">
            Welcome, <?php echo htmlspecialchars($user); ?>
        </span>

        <a href="logout.php" class="top-btn logout-btn">
            Logout
        </a>

    </div>

</header>

<div class="container">

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <h4>Filter Category</h4>

        <a href="MainPage.php">All Venues</a>
        <a href="?type=Garden">Garden Venues</a>
        <a href="?type=Hotel">Hotel Venues</a>
        <a href="?type=Resort">Resort Venues</a>
        <a href="?type=Events">Events Place</a>

    </aside>

    <!-- VENUE LIST -->

    <main class="venue-grid">

        <?php

        if($res->num_rows > 0){

            while($v = $res->fetch_assoc()){

                switch($v['VenueName']) {

                    case 'Tagaytay Highlands':
                        $image = 'images/highlands.jpg';
                        break;

                    case 'Nurture Wellness Village':
                        $image = 'images/nurture.jpg';
                        break;

                    case 'Villa Ibarra':
                        $image = 'images/villaibarra.jpg';
                        break;

                    case 'The Lake Hotel':
                        $image = 'images/lakehotel.jpg';
                        break;

                    case 'Hillcreek Gardens':
                        $image = 'images/hillcreek.jpg';
                        break;

                    case 'Taal Vista Hotel':
                        $image = 'images/taalvista.jpg';
                        break;

                    case 'Splendido Resort':
                        $image = 'images/splendido.jpg';
                        break;

                    case 'Sonya Garden':
                        $image = 'images/sonyagarden.jpg';
                        break;

                    case 'Narra Hill':
                        $image = 'images/narra.jpg';
                        break;

                    default:
                        $image = 'images/default.jpg';
                }

                ?>

                <div class="venue-card">

                    <img src="<?php echo $image; ?>" alt="Venue Image">

                    <div class="p-15">

                        <h3><?php echo $v['VenueName']; ?></h3>

                        <p class="location">
                            <?php echo $v['Location']; ?>
                        </p>

                        <p class="capacity">
                            Capacity: <b><?php echo $v['Capacity']; ?></b>
                        </p>

                        <p class="details">
                            <b>Catering:</b>
                            <?php echo $v['CateringAvailable']; ?>
                        </p>

                        <p class="details">
                            <b>Sound & Light:</b>
                            <?php echo $v['SoundLightSystem']; ?>
                        </p>

                        <p class="details">
                            <b>Amenities:</b><br>
                            <?php echo $v['Amenities'] ? $v['Amenities'] : 'No amenities listed'; ?>
                        </p>

                        <span class="price">
                            ₱<?php echo number_format($v['BasePrice'], 2); ?>
                        </span>

                        <a href="BookingForm.php?id=<?php echo $v['VenueID']; ?>" class="btn">
                            Book Now
                        </a>

                    </div>

                </div>

                <?php
            }

        } else {

            echo "<p class='no-data'>No venues found.</p>";
        }

        ?>

    </main>

</div>

</body>
</html>