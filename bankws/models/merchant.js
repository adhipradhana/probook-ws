const Sequelize = require('sequelize');
const db = require('./db');
const Account = require('./account');

const Merchant = db.define('merchant', {
  id: { type: Sequelize.INTEGER, primaryKey: true, autoIncrement: true },
  accountId: { 
    type: Sequelize.INTEGER, 
    allowNull: false,
    references: { model: Account, key: 'id' }
  },
  name: { type: Sequelize.STRING, allowNull: false },
  apiKey: { type: Sequelize.STRING(24), allowNull: false, unique: true }
});

Merchant.getByApiKey = (apiKey) => {
  return Merchant.findOne({ where: {apiKey: apiKey} })
    .then((merchant) => merchant);
};

module.exports = Merchant;