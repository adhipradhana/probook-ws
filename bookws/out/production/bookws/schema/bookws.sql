#
## table books
#

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books`(
  `id` VARCHAR(50) NOT NULL PRIMARY KEY,
  `rating` DECIMAL (5,1) NOT NULL,
  `price` INT(10) NOT NULL,
  `rating_count` INT(5) NOT NULL
);

#
## table sales
#

DROP TABLE IF EXISTS `sales`;
CREATE  TABLE `sales`(
  `id` VARCHAR(100) NOT NULL PRIMARY KEY,
  `genre` VARCHAR(50) NOT NULL,
  `total_sales` INT(10) NOT NULL
);

