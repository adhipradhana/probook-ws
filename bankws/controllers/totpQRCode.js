const express = require('express');
const qrCode = require('qrcode');
const Account = require('../models/account');
const MerchantAuth = require('../middlewares/merchantAuth');

const router = express.Router();

router.get('/', (req, res) => {
  Account.getByCardNumber(req.query.cardNumber)
    .then((account) => {
      if (account) {
        const totpSectetURL = 'otpauth://totp/SecretKey?secret=' + account.totpSecret;
        qrCode.toDataURL(totpSectetURL, (err, imageString) => {
          res.json({
            status: 'success',
            message: '',
            qrCode: imageString
          });
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