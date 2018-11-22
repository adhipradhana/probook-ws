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
        status: "success",
        message: "",
        name: account.name,
        balance: account.balance
      });
    }, (error) => {
      res.status(200).send({
        status: "error",
        message: error.message
      });
    });
});

app.post('/api/v1/charge', (req, res) => {
  Merchant.getBySecret(req.body.secret)
    .then((merchant) => {

      Account.getByCardNumber(req.body.cardNumber)
        .then((account) => {

          if (account.balance >= req.body.amount) {
            res.status(200).send({
              status: "success",
              message: "",
              from: account.name,
              to: merchant.name,
              amount: req.body.amount
            });
          } else {
            res.status(200).send({
              status: "error",
              message: "Insuffincent balance"
            });
          }

        }, (error) => {
          res.status(200).send({
            status: "error",
            message: error.message
          });
        });

    }, (error) => {
      res.status(200).send({
        status: "error",
        message: error.message
      });
    });
});

app.listen(PORT, () => {
  console.log(`server running on port ${PORT}`);
});
