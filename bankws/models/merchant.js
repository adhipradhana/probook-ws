const Sequelize = require('sequelize');
const db = require('./connection');
const Account = require('./account');

const Merchant = db.define('merchant', {
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  accountId: { 
    type: Sequelize.INTEGER, 
    allowNull: false,
    references: { model: Account, key: 'id' }
  },
  name: { type: Sequelize.STRING, allowNull: false },
  secret: { type: Sequelize.STRING(24), allowNull: false, unique: true }
});

Merchant.getBySecret = (secret) => {
  return Merchant.findOne({ where: {secret: secret} })
    .then((merchant) => {
      if (merchant) return merchant;
      else throw Error('Invalid merchant secret');
    });
};

module.exports = Merchant;