-- phpMyAdmin SQL Dump
-- version 4.1.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Aug 13, 2019 at 07:52 AM
-- Server version: 5.6.16
-- PHP Version: 5.5.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `librarymanagementsystemdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE IF NOT EXISTS `borrow` (
  `BorrowID` varchar(30) NOT NULL DEFAULT '',
  `MemberID` varchar(30) NOT NULL,
  `BorrowDate` varchar(20) NOT NULL,
  `TotalBookQty` int(11) NOT NULL,
  PRIMARY KEY (`BorrowID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`BorrowID`, `MemberID`, `BorrowDate`, `TotalBookQty`) VALUES
('BO-000001', 'M-000001', '2019-07-28', 2),
('BO-000002', 'M-000001', '2019-07-28', 1);

-- --------------------------------------------------------

--
-- Table structure for table `borrowdetail`
--

CREATE TABLE IF NOT EXISTS `borrowdetail` (
  `BorrowDetailID` varchar(30) NOT NULL,
  `ProductID` varchar(30) NOT NULL,
  `BorrowID` varchar(30) NOT NULL,
  `ReturnDate` varchar(30) NOT NULL,
  `DueDate` int(11) NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `Status` varchar(30) NOT NULL,
  PRIMARY KEY (`BorrowDetailID`),
  KEY `BorrowDetailID` (`BorrowDetailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `borrowdetail`
--

INSERT INTO `borrowdetail` (`BorrowDetailID`, `ProductID`, `BorrowID`, `ReturnDate`, `DueDate`, `TotalAmount`, `Status`) VALUES
('BD_000001', 'P-000001', 'BO-000001', '2019-07-26', 2, 2000, 'Returned'),
('BD_000002', 'P-000004', 'BO-000001', '2019-07-26', 2, 2000, 'Returned'),
('BD_000003', 'P-000002', 'BO-000002', '2019-07-31', 0, 0, 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `CategoryID` int(11) NOT NULL AUTO_INCREMENT,
  `CategoryName` varchar(20) NOT NULL,
  PRIMARY KEY (`CategoryID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`CategoryID`, `CategoryName`) VALUES
(1, 'Fiction'),
(3, 'Horror'),
(4, 'Fantansy'),
(5, 'Science'),
(6, 'Documentary');

-- --------------------------------------------------------

--
-- Table structure for table `damagelost`
--

CREATE TABLE IF NOT EXISTS `damagelost` (
  `DLID` varchar(30) NOT NULL DEFAULT '',
  `MemberID` varchar(30) NOT NULL,
  `ProductID` varchar(30) NOT NULL,
  `Status` varchar(30) NOT NULL,
  `Description` varchar(255) NOT NULL,
  `AmountToPay` int(11) NOT NULL,
  PRIMARY KEY (`DLID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `damagelost`
--

INSERT INTO `damagelost` (`DLID`, `MemberID`, `ProductID`, `Status`, `Description`, `AmountToPay`) VALUES
('DL-000001', 'M-000001', 'P-000002', 'Damage', 'can be reuse if maintenance is performed', 5000);

-- --------------------------------------------------------

--
-- Table structure for table `itemtype`
--

CREATE TABLE IF NOT EXISTS `itemtype` (
  `ItemTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemType` varchar(20) NOT NULL,
  `AllowlanceDays` varchar(30) NOT NULL,
  `AmountOfFine` varchar(30) NOT NULL,
  PRIMARY KEY (`ItemTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `itemtype`
--

INSERT INTO `itemtype` (`ItemTypeID`, `ItemType`, `AllowlanceDays`, `AmountOfFine`) VALUES
(1, 'Book', '1 Week', '1000Ks'),
(2, 'References', '2 Week', '2000Ks'),
(3, 'Magazine', '1 Week', '1000Ks'),
(4, 'Text Book', '1 Week', '2000Ks'),
(5, 'hello', '1 Week', '1000Ks');

-- --------------------------------------------------------

--
-- Table structure for table `itemtypedetail`
--

CREATE TABLE IF NOT EXISTS `itemtypedetail` (
  `ItemTypeDetailID` int(11) NOT NULL AUTO_INCREMENT,
  `ItemTypeID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  PRIMARY KEY (`ItemTypeDetailID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `MemberID` varchar(30) NOT NULL DEFAULT '',
  `MemberName` varchar(30) NOT NULL,
  `MemberEmail` varchar(30) NOT NULL,
  `MemberAddress` varchar(50) NOT NULL,
  `NRC` varchar(30) NOT NULL,
  `Age` int(11) NOT NULL,
  `PhoneNumber` int(11) NOT NULL,
  `RegisterDate` varchar(30) NOT NULL,
  `ExpireDate` varchar(30) NOT NULL,
  `MemberTypeID` int(11) NOT NULL,
  PRIMARY KEY (`MemberID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `member`
--

INSERT INTO `member` (`MemberID`, `MemberName`, `MemberEmail`, `MemberAddress`, `NRC`, `Age`, `PhoneNumber`, `RegisterDate`, `ExpireDate`, `MemberTypeID`) VALUES
('M-000001', 'kyawkyaw', 'kyawkyaw@gmail.com', 'Mandalay', '123445', 18, 12345, '2019-07-02', '2020-07-02', 2),
('M-000002', 'AyeAye', 'ayeaye@gmail.com', 'Mandalay', '123123', 20, 92620, '2019-07-22', '2019-07-29', 2),
('M-000003', 'Zaw Zaw', 'zaw@gmail.com', 'Yangon', '123456789', 30, 9789654, '2019-07-27', '2020-07-27', 2);

-- --------------------------------------------------------

--
-- Table structure for table `membertype`
--

CREATE TABLE IF NOT EXISTS `membertype` (
  `MemberTypeID` int(11) NOT NULL AUTO_INCREMENT,
  `MemberType` varchar(30) NOT NULL,
  `AllowlanceItemAmount` int(11) NOT NULL,
  `CardCost` int(11) NOT NULL,
  PRIMARY KEY (`MemberTypeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `membertype`
--

INSERT INTO `membertype` (`MemberTypeID`, `MemberType`, `AllowlanceItemAmount`, `CardCost`) VALUES
(2, 'Silver', 2, 25000),
(3, 'Gold', 3, 30000);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
  `ProductID` varchar(30) NOT NULL,
  `ProductImage` varchar(255) NOT NULL,
  `ProductName` varchar(40) NOT NULL,
  `Author` varchar(30) NOT NULL,
  `Language` varchar(30) NOT NULL,
  `Edition` varchar(30) NOT NULL,
  `Publisher` varchar(30) NOT NULL,
  `ISBN` varchar(40) NOT NULL,
  `NumberOfPages` int(11) NOT NULL,
  `OnDisplay` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `ItemTypeID` int(11) NOT NULL,
  PRIMARY KEY (`ProductID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`ProductID`, `ProductImage`, `ProductName`, `Author`, `Language`, `Edition`, `Publisher`, `ISBN`, `NumberOfPages`, `OnDisplay`, `Quantity`, `CategoryID`, `ItemTypeID`) VALUES
('P-000001', 'Image/_download.jpg', 'How to Study Smart', 'John', 'English', 'First Edition', 'John', 'ISBN 978-1-78280-808-1', 12, 3, 10, 5, 1),
('P-000002', 'Image/_children_bookcover.png', 'FRED', 'Smith', 'English', 'First Edition', 'Smith', 'ISBN 978-1-78280-808-2', 20, 3, 10, 1, 1),
('P-000003', 'Image/_images (1).jpg', 'How to be a Bomb', 'Willian', 'English', 'First Edition', 'Willian', 'ISBN 978-1-78280-808-3', 20, 3, 5, 4, 1),
('P-000004', 'Image/_images (3).jpg', 'Harry Potter', 'abcd', 'English', 'First Edition', 'abcd', 'ISBN 978-1-78280-808-4', 20, 3, 5, 4, 1);

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE IF NOT EXISTS `purchase` (
  `PurchaseOrderID` varchar(30) NOT NULL,
  `PurchaseOrderDate` varchar(20) NOT NULL,
  `TotalAmount` varchar(20) NOT NULL,
  `GrandTotal` varchar(30) NOT NULL,
  `TaxAmount` varchar(20) NOT NULL,
  `TotalQuantity` varchar(30) NOT NULL,
  `SupplierID` int(11) NOT NULL,
  `StaffID` int(11) NOT NULL,
  `Status` varchar(30) NOT NULL,
  PRIMARY KEY (`PurchaseOrderID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`PurchaseOrderID`, `PurchaseOrderDate`, `TotalAmount`, `GrandTotal`, `TaxAmount`, `TotalQuantity`, `SupplierID`, `StaffID`, `Status`) VALUES
('PO-000001', '2019-07-31', '25000', '26250', '1250', '10', 2, 2, 'Confirmed'),
('PO-000002', '2019-08-05', '10000', '10500', '500', '10', 3, 2, 'Confirmed');

-- --------------------------------------------------------

--
-- Table structure for table `purchasedetail`
--

CREATE TABLE IF NOT EXISTS `purchasedetail` (
  `PurchaseOrderID` varchar(30) NOT NULL,
  `ProductID` varchar(20) NOT NULL,
  `PurchaseQuantity` int(11) NOT NULL,
  `PurchasePrice` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `purchasedetail`
--

INSERT INTO `purchasedetail` (`PurchaseOrderID`, `ProductID`, `PurchaseQuantity`, `PurchasePrice`) VALUES
('PO-000001', 'P-000001', 5, 3000),
('PO-000001', 'P-000002', 5, 2000),
('PO-000001', 'P-000001', 5, 3000),
('PO-000001', 'P-000002', 5, 2000),
('PO-000002', 'P-000004', 5, 1000),
('PO-000002', 'P-000003', 5, 1000);

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE IF NOT EXISTS `returns` (
  `ReturnID` varchar(30) NOT NULL DEFAULT '',
  `ReturnDate` date NOT NULL,
  `TotalAmount` int(11) NOT NULL,
  `BorrowDetailID` varchar(30) NOT NULL,
  PRIMARY KEY (`ReturnID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`ReturnID`, `ReturnDate`, `TotalAmount`, `BorrowDetailID`) VALUES
('R_000001', '2019-07-28', 2000, 'BD_000001'),
('R_000002', '2019-07-28', 2000, 'BD_000002'),
('R_000003', '2019-07-29', 0, 'BD_000003');

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE IF NOT EXISTS `staff` (
  `StaffID` int(11) NOT NULL AUTO_INCREMENT,
  `StaffName` varchar(30) NOT NULL,
  `StaffEmail` varchar(30) NOT NULL,
  `StaffAddress` varchar(50) NOT NULL,
  `PasswordForLogIn` varchar(30) NOT NULL,
  `StaffPhone` varchar(20) NOT NULL,
  `StaffGradeID` int(11) NOT NULL,
  PRIMARY KEY (`StaffID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`StaffID`, `StaffName`, `StaffEmail`, `StaffAddress`, `PasswordForLogIn`, `StaffPhone`, `StaffGradeID`) VALUES
(1, 'Aye Aye', 'ayeaye@gmail.com', 'Yangon', 'staff123', '0973046126', 1),
(2, 'Kyaw Kyaw', 'kyawkyaw@gmail.com', 'Yangon', 'abcd', '0973046126', 4),
(3, 'Kaung Kaung', 'kaungkaung@gmail.com', 'Yangon', 'staff123', '0973046126', 1),
(5, 'Daw Hla', 'dawhla@gmail.com', 'Yangon', 'dawhla', '0946159', 1),
(6, 'Daw Myo', 'dawmyo@gmail.com', 'Yangon', 'dawmyo', '123456', 2);

-- --------------------------------------------------------

--
-- Table structure for table `staffgrade`
--

CREATE TABLE IF NOT EXISTS `staffgrade` (
  `StaffGradeID` int(11) NOT NULL AUTO_INCREMENT,
  `StaffGrade` varchar(30) NOT NULL,
  `Salary` varchar(30) NOT NULL,
  PRIMARY KEY (`StaffGradeID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `staffgrade`
--

INSERT INTO `staffgrade` (`StaffGradeID`, `StaffGrade`, `Salary`) VALUES
(1, 'Library Assistant', '100'),
(2, 'Database Administrator', '200'),
(4, 'Library Manager', '200');

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `SupplierID` int(11) NOT NULL AUTO_INCREMENT,
  `SupplierName` varchar(30) NOT NULL,
  `SupplierEmail` varchar(30) NOT NULL,
  `SupplierAddress` varchar(50) NOT NULL,
  `SupplierPhone` varchar(20) NOT NULL,
  PRIMARY KEY (`SupplierID`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`SupplierID`, `SupplierName`, `SupplierEmail`, `SupplierAddress`, `SupplierPhone`) VALUES
(1, 'Kyaw Kyaw', 'kyawkyaw@gmail.com', 'Yangon', '01530968'),
(2, 'Aye Aye', 'ayeaye@gmail.com', 'Mandalay', '097896546'),
(3, 'Kaung Kaung', 'kaungkaung@gmail.com', 'Mandalay', '094615432'),
(4, 'U Hla', 'uhla@gmail.com', 'Mandalay', '15376'),
(5, 'Min Khant', 'minkhant@gmail.com', 'Yangon', '09461593');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
