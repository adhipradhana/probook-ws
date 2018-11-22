const express = require('express');
const Account = require('../models/account');

const router = express.Router();

router.get('/', (req, res) => {
  Account.getByCardNumber(req.query.cardNumber)
    .then((account) => {
      res.json({
        status: 'success',
        message: '',
        name: account.name,
        balance: account.balance
      });
    })
    .catch((error) => {
      res.json({
        status: 'failed',
        message: error.message
      });
    });
});

module.exports = router;