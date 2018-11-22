const dotenv = require('dotenv');
const db = require('./models/index');
const Account = require('./models/account');
const Merchant = require('./models/merchant');
const Transaction = require('./models/transaction');

const vars = dotenv.config();
if (vars.error) {
  throw vars.error
}

db.sync({force: true})
  .then(() => {
    Account.create({ cardNumber: "4716717075371688", name: 'Joko Widodo', balance: 100000000 });
    Account.create({ cardNumber: "4024007171246290", name: 'Prabowo Subianto', balance: 1000000000001 });
    Account.create({ cardNumber: "4539562256288318", name: 'Sandiaga Uno', balance: 1000000000000 });
    Account.create({ cardNumber: "4126795473513873", name: 'Aldo Azali', balance: 1000000 });
  })
  .then(() => {
    Merchant.create({ 
      accountId: 1, 
      name: "ProBook", 
      secret: "DJJALIJALIKECEBONGKU"
    });
  })
  .then(() => {
    Transaction.create({ 
      senderId: 3, 
      receiverId: 2, 
      amount: 1000000000000.0
    });
  });