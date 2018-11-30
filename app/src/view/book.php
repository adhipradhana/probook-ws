<?php
function render_template(string $username, $book, $recommends, $reviews) {
  $reviewsHTML = "";
  $bookId = $book['id'];
  $bookImagePath = $book['image'];

  $rating = round($book['rating'], 1);
  $intRating = round($rating, 0, PHP_ROUND_HALF_UP);

  $ratingText = "" . $rating;
  if (($rating * 10) % 10 == 0) {
    $ratingText = $ratingText . ".0";
  }

  $orderHTML = "";
  $orderJS = "";
  $reviewContainerOpenHTML = "";
  $reviewContainerCloseHTML = "";
  $reviewContainerHTML = "";
  
  $ratingOpenHTML = "";
  $ratingCloseHTML = "";
  $recs = "";

  if (!is_null($recommends)) {
    $recs = $recs . <<<HTML
<div class='book-review-content-container'>
    <h3>You Might Also Like</h3>
</div>
HTML;
    foreach ($recommends as $recommend) {
      $recs = $recs . <<<HTML
<div class='search-book-container'>
  <div class='search-book-content-container'>
    <div class='search-book-image-container'>
      <img class='search-book-image' src="{$recommend['image']}"/>
    </div>
    <div class='search-book-text-container'>
      <h4 class='book-title'>{$recommend['title']}</h4>
      <h4 class='book-author'>{$recommend['authors']} - {$recommend['rating']} / 5.0 from {$recommend['rating_count']} votes</h4>
      <h4 class='book-author'>{$recommend['price']}</h5>
      <p class='book-description'>{$recommend['description']}</p>
    </div>
  </div>
  <div class='search-detail-button-container'>
    <form id='bookDetail-{$recommend['id']}' action='/book' method='get'>
      <input hidden name='id' value={$recommend['id']}>
    </form>
    <button class='search-detail-button' type='submit' form='bookDetail-{$recommend['id']}'>
      <div class='search-detail-button-inner'>
        DETAILS
      </div>
    </button>
  </div>
</div>
HTML;
    }
  } 

  if ($book['price'] != 'NOT FOR SALE') {
    $orderHTML = <<<HTML
<div class='book-order-container'>
  <div class='book-order-title-container'>
    <h3 class='book-order-title'>Order</h3>
  </div>
  <div class='book-order-dropdown-container add-background'>
    <h4 class='book-order-dropdown-label'>Amount: </h4>
    <select id='orderQuantitySelector' name='orderQuantity'>
      <option value='1'>1</option>
      <option value='2'>2</option>
      <option value='3'>3</option>
      <option value='4'>4</option>
      <option value='5'>5</option>
      <option value='6'>6</option>
      <option value='7'>7</option>
    </select>
  </div>
  <div class='book-order-button-container'>
    <input hidden id='bookIdField' value={$bookId}>
    <button id='orderButton' class='book-order-button'>
      <div class='book-order-button-inner'>
        ORDER
      </div>
    </button>
  </div>
</div>
HTML;

    $reviewContainerOpenHTML = <<<HTML
<div class='book-review-container'>
  <div class='book-review-title-container'>
    <h3 class='book-review-title'>Review</h3>
  </div>
  <div class='book-review-content-container'>
HTML;

    $reviewContainerCloseHTML = <<<HTML
  </div>
</div>
HTML;

    $ratingOpenHTML = <<<HTML
<div class='book-detail-stars-container add-background'>
HTML;

    $ratingCloseHTML = <<<HTML
</div>
<div class='book-detail-rating-container add-background'>
  <h4 class='book-detail-rating'>{$ratingText} / 5.0</h4>
</div>
HTML;

    $orderJS = <<<HTML
<script type='module' src='src/view/static/js/book.js'></script>
HTML;
  }

  $starsHTML = "";
  for ($x = 0; $x < $intRating; $x++) {
    $starsHTML = $starsHTML . <<<HTML

<div class="book-detail-star-icon"></div>

HTML;
  }
  for ($x = 0; $x < 5 - $intRating; $x++) {
    $starsHTML = $starsHTML . <<<HTML

<div class="book-detail-star-icon star-icon-empty"></div>

HTML;
  }

  foreach($reviews as $review) {
    $profileImagePath = "src/model/profile/".$review['user_id'].".jpg";
    if(!file_exists($profileImagePath)) {
      $profileImagePath = 'src/model/profile/avatar_default.jpg';
    }

    $reviewHTML = <<<HTML

<div class='book-review-item-container'>
  <div class='book-review-item-left-container'>
    <div class='book-review-item-profile_image-container'>
      <img class='book-review-item-profile_image' src='{$profileImagePath}'>
    </div>
  </div>
  <div class='book-review-item-center-container'>
    <h4 class='book-review-item-username'>@{$review['username']}</h4>
    <p class='book-review-item-text'>{$review['comment']}</p>
  </div>
  <div class='book-review-item-right-container'>
    <div class='book-review-item-rating-container'>
      <div class='book-review-item-rating-icon'></div>
      <p class='book-review-item-rating-text'>{$review['rating']}.0 / 5.0</p>
    </div>
  </div>
</div>

HTML;
    $reviewsHTML = $reviewsHTML . $reviewHTML;
  }

  if (empty($reviews)) {
    $reviewsHTML = <<<HTML

<h3 class='book-review-empty-message'>No reviews yet!</h3>

HTML;
  }

  return <<<HTML

<!DOCTYPE html>
<html>
<head>
  <link rel="icon" href="favicon.ico" type="image/x-icon" />
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
  <link rel='stylesheet' href='src/view/static/css/common.css'>
  <link rel='stylesheet' href='src/view/static/css/main.css'>
  <link rel='stylesheet' href='src/view/static/css/book.css'>
  <link rel='stylesheet' href='src/view/static/css/search.css'>
  <script src='src/view/static/js/order.js'></script>
  <script type='module' src='src/view/static/js/main.js'></script>
  {$orderJS}
  <link rel="stylesheet" href="src/view/static/css/fonts.css" type='text/css'>
  <meta name="google-signin-client_id" content="248062336710-1caa1sjcc7vicoq05a0ac0m8ctlien6k.apps.googleusercontent.com">
  <script src="https://apis.google.com/js/client:platform.js" async defer></script>
  <title>{$book['title']} - Browse</title>
</head>
<body>

  <div id='purchaseMessageBackground' class='book-purchase-message-background'>
  </div>
  <div id='purchaseMessagePopup' class='book-purchase-message-popup'>
    <div class='book-purchase-message-popup-close-container'>
      <div id='purchaseMessagePopupCloseButton' class='book-purchase-message-popup-close'></div>
    </div>
    <div class='book-purchase-message-popup-content'>
        <h3>Insert TOTP Code</h3>
        <form id='otpForm' class='book-otp-form'>
          <div class='book-otp-field-container'>
            <input id='otpNumberField0' class='book-otp-number-field' type='text' name='title' maxlength="1" autofocus ng-model="query">
            <input id='otpNumberField1' class='book-otp-number-field' type='text' name='title' maxlength="1" autofocus ng-model="query">
            <input id='otpNumberField2' class='book-otp-number-field' type='text' name='title' maxlength="1" autofocus ng-model="query">
            <input id='otpNumberField3' class='book-otp-number-field' type='text' name='title' maxlength="1" autofocus ng-model="query">
            <input id='otpNumberField4' class='book-otp-number-field' type='text' name='title' maxlength="1" autofocus ng-model="query">
            <input id='otpNumberField5' class='book-otp-number-field' type='text' name='title' maxlength="1" autofocus ng-model="query">
          </div>
        </form>
        <button id='orderOTPButton' class='order-otp-button'>ORDER</button>
    </div>
  </div>

  <div id='statusMessagePopup' class='book-purchase-message-popup'>
    <div class='book-purchase-message-popup-close-container'>
      <div id='statusMessagePopupCloseButton' class='book-purchase-message-popup-close'></div>
    </div>
    <div class='book-status-message-popup-content'>
      <div class='book-purchase-message-popup-content-icon-container'>
        <div class='book-purchase-message-popup-content-icon'>
          <div id="imageStatus"></div>
        </div>
      </div>
      <div class='book-purchase-message-popup-content-text-container'>
        <h3 id='orderStatus'>Purchase Successful!</h3>
        <p id='statusMessagePopupText'></p>
      </div>
    </div>
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
    <div class='main-content-container'>
      <div class='book-content-container'>
        <div class='book-detail-container'>
          <div class='book-detail-left-container'>
            <h3 class='book-detail-title'>{$book['title']}</h3>
            <h4 class='book-detail-author add-background'>{$book['author']}</h4>
            <p class='book-detail-synopsis add-background'>{$book['description']}</p>
          </div>
          <div class='book-detail-right-container'>
            <div class='book-detail-right-content-container'>
              <div class='book-detail-image-container'>
                <img class='book-detail-image' src='{$bookImagePath}'>
              </div>
              <div class='book-detail-rating-container add-background'>
                <h4 class='book-detail-rating'>{$book['price']}</h4>
              </div>
              {$ratingOpenHTML}
              {$starsHTML}
              {$ratingCloseHTML}
            </div>
          </div>
        </div>
        {$orderHTML}

        <div class='book-order-container'>      
          {$recs}
        </div>
        {$reviewContainerOpenHTML}
        {$reviewHTML}
        {$reviewContainerCloseHTML}
      </div>

    </div>
	</div>
</body>
</html>

HTML;
}
