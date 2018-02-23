       <?php
$app = new Slim();

$app->get('/categories', 'getCategories');
$app->post('/appsignup', 'userSignup');
$app->post('/appsignin', 'login');
$app->get('/settings', 'settings');
/*$app->get('/featuredProduct', 'featuredProduct');
$app->get('/productsBySubCategory/:id', 'productsBySubCategory');
$app->get('/addtocart/:userid/:id/:qty', 'addToCart');
$app->get('/emptyCart/:userid', 'emptyCart');
$app->get('/getCart/:userid', 'getCart');*/

$app->post('/checkout', 'checkout');
$app->post('/saveShippingAddress', 'saveShippingAddress');
$app->post('/getShippingAddress', 'getShippingAddress');

$app->post('/productsByCategory', 'productsByCategory');
$app->post('/productsByShop', 'productsByShop');
$app->post('/productsSearchByName', 'productsSearchByName');

$app->post('/userdetails', 'userDetails');
$app->post('/updatePhoto', 'updatePhoto');
$app->post('/changePassword', 'changePassword');

$app->post('/changeEmail', 'changeEmail');

$app->post('/addShop', 'addShop');
$app->post('/editShop', 'editShop');
$app->post('/activateShop', 'activateStore');
$app->post('/shopDetails', 'shopDetails');

$app->post('/listMyShops', 'listMyShops');
$app->post('/addProducts', 'addProducts');
$app->post('/listProducts', 'listProducts');
$app->post('/removeMyProduct', 'removeMyProduct');
$app->post('/productDetails', 'productDetails');
$app->post('/updateProductInventory', 'updateProductInventory');



$app->post('/updateProfile', 'updateProfile');
$app->post('/addToWishlist', 'addToWishlist');
$app->post('/removeFromWishlist/:user_id/:product_id', 'removeFromWishlist');
$app->post('/getWishlist/:user_id', 'getWishlist');
$app->post('/getOrderListBuyer', 'getOrderListBuyer');
$app->post('/getOrderListSeller', 'getOrderListSeller');
$app->get('/getOederDetails/:order_id', 'getOederDetails');
$app->post('/facebookSignup', 'facebookSignup');

$app->get('/checksan/:id', 'checksan');
$app->post('/forgotPassword', 'forgotPassword');
$app->get('/home', 'home');
$app->get('/listStores', 'listStores');
$app->post('/getCart', 'getCart');
$app->post('/removeProductFromCart', 'removeProductFromCart');
$app->post('/addtocart', 'addToCart');
$app->post('/editcart', 'editCart');

$app->post('/getOrderList', 'getOrderList');
$app->post('/getOederDetails', 'getOederDetails');


//$app->get('/login', 'login');

/*$app->get('/wines/:id',	'getWine');
$app->get('/wines/search/:query', 'findByName');
$app->post('/wines', 'addWine');
$app->put('/wines/:id', 'updateWine');
$app->delete('/wines/:id',	'deleteWine');*/
//$app->get('/signup', 'userSignup');
$app->run();
?>
