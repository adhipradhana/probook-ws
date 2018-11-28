--
-- Books Table
--

DROP TABLE IF EXISTS `books`;
CREATE TABLE `books`(
  `id` VARCHAR(50) NOT NULL PRIMARY KEY,
  `rating` DECIMAL (5,1) NOT NULL,
  `price` INT(10) NOT NULL,
  `rating_count` INT(5) NOT NULL
);

--
-- Sales Table
--

DROP TABLE IF EXISTS `sales`;
CREATE  TABLE `sales`(
  `id` VARCHAR(100) NOT NULL PRIMARY KEY,
  `genre` VARCHAR(50) NOT NULL,
  `total_sales` INT(10) NOT NULL
);

-- UPDATE books AS b, (
--   SELECT rating, rating_count
--   FROM books
--   WHERE id = '1'
-- ) AS curr
-- SET b.rating = (((curr.rating * curr.rating_count) + 4.0) / (curr.rating_count + 1)),
--     b.rating_count = curr.rating_count + 1
-- WHERE id = '1';
--
-- SELECT id from sales
-- NATURAL JOIN (
-- SELECT genre, MAX(total_sales) AS total_sales
-- FROM sales
-- WHERE genre = 'Comedy'
-- GROUP BY genre) as temp;




