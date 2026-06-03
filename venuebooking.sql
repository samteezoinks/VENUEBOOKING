-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2026 at 09:56 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `venuebooking`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenity`
--

CREATE TABLE `amenity` (
  `AmenityID` int(11) NOT NULL,
  `AmenityName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `amenity`
--

INSERT INTO `amenity` (`AmenityID`, `AmenityName`, `Description`) VALUES
(1, 'Swimming Pool', 'Large outdoor infinity pool'),
(2, 'Parking Area', 'Free parking for guests'),
(3, 'WiFi', 'Free high-speed internet'),
(4, 'Garden View', 'Beautiful garden scenery'),
(5, 'Airconditioned Hall', 'Fully airconditioned function hall'),
(6, 'Buffet Area', 'Spacious buffet setup'),
(7, 'Wedding Area', 'Dedicated wedding ceremony area'),
(8, 'Sound & Light System', 'Professional lights and speakers'),
(9, 'Event Host', 'Professional event host');

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `BookingID` int(11) NOT NULL,
  `CustomerID` int(11) DEFAULT NULL,
  `VenueID` int(11) DEFAULT NULL,
  `EventStartDateTime` datetime DEFAULT NULL,
  `EventEndDateTime` datetime DEFAULT NULL,
  `EventType` varchar(100) DEFAULT NULL,
  `ExpectedGuests` int(11) DEFAULT NULL,
  `TotalBudget` decimal(10,2) DEFAULT NULL,
  `BookingStatus` varchar(100) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `LastUpdated` datetime DEFAULT NULL,
  `SoundLightPrice` decimal(10,2) DEFAULT 0.00,
  `HostPrice` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`BookingID`, `CustomerID`, `VenueID`, `EventStartDateTime`, `EventEndDateTime`, `EventType`, `ExpectedGuests`, `TotalBudget`, `BookingStatus`, `CreatedDate`, `LastUpdated`, `SoundLightPrice`, `HostPrice`) VALUES
