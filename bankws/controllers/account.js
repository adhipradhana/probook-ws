const express = require('express');
const Account = require('../models/account');

const router = express.Router();

router.get('/', (req, res) => {
  Account.getByCardNumber(req.query.cardNumber)
    .then((account) => {
      if (account) {
        res.json({
          status: 'success',
          message: '',
          name: account.name,
          balance: account.balance
        });
      } else {
        res.json({
          status: 'failed',
          message: 'Invalid card number'
        });
      }
    });
});

module.exports = router;