<?php
include_once 'src/autoloader.php';

$router = new Router(new Request);
$dotEthes = new DotEthes(__DIR__);
$dotEthes->load();

/***************/
/* ROUTE PATHS */
/************* */

/** GET */
$router->get('/', function($request) {
  header("Location: /browse");
  exit();
});

$router->get('/login', function($request) {
  return LoginGetController::control($request);
}, [new TokenValidationMiddleware, new LoginRegisterMiddleware]);

$router->get('/register', function($request) {
  return RegisterGetController::control($request);
}, [new TokenValidationMiddleware, new LoginRegisterMiddleware]);

$router->get('/completeprofile', function($request) {
  return CompleteProfileGetController::control($request);
}, [new TokenValidationMiddleware, new ProfileIncompleteMiddleware]);

$router->get('/logout', function($request) {
  return LogoutGetController::control($request);
}, [new TokenValidationMiddleware, new LogoutAuthMiddleware]);

$router->get('/browse', function($request) {
  return BrowseGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/search', function($request) {
  return SearchGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/book', function($request) {
  return BookGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/history', function($request) {
  return HistoryGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/review', function($request) {
  return ReviewGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/profile', function($request) {
  return ProfileGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/edit', function($request) {
  return EditGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/about', function($request) {
  return AboutGetController::control($request);
}, [new TokenValidationMiddleware, new AuthMiddleware]);

$router->get('/deletecookie', function($request) {
  $db = new MarufDB();
  $db->deleteToken($request->token);
  setcookie('token', '', time() - 3600, '/');
});

/** POST */
$router->post('/login', function($request) {
  return LoginPostController::control($request);
});

$router->post('/register', function($request) {
  return RegisterPostController::control($request);
}, [new VerifyRegisterMiddleware]);

$router->post('/completeprofile', function($request) {
  return CompleteProfilePostController::control($request);
}, [new TokenValidationMiddleware, new ProfileIncompleteMiddleware]);

$router->post('/edit', function($request) {
  return EditPostController::control($request);
});

$router->post('/review', function($request) {
  return ReviewPostController::control($request);
});

$router->post('/googlelogin', function($request) {
  return GoogleLoginPostController::control($request);
});

/************/
/* REST API */
/************/

/** GET */
$router->get('/username', function($request) {
  return json_encode(Api::validateUsername($request->username));
});

$router->get('/email', function($request) {
  return json_encode(Api::validateEmail($request->email));
});

$router->get('/soapsearch', function($request) {
  return json_encode(Api::search($request->query));
});

$router->get('/cardnumber', function($request) {
  return json_encode(Api::validateCardNumber($request->cardnumber));
});

$router->get('/isusinggoogle', function($request) {
  return json_encode(Api::checkUsingGoogle());
});

/** POST */
$router->post('/order', function($request) {
  return json_encode(Api::order($request));
}, [new TokenValidationMiddleware, new ApiAuthMiddleware]);