<?php
function render_template(bool $error = FALSE, bool $redirected = FALSE) {
  return <<<HTML

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link rel='stylesheet' href='src/view/static/css/common.css'>
  <link rel='stylesheet' href='src/view/static/css/auth.css'>
  <link rel='stylesheet' href='src/view/static/css/login.css'>
  <meta name="google-signin-scope" content="profile email">
  <meta name="google-signin-client_id" content="248062336710-1caa1sjcc7vicoq05a0ac0m8ctlien6k.apps.googleusercontent.com">
  <script type='module' src='src/view/static/js/login.js'></script>
  <script src="https://apis.google.com/js/client:platform.js?onload=renderButton" async defer></script>
  <link rel="stylesheet" href="src/view/static/css/fonts.css" type='text/css'>
  <title>Login</title>
</head>
<body>
HTML
.
  ($redirected ?
  <<<HTML
  <div id='redirectedMessageContainer' class='auth-info-message-container'>
    <p>Please login first</p>
  </div>
HTML
  : '')
.
  ($error ?
    <<<HTML
    <div id='invalidCredentialsMessageContainer' class='auth-error-message-container'>
      <p>Incorrect username or password</p>
    </div>
HTML
  : '')
.
  <<<HTML
	<div class='auth-page-container'>
		<div class='auth-pane-container'>
      <div class='auth-pane-content'>
        <div class='auth-header-container'>
          <div id='titleContainer' class='auth-title-container'>
            <h1 class='auth-title'>LOGIN</h1>
          </div>
          <div id='inputValidationMessageContainer' class='auth-input-validation-message-container'>
            <p id='inputValidationMessage'></p>
          </div>
        </div>
        <form id='loginForm' action='/login' method='post'>

          <div class='auth-form-item'>
            <div class='auth-form-item-label-container'>
              <h4>Username</h4>
            </div>
            <div class='auth-form-item-field-container'>
              <input id='formUsernameField' type='text' name='username'>
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
  
        </form>
        <div class='auth-alt-container'>
          <a href='/register'>
            <p>Don't have an account?</p>
          </a>
        </div>
        <div class='auth-submit-container'>
          <button id='formSubmitButton' type='submit' form='loginForm' disabled>
            <div id='formSubmitButtonInner' class='auth-submit-inner'>
              LOGIN
            </div>
          </button>
        </div>
        <hr/>
        <div class='auth-google-container'>
          <div id='googleSignInButton' class='g-signin2' data-onsuccess='onSignIn' data-theme='dark'></div>  
          <script>
            function onSignIn(googleUser) {
              const profile = googleUser.getBasicProfile();

              const form = document.createElement('form');
              form.method = 'post';
              form.action = '/googlelogin';

              const emailField = document.createElement('input');
              emailField.type = 'hidden';
              emailField.name = 'email';
              emailField.value = profile.getEmail();

              const nameField = document.createElement('input');
              nameField.type = 'hidden';
              nameField.name = 'name';
              nameField.value = profile.getName();

              form.appendChild(emailField);
              form.appendChild(nameField);
              document.body.appendChild(form);
              form.submit();
              document.body.removeChild(form);
            }
          </script>
        </div>
      </div>
		</div>
	</div>
</body>
</html>

HTML;
}
