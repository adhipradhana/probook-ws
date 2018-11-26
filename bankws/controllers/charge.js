const express = require('express');
const Account = require('../models/account');
const Merchant = require('../models/merchant');
const Transaction = require('../models/transaction');

const router = express.Router();

router.post('/', (req, res) => {
  const apiKey = req.body.apiKey;
  const amount = parseFloat(req.body.amount);
  const customerCardNumber = req.body.cardNumber;
  let customerAccount;
  let merchantAccount;

  Merchant.getByApiKey(apiKey)
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
      res.json({
        status: 'success',
        message: ''
      });
    })
    .catch((error) => {
      res.json({
        status: 'failed',
        message: error.message
      });
    })
});

module.exports = router;