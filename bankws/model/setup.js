const Sequelize = require('sequelize');
const dotenv = require('dotenv');
const db = require('./index');

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

sequelize.sync({force: true})
  .then(() => {
    Account.create({ cardNumber: 4716717075371688, name: 'Joko Widodo', balance: 100000000.0 });
    Account.create({ cardNumber: 4024007171246290, name: 'Prabowo Subianto', balance: 100000000000.0 });
    Account.create({ cardNumber: 4539562256288318, name: 'Sandiaga Uno', balance: 1000000000000.0 });
    Account.create({ cardNumber: 4126795473513873, name: 'Aldo Azali', balance: 1000000.0 });
  })
  .then(() => {
    Transaction.create({ 
      senderCardNumber: 4539562256288318, 
      receiverCardNumber: 4716717075371688, 
      amount: 1000000000000.0
    });
  });