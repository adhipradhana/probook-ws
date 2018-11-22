const Sequelize = require('sequelize');
const db = require('./index');

const Account = db.define('account', {
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  cardNumber: { type: Sequelize.STRING(16), allowNull: false, unique: true },
  name: { type: Sequelize.STRING, allowNull: false },
  balance: { type: Sequelize.FLOAT, allowNull: false }
});

Account.getByCardNumber = (cardNumber) => {
  return Account.findOne({ where: {cardNumber: cardNumber} })
    .then((account) => {
      if (account) return account;
      else throw Error('Invalid credit card');
    });
};

Account.haveBalance = (id, amount) => {
  return Account.findOne({ where: {cardNumber: cardNumber} })
    .then((account) => {
      if (account) return account;
      else throw Error('Invalid credit card');
    });
};

module.exports = Account;