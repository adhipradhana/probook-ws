const Sequelize = require('sequelize');
const dotenv = require('dotenv');

const vars = dotenv.config();
if (vars.error) {
  throw vars.error
}

const sequelize = new Sequelize({
  host: process.env.BANK_DB_HOST,
  username: process.env.BANK_DB_USER,
  password: process.env.BANK_DB_PASS,
  database: process.env.BANK_DB_NAME,
  dialect: 'mysql'
});

const Account = sequelize.define('account', {
  cardNumber: { type: Sequelize.STRING(16), primaryKey: true },
  name: { type: Sequelize.STRING, allowNull: false },
  balance: { type: Sequelize.FLOAT, allowNull: false }
});

const Transaction = sequelize.define('transaction', {
  senderCardNumber: { 
    type: Sequelize.STRING(16), 
    allowNull: false,
    references: { model: Account, key: 'cardNumber' }
  },
  receiverCardNumber: { 
    type: Sequelize.STRING(16), 
    allowNull: false,
    references: { model: Account, key: 'cardNumber' }
  },
  amount: { type: Sequelize.FLOAT, allowNull: false },
  timeStamp: { type: Sequelize.DATE, defaultValue: Sequelize.NOW }
});

const db = {};
db.account = Account;
db.transaction = Transaction;

module.exports = db;