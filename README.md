# agri-project-backend-lumen
DDL commands to create the MY SQL databases. (Any change in the database name with user/password should be updated in the .env file of the lumen project)

CREATE TABLE `cropfielditem` (
  `cropfield_name` varchar(100) NOT NULL,
  `crop_name` varchar(100) NOT NULL,
  `crop_totalarea` decimal(10,0) NOT NULL,
  `crop_processedarea` decimal(10,0) DEFAULT NULL,
  PRIMARY KEY (`cropfield_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci



CREATE TABLE `process_field` (
  `process_id` int unsigned NOT NULL AUTO_INCREMENT,
  `tractor_name` varchar(100) NOT NULL,
  `field_name` varchar(100) NOT NULL,
  `culture_name` varchar(100) NOT NULL,
  `process_date` date NOT NULL,
  `process_area` decimal(10,0) NOT NULL,
  PRIMARY KEY (`process_id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci



CREATE TABLE `tractors` (
  `tractor_id` int NOT NULL AUTO_INCREMENT,
  `tractor_name` varchar(100) NOT NULL,
  PRIMARY KEY (`tractor_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

Run the Back end lumen project

Use the below command after cloning the project to any directory and changing the directory path to in cmd to the same folder
Use "composer install" to install the dependent modules. Then after,
php -S locahost:8000 -t public
