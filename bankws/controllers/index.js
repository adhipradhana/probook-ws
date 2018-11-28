const express = require('express');

const router = express.Router();

router.use('/account', require('./account'));
router.use('/charge', require('./charge'));
router.use('/totpQRCode', require('./totpQRCode'));

router.get('/', (_, res) => {
  res.json({
    status: 'success',
    message: 'Service available'
  });
});

module.exports = router;