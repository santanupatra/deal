       <?php
$app = new Slim();

$app->get('/categories', 'getCategories');
$app->post('/getCategoriesByShop', 'getCategoriesByShop');
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

$app->post('/productsWithoutCategory', 'productsWithoutCategory');
$app->post('/productsByCategory', 'productsByCategory');
$app->post('/productsByShop', 'productsByShop');
$app->post('/productsSearchByName', 'productsSearchByName');
$app->post('/allsearch', 'allsearch');

$app->post('/userdetails', 'userDetails');
$app->post('/updatePhoto', 'updatePhoto');
$app->post('/changePassword', 'changePassword');

$app->post('/changeEmail', 'changeEmail');
$app->post('/dashboard', 'dashboard');



$app->post('/addShop', 'addShop');
$app->post('/editShop', 'editShop');
$app->post('/activateShop', 'activateStore');
$app->post('/shopDetails', 'shopDetails');
$app->post('/allshop', 'allshop');

$app->post('/listMyShops', 'listMyShops');
$app->post('/addProducts', 'addProducts');
$app->post('/updateProductImage', 'updateProductImage');
$app->post('/listProducts', 'listProducts');
$app->post('/allProducts', 'allProducts');
$app->post('/removeMyProduct', 'removeMyProduct');
$app->post('/productDetails', 'productDetails');
$app->post('/updateProductInventory', 'updateProductInventory');



$app->post('/updateProfile', 'updateProfile');
$app->post('/addToWishlist', 'addToWishlist');
$app->post('/removeFromWishlist', 'removeFromWishlist');
$app->post('/getWishlist', 'getWishlist');
$app->post('/getOrderListBuyer', 'getOrderListBuyer');
$app->post('/getOrderListSeller', 'getOrderListSeller');
$app->post('/getPurchaseHistoryBuyer', 'getPurchaseHistoryBuyer');
$app->get('/getOederDetails/:order_id', 'getOederDetails');
$app->post('/facebookSignup', 'facebookSignup');

$app->get('/checksan/:id', 'checksan');
$app->post('/forgotPassword', 'forgotPassword');
$app->post('/home', 'home');
$app->get('/listStores', 'listStores');
$app->post('/getCart', 'getCart');
$app->post('/removeProductFromCart', 'removeProductFromCart');
$app->post('/addtocart', 'addToCart');
$app->post('/editcart', 'editCart');
$app->post('/buynow', 'buynow');
$app->post('/mybuyerinbox', 'mybuyerinbox');
$app->post('/mybuyersent', 'mybuyersent');
$app->post('/mysellerinbox', 'mysellerinbox');
$app->post('/mysellersent', 'mysellersent');
$app->post('/mysellerfolder', 'mysellerfolder');
$app->post('/message_favorite', 'message_favorite');
$app->post('/getOrderList', 'getOrderList');
$app->post('/getOederDetails', 'getOederDetails');

$app->post('/myfollow', 'myfollow');
$app->post('/unfollow', 'unfollow');
$app->post('/follow', 'follow');
$app->post('/rateorder', 'rateorder');
$app->post('/OrderDetails', 'OrderDetails');
$app->post('/orderemail', 'orderemail');
$app->post('/deletebuyerinbox', 'deleteinbox');
$app->post('/deletesellerinbox', 'deletesellerinbox');
$app->post('/messagedetails', 'messagedetails');
$app->post('/messagereply', 'messagereply');
$app->post('/addfeedback', 'addfeedback');
$app->post('/removetemcart', 'removetemcart');
$app->post('/cancelorder', 'cancelorder');
$app->post('/selleracceptcancel', 'selleracceptcancel');
$app->post('/sellerrejectcancel', 'sellerrejectcancel');
$app->post('/sellercancelorder', 'sellercancelorder');
$app->post('/extendprocessingtime', 'extendprocessingtime');
$app->post('/acceptextendprocessingtime', 'acceptextendprocessingtime');
$app->post('/rejectextendprocessingtime', 'rejectextendprocessingtime');
$app->post('/buyerreceivedorder', 'buyerreceivedorder');
$app->post('/getawaitingshipmentSeller', 'getawaitingshipmentSeller');
$app->post('/getdisputeSeller', 'getdisputeSeller');
$app->post('/getfinishSeller', 'getfinishSeller');
$app->post('/addtrack', 'addtrack');
$app->post('/opendispute', 'opendispute');
$app->post('/acceptdisputebyseller', 'acceptdisputebyseller');
$app->post('/rejectdisputebyseller', 'rejectdisputebyseller');
$app->post('/buyeracceptdispute', 'buyeracceptdispute');
$app->post('/buyercanceldispute', 'buyercanceldispute');
$app->post('/disputemessage', 'disputemessage');
$app->post('/disputehistory', 'disputehistory');
$app->post('/messagehistory', 'messagehistory');
$app->post('/sellerfeedbacklist', 'sellerfeedbacklist');
$app->post('/sellerreport', 'sellerreport');
$app->post('/homemembership', 'homemembership');
$app->post('/getpaypalemail', 'getpaypalemail');
$app->post('/renewpayment', 'renewpayment');


//$app->get('/login', 'login');

/*$app->get('/wines/:id',	'getWine');
$app->get('/wines/search/:query', 'findByName');
$app->post('/wines', 'addWine');
$app->put('/wines/:id', 'updateWine');
$app->delete('/wines/:id',	'deleteWine');*/
//$app->get('/signup', 'userSignup');
$app->run();
?>
