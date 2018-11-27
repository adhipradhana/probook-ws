const speakeasy = require('speakeasy');
const Account = require('../models/account');

module.exports = function(req, res, next) {
  Account.getByCardNumber(req.body.cardNumber)
    .then((customerAccount) => {
      if (customerAccount) {
        const verified = speakeasy.totp.verify({
          secret: customerAccount.totpSecret,
          encoding: 'base32',
          token: req.body.totpCode.toString(),
          window: 2
        });
        if (verified) {
          req.body.customerAccount = customerAccount;
          next();
        } else {
          res.json({
            status: 'failed',
            message: 'Invalid TOTP code'
          });
        }
      } else {
        res.json({
          status: 'failed',
          message: 'Invalid customer card number'
        });
      }
    });
}
