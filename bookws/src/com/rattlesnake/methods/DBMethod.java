package com.rattlesnake.methods;

import java.sql.*;
import java.util.HashMap;

public class DBMethod {

    private static final String host = "jdbc:mysql://localhost:3306/bookws";
    private static final String user = "root";
    private static final String password = "";

    public static HashMap<String, Number> getBookInfo(String id) {
        Connection con = null;
        HashMap<String, Number> result = new HashMap<>();

        try {
            // create connection
            con = DriverManager.getConnection(host, user, password);

            // prepare sql statement
            String selectSql = "SELECT price, rating, rating_count FROM books WHERE id = ?";
            PreparedStatement preparedStatement = con.prepareStatement(selectSql);
            preparedStatement.setString(1, id);

            // execute query
            ResultSet resultSet = preparedStatement.executeQuery();

            // get result
            resultSet.last();
            int count = resultSet.getRow();

            // empty set
            if (count == 0) {
                return null;
            }

            // return result
            long price = resultSet.getLong("price");
            double rating = resultSet.getDouble("rating");
            int rating_count = resultSet.getInt("rating_count");

            result.put("price", price);
            result.put("rating", rating);
            result.put("rating_count", rating_count);

            return result;
        } catch (SQLException e) {
            e.printStackTrace();

            return null;
        } finally {
            try {
                con.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    public static boolean changeRating(String id, double rating) {
        Connection con = null;

        try {
            // create connection
            con = DriverManager.getConnection(host, user, password);

            // prepare sql statement
            String updateSql =
                    "UPDATE books AS b, (" +
                    "  SELECT rating, rating_count" +
                    "  FROM books" +
                    "  WHERE id = ?" +
                    ") AS curr" +
                    "SET b.rating = (((curr.rating * curr.rating_count) + ?) / (curr.rating_count + 1))," +
                    "b.rating_count = curr.rating_count + 1" +
                    "WHERE id = ?";
            PreparedStatement preparedStatement = con.prepareStatement(updateSql);
            preparedStatement.setString(1, id);
            preparedStatement.setDouble(2, rating);
            preparedStatement.setString(3, id);

            // execute query
            int rowsAffected = preparedStatement.executeUpdate();
            if (rowsAffected == 0) {
                return false;
            }

            return true;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        } finally {
            try {
                con.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    public static String getRecommendedBook(String genre) {
        Connection con = null;
        try {
            // create a connection
            con = DriverManager.getConnection(host, user, password);

            // prepare sql statement
            String selectSql =
                    "SELECT * from sales " +
                    "NATURAL JOIN (" +
                    "SELECT genre, MAX(total_sales) AS total_sales " +
                    "FROM sales " +
                    "WHERE genre = ?" +
                    "GROUP BY genre) as temp";
            PreparedStatement preparedStatement = con.prepareStatement(selectSql);
            preparedStatement.setString(1, genre);

            // execute query
            ResultSet resultSet = preparedStatement.executeQuery();

            // get result
            resultSet.last();
            int count = resultSet.getRow();

            // empty set
            if (count == 0) {
                return null;
            }

            return resultSet.getString("id");
        } catch (SQLException e) {
            e.printStackTrace();
            return null;
        } finally {
            try {
                con.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }

    public static boolean updateSales(String id, String genre, int amount) {
        Connection con = null;
        boolean result;

        try {
            // create a connection
            con = DriverManager.getConnection(host, user, password);

            // start transaction
            String startTransaction = "START TRANSACTION";
            Statement statement = con.createStatement();
            statement.execute(startTransaction);

            // see sales
            String selectSql = "SELECT total_sales FROM sales WHERE id = ?";
            PreparedStatement preparedStatement = con.prepareStatement(selectSql);
            preparedStatement.setString(1,id);

            // see query result
            ResultSet resultSet = preparedStatement.executeQuery();
            resultSet.last();

            if (resultSet.getRow() == 0) {
                // create new tuple
                String insertSql = "INSERT INTO sales(id, genre, total_sales) VALUES(?, ?, ?)";
                preparedStatement = con.prepareStatement(insertSql);
                preparedStatement.setString(1, id);
                preparedStatement.setString(2, genre);
                preparedStatement.setInt(3, amount);

                int rowsAffected = preparedStatement.executeUpdate();
                if (rowsAffected == 0) {
                    result = false;
                } else {
                    result = true;
                }
            } else {
                int totalSales = resultSet.getInt("total_sales");

                // update the tuple
                String updateSQL = "UPDATE sales SET total_sales = ? WHERE id = ?";
                preparedStatement = con.prepareStatement(updateSQL);
                preparedStatement.setInt(1, totalSales + amount);
                preparedStatement.setString(2, id);

                int rowsAffected = preparedStatement.executeUpdate();
                if (rowsAffected == 0) {
                    result = false;
                } else {
                    result = true;
                }
            }

            // commit transaction
            String commitTransaction = "COMMIT";
            statement.execute(commitTransaction);

            return result;
        } catch (SQLException e) {
            e.printStackTrace();
            return false;
        } finally {
            try {
                con.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }
    }
}
