<?php
function render_template(string $username) {
  return <<<HTML

<!DOCTYPE html>
<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link rel='stylesheet' href='src/view/static/css/common.css'>
  <link rel='stylesheet' href='src/view/static/css/main.css'>
  <link rel='stylesheet' href='src/view/static/css/browse.css'>
  <link rel='stylesheet' href='src/view/static/css/search.css'>
  <script type='module' src='src/view/static/js/main.js'></script>
  <script type='module' src='src/view/static/js/browse.js'></script>
  <script src='src/view/static/js/app.js'></script>
  <script src='src/view/static/js/lib/angular.soap.js'></script>
  <script src='src/view/static/js/lib/soapclient.js'></script>
  <link rel="stylesheet" href="src/view/static/css/fonts.css" type='text/css'>
  <meta name="google-signin-client_id" content="248062336710-1caa1sjcc7vicoq05a0ac0m8ctlien6k.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/client:platform.js?" async defer></script>
  <title>Pro-Book</title>
</head>
<body>
  <div id='inputValidationMessageContainer' class='main-input-validation-message-container'>
    <p id='inputValidationMessage' class='main-input-validation-message'></p>
  </div>
	<div class='main-page-container'>
    <div class='main-header-container'>
      <div class='main-header-top-container'>
        <div id='titleContainer' class='main-title-container'>
          <div class='main-title-zstack'>
            <h1 id='titleShadow' class='main-title-shadow'>PRO-BOOK</h1>
          </div>
          <div class='main-title-zstack'>
            <h1 id='titleBackground' class='main-title-background'>PRO-BOOK</h1>
          </div>
          <div class='main-title-zstack'>
            <h1 id='titleText' class='main-title-text'><span class='main-title-text-first'>PRO</span>-BOOK</h1>
          </div>
        </div>
        <div class='main-misc-container'>
          <div class='main-greeting-container'>
            <h5>Hi, {$username}!</h5>
          </div>
          <div id='logoutButtonContainer' class='main-logout-button-container'>
            <form id='logoutForm' action='/logout' method='get'></form>
            <button id="logoutButton" class='main-logout-button'>
              <div id="logoutButtonIcon" class='main-logout-button-icon'></div>
            </button>
            <div class="g-signin2" hidden></div>
          </div>
        </div>
      </div>
      <div class='main-header-bottom-container'>
        <div id='browseTab' class='main-menu-tab tab-selected'>
          <h3>Browse</h3>
        </div>
        <div id='historyTab' class='main-menu-tab tab-mid'>
          <h3>History</h3>
        </div>
        <div id='profileTab' class='main-menu-tab'>
          <h3>Profile</h3>
        </div>
      </div>
    </div>
    <div ng-class="{'search-main-content-container': status , 'main-content-container': !status }" ng-app="probookSearch" ng-controller="searchBook">

        <div class='browse-content-container'>
          <div class='browse-title-container'>
            <h1 class='browse-title'>Search B<a class='o-button' href='/about'>o</a><a class='o-button' href='/about'>o</a>ks</h1>
          </div>
          <form id='browseForm' class='browse-form'>
            <input id='queryField' type='text' name='title' placeholder='Input search terms...' autofocus ng-model="query">
          </form>
          <div class='browse-submit-container'>
            <button id='submitButton' type='submit' form='browseForm' disabled ng-click="search()">
              <div id='submitButtonInner' class='browse-submit-inner'>
                SEARCH
              </div>
            </button>
          </div>
        </div>

        <div ng-if="status" class='ng-search-content-container'>
          <div class='search-title-container'>
            <h1 class='search-title'>Search Result</h1>
            <div class='search-result-count-container add-background'>
              <h4 class='search-result-count'>Found {{ books.length }} results</h4>
            </div>
          </div>
          <div class='search-result-container'>
          
          <div ng-repeat="book in books">
            <div class='search-book-container'>
              <div class='search-book-content-container'>
                <div class='search-book-image-container'>
                  <img class='search-book-image' src="{{ book.image }}"/>
                </div>
                <div class='search-book-text-container'>
                  <h4 class='book-title'>{{ book.title }}</h4>
                  <h4 class='book-author'>{{ book.authors }} - {{ book.rating }} / 5.0 from {{ book.rating_count }} votes</h4>
                  <h4 class='book-author'>{{ book.price }}</h5>
                  <p class='book-description'>{{ book.description }}</p>
                </div>
              </div>
              <div class='search-detail-button-container'>
                <form id='bookDetail-{{book.id}}' action='/book' method='get'>
                  <input hidden name='id' value={{book.id}}>
                </form>
                <button class='search-detail-button' type='submit' form='bookDetail-{{book.id}}'>
                  <div class='search-detail-button-inner'>
                    DETAILS
                  </div>
                </button>
              </div>
            </div>
          </div>
        </div>
        
    </div>
	</div>
</body>
</html>

HTML;
}