(9, 5, 2, '2026-05-25 13:00:00', '2026-05-25 21:00:00', 'Corporate Event', 300, 245000.00, 'Confirmed', '2026-05-25 15:58:40', NULL, 10000.00, 5000.00),
(10, 5, 2, '2026-05-26 16:00:00', '2026-05-26 22:00:00', 'Corporate Event', 300, 50000.00, 'Pending', '2026-05-25 16:07:41', NULL, 10000.00, 5000.00),
(11, 5, 2, '2026-05-26 16:00:00', '2026-05-26 22:00:00', 'Corporate Event', 300, 50000.00, 'Confirmed', '2026-05-25 16:10:04', NULL, 10000.00, 5000.00),
(12, 5, 3, '2026-05-25 19:00:00', '2026-05-25 20:00:00', 'Corporate Event', 100, 120000.00, 'Pending', '2026-05-25 16:11:42', NULL, 10000.00, 5000.00),
(13, 5, 3, '2026-05-25 19:00:00', '2026-05-25 20:00:00', 'Corporate Event', 100, 120000.00, 'Confirmed', '2026-05-25 16:22:47', NULL, 10000.00, 5000.00),
(14, 5, 2, '2026-06-03 16:30:00', '2026-06-03 21:30:00', 'Corporate Event', 300, 245000.00, 'Confirmed', '2026-05-25 16:34:28', NULL, 10000.00, 5000.00),
(15, 5, 2, '2026-05-30 13:00:00', '2026-05-30 20:00:00', 'Corporate Event', 300, 245000.00, 'Confirmed', '2026-05-29 13:00:44', NULL, 0.00, 0.00),
(16, 5, 2, '2026-05-29 13:00:00', '2026-05-29 20:00:00', 'Corporate Event', 300, 245000.00, 'Confirmed', '2026-05-29 14:32:49', NULL, 0.00, 0.00),
(17, 5, 3, '2026-06-02 14:00:00', '2026-06-02 19:00:00', 'Corporate Event', 100, 120000.00, 'Confirmed', '2026-06-02 14:42:51', NULL, 0.00, 0.00),
(18, 5, 2, '2026-06-02 15:00:00', '2026-07-09 20:00:00', 'Corporate Event', 300, 245000.00, 'Confirmed', '2026-06-02 15:06:05', NULL, 0.00, 0.00),
(19, 5, 3, '2026-06-25 13:00:00', '2026-06-25 19:00:00', 'Corporate Event', 150, 95000.00, 'Confirmed', '2026-06-02 16:48:59', NULL, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `booking_package`
--

CREATE TABLE `booking_package` (
  `BookingPackageID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `PackageID` int(11) DEFAULT NULL,
  `PackagePrice` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `AddedDate` datetime DEFAULT NULL,
  `SoundLightPrice` decimal(10,2) DEFAULT 0.00,
  `HostPrice` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking_package`
--

INSERT INTO `booking_package` (`BookingPackageID`, `BookingID`, `PackageID`, `PackagePrice`, `Quantity`, `AddedDate`, `SoundLightPrice`, `HostPrice`) VALUES
(3, 13, 4, 850.00, 100, '2026-05-25 16:22:47', 0.00, 0.00),
(4, 14, 3, 650.00, 300, '2026-05-25 16:34:28', 0.00, 0.00),
(5, 15, 3, 650.00, 300, '2026-05-29 13:00:44', 0.00, 0.00),
(6, 16, 3, 650.00, 300, '2026-05-29 14:32:49', 0.00, 0.00),
(7, 17, 4, 850.00, 100, '2026-06-02 14:42:51', 0.00, 0.00),
(8, 18, 3, 650.00, 300, '2026-06-02 15:06:05', 0.00, 0.00),
(9, 19, 5, 400.00, 150, '2026-06-02 16:48:59', 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `catering_category`
--

CREATE TABLE `catering_category` (
  `CategoryID` int(11) NOT NULL,
  `CategoryName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catering_item`
--

CREATE TABLE `catering_item` (
  `ItemID` int(11) NOT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `ItemName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `CuisineType` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `catering_package`
--

CREATE TABLE `catering_package` (
  `PackageID` int(11) NOT NULL,
  `VenueID` int(11) DEFAULT NULL,
  `PackageName` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `BasePrice` decimal(10,2) DEFAULT NULL,
  `PackageType` varchar(100) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `catering_package`
--

INSERT INTO `catering_package` (`PackageID`, `VenueID`, `PackageName`, `Description`, `BasePrice`, `PackageType`, `CreatedDate`) VALUES
(1, 1, 'Highlands Premium Buffet', '5-course international buffet with premium carving station.', 1200.00, 'Food & Beverage', NULL),
(2, 1, 'Highlands Cocktail Hour', 'Heavy hors d\'oeuvres and open bar service.', 750.00, 'Beverage', NULL),
(3, 2, 'Organic Wellness Platter', 'Farm-to-table organic buffet with healthy infusion drinks.', 650.00, 'Food & Beverage', NULL),
(4, 3, 'Ibarra Classic Buffet', 'Traditional Filipino-Spanish fusion wedding buffet menu.', 850.00, 'Food & Beverage', NULL),
(5, 3, 'Intimate High Tea', 'Mid-afternoon tea set with artisan pastries.', 400.00, 'Snacks', NULL),
(6, 4, 'Lakeview Corporate Lunch', 'Plated executive lunch boxes with bottomless iced tea.', 500.00, 'Food & Beverage', NULL),
(7, 5, 'Garden Gala Buffet', 'Rustic outdoor buffet setup with complete table arrangements.', 900.00, 'Food & Beverage', NULL),
(8, 6, 'Taal Heritage Grand Feast', 'Premium local heritage menu featuring gourmet Bulalo.', 1500.00, 'Food & Beverage', NULL),
(9, 6, 'Summit Coffee Break', 'Am/Pm snacks with overflowing local Kapeng Barako.', 350.00, 'Snacks', NULL),
(10, 7, 'Splendido Fairway Buffet', 'Hearty golf club buffet designed for corporate tournaments.', 800.00, 'Food & Beverage', NULL),
(11, 8, 'Sonya Signature Organic Menu', 'Famous eat-all-you-can organic salad and signature pastas.', 783.00, 'Food & Beverage', NULL),
(12, 9, 'Narra Hill Pavilion Dinner', 'Boutique dinner menu with premium ambient setup.', 1100.00, 'Food & Beverage', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `CustomerID` int(11) NOT NULL,
  `CompanyName` varchar(255) DEFAULT NULL,
  `ContactPerson` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Phone` varchar(50) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `PostalCode` varchar(20) DEFAULT NULL,
  `RegistrationDate` datetime DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`CustomerID`, `CompanyName`, `ContactPerson`, `Email`, `Phone`, `Address`, `City`, `PostalCode`, `RegistrationDate`, `Password`) VALUES
(5, NULL, 'Testing', 'test@email.com', '09123456789', NULL, NULL, NULL, NULL, '$2y$10$f93Qra8DtKIK2IE1tHH3quwEIJkVbZHlFLInxctUMuc1H6UphYRa2');

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `InvoiceID` int(11) NOT NULL,
  `BookingID` int(11) NOT NULL,
  `InvoiceDate` datetime DEFAULT current_timestamp(),
  `TotalAmount` decimal(10,2) DEFAULT NULL,
  `PaymentStatus` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`InvoiceID`, `BookingID`, `InvoiceDate`, `TotalAmount`, `PaymentStatus`) VALUES
(1, 17, '2026-06-02 14:43:22', 120000.00, 'Paid'),
(2, 17, '2026-06-02 14:46:38', 120000.00, 'Paid'),
(3, 18, '2026-06-02 15:06:12', 245000.00, 'Paid'),
(4, 19, '2026-06-02 16:50:02', 95000.00, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `PaymentID` int(11) NOT NULL,
  `BookingID` int(11) DEFAULT NULL,
  `Amount` decimal(10,2) DEFAULT NULL,
  `DueDate` datetime DEFAULT NULL,
  `PaidDate` datetime DEFAULT NULL,
  `PaymentStatus` varchar(100) DEFAULT NULL,
  `PaymentMethod` varchar(100) DEFAULT NULL,
  `TransactionID` varchar(255) DEFAULT NULL,
  `FullName` varchar(100) DEFAULT NULL,
  `CardNumber` varchar(30) DEFAULT NULL,
  `ExpiryDate` varchar(10) DEFAULT NULL,
  `CVV` varchar(10) DEFAULT NULL,
  `GCashNumber` varchar(20) DEFAULT NULL,
  `BankAccountNumber` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`PaymentID`, `BookingID`, `Amount`, `DueDate`, `PaidDate`, `PaymentStatus`, `PaymentMethod`, `TransactionID`, `FullName`, `CardNumber`, `ExpiryDate`, `CVV`, `GCashNumber`, `BankAccountNumber`) VALUES
(10, 13, 120000.00, NULL, '2026-05-25 16:23:00', 'Paid', 'GCash', NULL, 'Samuel David Briones Pebres', '', '', '', '09111111111', ''),
(11, 14, 245000.00, NULL, '2026-05-25 16:35:37', 'Paid', 'GCash', NULL, 'Samuel David Briones Pebres', '', '', '', '123123123123', ''),
(12, 15, 245000.00, NULL, '2026-05-29 13:01:03', 'Paid', 'GCash', NULL, 'Samuel David Briones Pebres', '', '', '', '09123123123', ''),
(13, 16, 245000.00, NULL, '2026-05-29 14:33:30', 'Paid', 'Bank Transfer', NULL, 'Samuel David Briones Pebres', '', '', '', '', '123456789'),
(14, 17, 120000.00, NULL, '2026-06-02 14:43:22', 'Paid', 'Credit Card', NULL, 'Samuel David Briones Pebres', '123123123123123', '09/29', '589', '', ''),
(15, 17, 120000.00, NULL, '2026-06-02 14:46:38', 'Paid', 'Credit Card', NULL, 'Samuel David Briones Pebres', '123123123123123', '09/29', '582', '', ''),
(16, 18, 245000.00, NULL, '2026-06-02 15:06:12', 'Paid', 'Credit Card', NULL, 'Samuel David Briones Pebres', '123123123123123', '09/29', '582', '', ''),
(17, 19, 95000.00, NULL, '2026-06-02 16:50:02', 'Paid', 'Credit Card', NULL, 'Samuel David Briones Pebres', '123123123123123', '09/29', '582', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `venue`
--

CREATE TABLE `venue` (
  `VenueID` int(11) NOT NULL,
  `VenueName` varchar(255) DEFAULT NULL,
  `Location` varchar(255) DEFAULT NULL,
  `City` varchar(100) DEFAULT NULL,
  `Capacity` decimal(10,2) DEFAULT NULL,
  `BasePrice` decimal(10,2) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `ContactPerson` varchar(255) DEFAULT NULL,
  `ContactPhone` varchar(50) DEFAULT NULL,
  `CreatedDate` datetime DEFAULT NULL,
  `VenueType` varchar(100) DEFAULT NULL,
  `VenueImage` varchar(255) DEFAULT NULL,
  `CateringAvailable` varchar(10) DEFAULT 'Yes',
  `SoundLightSystem` varchar(10) DEFAULT 'Yes'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue`
--

INSERT INTO `venue` (`VenueID`, `VenueName`, `Location`, `City`, `Capacity`, `BasePrice`, `Description`, `ContactPerson`, `ContactPhone`, `CreatedDate`, `VenueType`, `VenueImage`, `CateringAvailable`, `SoundLightSystem`) VALUES
(2, 'Tagaytay Highlands', 'Tagaytay City', NULL, 300.00, 50000.00, 'Hotel', NULL, NULL, NULL, 'Hotel', NULL, 'Yes', 'Yes'),
(3, 'Nurture Wellness Village', 'Tagaytay City', NULL, 150.00, 35000.00, 'Garden', NULL, NULL, NULL, 'Garden', NULL, 'Yes', 'Yes'),
(4, 'Villa Ibarra', 'Tagaytay City', NULL, 250.00, 45000.00, 'Events', NULL, NULL, NULL, 'Events', NULL, 'Yes', 'Yes'),
(5, 'The Lake Hotel', 'Tagaytay City', NULL, 200.00, 40000.00, 'Hotel', NULL, NULL, NULL, 'Hotel', NULL, 'Yes', 'Yes'),
(6, 'Hillcreek Gardens', 'Tagaytay City', NULL, 180.00, 38000.00, 'Garden', NULL, NULL, NULL, 'Garden', NULL, 'Yes', 'Yes'),
(7, 'Taal Vista Hotel', 'Tagaytay City', NULL, 500.00, 75000.00, 'Hotel', NULL, NULL, NULL, 'Hotel', NULL, 'Yes', 'Yes'),
(8, 'Splendido Resort', 'Tagaytay City', NULL, 220.00, 42000.00, 'Resort', NULL, NULL, NULL, 'Resort', NULL, 'Yes', 'Yes'),
(9, 'Sonya Garden', 'Tagaytay City', NULL, 120.00, 30000.00, 'Garden', NULL, NULL, NULL, 'Garden', NULL, 'Yes', 'Yes'),
(13, 'Narra Hill', 'Tagaytay-Nasugbu Hwy', 'Tagaytay', 150.00, 50000.00, 'A beautiful glass house with overlooking Taal view.', NULL, NULL, '2026-05-22 10:40:14', 'Garden', 'narra.jpg', 'Yes', 'Yes');

-- --------------------------------------------------------

--
-- Table structure for table `venue_amenity`
--

CREATE TABLE `venue_amenity` (
  `VenueAmenityID` int(11) NOT NULL,
  `VenueID` int(11) DEFAULT NULL,
  `AmenityID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `venue_amenity`
--

INSERT INTO `venue_amenity` (`VenueAmenityID`, `VenueID`, `AmenityID`) VALUES
(139, 2, 1),
(140, 2, 2),
(141, 2, 3),
(142, 2, 8),
(143, 3, 3),
(144, 3, 4),
(145, 3, 5),
(146, 4, 2),
(147, 4, 5),
(148, 4, 6),
(149, 4, 9),
(150, 5, 1),
(151, 5, 2),
(152, 5, 3),
(153, 6, 4),
(154, 6, 7),
(155, 7, 1),
(156, 7, 2),
(157, 7, 5),
(158, 7, 8),
(159, 8, 1),
(160, 8, 3),
(161, 9, 4),
(162, 9, 6),
(163, 9, 7),
(164, 13, 4),
(165, 13, 7),
(166, 13, 8),
(167, 13, 9);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `amenity`
--
ALTER TABLE `amenity`
  ADD PRIMARY KEY (`AmenityID`);

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`BookingID`),
  ADD KEY `FK_Booking_Customer` (`CustomerID`),
  ADD KEY `FK_Booking_Venue` (`VenueID`);

--
-- Indexes for table `booking_package`
--
ALTER TABLE `booking_package`
  ADD PRIMARY KEY (`BookingPackageID`),
  ADD KEY `FK_BookingPackage_Booking` (`BookingID`),
  ADD KEY `FK_BookingPackage_Package` (`PackageID`);

--
-- Indexes for table `catering_category`
--
ALTER TABLE `catering_category`
  ADD PRIMARY KEY (`CategoryID`);

--
-- Indexes for table `catering_item`
--
ALTER TABLE `catering_item`
  ADD PRIMARY KEY (`ItemID`),
  ADD KEY `FK_CateringItem_Category` (`CategoryID`);

--
-- Indexes for table `catering_package`
--
ALTER TABLE `catering_package`
  ADD PRIMARY KEY (`PackageID`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`InvoiceID`),
  ADD KEY `BookingID` (`BookingID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `FK_Payment_Booking` (`BookingID`);

--
-- Indexes for table `venue`
--
ALTER TABLE `venue`
  ADD PRIMARY KEY (`VenueID`),
  ADD UNIQUE KEY `unique_venue_name` (`VenueName`);

--
-- Indexes for table `venue_amenity`
--
ALTER TABLE `venue_amenity`
  ADD PRIMARY KEY (`VenueAmenityID`),
  ADD KEY `FK_VenueAmenity_Venue` (`VenueID`),
  ADD KEY `FK_VenueAmenity_Amenity` (`AmenityID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `amenity`
--
ALTER TABLE `amenity`
  MODIFY `AmenityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `BookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `booking_package`
--
ALTER TABLE `booking_package`
  MODIFY `BookingPackageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `catering_category`
--
ALTER TABLE `catering_category`
  MODIFY `CategoryID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catering_item`
--
ALTER TABLE `catering_item`
  MODIFY `ItemID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `catering_package`
--
ALTER TABLE `catering_package`
  MODIFY `PackageID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `InvoiceID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `venue`
--
ALTER TABLE `venue`
  MODIFY `VenueID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `venue_amenity`
--
ALTER TABLE `venue_amenity`
  MODIFY `VenueAmenityID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=168;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `FK_Booking_Customer` FOREIGN KEY (`CustomerID`) REFERENCES `customer` (`CustomerID`),
  ADD CONSTRAINT `FK_Booking_Venue` FOREIGN KEY (`VenueID`) REFERENCES `venue` (`VenueID`);

--
-- Constraints for table `booking_package`
--
ALTER TABLE `booking_package`
  ADD CONSTRAINT `FK_BookingPackage_Booking` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`),
  ADD CONSTRAINT `FK_BookingPackage_Package` FOREIGN KEY (`PackageID`) REFERENCES `catering_package` (`PackageID`);

--
-- Constraints for table `catering_item`
--
ALTER TABLE `catering_item`
  ADD CONSTRAINT `FK_CateringItem_Category` FOREIGN KEY (`CategoryID`) REFERENCES `catering_category` (`CategoryID`);

--
-- Constraints for table `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `FK_Payment_Booking` FOREIGN KEY (`BookingID`) REFERENCES `booking` (`BookingID`);

--
-- Constraints for table `venue_amenity`
--
ALTER TABLE `venue_amenity`
  ADD CONSTRAINT `FK_VenueAmenity_Amenity` FOREIGN KEY (`AmenityID`) REFERENCES `amenity` (`AmenityID`),
  ADD CONSTRAINT `FK_VenueAmenity_Venue` FOREIGN KEY (`VenueID`) REFERENCES `venue` (`VenueID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
