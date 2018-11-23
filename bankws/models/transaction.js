const Sequelize = require('sequelize');
const db = require('./index');
const Account = require('./account');

const Transaction = db.define('transaction', {
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

module.exports = Transaction;