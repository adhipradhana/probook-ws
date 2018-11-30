import $$ from './lib/jQowi.js';

$$('#orderButton').onclick = () => {
  $$('#purchaseMessageBackground').style.zIndex = 2;
  $$('#purchaseMessagePopup').style.zIndex = 2;
  setTimeout(() => {
    $$('#purchaseMessageBackground').classList.add('visible');
    $$('#purchaseMessagePopup').classList.add('visible');
    $$('#otpNumberField0').focus();
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
  let otpCode = "";
  for (let i = 0; i < 6; i++) {
    otpCode += $$('#otpNumberField' + i).value;
  }
  const data = {
    'book_id': book_id,
    'otp': otpCode,
    'quantity': parseInt($$('#orderQuantitySelector').value, 10)
  }

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
      console.log(response);
      response = JSON.parse(response);

      $$('#orderOTPButton').disabled = false;

      if (response.orderNumber == -1) {
        $$('#statusMessagePopupText').innerHTML = response.message;
        $$('#orderStatus').innerHTML = 'Purchase Failed!';
        if ( $$('#imageStatus').classList.contains('book-purchase-message-popup-content-icon-img') ) {
          $$('#imageStatus').classList.remove('book-purchase-message-popup-content-icon-img');
        }
        $$('#imageStatus').classList.add('book-purchase-message-popup-content-icon-img-fail');
      } else {
        $$('#orderStatus').innerHTML = 'Purchase Successful!';
        $$('#statusMessagePopupText').innerHTML = 'Transaction Number: ' + response.orderNumber;

        if ( $$('#imageStatus').classList.contains('book-purchase-message-popup-content-icon-img-fail') ) {
          $$('#imageStatus').classList.remove('book-purchase-message-popup-content-icon-img-fail');
        }
        $$('#imageStatus').classList.add('book-purchase-message-popup-content-icon-img');
      }

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

function isNum(value) {
  const re = /^\d+$/;
  return re.test(value);
}

const handleOTPInputs = (key, idx) => {
  if (!isNum(key.key)) {
    key.preventDefault();
  }
}

const handleOTPBackspace = (key, idx) => {
  if (key.key == 'Backspace' && $$('#otpNumberField' + idx).value == "") {
    if (idx > 0) $$('#otpNumberField' + (idx - 1)).value = "";
    checkOTPInputs();
  }
}

const checkOTPInputs = () => {
  for (let i = 0; i < 6; i++) {
    const input = $$('#otpNumberField' + i);
    if (input.value.length == 0) {
      input.focus();
      break;
    }
  }
}

for (let i = 0; i < 6; i++) {
  $$('#otpNumberField' + i).onkeypress = (key) => { handleOTPInputs(key, i) };
  $$('#otpNumberField' + i).onkeydown = (key) => { handleOTPBackspace(key, i) };
  $$('#otpNumberField' + i).oninput = checkOTPInputs;
}