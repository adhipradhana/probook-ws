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
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  cardNumber: { type: Sequelize.STRING(16), allowNull: false, unique: true },
  name: { type: Sequelize.STRING, allowNull: false },
  balance: { type: Sequelize.FLOAT, allowNull: false }
});

const Merchant = sequelize.define('merchant', {
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  accountId: { 
    type: Sequelize.INTEGER, 
    allowNull: false,
    references: { model: Account, key: 'id' }
  },
  name: { type: Sequelize.STRING, allowNull: false },
  secret: { type: Sequelize.STRING(24), allowNull: false }
});

const Transaction = sequelize.define('transaction', {
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  senderId: { 
    type: Sequelize.INTEGER, 
    allowNull: false,
    references: { model: Account, key: 'id' }
  },
  receiverId: { 
    type: Sequelize.INTEGER, 
    allowNull: false,
    references: { model: Account, key: 'id' }
  },
  amount: { type: Sequelize.FLOAT, allowNull: false },
  timeStamp: { type: Sequelize.DATE, defaultValue: Sequelize.NOW }
});

const db = {};
db.sequelize = sequelize;
db.account = Account;
db.merchant = Merchant;
db.transaction = Transaction;

module.exports = db;