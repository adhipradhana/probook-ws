const Sequelize = require('sequelize');
const db = require('./connection');

const Account = db.define('account', {
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  cardNumber: { type: Sequelize.STRING(16), allowNull: false, unique: true },
  name: { type: Sequelize.STRING, allowNull: false },
  balance: { type: Sequelize.BIGINT, allowNull: false }
});

Account.getById = (id) => {
  return Account.findOne({ where: {id: id} })
    .then((account) => {
      if (account) return account;
      else throw Error('Invalid id');
    });
};

Account.getByCardNumber = (cardNumber) => {
  return Account.findOne({ where: {cardNumber: cardNumber} })
    .then((account) => {
      if (account) return account;
      else throw Error('Invalid credit card');
    });
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