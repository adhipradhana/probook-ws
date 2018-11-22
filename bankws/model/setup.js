const Sequelize = require('sequelize');
const dotenv = require('dotenv');
const db = require('./index');

const vars = dotenv.config();
if (vars.error) {
  throw vars.error
}

db.sequelize.sync({force: true})
  .then(() => {
    db.account.create({ cardNumber: 4716717075371688, name: 'Joko Widodo', balance: 100000000.0 });
    db.account.create({ cardNumber: 4024007171246290, name: 'Prabowo Subianto', balance: 100000000000.0 });
    db.account.create({ cardNumber: 4539562256288318, name: 'Sandiaga Uno', balance: 1000000000000.0 });
    db.account.create({ cardNumber: 4126795473513873, name: 'Aldo Azali', balance: 1000000.0 });
  })
  .then(() => {
    db.merchant.create({ 
      accountId: 1, 
      name: "ProBook", 
      secret: "DJJALIJALIKECEBONGKU"
    });
  })
  .then(() => {
    db.transaction.create({ 
      senderId: 3, 
      receiverId: 2, 
      amount: 1000000000000.0
    });
  });