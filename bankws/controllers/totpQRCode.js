const express = require('express');
const qrCode = require('qrcode');
const Account = require('../models/account');

const router = express.Router();

router.get('/', (req, res) => {
  Account.getByCardNumber(req.query.cardNumber)
    .then((account) => {
      if (account) {
        const totpSectetURL = 'otpauth://totp/SecretKey?secret=' + account.totpSecret;
        qrCode.toDataURL(totpSectetURL, (err, imageString) => {
          const imageBase64 = new Buffer(imageString.split(',')[1], 'base64');
          res.set('Content-Type', 'image/png');
          res.set('Content-Length', imageBase64.length);
          res.end(imageBase64);
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