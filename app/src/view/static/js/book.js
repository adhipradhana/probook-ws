import $$ from './lib/jQowi.js';

/* 
$$('#orderButton').onclick = () => {
  $$('#orderButton').disabled = true;
  const data = {
    'book_id': parseInt($$('#bookIdField').value, 10),
    'quantity': parseInt($$('#orderQuantitySelector').value, 10)
  }
  $$.ajax({
    method: 'POST',
    url: '/order',
    data: JSON.stringify(data),
    callback: (response) => {
      response = JSON.parse(response);
      $$('#orderButton').disabled = false;
      $$('#purchaseMessagePopupText').innerHTML = 'Transaction Number: ' + response.orderNumber;
      $$('#purchaseMessageBackground').style.zIndex = 2;
      $$('#purchaseMessagePopup').style.zIndex = 2;
      setTimeout(() => {
        $$('#purchaseMessageBackground').classList.add('visible');
        $$('#purchaseMessagePopup').classList.add('visible');
      }, 100);
    },
  })
}; 
*/

$$('#orderButton').onclick = () => {
  $$('#purchaseMessageBackground').style.zIndex = 2;
  $$('#purchaseMessagePopup').style.zIndex = 2;
  setTimeout(() => {
    $$('#purchaseMessageBackground').classList.add('visible');
    $$('#purchaseMessagePopup').classList.add('visible');
  }, 100);
};

$$('#orderOTPButton').onclick = () => {
  var book_id = null, tmp = [];
  location.search
      .substr(1)
      .split("&")
      .forEach(function (item) {
        tmp = item.split("=");
        if (tmp[0] === 'id') book_id = decodeURIComponent(tmp[1]);
      });

  $$('#orderOTPButton').disabled = true;
  const data = {
    'book_id': book_id,
    'otp': $$('#otpField').value,
    'quantity': parseInt($$('#orderQuantitySelector').value, 10)
  }

  console.log(data);

  $$('#purchaseMessageBackground').classList.remove('visible');
  $$('#purchaseMessagePopup').classList.remove('visible');
  setTimeout(() => {
    $$('#purchaseMessageBackground').style.zIndex = -1;
    $$('#purchaseMessagePopup').style.zIndex = -1;
  }, 250);

  $$.ajax({
    method: 'POST',
    url: '/order',
    data: JSON.stringify(data),
    callback: (response) => {
      response = JSON.parse(response);

      $$('#orderOTPButton').disabled = false;

      $$('#statusMessagePopupText').innerHTML = 'Transaction Number: ' + response.orderNumber;
      $$('#purchaseMessageBackground').style.zIndex = 2;
      $$('#statusMessagePopup').style.zIndex = 2;
      setTimeout(() => {
        $$('#purchaseMessageBackground').classList.add('visible');
        $$('#statusMessagePopup').classList.add('visible');
      }, 100);
    },
  })
};

$$('#purchaseMessagePopupCloseButton').onclick = () => {
  $$('#purchaseMessageBackground').classList.remove('visible');
  $$('#purchaseMessagePopup').classList.remove('visible');
  setTimeout(() => {
    $$('#purchaseMessageBackground').style.zIndex = -1;
    $$('#purchaseMessagePopup').style.zIndex = -1;
  }, 250);
};

$$('#statusMessagePopupCloseButton').onclick = () => {
  $$('#purchaseMessageBackground').classList.remove('visible');
  $$('#statusMessagePopup').classList.remove('visible');
  setTimeout(() => {
    $$('#purchaseMessageBackground').style.zIndex = -1;
    $$('#statusMessagePopup').style.zIndex = -1;
  }, 250);
};