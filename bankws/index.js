const express = require('express');
const bodyParser = require('body-parser');
const db = require('./models/index');
const Account = require('./models/account');
const Merchant = require('./models/merchant');
const Transaction = require('./models/transaction');

const PORT = 5000;
const app = express();

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: true }))

app.get('/api/v1/status', (_, res) => {
  res.status(200).send({
    status: 'available'
  });
});

app.get('/api/v1/account', (req, res) => {
  Account.getByCardNumber(req.query.cardNumber)
    .then((account) => {
      res.status(200).send({
        status: 'success',
        message: '',
        name: account.name,
        balance: account.balance
      });
    })
    .catch((error) => {
      res.status(200).send({
        status: 'error',
        message: error.message
      });
    });
});

app.post('/api/v1/charge', (req, res) => {
  const secret = req.body.secret;
  const amount = parseFloat(req.body.amount);
  const customerCardNumber = req.body.cardNumber;
  let customerAccount;
  let merchantAccount;

  Merchant.getBySecret(secret)
    .then((merchant) => {
      return Account.getById(merchant.accountId);
    })
    .then((account) => {
      merchantAccount = account;
      return Account.getByCardNumber(customerCardNumber);
    })
    .then((account) => {
      customerAccount = account;
      return customerAccount.decreaseBalance(amount);
    })
    .then(() => {
      return merchantAccount.increaseBalance(amount);
    })
    .then(() => {
      Transaction.create({ 
        senderId: customerAccount.id, 
        receiverId: merchantAccount.id, 
        amount: amount
      });
    })
    .then(() => {
      res.status(200).send({
        status: 'success',
        message: '',
      });
    })
    .catch((error) => {
      res.status(200).send({
        status: 'error',
        message: error.message
      });
    })

  // Merchant.getBySecret(secret)
  //   .then((merchant) => {

  //     Account.getByCardNumber(customerCardNumber)
  //       .then((account) => {

  //         if (account.balance >= amount) {

  //           account.increaseBalance(amount)
  //             .then(() => {
  //               account.increaseBalance(amount);
  //             })
  //             .then(() => {
  //               account.increaseBalance(amount);
  //             })
  //             .then(() => {
  //               res.status(200).send({
  //                 status: 'success',
  //                 message: '',
  //                 senderCardNumber: account.name,
  //                 receiverCardNumber: merchant.name,
  //                 amount: req.body.amount
  //               });
  //             });

  //         } else {
  //           res.status(200).send({
  //             status: 'error',
  //             message: 'Insuffincent balance'
  //           });
  //         }

  //       }, (error) => {
  //         res.status(200).send({
  //           status: 'error',
  //           message: error.message
  //         });
  //       });

  //   }, (error) => {
  //     res.status(200).send({
  //       status: 'error',
  //       message: error.message
  //     });
  //   });
});

app.listen(PORT, () => {
  console.log(`server running on port ${PORT}`);
});
