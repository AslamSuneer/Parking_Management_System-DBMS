SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Create Category Table
CREATE TABLE `category` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `rate` double NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into Category Table
INSERT INTO `category` (`id`, `name`, `rate`) VALUES
(1, 'Car', 50),
(2, 'Motorcycle', 35),
(3, 'Sample vehicle', 50),
(4, 'Vehicle type2', 70);

-- Create Parked List Table
CREATE TABLE `parked_list` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `category_id` int(30) NOT NULL,
  `location_id` int(30) NOT NULL,
  `ref_no` varchar(100) NOT NULL,
  `vehicle_brand` varchar(200) NOT NULL,
  `vehicle_registration` varchar(15) NOT NULL,
  `owner` text NOT NULL,
  `vehicle_description` text NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=in, 2=out',
  `amount_due` double NOT NULL,
  `amount_tendered` double NOT NULL,
  `amount_change` double NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into Parked List Table
INSERT INTO `parked_list` (`id`, `category_id`, `location_id`, `ref_no`, `vehicle_brand`, `vehicle_registration`, `owner`, `vehicle_description`, `status`, `amount_due`, `amount_tendered`, `amount_change`, `date_created`) VALUES
(3, 1, 1, '5020555486', 'Ford Mustang', 'CDM-0623', 'John Smith', 'Black', 1, 0, 0, 0, '2024-10-10 11:38:57'),
(5, 1, 1, '4970885858', 'Fortuner', 'GCN-1514', 'Claire Blake', 'White', 2, 137.5, 150, 12.5, '2024-10-8 12:09:10'),
(6, 1, 1, '9428140638', 'Sample', 'WER-7894', 'Sample Only', 'Sample', 2, 123.33, 150, 26.67, '2024-10-5 12:09:56'),
(7, 2, 2, '4033430792', 'asdasdasd', 'qwa-1234', 'ada asd asd', 'asdasda', 1, 0, 0, 0, '2024-10-4 16:26:27'),
(8, 3, 3, '3599556075', 'Sample', 'GCN-2020', 'Sample Only', 'White', 2, 3.33, 50, 46.67, '2024-10-3 08:20:22'),
(9, 4, 4, '4099773928', 'Sample', 'ABC-1234', 'George Wilson', 'Black Vehicle', 2, 1.17, 5, 3.83, '2024-10-2 08:28:44');

-- Create Parking Locations Table
CREATE TABLE `parking_locations` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `location` text NOT NULL,
  `capacity` int(11) NOT NULL,
  `category_id` int(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into Parking Locations Table
INSERT INTO `parking_locations` (`id`, `location`, `capacity`, `category_id`) VALUES
(1, 'Car Area 1', 10, 1),
(2, 'Area 1', 30, 2),
(3, 'Sample area', 20, 3),
(4, 'Area Block 23', 10, 4);

-- Create Parking Movement Table
CREATE TABLE `parking_movement` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `pl_id` int(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1 COMMENT '1=in, 2=out',
  `created_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into Parking Movement Table
INSERT INTO `parking_movement` (`id`, `pl_id`, `status`, `created_timestamp`) VALUES
(1, 2, 1, '2024-10-15 11:13:19'),
(2, 3, 1, '2024-10-15 11:31:41'),
(3, 4, 1, '2024-10-15 11:39:37'),
(4, 5, 1, '2024-10-16 12:09:10'),
(5, 6, 1, '2024-10-17 12:09:56'),
(6, 6, 2, '2024-10-17 14:37:00'),
(7, 5, 2, '2024-10-16 14:54:00'),
(8, 7, 1, '2024-10-18 16:26:27'),
(9, 8, 1, '2024-10-19 08:20:22'),
(11, 8, 2, '2024-10-19 08:24:00'),
(12, 9, 1, '2024-10-20 08:28:44'),
(13, 9, 2, '2024-10-20 08:29:00');

-- Create Users Table
CREATE TABLE `users` (
  `id` int(30) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `type` tinyint(4) NOT NULL DEFAULT 2 COMMENT '1=Admin, 2=Staff, 3=User',
  `username` varchar(100) NOT NULL,
  `password` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert data into Users Table
INSERT INTO `users` (`id`, `name`, `type`, `username`, `password`) VALUES
(1, 'Administrator', 1, 'admin', '0192023a7bbd73250516f069df18b500');

COMMIT;
