const express = require('express');
const db = require('../models/db');
const Transaction = require('../models/transaction');
const MerchantAuth = require('../middlewares/merchantAuth');
const CustomerAuth = require('../middlewares/customerAuth');

const router = express.Router();
router.use(MerchantAuth);
router.use(CustomerAuth);

router.post('/', (req, res) => {
  const customerAccount = req.body.customerAccount;
  const merchantAccount = req.body.merchantAccount;
  const amount = parseInt(req.body.amount);

  db.transaction(function(t) {
    customerAccount.decreaseBalance(amount)
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
        })
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