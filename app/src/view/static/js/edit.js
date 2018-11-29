import $$ from './lib/jQowi.js';

const invalidNameMessage = 'Name must be a valid person name with less than 20 characters';
const invalidAddressMessage = 'Address cannot be empty';
const invalidPhoneNumberMessage = 'Phone number must be a number with 9 to 12 digits';
const checkingCardNumberMessage = 'Please wait, we are validating your card number...';
const invalidCardNumberMessage = 'Card number invalid';
const invalidImageMessage = 'Image must be in JPG format';

let cardNumberValidationMessage = invalidCardNumberMessage;
let cardNumberValid = true;
let cardNumberValidationRequest;

let submitButtonHovered = false;
let imageSelected = false;

function isName(value) {
  const re = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
  return re.test(value);
}

function isNum(value) {
  const re = /^\d+$/;
  return re.test(value);
}

function isJPG(value) {
  return value.endsWith('.jpg');
}

function showInputValidationMessage() {
  $$('#inputValidationMessageContainer').classList.add('visible');
  $$('#inputValidationMessage').classList.add('visible');
}

function hideInputValidationMessage() {
  $$('#inputValidationMessageContainer').classList.remove('visible');
  $$('#inputValidationMessage').classList.remove('visible');
}

function updateInputValidationMessage(message) {
  $$('#inputValidationMessage').innerHTML = message;
}

function validateInput(_) {
  const nameField = $$('#nameField');
  const addressField = $$('#addressField');
  const phoneNumberField = $$('#phoneNumberField');
  const imagePath = $$('#fileNameTextArea').value;
  const submitButton = $$('#submitButton');

  if (!isName(nameField.value) || nameField.value.length == 0 || nameField.value.length > 20) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidNameMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (addressField.value.length == 0) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidAddressMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (!isNum(phoneNumberField.value) || phoneNumberField.value.length < 9 || phoneNumberField.value.length > 12) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidPhoneNumberMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (!cardNumberValid) {
    submitButton.disabled = true;
    updateInputValidationMessage(cardNumberValidationMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (imageSelected && !isJPG(imagePath)) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidImageMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else {
    submitButton.disabled = false;
    hideInputValidationMessage();
  }
}

function validateCardNumber(_) {
  const cardNumber = event.target.value;
  const cardNumberValidationIcon = $$('#cardNumberFieldValidationIcon');
  const submitButton = $$('#submitButton');
  cardNumberValidationIcon.style.opacity = 1;
  if (cardNumberValidationRequest) cardNumberValidationRequest.abort();
  if (isNum(cardNumber)) {
    submitButton.disabled = true;
    cardNumberValid = false;
    cardNumberValidationMessage = checkingCardNumberMessage;
    cardNumberValidationRequest = $$.ajax({
      method: 'GET',
      url: '/cardnumber?cardnumber=' + cardNumber,
      callback: (response) => {
        response = JSON.parse(response);
        const cardNumberValidationIcon = $$('#cardNumberFieldValidationIcon');
        const submitButton = $$('#submitButton');
        if (response.valid) {
          cardNumberValidationIcon.src = 'src/view/static/img/icon_success.svg';
          submitButton.disabled = false;
          cardNumberValid = true;
        } else {
          cardNumberValidationIcon.src = 'src/view/static/img/icon_failed.svg';
          submitButton.disabled = true;
          cardNumberValid = false;
          cardNumberValidationMessage = invalidCardNumberMessage;
        }
        validateInput(null);
      },
    });
  } else {
    cardNumberValidationIcon.src = 'src/view/static/img/icon_failed.svg';
    submitButton.disabled = true;
    cardNumberValid = false;
    cardNumberValidationMessage = invalidCardNumberMessage;
  }
  validateInput(null);
}

$$('#fileNameTextArea').disabled = true;
$$('#fileNameTextArea').value ='Choose file...';

$$('#fileUploadContainer').onclick = () => {
  $$('#fileToUpload').click();
};

$$('#fileToUpload').onchange = () => {
  $$('#fileNameTextArea').value = $$('#fileToUpload').value.split('\\').pop();
  imageSelected = true;
  validateInput();
};

$$('#cardNumberField').oninput = validateCardNumber;

$$('#nameField').oninput = validateInput;
$$('#addressField').oninput = validateInput;
$$('#phoneNumberField').oninput = validateInput;

$$('#submitButtonContainer').onmouseenter = () => {
  if ($$('#submitButton').disabled) {
    showInputValidationMessage();
  }
  submitButtonHovered = true;
};

$$('#submitButtonContainer').onmouseleave = () => {
  hideInputValidationMessage();
  submitButtonHovered = false;
};
