const express = require('express');
const bodyParser = require('body-parser');

const PORT = 5000;
const app = express();

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use('/api/v1', require('./controllers'));

app.listen(PORT, () => {
  console.log(`server running on port ${PORT}`);
});
