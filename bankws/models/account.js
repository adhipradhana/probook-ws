const Sequelize = require('sequelize');
const db = require('./db');

const Account = db.define('account', {
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  cardNumber: { type: Sequelize.STRING(16), allowNull: false, unique: true },
  name: { type: Sequelize.STRING, allowNull: false },
  balance: { type: Sequelize.BIGINT, allowNull: false },
  totpSecret: { type: Sequelize.STRING(52), allowNull: false }
});

Account.getById = (id) => {
  return Account.findOne({ where: {id: id} })
    .then((account) => account);
};

Account.getByCardNumber = (cardNumber) => {
  return Account.findOne({ where: {cardNumber: cardNumber} })
    .then((account) => account);
};

Account.prototype.increaseBalance = function(amount) {
  return this.update({ 
    balance: this.balance + amount 
  });
};

Account.prototype.decreaseBalance = function(amount) {
  if (this.balance >= amount) return this.update({ 
    balance: this.balance - amount 
  });
  else throw Error('Insufficient balance');
};

module.exports = Account;
