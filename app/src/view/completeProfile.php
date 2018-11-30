<?php
function render_template(string $name, string $email) {
  return <<<HTML

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link rel='stylesheet' href='src/view/static/css/common.css'>
  <link rel='stylesheet' href='src/view/static/css/auth.css'>
  <link rel='stylesheet' href='src/view/static/css/register.css'>
  <link rel='stylesheet' href='src/view/static/css/completeProfile.css'>
  <script type='module' src='src/view/static/js/completeProfile.js'></script>
  <link rel="stylesheet" href="src/view/static/css/fonts.css" type='text/css'>
  <meta name="google-signin-client_id" content="248062336710-1caa1sjcc7vicoq05a0ac0m8ctlien6k.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/client:platform.js" async defer></script>
  <title>Complete Your Profile</title>
</head>
<body>
	<div class='auth-page-container'>
		<div class='auth-pane-container'>
      <div class='auth-pane-content'>
        <div class='auth-header-container'>
          <div id='titleContainer' class='auth-title-container'>
            <h1 class='auth-title'>COMPLETE YOUR<br>PROFILE</h1>
          </div>
          <div id='inputValidationMessageContainer' class='auth-input-validation-message-container'>
            <p id='inputValidationMessage'></p>
          </div>
        </div>
        <form action='/completeprofile' method='post' id='completeProfileForm'>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Name</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <div class='auth-form-item-field-text-container'>
                <h5>{$name}</h5>
              </div>
            </div>
          </div>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Email</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <div class='auth-form-item-field-text-container'>
                <h5>{$email}</h5>
              </div>
            </div>
          </div>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Username</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <div class='auth-form-item-field-text-container'>
                <input id='formUsernameField' type='text' name='username'>
              </div>
              <div id='formUsernameValidation' class='auth-form-item-field-validation-container'>
                <img id='formUsernameValidationIcon' class='auth-form-item-validation-icon' src='src/view/static/img/icon_failed.svg' alt='Validation icon'>
              </div>
            </div>
          </div>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Password</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <input id='formPasswordField' type='password' name='password'>
            </div>
          </div>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Confirm Password</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <input id='formConfirmPasswordField' type='password' name='confirmPassword'>
            </div>
          </div>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Card Number</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <div class='auth-form-item-field-text-container'>
                <input id='formCardNumberField' type='text' name='cardNumber'>
              </div>
              <div id='formCardNumberValidation' class='auth-form-item-field-validation-container'>
                <img id='formCardNumberValidationIcon' class='auth-form-item-validation-icon' src='src/view/static/img/icon_failed.svg' alt='Validation icon'>
              </div>
            </div>
          </div>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Address</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <textarea id='formAddressField' name='address' form='completeProfileForm'></textarea>
            </div>
          </div>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Phone Number</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <input id='formPhoneNumberField' type='text' name='phone_number'>
            </div>
          </div>

        </form>
        <div class='g-signin2' hidden></div>
        <form id='logoutForm' action='/logout' method='get'></form>
        <div class='complete-profile-buttons-container'>
          <button id='cancelButton' class='complete-profile-cancel-button'>
            CANCEL
          </button>
          <button id='formSubmitButton' type='submit' form='completeProfileForm' disabled>
            <div id='formSubmitButtonInner' class='auth-submit-inner'>
              CONFIRM
            </div>
          </button>
        </div>
      </div>
		</div>
	</div>
</body>
</html>

HTML;
}
