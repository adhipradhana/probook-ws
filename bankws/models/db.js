const Sequelize = require('sequelize');
const dotenv = require('dotenv');

const vars = dotenv.config();
if (vars.error) {
  throw vars.error
}

const db = new Sequelize({
  host: process.env.BANK_DB_HOST,
  username: process.env.BANK_DB_USER,
  password: process.env.BANK_DB_PASS,
  database: process.env.BANK_DB_NAME,
  dialect: 'mysql'
});

module.exports = db;