package com.rattlesnake.methods;

import java.sql.*;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import io.github.cdimascio.dotenv.Dotenv;

public class DBMethod {

    private static Dotenv dotenv = Dotenv.load();

    private static final String host = dotenv.get("DB_HOST");
    private static final String user = dotenv.get("DB_USER");
    private static final String password = dotenv.get("DB_PASSWORD");

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

    public static List<String> getRecommendedBook(String[] genres) {
        Connection con = null;

        try {
            // create a connection
            con = DriverManager.getConnection(host, user, password);

            // prepare sql statement
            StringBuilder selectSql = new StringBuilder("SELECT id FROM sales WHERE genre IN (");
            for (int i = 0; i < genres.length; i++) {
                if (i == 0) {
                    selectSql.append('?');
                } else {
                    selectSql.append(",?");
                }
            }
            selectSql.append(") AND total_sales > 0 ORDER BY total_sales DESC LIMIT 3");
            PreparedStatement preparedStatement = con.prepareStatement(selectSql.toString());
            for (int i = 0; i < genres.length; i++) {
                preparedStatement.setString(i + 1, genres[i]);
            }

            // execute query
            ResultSet resultSet = preparedStatement.executeQuery();

            // get result
            List<String> idList = new ArrayList<>();
            resultSet.first();
            while (resultSet.next()) {
                idList.add(resultSet.getString("id"));
            }

            // empty set
            if (idList.size() == 0) {
                return null;
            }

            return idList;
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
