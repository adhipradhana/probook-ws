import $$ from './lib/jQowi.js';

const invalidNameMessage = 'Name must be a valid person name with less than 20 characters';
const invalidUsernameMessage = 'Username must contains alphanumeric or underscore';
const checkingUsernameMessage = 'Please wait, we are checking your username availability...';
const takenUsernameMessage = 'Username already taken';
const invalidPasswordMessage = 'Password must contains at least 6 characters';
const notMatchingPasswordMessage = 'Password confirmation does not match';
const checkingCardNumberMessage = 'Please wait, we are validating your card number...';
const invalidCardNumberMessage = 'Card number invalid';
const invalidAddressMessage = 'Address cannot be empty';
const invalidPhoneNumberMessage = 'Phone number must be a number with 9 to 12 digits';

let usernameValidationMessage = invalidUsernameMessage;
let cardNumberValidationMessage = invalidCardNumberMessage;

let usernameValid = false;
let cardNumberValid = false;

let usernameValidationRequest;
let cardNumberValidationRequest;

let submitButtonHovered = false;

function isName(value) {
  const re = /^[a-zA-Z]+(([',. -][a-zA-Z ])?[a-zA-Z]*)*$/;
  return re.test(value);
}

function isUsername(value) {
  const re = /^[a-zA-Z0-9_]+$/;
  return re.test(value);
}

function isNum(value) {
  const re = /^\d+$/;
  return re.test(value);
}

function showInputValidationMessage() {
  $$('#inputValidationMessageContainer').classList.add('visible');
  $$('#titleContainer').classList.add('moved');
}

function hideInputValidationMessage() {
  $$('#inputValidationMessageContainer').classList.remove('visible');
  $$('#titleContainer').classList.remove('moved');
}

function updateInputValidationMessage(message) {
  $$('#inputValidationMessage').innerHTML = message;
}

function validateInput(_) {
  const nameField = $$('#formNameField');
  const passwordField = $$('#formPasswordField');
  const confirmPasswordField = $$('#formConfirmPasswordField');
  const addressField = $$('#formAddressField');
  const phoneNumberField = $$('#formPhoneNumberField');
  const submitButton = $$('#formSubmitButton');

  if (!isName(nameField.value) || nameField.value.length == 0 || nameField.value.length > 20) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidNameMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (!usernameValid) {
    submitButton.disabled = true;
    updateInputValidationMessage(usernameValidationMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (passwordField.value.length < 6) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidPasswordMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (confirmPasswordField.value != passwordField.value) {
    submitButton.disabled = true;
    updateInputValidationMessage(notMatchingPasswordMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (!cardNumberValid) {
    submitButton.disabled = true;
    updateInputValidationMessage(cardNumberValidationMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (addressField.value.length == 0) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidAddressMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else if (!isNum(phoneNumberField.value) || phoneNumberField.value.length < 9 || phoneNumberField.value.length > 12) {
    submitButton.disabled = true;
    updateInputValidationMessage(invalidPhoneNumberMessage);
    if (submitButtonHovered) showInputValidationMessage();
  } else {
    submitButton.disabled = false;
    hideInputValidationMessage();
  }
}

function validateUsername(_) {
  const username = event.target.value;
  const usernameValidationIcon = $$('#formUsernameValidationIcon');
  const submitButton = $$('#formSubmitButton');
  usernameValidationIcon.style.opacity = 1;
  if (usernameValidationRequest) usernameValidationRequest.abort();
  if (isUsername(username)) {
    submitButton.disabled = true;
    usernameValid = false;
    usernameValidationMessage = checkingUsernameMessage;
    usernameValidationRequest = $$.ajax({
      method: 'GET',
      url: '/username?username=' + username,
      callback: (response) => {
        response = JSON.parse(response);
        const usernameValidationIcon = $$('#formUsernameValidationIcon');
        const submitButton = $$('#formSubmitButton');
        if (response.valid) {
          usernameValidationIcon.src = 'src/view/static/img/icon_success.svg';
          submitButton.disabled = false;
          usernameValid = true;
        } else {
          usernameValidationIcon.src = 'src/view/static/img/icon_failed.svg';
          submitButton.disabled = true;
          usernameValid = false;
          usernameValidationMessage = takenUsernameMessage;
        }
        validateInput(null);
      },
    });
  } else {
    usernameValidationIcon.src = 'src/view/static/img/icon_failed.svg';
    submitButton.disabled = true;
    usernameValid = false;
    usernameValidationMessage = invalidUsernameMessage;
  }
  validateInput(null);
}

function validateCardNumber(_) {
  const cardNumber = event.target.value;
  const cardNumberValidationIcon = $$('#formCardNumberValidationIcon');
  const submitButton = $$('#formSubmitButton');
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
        const cardNumberValidationIcon = $$('#formCardNumberValidationIcon');
        const submitButton = $$('#formSubmitButton');
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

$$('#formUsernameField').oninput = validateUsername;
$$('#formCardNumberField').oninput = validateCardNumber;

$$('#formNameField').oninput = validateInput;
$$('#formPasswordField').oninput = validateInput;
$$('#formConfirmPasswordField').oninput = validateInput;
$$('#formAddressField').oninput = validateInput;
$$('#formPhoneNumberField').oninput = validateInput;

updateInputValidationMessage(invalidNameMessage);

$$('#formSubmitButtonInner').onmouseenter = () => {
  if ($$('#formSubmitButton').disabled) showInputValidationMessage();
  submitButtonHovered = true;
};

$$('#formSubmitButtonInner').onmouseleave = () => {
  hideInputValidationMessage();
  submitButtonHovered = false;
};
