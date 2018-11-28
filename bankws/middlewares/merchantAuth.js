const Account = require('../models/account');
const Merchant = require('../models/merchant');

module.exports = function(req, res, next) {
  Merchant.getByApiKey(req.body.apiKey)
    .then((merchant) => {
      if (merchant) {
        req.body.merchant = merchant;
        Account.getById(merchant.accountId)
          .then((merchantAccount) => {
            req.body.merchantAccount = merchantAccount;
            next();
          })
      } else {
        res.json({
          status: 'failed',
          message: 'Invalid merchant API key'
        });
      }
    });
};
