const express = require('express');
const bodyParser = require('body-parser');
const db = require('./model/index');

const PORT = 5000;
const app = express();

app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: true }))

app.get('/api/v1/status', (_, res) => {
  res.status(200).send({
    status: 'available'
  });
});

app.get('/api/v1/account', (req, res) => {
  db.account.findOne({ where: {cardNumber: req.query.cardNumber} })
    .then((account) => {
      if (account) {
        res.status(200).send({
          name: account.name,
          balance: account.balance
        });
      } else {
        res.status(200).send({});
      }
    });
});

app.post('/api/v1/charge', (req, res) => {
  console.log(req.body);
  res.status(200).send({
    status: 'available'
  });
});

app.listen(PORT, () => {
  console.log(`server running on port ${PORT}`);
});
