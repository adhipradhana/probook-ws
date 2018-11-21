const express = require('express');
const db = require('./model/index');

const PORT = 5000;
const app = express();

app.get('/api/v1/status', (_, res) => {
  res.status(200).send({
    status: 'available'
  });
});

app.get('/api/v1/account', (req, res) => {
  const cardNumberQuery = req.query.cardNumber;
  console.log(cardNumberQuery);
  db.account.findOne({ where: {cardNumber: cardNumberQuery} })
    .then((account) => {
      res.status(200).send(account);
    })
});

app.post('/api/v1/charge', (req, res) => {
  res.status(200).send({
    status: 'available'
  });
});

app.listen(PORT, () => {
  console.log(`server running on port ${PORT}`);
});
