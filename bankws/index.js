require('dotenv').config()
const express = require('express');
const Sequelize = require('sequelize');
const dotenv = require('dotenv');

const vars = dotenv.config();
if (vars.error) {
  throw vars.error
}

const sequelize = new Sequelize({
  host: process.env.BANK_DB_HOST,
  username: process.env.BANK_DB_USER,
  password: process.env.BANK_DB_PASS,
  database: process.env.BANK_DB_NAME,
  dialect: 'mysql'
});

const PORT = 5000;
const app = express();

app.get('/api/v1/status', (_, res) => {
  res.status(200).send({
    status: 'available'
  });
});

app.get('/api/v1/account', (req, res) => {
  const cardNumber = req.query.cardNumber;
  Post.findAll({
    where: {
      authorId: 2
    }
  });
  res.status(200).send({
    cardNumber: cardNumber
  });
});

app.post('/api/v1/charge', (req, res) => {
  res.status(200).send({
    status: 'available'
  });
});

app.listen(PORT, () => {
  console.log(`server running on port ${PORT}`);
});
