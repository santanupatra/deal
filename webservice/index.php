<?php
error_reporting(1);
require 'Slim/Slim.php';
require 'config.php';
require 'crud.php';
require 'routs.php';
require 'class.phpmailer.php';
require 'users.php';

function getCategories() {
    $data = array();
    $allcategories = array();
	$allsubcategories = array();
	$is_active=1;

    $sql = "select * FROM categories  WHERE is_active=:is_active ORDER BY name ASC";
//  exit;
    try {
        $db = getConnection();
		$stmt = $db->prepare($sql);
        $stmt->bindParam("is_active", $is_active);
        $stmt->execute();
        $getcategories = $stmt->fetchAll(PDO::FETCH_OBJ);

        //print_r($getcategories);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getcategories as $categories) {

           //     $image_url = SITE_URL . 'upload/categoryimage/' . $categories->image;
			unset($allsubcategories);
			$allsubcategories = array();
			$sub_sql = "select * FROM categories WHERE `parent_id`='" . $categories->id . "'";
			//echo '<br>';
			$stmtsubcategory = $db->query($sub_sql);
			$Subcategories = $stmtsubcategory->fetchAll(PDO::FETCH_OBJ);
			
			 $isSubcategoryExists = $stmtsubcategory->rowCount();
			//echo '<br>';
			if ($isSubcategoryExists > 0) {
			
           // echo 'test<br>';
			foreach ($Subcategories as $subs) {
			
			$allsubcategories[]=array(
			"id" => stripslashes($subs->id),
			"name" => stripslashes($subs->name));
			}
			
			//print_r($allsubcategories);
			}
		   

			$allcategories[] = array(
			"id" => stripslashes($categories->id),
			"name" => stripslashes($categories->name),
			"subcategories" => $allsubcategories,
			"parent_id" => stripslashes($categories->parent_id));
					
					
            }
            $data['all_categories'] = $allcategories;
            $data['Ack'] = 1;
        } else {
            $data['all_categories'] = '';
            $data['Ack'] = 0;
        }

        $db = null;
        //    echo '{"categories": ' . json_encode($categories) . '}';
    } catch (PDOException $e) {
        $data['all_categories'] = '';
        $data['Ack'] = 0;
    }

    echo json_encode($data);
    exit;
}

function productsSearchByName() {
    $data = array();
    $allproducts = array();
	$productImagesData = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$key = $body['key'];
	$user_id = $body['user_id'];
	
    try {
        $sql = "SELECT * FROM products WHERE name LIKE :key ORDER BY name";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $query = "%" . $key . "%";
        $stmt->bindParam("key", $query);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
		
        if ($count > 0) {
            foreach ($getproducts as $products) {

			unset($productImages);
			$productImages = array();
			$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
			$stmtProductImage = $db->query($productImage);
			$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
			
			$isImageExists = $stmtProductImage->rowCount();
			if ($isImageExists > 0) {
			
			//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
			foreach ($productImages as $img_products) {
			//echo '<pre>';
			//print_r($img_products);
			$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
			}
			}
			
			
			$sql1 = "SELECT * FROM wishlists WHERE product_id=:product_id and user_id=:user_id ";
		    $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("product_id", $products->id);
			$stmt1->bindParam("user_id", $user_id);
            $stmt1->execute();
		    $count1 = $stmt1->rowCount();
		    if($count1>0)
		     {
		     $in_wishlist=1;
		      }
		   else
		      {
		     $in_wishlist=0;
		       }
			
			
				
			//	print_r($productImagesData);

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
                    "sku" => stripslashes(strip_tags($products->sku)),
					"category_id" => stripslashes($products->category_id),
					"sub_category_id" => stripslashes($products->sub_category_id),
					"is_featured" => stripslashes($products->is_featured),
					"unit_type" => stripslashes($products->unit_type),
					"quantity_lot" => stripslashes($products->quantity_lot),
					"price_lot" => stripslashes($products->price_lot),
					"sale_on" => stripslashes($products->sale_on),
					"discount" => stripslashes($products->discount),
					"start_date" => stripslashes($products->start_date),
					"end_date" => stripslashes($products->end_date),
					"created_at" => stripslashes($products->created_at),
					"return_policy" => stripslashes($products->return_policy),
					"item_specification" => stripslashes($products->item_specification),
					"item_description" => stripslashes($products->item_description),
					"delivery_terms" => stripslashes($products->delivery_terms),
                    "views" => stripslashes($products->views),
					"last_view_date" => stripslashes($products->last_view_date),
					"total_rate" => stripslashes($products->total_rate),
					"rate_count" => stripslashes($products->rate_count),
				    "in_wishlist" => stripslashes($in_wishlist),
                    "image" => $productImagesData);
					
					
					
            }
            $data['all_products'] = $allproducts;
            $data['Ack'] = 1;
        } else {
            $data['products'] = '';
            $data['Ack'] = 0;
        }
    } catch (PDOException $e) {
        $data['products'] = '';
        $data['Ack'] = 0;
    }
//print_r($data);	
	
    echo json_encode($data);
    exit;
}



function getCategoriesByShop() {
    $data = array();
    $allCategories = array();
	$allSubcategories = array();


	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$shop_id = $body['shop_id'];
	
	
	
    $sql = "select * FROM shops  WHERE id=:id";

        $db = getConnection();
		$stmt = $db->prepare($sql);
        $stmt->bindParam("id", $shop_id);
        $stmt->execute();
        $shopDetails = $stmt->fetchObject();	
	
	$shopSubcategory=explode(',',$shopDetails->sub_categories);
	
	$sqlStoreCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shopDetails->categories .")";
	//$db = getConnection();
	$stmtStoreCategoryDetails = $db->prepare($sqlStoreCategoryDetails);
	$stmtStoreCategoryDetails->execute();
	$getStoreCategoryDetails = $stmtStoreCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allCategories);
	$allCategories=array();
	foreach ($getStoreCategoryDetails as $shops_categories) {
	
	
	   //     $image_url = SITE_URL . 'upload/categoryimage/' . $categories->image;
			unset($allSubcategories);
			$allSubcategories = array();
			$sub_sql = "select * FROM categories WHERE `parent_id`='" . $shops_categories->id . "'";
			//echo '<br>';
			$stmtsubcategory = $db->query($sub_sql);
			$Subcategories = $stmtsubcategory->fetchAll(PDO::FETCH_OBJ);
			
			 $isSubcategoryExists = $stmtsubcategory->rowCount();
			//echo '<br>';
			if ($isSubcategoryExists > 0) {
			
           // echo 'test<br>';
			foreach ($Subcategories as $subs) {
			
			if(in_array($subs->id, $shopSubcategory)){
			
			$allSubcategories[]=array(
			"id" => stripslashes($subs->id),
			"name" => stripslashes($subs->name));
			}
			
			//print_r($allsubcategories);
			}						   
						   
	}
	
	
	
	
    $allCategories[]=array('ID' => $shops_categories->id,
	                       'NAME' => $shops_categories->name,
						   'SUB_CAT' => $allSubcategories);	
	
	
	}
	$data['category']=$allCategories;
	$data['Ack']=1;
    $data['shop_id']=$shop_id;
    echo json_encode($data);
    exit;
}




function home() {
    $data = array();
    $allproducts = array();
	$productImagesData = array();
	$allshops = array();
	$allbanners = array();
    $app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
    try {
        $sql = "SELECT * FROM products WHERE `is_featured`='Y' ORDER BY id limit 10";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $products) {

			unset($productImagesData);
			$productImagesData = array();
			$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
			$stmtProductImage = $db->query($productImage);
			$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
			
			$isImageExists = $stmtProductImage->rowCount();
			if ($isImageExists > 0) {
			
			//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
			foreach ($productImages as $img_products) {
			//echo '<pre>';
			//print_r($img_products);
			$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
			}
			}
				
			//	print_r($productImagesData);

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
                    "sku" => stripslashes(strip_tags($products->sku)),
					"category_id" => stripslashes($products->category_id),
					"sub_category_id" => stripslashes($products->sub_category_id),
					"is_featured" => stripslashes($products->is_featured),
					"unit_type" => stripslashes($products->unit_type),
					"quantity_lot" => stripslashes($products->quantity_lot),
					"price_lot" => stripslashes($products->price_lot),
					"sale_on" => stripslashes($products->sale_on),
					"discount" => stripslashes($products->discount),
					"start_date" => stripslashes($products->start_date),
					"end_date" => stripslashes($products->end_date),
					"created_at" => stripslashes($products->created_at),
					"return_policy" => stripslashes($products->return_policy),
					"item_specification" => stripslashes($products->item_specification),
					"item_description" => stripslashes($products->item_description),
					"delivery_terms" => stripslashes($products->delivery_terms),
                    "views" => stripslashes($products->views),
					"last_view_date" => stripslashes($products->last_view_date),
					"total_rate" => stripslashes($products->total_rate),
					"rate_count" => stripslashes($products->rate_count),
                    "image" => $productImagesData);
					
					
					
            }
            $data['all_products'] = $allproducts;
           
        } else {
            $data['products'] = '';
        
        }
		
/*				echo '<pre>';
		print_r($allproducts);*/
		
// GET FEATURED STORES

// ==================================================







        $is_active=1;
		$is_featured=1;
		 $sql = "SELECT * FROM   follows WHERE 1";
        $db = getConnection();
        $stmt = $db->prepare($sql);
       // $stmt->bindParam("id", $user_id);
        $stmt->execute();

		
		 $count = $stmt->rowCount();
        //if ($count > 0) {

        $getshopDetails = $stmt->fetchAll(PDO::FETCH_OBJ);

        foreach ($getshopDetails as $fshop) {

            

                $allshop[] = $fshop->shop_id;
           
        }

        $all_users = implode(',', array_unique($allshop));

        if ($all_users == '') {
            $all_users = "'" . "'";
        } else {
            $all_users = $all_users;
        }
		
		
       // $sql = "SELECT * FROM shops WHERE id NOT IN ($all_users) AND is_active=:is_active AND is_featured=:is_featured AND user_id!=:user_id ORDER BY id limit 3";
	     $sql = "SELECT * FROM shops WHERE is_featured=:is_featured ORDER BY name DESC limit 3";

        $stmt2 = $db->prepare($sql);
        //$stmt2->bindParam("is_active", $is_active);
		$stmt2->bindParam("is_featured", $is_featured);
		//$stmt2->bindParam("user_id", $user_id);
        $stmt2->execute();
        $getshops = $stmt2->fetchAll(PDO::FETCH_OBJ);
       $count = $stmt2->rowCount();
        if ($count > 0) {
            foreach ($getshops as $shops) {
			if($shops->logo!=''){
			$logo=SITE_URL . 'app/webroot/shop_images/' . $shops->logo;
			}
			else{
			$logo='';
			}
			if($shops->cover_photo!=''){
			$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $shops->cover_photo;
			}
			else{
			$cover_photo='';
			}


			$storeProductCount = "select * FROM products WHERE `shop_id`='" . $shops->id . "'";
			$stmtproCount = $db->query($storeProductCount);
			$totalProductCount = $stmtproCount->rowCount();
			
						

                $allshops[] = array(
                    "id" => stripslashes($shops->id),
                    "user_id" => stripslashes($shops->user_id),
                    "name" => stripslashes(strip_tags($shops->name)),
					"description" => stripslashes($shops->description),
					"categories" => stripslashes($shops->categories),
					"sub_categories" => stripslashes($shops->sub_categories),
					"facebook" => stripslashes($shops->facebook),
					"twitter" => stripslashes($shops->twitter),
					"linkedin" => stripslashes($shops->linkedin),
					"pinterest" => stripslashes($shops->pinterest),
					"youtube" => stripslashes($shops->youtube),
					"is_active" => stripslashes($shops->is_active),
					"created_at" => stripslashes($shops->created_at),
					"paid_on" => stripslashes($shops->paid_on),
					"last_date" => stripslashes($shops->last_date),
					"total_product_count" => $totalProductCount,
					"logo" => stripslashes($logo),
					"cover_photo" => stripslashes($cover_photo));
					
					
					
            }
            $data['all_shop'] = $allshops;
          
        } else {
            $data['all_shop'] = '';
         
        }
		

		// END OF STORES
		
// GET BANNERS

// ==================================================

        $sql3 = "SELECT * FROM site_settings WHERE 1";

        $stmt3 = $db->prepare($sql3);
        $stmt3->execute();
        $getbanners = $stmt3->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt3->rowCount();
        if ($count > 0) {
            foreach ($getbanners as $banners) {
			
			if($shops->logo!=''){
			$banner_url=SITE_URL . 'banner_image/' . $banners->banner_image;
			}
			else{
			$banner_url='';
			}
			$heading=$banners->heading;
			$sub_heading=$banners->sub_heading;

                $allbanners[] = array(
                    "id" => stripslashes($shops->id),
					  "heading" => stripslashes($heading),
					    "sub_heading" => stripslashes($sub_heading),
					"image" => stripslashes($banner_url));
					
					
					
					
            }
            $data['all_banner'] = $allbanners;
          
        } else {
            $data['all_banner'] = $allbanners;
         
        }
		
		
		
		// END OF BANNERS		
		
		
	 $data['Ack'] = 1;	
		
    } catch (PDOException $e) {
        $data['products'] = '';
        $data['Ack'] = 0;
    }
/*echo '<pre>';
print_r($data);	
echo '</pre>';*/
	
    echo json_encode($data);
    exit;
}

function allshop() {
    $data = array();
	$productImagesData = array();
	$allshops = array();
	
     $app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
    try {
       
		
// GET FEATURED STORES

// ==================================================
        $is_active=1;
	
        $sql = "SELECT * FROM shops WHERE is_active=:is_active ORDER BY id ASC";
        $db = getConnection();
        $stmt2 = $db->prepare($sql);
        $stmt2->bindParam("is_active", $is_active);
		//$stmt2->bindParam("is_featured", $is_featured);
        $stmt2->execute();
        $getshops = $stmt2->fetchAll(PDO::FETCH_OBJ);
       $count = $stmt2->rowCount();
        if ($count > 0) {
            foreach ($getshops as $shops) {
			if($shops->logo!=''){
			$logo=SITE_URL . 'app/webroot/shop_images/' . $shops->logo;
			}
			else{
			$logo='';
			}
			if($shops->cover_photo!=''){
			$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $shops->cover_photo;
			}
			else{
			$cover_photo='';
			}


			$storeProductCount = "select * FROM products WHERE `shop_id`='" . $shops->id . "'";
			$stmtproCount = $db->query($storeProductCount);
			$totalProductCount = $stmtproCount->rowCount();
			
			 $sql1 = "SELECT * FROM follows WHERE shop_id=:shop_id and user_id=:user_id";
		     $stmt1 = $db->prepare($sql1);
             $stmt1->bindParam("shop_id", $shops->id);
			 $stmt1->bindParam("user_id", $user_id);
             $stmt1->execute();
		     $count1 = $stmt1->rowCount();
		     if($count1>0)
		     {
		     $in_follow=1;
		     }
		    else
		    {
		    $in_follow=0;
		    }
			
						

                $allshops[] = array(
                    "id" => stripslashes($shops->id),
                    "user_id" => stripslashes($shops->user_id),
                    "name" => stripslashes(strip_tags($shops->name)),
					"description" => stripslashes($shops->description),
					"categories" => stripslashes($shops->categories),
					"sub_categories" => stripslashes($shops->sub_categories),
					"facebook" => stripslashes($shops->facebook),
					"twitter" => stripslashes($shops->twitter),
					"linkedin" => stripslashes($shops->linkedin),
					"pinterest" => stripslashes($shops->pinterest),
					"youtube" => stripslashes($shops->youtube),
					"is_active" => stripslashes($shops->is_active),
					"created_at" => stripslashes($shops->created_at),
					"paid_on" => stripslashes($shops->paid_on),
					"last_date" => stripslashes($shops->last_date),
					"total_product_count" => $totalProductCount,
					"logo" => stripslashes($logo),
					"in_follow" => stripslashes($in_follow),
					"cover_photo" => stripslashes($cover_photo));
					
					
					
            }
            $data['allshops'] = $allshops;
          
        } else {
            $data['allshops'] = '';
         
        }
		
		
	 $data['Ack'] = 1;	
		
    } catch (PDOException $e) {
	    print_r($e);
        $data['allshops'] = '';
        $data['Ack'] = 0;
    }
/*echo '<pre>';
print_r($data);	
echo '</pre>';*/
	
    echo json_encode($data);
    exit;
}

	function shopDetails() {
	$data = array();
	$allproducts = array();
	$allCategories = array();
	$allSubCategories = array();
	$allSellProducts = array();
	$allNewArrivalProducts = array();
	$allTopSellingProducts = array();
	$productImagesData = array();
	$allshops = array();

	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$id = $body['shop_id'];

	
	try {
	
	
	// GET FEATURED STORES
	
	$sql = "SELECT * FROM shops WHERE id=:id";
	$db = getConnection();
	$stmt2 = $db->prepare($sql);
	$stmt2->bindParam("id", $id);
	$stmt2->execute();
	$getshops = $stmt2->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt2->rowCount();
	if ($count > 0) {
	foreach ($getshops as $shops) {
	if($shops->logo!=''){
	$logo=SITE_URL . 'app/webroot/shop_images/' . $shops->logo;
	}
	else{
	$logo='';
	}
	if($shops->cover_photo!=''){
	$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $shops->cover_photo;
	}
	else{
	$cover_photo='';
	}
	
	
	$storeProductCount = "select * FROM products WHERE `shop_id`='" . $shops->id . "'";
	$stmtproCount = $db->query($storeProductCount);
	$totalProductCount = $stmtproCount->rowCount();


	$sqlStoreOwnerDetails = "SELECT  * FROM users WHERE `id`='" . $shops->user_id . "'";
	$stmtStoreOwnerDetails = $db->prepare($sqlStoreOwnerDetails);
	$stmtStoreOwnerDetails->execute();
	$getStoreOwnerDetails = $stmtStoreOwnerDetails->fetchObject();	
	$paypal_business_email =$getStoreOwnerDetails->paypal_business_email;	
	
	
	
	// GET CATEGORIES  ======================================================
	
	
	$sqlStoreCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->categories .")";
	$stmtStoreCategoryDetails = $db->prepare($sqlStoreCategoryDetails);
	$stmtStoreCategoryDetails->execute();
	$getStoreCategoryDetails = $stmtStoreCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allCategories);
	$allCategories=array();
	foreach ($getStoreCategoryDetails as $shops_categories) {
    $allCategories[]=array('ID' => $shops_categories->id,
	                       'NAME' => $shops_categories->name);
	}
	// ======================================================================
	
	// GET SUBCATEGORIES  ======================================================
	
	
	$sqlStoreSubCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->sub_categories .")";
	$stmtStoreSubCategoryDetails = $db->prepare($sqlStoreSubCategoryDetails);
	$stmtStoreSubCategoryDetails->execute();
	$getStoreSubCategoryDetails = $stmtStoreSubCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allSubCategories);
	$allSubCategories=array();
	foreach ($getStoreSubCategoryDetails as $shops_sub_categories) {
    $allSubCategories[]=array('ID' => $shops_sub_categories->id,
	                       'NAME' => $shops_sub_categories->name);
	}
	// ======================================================================	
	
	 $sql1 = "SELECT * FROM follows WHERE shop_id=:shop_id ";
		     $stmt1 = $db->prepare($sql1);
             $stmt1->bindParam("shop_id", $shops->id);
             $stmt1->execute();
		     $count1 = $stmt1->rowCount();
		     if($count1>0)
		     {
		     $in_follow=1;
		     }
		     else
		     {
		     $in_follow=0;
		     }
	
	
	$allshops[] = array(
	"id" => stripslashes($shops->id),
	"user_id" => stripslashes($shops->user_id),
	"name" => stripslashes(strip_tags($shops->name)),
	"description" => stripslashes($shops->description),
	"categories" => $allCategories,
	"sub_categories" => $allSubCategories,
	"facebook" => stripslashes($shops->facebook),
	"twitter" => stripslashes($shops->twitter),
	"linkedin" => stripslashes($shops->linkedin),
	"pinterest" => stripslashes($shops->pinterest),
	"youtube" => stripslashes($shops->youtube),
	"is_active" => stripslashes($shops->is_active),
	"created_at" => stripslashes($shops->created_at),
	"paid_on" => stripslashes($shops->paid_on),
	"last_date" => stripslashes($shops->last_date),
	"paypal_business_email" => stripslashes($paypal_business_email),
	"total_product_count" => $totalProductCount,
	"logo" => stripslashes($logo),
	"in_follow" => stripslashes($in_follow),
	"cover_photo" => stripslashes($cover_photo));
	
	
	
	}
	$data['all_shop'] = $allshops;
	
	} else {
	$data['all_shop'] = $allshops;
	
	}

	
	//  GET ALL STORE PRODUCTS
	
	$sql = "SELECT * FROM products WHERE shop_id=:shop_id ORDER BY name";
	//$db = getConnection();
	$stmt = $db->prepare($sql);
    $stmt->bindParam("shop_id", $id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImagesData = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	
	//	print_r($productImagesData);
	
	$allproducts[] = array(
	"id" => stripslashes($products->id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"image" => $productImagesData);
	
	
	
	}
	$data['all_products'] = $allproducts;
	
	} else {
	$data['all_products'] = $allproducts;
	
	}		
	
	
	
		//  GET ALL SELL PRODUCTS
	
	$sql = "SELECT * FROM products WHERE shop_id=:shop_id AND `sale_on`='Y' ORDER BY name";
	//$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("shop_id", $id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImagesData = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	
	//	print_r($productImagesData);
	
	$allSellProducts[] = array(
	"id" => stripslashes($products->id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"image" => $productImagesData);
	
	
	
	}
	$data['all_sale_products'] = $allSellProducts;
	
	} else {
	$data['all_sale_products'] = $allSellProducts;
	
	}	
	


		//  GET ALL NEW ARRIVAL PRODUCTS
	
	$sql = "SELECT * FROM products WHERE shop_id=:shop_id ORDER BY id DESC";
	//$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("shop_id", $id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImagesData = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	
	//	print_r($productImagesData);
	
	$allNewArrivalProducts[] = array(
	"id" => stripslashes($products->id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"image" => $productImagesData);
	
	
	
	}
	$data['all_new_arrival_products'] = $allNewArrivalProducts;
	
	} else {
	$data['all_new_arrival_products'] = $allNewArrivalProducts;
	
	}
	
		

		//  GET ALL TOP SELLING PRODUCTS
	
	$sql = "SELECT * FROM products WHERE shop_id=:shop_id ORDER BY sold_quantity DESC";
	//$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("shop_id", $id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImagesData = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	
	//	print_r($productImagesData);
	
	$allTopSellingProducts[] = array(
	"id" => stripslashes($products->id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"image" => $productImagesData);
	
	
	
	}
	$data['all_top_selling_products'] = $allTopSellingProducts;
	
	} else {
	$data['all_top_selling_products'] = $allTopSellingProducts;
	
	}
	



	
	$data['Ack'] = 1;	
	
	} catch (PDOException $e) {
	//print_r($e);
	$data['products'] = '';
	$data['Ack'] = 0;
	}
	/*echo '<pre>';
	print_r($data);	
	echo '</pre>';*/
	
	echo json_encode($data);
	exit;
}

function productsByCategory() {
 
    
    $data = array();
    $allproducts = array();
	$productImagesData = array();


	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	
	
	$category_id = $body['category_id'];
	$popularity = $body['popularity'];
	$lowtohigh = $body['lowtohigh'];
	$hightolow = $body['hightolow'];
	$newest = $body['newest'];
	$price1 = $body['price1'];
	$price2 = $body['price2'];
	$user_id = $body['user_id'];
	
	//$in_wishlist = $body['in_wishlist'];
	

		
    try {
	
	    if($price1!='' && $price2!='')
		{
        $sql = "SELECT * FROM products WHERE category_id=:category_id and (price_lot>='".$price1."' and price_lot<='".$price2."')";
		}
		else
		{
        $sql = "SELECT * FROM products WHERE category_id=:category_id";
		}
	
	    if($popularity!='' && $popularity==1)
		{
        $sql.=" ORDER BY views DESC";
		}
		elseif($lowtohigh!='' && $lowtohigh==2)
		{
        $sql.=" ORDER BY discount ASC";
		}
		elseif($hightolow!='' && $hightolow==3)
		{
        $sql.=" ORDER BY discount DESC";
		}
		elseif($newest!='' && $newest==4)
		{
        $sql.=" ORDER BY id DESC";
		}
		else
		{
		 $sql.=" ORDER BY name ASC";
		}
		
		
		
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("category_id", $category_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
		
		
	   
	   
	    if ($count > 0) {
            foreach ($getproducts as $products) {

			unset($productImagesData);
			$productImagesData = array();
			$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
			$stmtProductImage = $db->query($productImage);
			$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
			
			$isImageExists = $stmtProductImage->rowCount();
			if ($isImageExists > 0) {
			
			//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
			foreach ($productImages as $img_products) {
			//echo '<pre>';
			//print_r($img_products);
			$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
			}
			}
			
			
			
		$sql1 = "SELECT * FROM wishlists WHERE product_id=:product_id and user_id=:user_id";
		$stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("product_id", $products->id);
		$stmt1->bindParam("user_id", $user_id);
        $stmt1->execute();
		$count1 = $stmt1->rowCount();
		if($count1>0)
		{
		$in_wishlist=1;
		}
		else
		{
		$in_wishlist=0;
		}
			
			
			
			
			
			
				
			//	print_r($productImagesData);

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
                    "sku" => stripslashes(strip_tags($products->sku)),
					"category_id" => stripslashes($products->category_id),
					"sub_category_id" => stripslashes($products->sub_category_id),
					"is_featured" => stripslashes($products->is_featured),
					"unit_type" => stripslashes($products->unit_type),
					"quantity_lot" => stripslashes($products->quantity_lot),
					"price_lot" => stripslashes($products->price_lot),
					"sale_on" => stripslashes($products->sale_on),
					"discount" => stripslashes($products->discount),
					"start_date" => stripslashes($products->start_date),
					"end_date" => stripslashes($products->end_date),
					"created_at" => stripslashes($products->created_at),
					"return_policy" => stripslashes($products->return_policy),
					"item_specification" => stripslashes($products->item_specification),
					"item_description" => stripslashes($products->item_description),
					"delivery_terms" => stripslashes($products->delivery_terms),
                    "views" => stripslashes($products->views),
					"last_view_date" => stripslashes($products->last_view_date),
					"total_rate" => stripslashes($products->total_rate),
					"rate_count" => stripslashes($products->rate_count),
					"in_wishlist" => stripslashes($in_wishlist),
                    "image" => $productImagesData);
					
					
					
            }
            $data['all_products'] = $allproducts;
            $data['Ack'] = 1;
        } else {
            $data['products'] = '';
            $data['Ack'] = 0;
        }
    } catch (PDOException $e) {
	     print_r($e);
        $data['products'] = '';
        $data['Ack'] = 0;
    }
//print_r($data);	
	
    echo json_encode($data);
    exit;
}

function productsWithoutCategory() {
    $data = array();
    $allproducts = array();
    $productImagesData = array();


	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$category_id = $body['category_id'];
	
		
    try {
        $sql = "SELECT * FROM products ORDER BY name DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        //$stmt->bindParam("category_id", $category_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
		
        if ($count > 0) {
            foreach ($getproducts as $products) {

                unset($productImagesData);
                $productImagesData = array();
                $productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
                $stmtProductImage = $db->query($productImage);
                $productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);

                $isImageExists = $stmtProductImage->rowCount();
                if ($isImageExists > 0) {

                //	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
                foreach ($productImages as $img_products) {
                //echo '<pre>';
                //print_r($img_products);
                $productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
                }
                }
				
				$sql1 = "SELECT * FROM wishlists WHERE product_id=:product_id ";
		$stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("product_id", $products->id);
        $stmt1->execute();
		$count1 = $stmt1->rowCount();
		if($count1>0)
		{
		$in_wishlist=1;
		}
		else
		{
		$in_wishlist=0;
		}
				
			//	print_r($productImagesData);

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
                    "sku" => stripslashes(strip_tags($products->sku)),
                    "category_id" => stripslashes($products->category_id),
                    "sub_category_id" => stripslashes($products->sub_category_id),
                    "is_featured" => stripslashes($products->is_featured),
                    "unit_type" => stripslashes($products->unit_type),
                    "quantity_lot" => stripslashes($products->quantity_lot),
                    "price_lot" => stripslashes($products->price_lot),
                    "sale_on" => stripslashes($products->sale_on),
                    "discount" => stripslashes($products->discount),
                    "start_date" => stripslashes($products->start_date),
                    "end_date" => stripslashes($products->end_date),
                    "created_at" => stripslashes($products->created_at),
                    "return_policy" => stripslashes($products->return_policy),
                    "item_specification" => stripslashes($products->item_specification),
                    "item_description" => stripslashes($products->item_description),
                    "delivery_terms" => stripslashes($products->delivery_terms),
                    "views" => stripslashes($products->views),
                    "last_view_date" => stripslashes($products->last_view_date),
                    "total_rate" => stripslashes($products->total_rate),
                    "rate_count" => stripslashes($products->rate_count),
					"in_wishlist" => stripslashes($in_wishlist),
                    "image" => $productImagesData);
	    }
            $data['all_products'] = $allproducts;
            $data['Ack'] = 1;
        } else {
            $data['products'] = '';
            $data['Ack'] = 0;
        }
    } catch (PDOException $e) {
        $data['products'] = '';
        $data['Ack'] = 0;
    }
//print_r($data);	
	
    echo json_encode($data);
    exit;
}

	function productsByShop() {
	$data = array();
	$allproducts = array();
	$productImagesData = array();
	
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$shop_id = $body['shop_id'];
	
	
	try {
	$sql = "SELECT * FROM products WHERE shop_id=:shop_id ORDER BY name DESC";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("shop_id", $shop_id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImages = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	
	//	print_r($productImagesData);
	
	$allproducts[] = array(
	"id" => stripslashes($products->id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity" => stripslashes($products->quantity),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"image" => $productImagesData);
	
	
	
	}
	$data['all_products'] = $allproducts;
	$data['Ack'] = 1;
	} else {
	$data['products'] = '';
	$data['Ack'] = 0;
	}
	} catch (PDOException $e) {
	$data['products'] = '';
	$data['Ack'] = 0;
	}
	//print_r($data);	
	
	echo json_encode($data);
	exit;
}



function listStores() {
    $data = array();
    $allshops = array();
	$allCategories=array();
	$allSubCategories=array();
	$is_active=1;
	
    try {
        $sql = "SELECT * FROM shops WHERE is_active=:is_active ORDER BY name DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("is_active", $is_active);
        $stmt->execute();
        $getshops = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getshops as $shops) {
			
			//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
			if($shops->logo!=''){
			$logo=SITE_URL . 'app/webroot/shop_images/' . $shops->name;
			}
			else{
			$logo='';
			}
			if($shops->cover_photo!=''){
			$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $shops->name;
			}
			else{
			$cover_photo='';
			}
			

	// GET CATEGORIES  ======================================================
	
	
	$sqlStoreCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->categories .")";
	$stmtStoreCategoryDetails = $db->prepare($sqlStoreCategoryDetails);
	$stmtStoreCategoryDetails->execute();
	$getStoreCategoryDetails = $stmtStoreCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allCategories);
	$allCategories=array();
	foreach ($getStoreCategoryDetails as $shops_categories) {
    $allCategories[]=array('ID' => $shops_categories->id,
	                       'NAME' => $shops_categories->name);
	}
	// ======================================================================
	
	// GET SUBCATEGORIES  ======================================================
	
	
	$sqlStoreSubCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->sub_categories .")";
	$stmtStoreSubCategoryDetails = $db->prepare($sqlStoreSubCategoryDetails);
	$stmtStoreSubCategoryDetails->execute();
	$getStoreSubCategoryDetails = $stmtStoreSubCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allSubCategories);
	$allSubCategories=array();
	foreach ($getStoreSubCategoryDetails as $shops_sub_categories) {
    $allSubCategories[]=array('ID' => $shops_sub_categories->id,
	                       'NAME' => $shops_sub_categories->name);
	}
	// ======================================================================	


				
			//	print_r($productImagesData);

                $allshops[] = array(
                    "id" => stripslashes($shops->id),
                    "user_id" => stripslashes($shops->user_id),
                    "name" => stripslashes(strip_tags($shops->name)),
					"description" => stripslashes($shops->description),
					"categories" => $allCategories,
					"sub_categories" => $allSubCategories,
					"facebook" => stripslashes($shops->facebook),
					"twitter" => stripslashes($shops->twitter),
					"linkedin" => stripslashes($shops->linkedin),
					"pinterest" => stripslashes($shops->pinterest),
					"youtube" => stripslashes($shops->youtube),
					"is_active" => stripslashes($shops->is_active),
					"created_at" => stripslashes($shops->created_at),
					"paid_on" => stripslashes($shops->paid_on),
					"last_date" => stripslashes($shops->last_date),
					"logo" => stripslashes($logo),
					"cover_photo" => stripslashes($cover_photo));
					
					
					
            }
            $data['allshops'] = $allshops;
            $data['Ack'] = 1;
        } else {
            $data['allshops'] = '';
            $data['Ack'] = 0;
        }
		
		
		
		
    } catch (PDOException $e) {
        $data['products'] = '';
        $data['Ack'] = 0;
    }
//print_r($data);	
	
    echo json_encode($data);
    exit;
}




function addProducts() {

    $data = array();
    $app = new Slim();
    //    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());

    $user_id = $body['user_id'];
    $shop_id = $body['shop_id'];
    $name = $body['name'];
    $sku = $body['sku'];
	$quantity = $body['quantity'];
	$sold_quantity = $body['sold_quantity'];
    $category_id = $body['category_id'];
    $sub_category_id = $body['sub_category_id'];
	$is_featured = $body['is_featured'];
	$unit_type = $body['unit_type'];
	$quantity_lot = $body['quantity_lot'];
	$price_lot = $body['price_lot'];
	$keywords = $body['keywords'];
	$shipping_time = $body['shipping_time'];
	$processing_time = $body['processing_time'];
	$sale_on = $body['sale_on'];
	$discount = $body['discount'];
	$start_date = $body['start_date'];
	$end_date = $body['end_date'];
	$package_weight = $body['package_weight'];
	$package_unit = $body['package_unit'];
	$package_size1 = $body['package_size1'];
	$package_size2 = $body['package_size2'];
	$package_size3 = $body['package_size3'];
	$package_size_unit = $body['package_size_unit'];
	$status = $body['status'];
	$return_policy = $body['return_policy'];
	$item_specification = $body['item_specification'];
	$item_description = $body['item_description'];
	$delivery_terms = $body['delivery_terms'];





	$sql = "INSERT INTO products (user_id, shop_id, name, sku, quantity, sold_quantity, category_id, sub_category_id, is_featured, unit_type, quantity_lot, price_lot, keywords, shipping_time, processing_time, sale_on, discount, start_date, end_date, package_weight, package_unit, package_size1, package_size2, package_size3, package_size_unit, status, return_policy, item_specification, item_description, delivery_terms) VALUES (:user_id, :shop_id, :name, :sku, :quantity, :sold_quantity, :category_id, :sub_category_id, :is_featured, :unit_type, :quantity_lot, :price_lot, :keywords, :shipping_time, :processing_time, :sale_on, :discount, :start_date, :end_date, :package_weight, :package_unit, :package_size1, :package_size2, :package_size3, :package_size_unit, :status, :return_policy, :item_specification, :item_description, :delivery_terms)";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("shop_id", $shop_id);
	$stmt->bindParam("name", $name);
	$stmt->bindParam("sku", $sku);
	$stmt->bindParam("quantity", $quantity);
	$stmt->bindParam("sold_quantity", $sold_quantity);
	$stmt->bindParam("category_id", $category_id);
	$stmt->bindParam("sub_category_id", $sub_category_id);
	$stmt->bindParam("is_featured", $is_featured);
	$stmt->bindParam("unit_type", $unit_type);
	$stmt->bindParam("quantity_lot", $quantity_lot);
	$stmt->bindParam("price_lot", $price_lot);
	$stmt->bindParam("keywords", $keywords);
	$stmt->bindParam("shipping_time", $shipping_time);
	$stmt->bindParam("processing_time", $processing_time);
	$stmt->bindParam("sale_on", $sale_on);
	$stmt->bindParam("discount", $discount);
	$stmt->bindParam("start_date", $start_date);
	$stmt->bindParam("end_date", $end_date);
	$stmt->bindParam("package_weight", $package_weight);
	$stmt->bindParam("package_unit", $package_unit);
	$stmt->bindParam("package_size1", $package_size1);
	$stmt->bindParam("package_size2", $package_size2);
	$stmt->bindParam("package_size3", $package_size3);
	$stmt->bindParam("package_size_unit", $package_size_unit);
	$stmt->bindParam("status", $status);
	$stmt->bindParam("return_policy", $return_policy);
	$stmt->bindParam("item_specification", $item_specification);
	$stmt->bindParam("item_description", $item_description);
	$stmt->bindParam("delivery_terms", $delivery_terms);	
	$stmt->execute();
	//   
	
	$lastID = $db->lastInsertId();
	$data['last_id'] = $lastID;
	$data['Ack'] = '1';
	$data['msg'] = 'Product Added Successfully...';
	
	
	
	$db = null;
	//echo json_encode($user);
	} catch (PDOException $e) {
	echo '{"error":{"text":'. $e->getMessage() .'}}';
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Error !!!';
	}
	
	
	
	
    echo json_encode($data);
	exit;
}



	function updateProductImage() {
	
	$data = array();
	$app = new Slim();
	$request = Slim::getInstance()->request();
	
	//$body = json_decode($request->getBody());
	//print_r($request->post("id"));
	//die();
	try {
	$db = getConnection();
	
	//print_r($_FILES['image']['tmp_name']);
	//echo $id;
	//exit();
	//print_r($body);
	//exit();
	
	
	if ($_FILES['product_image']['tmp_name'] != '') {
	$product_id = $request->post("prd_id");
	
	$target_path = "../app/webroot/product_images/";
	
	//	$target_path = "user_images/";
	$userfile_name = $_FILES['product_image']['name'];
	$userfile_tmp = $_FILES['product_image']['tmp_name'];
	$product_image = time() . $userfile_name;
	$img = $target_path . $product_image;
	move_uploaded_file($userfile_tmp, $img);
	
	$sqlimg = "INSERT INTO product_images (product_id, name) VALUES (:product_id, :name)";
	
	$stmt1 = $db->prepare($sqlimg);
	$stmt1->bindParam("product_id", $product_id);
	$stmt1->bindParam("name", $product_image);
	$stmt1->execute();
	
	$data['Ack'] = '1';
	$data['msg'] = 'Image Added.';
	} else {
	$data['id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Image Not Added.';
	}
	
	$db = null;
	} catch (PDOException $e) {
	$data['id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Image Not Added. Please Try Again.';
	}
	echo json_encode($data);
	exit;
}




function editProducts() {

    $data = array();
    $app = new Slim();
    //    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());

    $prd_id = $body['prd_id'];
    $user_id = $body['user_id'];
    $shop_id = $body['shop_id'];
    $name = $body['name'];
    $sku = $body['sku'];
	$quantity = $body['quantity'];
	$sold_quantity = $body['sold_quantity'];
    $category_id = $body['category_id'];
    $sub_category_id = $body['sub_category_id'];
	$is_featured = $body['is_featured'];
	$unit_type = $body['unit_type'];
	$quantity_lot = $body['quantity_lot'];
	$price_lot = $body['price_lot'];
	$keywords = $body['keywords'];
	$shipping_time = $body['shipping_time'];
	$processing_time = $body['processing_time'];
	$sale_on = $body['sale_on'];
	$discount = $body['discount'];
	$start_date = $body['start_date'];
	$end_date = $body['end_date'];
	$package_weight = $body['package_weight'];
	$package_unit = $body['package_unit'];
	$package_size1 = $body['package_size1'];
	$package_size2 = $body['package_size2'];
	$package_size3 = $body['package_size3'];
	$package_size_unit = $body['package_size_unit'];
	$status = $body['status'];
	$return_policy = $body['return_policy'];
	$item_specification = $body['item_specification'];
	$item_description = $body['item_description'];
	$delivery_terms = $body['delivery_terms'];



	$sql = "UPDATE products set user_id=:user_id, shop_id=:shop_id, name=:name, sku=:sku, quantity=:quantity, sold_quantity=:sold_quantity, category_id=:category_id, sub_category_id=:sub_category_id, is_featured=:is_featured, unit_type=:unit_type, quantity_lot=:quantity_lot, price_lot=:price_lot, keywords=:keywords, shipping_time=:shipping_time, processing_time=:processing_time, sale_on=:sale_on, discount=:discount, start_date=:start_date, end_date=:end_date, package_weight=:package_weight, package_unit=:package_unit, package_size1=:package_size1, package_size2=:package_size2, package_size3=:package_size3, package_size_unit=:package_size_unit, status=:status, return_policy=:return_policy, item_specification=:item_specification, item_description=:item_description, delivery_terms=:delivery_terms WHERE id=:id";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("shop_id", $shop_id);
	$stmt->bindParam("name", $name);
	$stmt->bindParam("sku", $sku);
	$stmt->bindParam("quantity", $quantity);
	$stmt->bindParam("sold_quantity", $sold_quantity);
	$stmt->bindParam("category_id", $category_id);
	$stmt->bindParam("sub_category_id", $sub_category_id);
	$stmt->bindParam("is_featured", $is_featured);
	$stmt->bindParam("unit_type", $unit_type);
	$stmt->bindParam("quantity_lot", $quantity_lot);
	$stmt->bindParam("price_lot", $price_lot);
	$stmt->bindParam("keywords", $keywords);
	$stmt->bindParam("shipping_time", $shipping_time);
	$stmt->bindParam("processing_time", $processing_time);
	$stmt->bindParam("sale_on", $sale_on);
	$stmt->bindParam("discount", $discount);
	$stmt->bindParam("start_date", $start_date);
	$stmt->bindParam("end_date", $end_date);
	$stmt->bindParam("package_weight", $package_weight);
	$stmt->bindParam("package_unit", $package_unit);
	$stmt->bindParam("package_size1", $package_size1);
	$stmt->bindParam("package_size2", $package_size2);
	$stmt->bindParam("package_size3", $package_size3);
	$stmt->bindParam("package_size_unit", $package_size_unit);
	$stmt->bindParam("status", $status);
	$stmt->bindParam("return_policy", $return_policy);
	$stmt->bindParam("item_specification", $item_specification);
	$stmt->bindParam("item_description", $item_description);
	$stmt->bindParam("delivery_terms", $delivery_terms);	
	$stmt->bindParam("id", $id);	
	$stmt->execute();
	//   
	
	$lastID = $db->lastInsertId();
	$data['last_id'] = $lastID;
	$data['Ack'] = '1';
	$data['msg'] = 'Registered Successfully...';
	
	
	
	$db = null;
	//echo json_encode($user);
	} catch (PDOException $e) {
	//error_log($e->getMessage(), 3, '/var/tmp/php.log');
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Error !!!';
	}
	
	
	
	
    echo json_encode($data);
	exit;
}








	function addShop() {
	
	$data = array();
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$name = $body['name'];
	$description = $body['description'];
	$categories = $body['categories'];
	$sub_categories = $body['sub_categories'];
	$facebook = $body['facebook'];
	$twitter = $body['twitter'];
	$linkedin = $body['linkedin'];
	$pinterest = $body['pinterest'];
	$youtube = $body['youtube'];
	$paypal_business_email = $body['paypal_business_email'];
	$is_active = 0;
	$created_at = date('Y-m-d H:i:s');
	
	$logo='';
	$cover_photo='';
	


	$db = getConnection();

	
	$storeProductCount = "select * FROM shops WHERE `user_id`='" . $user_id . "'";
	$stmtproCount = $db->query($storeProductCount);
	$totalProductCount = $stmtproCount->rowCount();
	
	if($totalProductCount==0){
	
	
	if ($_FILES['logo']['tmp_name'] != '') {
	$target_path = "../app/webroot/shop_images/";
	$userfile_name = $_FILES['logo']['name'];
	$userfile_tmp = $_FILES['logo']['tmp_name'];
	$logo = time() . $userfile_name;
	$img = $target_path . $logo;
	move_uploaded_file($userfile_tmp, $img);
	
	}
	
	if ($_FILES['cover_photo']['tmp_name'] != '') {
	$target_path = "../app/webroot/shop_images/";
	$userfile_name = $_FILES['cover_photo']['name'];
	$userfile_tmp = $_FILES['cover_photo']['tmp_name'];
	$cover_photo = time() . $userfile_name;
	$img = $target_path . $cover_photo;
	move_uploaded_file($userfile_tmp, $img);
	}



	
		$sql = "INSERT INTO shops (user_id, name, description, logo, cover_photo, categories, sub_categories, facebook, twitter, linkedin, pinterest, youtube, is_active, created_at) VALUES (:user_id, :name, :description, :logo, :cover_photo, :categories, :sub_categories, :facebook, :twitter, :linkedin, :pinterest, :youtube, :is_active, :created_at)";
	
	try {	
	
		$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("name", $name);
	$stmt->bindParam("description", $description);
	$stmt->bindParam("logo", $logo);
	$stmt->bindParam("cover_photo", $cover_photo);
	$stmt->bindParam("categories", $categories);
	$stmt->bindParam("sub_categories", $sub_categories);
	$stmt->bindParam("facebook", $facebook);
	$stmt->bindParam("twitter", $twitter);
	$stmt->bindParam("linkedin", $linkedin);
	$stmt->bindParam("pinterest", $pinterest);
	$stmt->bindParam("youtube", $youtube);
	$stmt->bindParam("is_active", $is_active);
	$stmt->bindParam("created_at", $created_at);
	$stmt->execute();
	//   
	
	$lastID = $db->lastInsertId();
	$data['last_id'] = $lastID;
	$data['Ack'] = '1';
	$data['msg'] = 'Shop Added Successfully...';
	
	
	
	
	$sql = "UPDATE users SET paypal_business_email=:paypal_business_email  WHERE id=:id";
	$stmt = $db->prepare($sql);
	$stmt->bindParam("paypal_business_email", $paypal_business_email);
	$stmt->bindParam("id", $user_id);
	$stmt->execute();
	$db = null;
	//echo json_encode($user);
	} catch (PDOException $e) {
	//error_log($e->getMessage(), 3, '/var/tmp/php.log');
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Error !!!';
	}
	
	}
	else{
	
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'You can not Add Multiple Shops';	
	
	}
	
	
	
	echo json_encode($data);
	exit;
}


	function updateProductInventory() {
	
	$data = array();
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$id = $body['prd_id'];
	$user_id = $body['user_id'];
	$quantity = $body['quantity'];
	$price_lot = $body['price'];

	
	$sql = "UPDATE products SET quantity=:quantity, price_lot=:price_lot WHERE id=:id AND user_id=:user_id";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("quantity", $quantity);
	$stmt->bindParam("price_lot", $price_lot);
	$stmt->bindParam("id", $id);
	$stmt->bindParam("user_id", $user_id);
	$stmt->execute();

	$lastID = $db->lastInsertId();
	$data['last_id'] = $lastID;
	$data['Ack'] = '1';
	$data['msg'] = 'Inventory Updated Successfully...';
	$db = null;
	//echo json_encode($user);
	} catch (PDOException $e) {
	//error_log($e->getMessage(), 3, '/var/tmp/php.log');
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Error !!!';
	}
	
	echo json_encode($data);
	exit;
}




	function editShop() {
	
	$data = array();
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$shop_id = $body['shop_id'];
	$user_id = $body['user_id'];
	$name = $body['name'];
	$description = $body['description'];
	$categories = $body['categories'];
	$sub_categories = $body['sub_categories'];
	$facebook = $body['facebook'];
	$twitter = $body['twitter'];
	$linkedin = $body['linkedin'];
	$pinterest = $body['pinterest'];
	$youtube = $body['youtube'];
	
	$logo='';
	$cover_photo='';
	
	if ($_FILES['logo']['tmp_name'] != '') {
	$target_path = "../app/webroot/shop_images/";
	$userfile_name = $_FILES['logo']['name'];
	$userfile_tmp = $_FILES['logo']['tmp_name'];
	$logo = time() . $userfile_name;
	$img = $target_path . $logo;
	move_uploaded_file($userfile_tmp, $img);
	
	$updateLogo = "UPDATE shops SET `logo`='".$logo."' WHERE `id`='" . $shop_id . "'";
	$db->query($updateLogo);
	}
	
	if ($_FILES['cover_photo']['tmp_name'] != '') {
	$target_path = "../app/webroot/shop_images/";
	$userfile_name = $_FILES['cover_photo']['name'];
	$userfile_tmp = $_FILES['cover_photo']['tmp_name'];
	$cover_photo = time() . $userfile_name;
	$img = $target_path . $cover_photo;
	move_uploaded_file($userfile_tmp, $img);
	
	$updateCoverPhoto = "UPDATE shops SET `cover_photo`='".$cover_photo."' WHERE `id`='" . $shop_id . "'";
	$db->query($updateCoverPhoto);
	}
			
	$sql = "UPDATE shops SET user_id=:user_id, name=:name, description=:description,categories=:categories, sub_categories=:sub_categories, facebook=:facebook, twitter=:twitter, linkedin=:linkedin, pinterest=:pinterest, youtube=:youtube  WHERE id=:id";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("name", $name);
	$stmt->bindParam("description", $description);
	$stmt->bindParam("categories", $categories);
	$stmt->bindParam("sub_categories", $sub_categories);
	$stmt->bindParam("facebook", $facebook);
	$stmt->bindParam("twitter", $twitter);
	$stmt->bindParam("linkedin", $linkedin);
	$stmt->bindParam("pinterest", $pinterest);
	$stmt->bindParam("youtube", $youtube);
	$stmt->bindParam("id", $shop_id);
	$stmt->execute();
	//   
	
	$lastID = $db->lastInsertId();
	$data['last_id'] = $lastID;
	$data['Ack'] = '1';
	$data['msg'] = 'Shop Added Successfully...';
	
	
	
	$db = null;
	//echo json_encode($user);
	} catch (PDOException $e) {
	//error_log($e->getMessage(), 3, '/var/tmp/php.log');
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Error !!!';
	}
	
	
	
	
	echo json_encode($data);
	exit;
}


	function activateStore() {
	
	$data = array();
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$shop_id = $body['shop_id'];
	$user_id = $body['user_id'];
    $paypal_transaction_id = $body['paypal_transaction_id'];
	$payment_status = $body['payment_status'];
	$paid_amount = $body['paid_amount'];
	$paid_on=date('Y-m-d H:i:s');
	$is_active=1;
	$last_date=date('Y-m-d H:i:s', strtotime("+30 days"));
	
	
	$sql = "UPDATE shops SET is_active=:is_active, paid_on=:paid_on, last_date=:last_date  WHERE id=:id";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("is_active", $is_active);
	$stmt->bindParam("paid_on", $paid_on);
	$stmt->bindParam("last_date", $last_date);
	$stmt->bindParam("id", $shop_id);
	$stmt->execute();
	
	$sql6 = "INSERT INTO payments (userid, amount, datetime, status, transaction_id) VALUES (:user_id, :paid_amount, :paid_on, :payment_status, :paypal_transaction_id)";

	$stmt6 = $db->prepare($sql6);
	$stmt6->bindParam("user_id", $user_id);
	$stmt6->bindParam("paid_amount", $paid_amount);
	$stmt6->bindParam("paid_on", $paid_on);
	$stmt6->bindParam("payment_status", $payment_status);
	$stmt6->bindParam("paypal_transaction_id", $paypal_transaction_id);
	$stmt6->execute();
	//   
	
	$lastID = $db->lastInsertId();
	$data['last_id'] = $lastID;
	$data['Ack'] = '1';
	$data['msg'] = 'Shop Payment Completed Successfully...';
	
	
	
	$db = null;
	//echo json_encode($user);
	} catch (PDOException $e) {
	//error_log($e->getMessage(), 3, '/var/tmp/php.log');
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Error !!!';
	}
	
	
	
	
	echo json_encode($data);
	exit;
	}


	function listProducts() {
	$data = array();
	$allproducts = array();
	$productImagesData = array();
	
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	
	try {
	$sql = "SELECT * FROM products WHERE user_id=:user_id ORDER BY id DESC";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImagesData = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	 $sql1 = "SELECT * FROM wishlists WHERE product_id=:product_id ";
		$stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("product_id", $products->id);
        $stmt1->execute();
		$count1 = $stmt1->rowCount();
		if($count1>0)
		{
		$in_wishlist=1;
		}
		else
		{
		$in_wishlist=0;
		}
	
	//	print_r($productImagesData);
	
	$sqlCatName = "SELECT  `name` FROM categories WHERE `id`='" . $products->category_id . "'";
	$stmtCatName = $db->prepare($sqlCatName);
	$stmtCatName->execute();
	$getCatdetails = $stmtCatName->fetchObject();	
	
	
	$sqlSubCatName = "SELECT  `name` FROM categories WHERE `id`='" . $products->sub_category_id . "'";
	$stmtSubCatName = $db->prepare($sqlSubCatName);
	$stmtSubCatName->execute();
	$getSubCatdetails = $stmtSubCatName->fetchObject();	
	
	$allproducts[] = array(
	"id" => stripslashes($products->id),
	"shop_id" => stripslashes($products->shop_id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"category_name" => stripslashes($getCatdetails->name),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"sub_category_name" => stripslashes($getSubCatdetails->name),
	"quantity" => stripslashes($getSubCatdetails->quantity),
	"sold_quantity" => stripslashes($getSubCatdetails->sold_quantity),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"keywords" => stripslashes($products->keywords),
	"shipping_time" => stripslashes($products->shipping_time),
	"processing_time" => stripslashes($products->processing_time),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"package_weight" => stripslashes($products->package_weight),
	"package_unit" => stripslashes($products->package_unit),
	"package_size1" => stripslashes($products->package_size1),
	"package_size2" => stripslashes($products->package_size2),
	"package_size3" => stripslashes($products->package_size3),
	"package_size_unit" => stripslashes($products->package_size_unit),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"status" => stripslashes($products->status),
	"in_wishlist" => stripslashes($in_wishlist),
	"image" => $productImagesData);
	
	
	
	}
	
	$data['shop_id'] = $products->shop_id;
	$data['all_products'] = $allproducts;
	$data['Ack'] = 1;
	} else {
	$data['products'] = '';
	$data['Ack'] = 0;
	}
	} catch (PDOException $e) {
	$data['products'] = '';
	$data['Ack'] = 0;
	}
	//print_r($data);	
	
	echo json_encode($data);
	exit;
}

function allProducts() {
	$data = array();
	$allproducts = array();
	$productImagesData = array();
	
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	
	try {
	$sql = "SELECT * FROM products WHERE 1 ORDER BY id";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImagesData = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	 $sql1 = "SELECT * FROM wishlists WHERE product_id=:product_id and user_id=:user_id  ";
		$stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("product_id", $products->id);
		  $stmt1->bindParam("user_id", $user_id);
        $stmt1->execute();
		$count1 = $stmt1->rowCount();
		if($count1>0)
		{
		$in_wishlist=1;
		}
		else
		{
		$in_wishlist=0;
		}
	
	//	print_r($productImagesData);
	
	$sqlCatName = "SELECT  `name` FROM categories WHERE `id`='" . $products->category_id . "'";
	$stmtCatName = $db->prepare($sqlCatName);
	$stmtCatName->execute();
	$getCatdetails = $stmtCatName->fetchObject();	
	
	
	$sqlSubCatName = "SELECT  `name` FROM categories WHERE `id`='" . $products->sub_category_id . "'";
	$stmtSubCatName = $db->prepare($sqlSubCatName);
	$stmtSubCatName->execute();
	$getSubCatdetails = $stmtSubCatName->fetchObject();	
	
	$allproducts[] = array(
	"id" => stripslashes($products->id),
	"shop_id" => stripslashes($products->shop_id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"category_name" => stripslashes($getCatdetails->name),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"sub_category_name" => stripslashes($getSubCatdetails->name),
	"quantity" => stripslashes($getSubCatdetails->quantity),
	"sold_quantity" => stripslashes($getSubCatdetails->sold_quantity),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"keywords" => stripslashes($products->keywords),
	"shipping_time" => stripslashes($products->shipping_time),
	"processing_time" => stripslashes($products->processing_time),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"package_weight" => stripslashes($products->package_weight),
	"package_unit" => stripslashes($products->package_unit),
	"package_size1" => stripslashes($products->package_size1),
	"package_size2" => stripslashes($products->package_size2),
	"package_size3" => stripslashes($products->package_size3),
	"package_size_unit" => stripslashes($products->package_size_unit),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"status" => stripslashes($products->status),
    "in_wishlist" => stripslashes($in_wishlist),
	"image" => $productImagesData);
	
	
	
	}
	
	$data['shop_id'] = $products->shop_id;
	$data['all_products'] = $allproducts;
	$data['Ack'] = 1;
	} else {
	$data['products'] = '';
	$data['Ack'] = 0;
	}
	} catch (PDOException $e) {
	$data['products'] = '';
	$data['Ack'] = 0;
	}
	//print_r($data);	
	
	echo json_encode($data);
	exit;
}


	function listMyShops() {
	$data = array();
	$allshops = array();
	$allCategories=array();
	$allSubCategories=array();
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	try {
	$sql = "SELECT * FROM shops WHERE user_id=:user_id";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->execute();
	$getshops = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getshops as $shops) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	if($shops->logo!=''){
	$logo=SITE_URL . 'app/webroot/shop_images/' . $shops->logo;
	}
	else{
	$logo='';
	}
	if($shops->cover_photo!=''){
	$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $shops->cover_photo;
	}
	else{
	$cover_photo='';
	}
	
	
	// GET CATEGORIES  ======================================================
	
	
	$sqlStoreCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->categories .")";
	$stmtStoreCategoryDetails = $db->prepare($sqlStoreCategoryDetails);
	$stmtStoreCategoryDetails->execute();
	$getStoreCategoryDetails = $stmtStoreCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allCategories);
	$allCategories=array();
	foreach ($getStoreCategoryDetails as $shops_categories) {
    $allCategories[]=array('ID' => $shops_categories->id,
	                       'NAME' => $shops_categories->name);
	}
	// ======================================================================
	
	// GET SUBCATEGORIES  ======================================================
	
	
	$sqlStoreSubCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->sub_categories .")";
	$stmtStoreSubCategoryDetails = $db->prepare($sqlStoreSubCategoryDetails);
	$stmtStoreSubCategoryDetails->execute();
	$getStoreSubCategoryDetails = $stmtStoreSubCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allSubCategories);
	$allSubCategories=array();
	foreach ($getStoreSubCategoryDetails as $shops_sub_categories) {
    $allSubCategories[]=array('ID' => $shops_sub_categories->id,
	                       'NAME' => $shops_sub_categories->name);
	}
	// ======================================================================	
	
	
	$sqlStoreOwnerDetails = "SELECT  * FROM users WHERE `id`='" . $shops->user_id . "'";
	$stmtStoreOwnerDetails = $db->prepare($sqlStoreOwnerDetails);
	$stmtStoreOwnerDetails->execute();
	$getStoreOwnerDetails = $stmtStoreOwnerDetails->fetchObject();	
	$paypal_business_email =$getStoreOwnerDetails->paypal_business_email;	
	
	
	
	$allshops[] = array(
	"id" => stripslashes($shops->id),
	"user_id" => stripslashes($shops->user_id),
	"name" => stripslashes(strip_tags($shops->name)),
	"description" => stripslashes($shops->description),
	"categories" => $allCategories,
	"sub_categories" => $allSubCategories,
	"facebook" => stripslashes($shops->facebook),
	"twitter" => stripslashes($shops->twitter),
	"linkedin" => stripslashes($shops->linkedin),
	"pinterest" => stripslashes($shops->pinterest),
	"youtube" => stripslashes($shops->youtube),
	"is_active" => stripslashes($shops->is_active),
	"created_at" => stripslashes($shops->created_at),
	"paid_on" => stripslashes($shops->paid_on),
	"last_date" => stripslashes($shops->last_date),
	"paypal_business_email" => stripslashes($paypal_business_email),
	"logo" => stripslashes($logo),
	"cover_photo" => stripslashes($cover_photo));
	
	$data['shop_id'] = $shops->id;
	
	}
	$data['allshops'] = $allshops;
	$data['Ack'] = 1;
	} else {
	$data['allshops'] = $allshops;
	$data['shop_id'] = 0;
	$data['Ack'] = 0;
	}
	
	
	
	
	} catch (PDOException $e) {
	$data['allshops'] = $allshops;
	$data['shop_id'] = 0;
	$data['Ack'] = 0;
	}
	//print_r($data);	
	
	echo json_encode($data);
	exit;
}





	function productDetails() {
	$data = array();
	$allproducts = array();
	$productImagesData = array();
	$productAllReviewsList = array();
	$allCartProducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$id = $body['prd_id'];
	$user_id = $body['user_id'];
	
	$sqlview = "SELECT  * from `products` WHERE `id`='" . $id . "'";
	$db = getConnection();
	        $stmtview = $db->prepare($sqlview);
	        $stmtview->execute();
	        $getview = $stmtview->fetchObject();
			$view=$getview->views+1;
		    
			$updateview = "UPDATE `products` SET `views`='".$view."' WHERE `id`='" . $id . "'";
	        $stmtviewup = $db->prepare($updateview);
	        $stmtviewup->execute();
	
	
	try {
	
		
	$sql = "SELECT * FROM products WHERE id=:id";
	$stmt = $db->prepare($sql);
	$stmt->bindParam("id", $id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getproducts as $products) {
	
	unset($productImagesData);
	$productImagesData = array();
	
	
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	
	        $sql1 = "SELECT * FROM wishlists WHERE product_id=:product_id and user_id=:user_id";
		    $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("product_id", $products->id);
			 $stmt1->bindParam("user_id", $user_id);
            $stmt1->execute();
		    $count1 = $stmt1->rowCount();
		    if($count1>0)
		     {
		     $in_wishlist=1;
		      }
		     else
		      {
		     $in_wishlist=0;
		       }
			
	
	
	
	unset($productAllReviews);
	$productReviews = "select * FROM ratings WHERE `product_id`='" . $id . "'";
	$stmtProductReview = $db->query($productReviews);
	$productAllReviews = $stmtProductReview->fetchAll(PDO::FETCH_OBJ);
	$isReviewExists = $stmtProductReview->rowCount();
	if ($isReviewExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productAllReviews as $reviews) {
	//echo '<pre>';
	//print_r($img_products);
	
	$sqlReviewUserDetails = "SELECT  * FROM users WHERE `id`='" . $reviews->user_id . "'";
	$stmtReviewUserDetails = $db->prepare($sqlReviewUserDetails);
	$stmtReviewUserDetails->execute();
	$getReviewUserDetails = $stmtReviewUserDetails->fetchObject();	
	$reviewerName=$getReviewUserDetails->first_name.' '.$getReviewUserDetails->last_name;
	
	$productAllReviewsList[]=array(
	"product_id" => stripslashes($reviews->product_id),
	"shop_id" => stripslashes($reviews->shop_id),
	"user_id" => stripslashes($reviews->user_id),
	"user_name" => stripslashes($reviewerName),
	"accuracy" => stripslashes($reviews->rate_this),
	"product_as_described" => stripslashes($reviews->product_description),
	"shipment_delivery" => stripslashes($reviews->ship_item),
	"avg_rating" => stripslashes($reviews->rating),
	"review" => stripslashes($reviews->review),
	"date_time" => stripslashes($reviews->date_time));
	}
	}	

	
	
	$sqlCatName = "SELECT  `name` FROM categories WHERE `id`='" . $products->category_id . "'";
	$stmtCatName = $db->prepare($sqlCatName);
	$stmtCatName->execute();
	$getCatdetails = $stmtCatName->fetchObject();	
	
	
	$sqlSubCatName = "SELECT  `name` FROM categories WHERE `id`='" . $products->sub_category_id . "'";
	$stmtSubCatName = $db->prepare($sqlSubCatName);
	$stmtSubCatName->execute();
	$getSubCatdetails = $stmtSubCatName->fetchObject();	
	//print_r($catName);
	
	
//		print_r($productReviews);




	/**/// GET Product General RATING
	
	$sqlAvgRating = "SELECT CAST(AVG(rating) AS SIGNED) as avg_rating FROM ratings WHERE `product_id`='" . $id . "'";
	$stmtAvgRating = $db->prepare($sqlAvgRating);
	$stmtAvgRating->execute();
	$getAvgRating = $stmtAvgRating->fetchObject();	
	$avgRatingCount = $stmtAvgRating->rowCount();
	if($avgRatingCount>0){
	$product_rating = $getAvgRating->avg_rating;	
	}
	else{
	$product_rating = 0;	
	}
	
// GRT PRODUCT ACCURACY RATING

	
	$sqlAvgRating = "SELECT CAST(AVG(rate_this) AS SIGNED) as avg_rating FROM ratings WHERE `product_id`='" . $id . "'";
	$stmtAvgRating = $db->prepare($sqlAvgRating);
	$stmtAvgRating->execute();
	$getAvgRating = $stmtAvgRating->fetchObject();	
	$avgRatingCount = $stmtAvgRating->rowCount();
	if($avgRatingCount>0){
	$product_accuracy_rating = $getAvgRating->avg_rating;	
	}
	else{
	$product_accuracy_rating = 0;	
	}	
	
	// GRT PRODUCT SATISFACTION RATING

	
	$sqlAvgRating = "SELECT CAST(AVG(seller_communication) AS SIGNED) as avg_rating FROM ratings WHERE `product_id`='" . $id . "'";
	$stmtAvgRating = $db->prepare($sqlAvgRating);
	$stmtAvgRating->execute();
	$getAvgRating = $stmtAvgRating->fetchObject();	
	$avgRatingCount = $stmtAvgRating->rowCount();
	if($avgRatingCount>0){
	$product_satisfaction_rating = $getAvgRating->avg_rating;	
	}
	else{
	$product_satisfaction_rating = 0;	
	}	
	
	// GRT PRODUCT DESCRIBED RATING

	
	$sqlAvgRating = "SELECT CAST(AVG(product_description) AS SIGNED) as avg_rating FROM ratings WHERE `product_id`='" . $id . "'";
	$stmtAvgRating = $db->prepare($sqlAvgRating);
	$stmtAvgRating->execute();
	$getAvgRating = $stmtAvgRating->fetchObject();	
	$avgRatingCount = $stmtAvgRating->rowCount();
	if($avgRatingCount>0){
	$product_described_rating = $getAvgRating->avg_rating;	
	}
	else{
	$product_described_rating = 0;	
	}	
	
	
	// GRT PRODUCT SHIPMENT RATING

	
	$sqlAvgRating = "SELECT CAST(AVG(ship_item) AS SIGNED) as avg_rating FROM ratings WHERE `product_id`='" . $id . "'";
	$stmtAvgRating = $db->prepare($sqlAvgRating);
	$stmtAvgRating->execute();
	$getAvgRating = $stmtAvgRating->fetchObject();	
	$avgRatingCount = $stmtAvgRating->rowCount();
	if($avgRatingCount>0){
	$product_shipment_rating = $getAvgRating->avg_rating;	
	}
	else{
	$product_shipment_rating = 0;	
	}

	// GRT PRODUCT SHIPMENT RATING

	
	$sqlgetTotalRating = "SELECT * FROM ratings WHERE `product_id`='" . $id . "'";
	$stmtTotalRating = $db->prepare($sqlgetTotalRating);
	$stmtTotalRating->execute();
	$getTotalRating = $stmtTotalRating->fetchAll(PDO::FETCH_OBJ);;	
	$ratingCount = $stmtTotalRating->rowCount();


	$sqlTotalSoldItem = "SELECT * FROM order_details WHERE `product_id`='" . $id . "'";
	$stmtTotalSoldItem = $db->prepare($sqlTotalSoldItem);
	$stmtTotalSoldItem->execute();
$getTotalSoldItem = $stmtTotalSoldItem->fetchAll(PDO::FETCH_OBJ);;	
		$total_sold_item = $stmtTotalSoldItem->rowCount();
		
		
			
			
	
	
	$allproducts[] = array(
	"id" => stripslashes($products->id),
	"name" => stripslashes($products->name),
	"sku" => stripslashes(strip_tags($products->sku)),
	"category_id" => stripslashes($products->category_id),
	"sub_category_id" => stripslashes($products->sub_category_id),
	"category_name" => stripslashes($getCatdetails->name),
	"sub_category_name" => stripslashes($getSubCatdetails->name),
	"is_featured" => stripslashes($products->is_featured),
	"unit_type" => stripslashes($products->unit_type),
	"quantity_lot" => stripslashes($products->quantity_lot),
	"price_lot" => stripslashes($products->price_lot),
	"keywords" => stripslashes($products->keywords),
	"shipping_time" => stripslashes($products->shipping_time),
	"processing_time" => stripslashes($products->processing_time),
	"sale_on" => stripslashes($products->sale_on),
	"discount" => stripslashes($products->discount),
	"start_date" => stripslashes($products->start_date),
	"end_date" => stripslashes($products->end_date),
	"package_weight" => stripslashes($products->package_weight),
	"package_unit" => stripslashes($products->package_unit),
	"package_size1" => stripslashes($products->package_size1),
	"package_size2" => stripslashes($products->package_size2),
	"package_size3" => stripslashes($products->package_size3),
	"package_size_unit" => stripslashes($products->package_size_unit),
	"created_at" => stripslashes($products->created_at),
	"return_policy" => stripslashes($products->return_policy),
	"item_specification" => stripslashes($products->item_specification),
	"item_description" => stripslashes($products->item_description),
	"delivery_terms" => stripslashes($products->delivery_terms),
	"views" => stripslashes($products->views),
	"last_view_date" => stripslashes($products->last_view_date),
	"total_rate" => stripslashes($products->total_rate),
	"rate_count" => stripslashes($products->rate_count),
	"rate_count" => stripslashes($products->rate_count),
	"product_rating" => stripslashes($product_rating),
	"average_rating" => stripslashes($product_rating),
	"product_accuracy_rating" => stripslashes($product_accuracy_rating),
	"product_satisfaction_rating" => stripslashes($product_satisfaction_rating),
	"product_described_rating" => stripslashes($product_described_rating),
	"product_shipment_rating" => stripslashes($product_shipment_rating),
	"total_rating" => $ratingCount,
	"total_order" => $total_sold_item,
	"productReviews" => $productAllReviewsList,
	"in_wishlist" => $in_wishlist,
	"image" => $productImagesData);
	
	
	
	}
	$data['prd_id'] = $id;
	$data['user_id'] = $user_id;
	$data['all_products'] = $allproducts;
	
	$data['Ack'] = 1;
	
	
	
	
	
		
		// GET CART DETAILS 
		// ============================================================================
		$sqlcart = "SELECT * FROM temp_carts WHERE user_id=:user_id";
		//  $db = getConnection();
		$stmtcart = $db->prepare($sqlcart);
		$stmtcart->bindParam("user_id", $user_id);
		$stmtcart->execute();
		$getCartProducts = $stmtcart->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmtcart->rowCount();
		if ($count > 0) {
		foreach ($getCartProducts as $cartProducts) {
		$allCartProducts[] = array(
		"user_id" => stripslashes($cartProducts->user_id),
		"shop_id" => stripslashes($cartProducts->shop_id),
		"prd_id" => stripslashes($cartProducts->prd_id),
		"name" => stripslashes($cartProducts->name),
		"price" => stripslashes($cartProducts->price),
		"quantity" => stripslashes($cartProducts->quantity),
		"shipping_address" => stripslashes($cartProducts->shipping_address),
		"shipping_time" => stripslashes($cartProducts->shipping_time),
		"processing_time" => stripslashes($cartProducts->processing_time),
		"product_woner_id" => stripslashes($cartProducts->product_woner_id),
		"pay_amt" => stripslashes($cartProducts->pay_amt),
		"image" => SITE_URL . $cartProducts->image,
		"cdate" => stripslashes($cartProducts->cdate));
		
		}
		$data['all_cart_items'] = $allCartProducts;
		
        }
		else{
		$data['all_cart_items'] = $allCartProducts;
		
		}


		
		// GET CART TOTAL AMOUNT
		
		$sqlCartTotal = "SELECT CAST(SUM(pay_amt) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
		$stmtCartTotal = $db->prepare($sqlCartTotal);
		$stmtCartTotal->execute();
		$getCartTotal = $stmtCartTotal->fetchObject();	
		$cartElementCount = $stmtCartTotal->rowCount();
		if($cartElementCount>0){
		$data['all_amount'] = $getCartTotal->total;	
		}
		else{
		$data['all_amount'] = 0;	
		}
		
		
		// GET CART TOTAL NUMBER
		
		$sqlCartTotalQuantity = "SELECT CAST(SUM(quantity) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
		$stmtCartTotalQuantity = $db->prepare($sqlCartTotalQuantity);
		$stmtCartTotalQuantity->execute();
		$getCartTotalQuantity = $stmtCartTotalQuantity->fetchObject();	
		$cartElementCountQuantity = $stmtCartTotalQuantity->rowCount();
		if($cartElementCountQuantity>0){
		$data['cart_quantity'] = $getCartTotalQuantity->total;	
		}
		else{
		$data['cart_quantity'] = 0;	
		}				
		
			


	} else {
	$data['products'] = '';
	$data['prd_id'] = $id;
	$data['user_id'] = $user_id;
	$data['Ack'] = 0;
	}
	} catch (PDOException $e) {
	print_r($e);
	$data['products'] = '';
	$data['prd_id'] = $id;
	$data['user_id'] = $user_id;
	$data['Ack'] = 0;
	}
	//print_r($data);	
	
	echo json_encode($data);
	exit;
}



	function removeMyProduct() {
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$id = $body['prd_id'];
	
	
	$sql = "DELETE FROM products WHERE user_id=:user_id AND id=:id";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("id", $id);
	$stmt->execute();
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Product Removed Successfully';
	} catch (PDOException $e) {
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}





function userSignup() {

    //error_log('addWine\n', 3, '/var/tmp/php.log');
    $data = array();
    $app = new Slim();
    //    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());

    $email = $body['email'];
    $pass_app = $body['password'];
    $first_name = $body['firstname'];
    $last_name = $body['lastname'];
	$company_name = $body['companyname'];
	$mobile_number = $body['phone'];
    $my_latitude = $body['my_latitude'];
    $my_longitude = $body['my_longitude'];


    $byeamil = findByConditionArray(array('email' => $email), 'users');
    if (empty($byeamil)) {

//    echo $paramValue = $app->request->post('fname');
        $sql = "INSERT INTO users (first_name, last_name, email, pass_app, company_name, mobile_number, my_latitude, my_longitude) VALUES (:first_name, :last_name, :email, :pass_app, :company_name, :mobile_number, :my_latitude, :my_longitude)";
        try {
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("first_name", $first_name);
            $stmt->bindParam("last_name", $last_name);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("mobile_number", $mobile_number);
            $stmt->bindParam("pass_app", md5($pass_app));
            $stmt->bindParam("company_name", $company_name);
            $stmt->bindParam("my_latitude", $my_latitude);
            $stmt->bindParam("my_longitude", $my_longitude);

            $stmt->execute();
//   

            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Registered Successfully...';
            $sql = "SELECT * FROM users WHERE id=:id ";

            //$db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $lastID);
            $stmt->execute();

            $getUserdetails = $stmt->fetchObject();


if($getUserdetails->profile_image!=''){
$profile_image=SITE_URL.'app/webroot/user_images/'.$getUserdetails->profile_image;
}
else{
$profile_image='';
}

             $data['UserDetails'] = array(
			    "user_id" => stripslashes($getUserdetails->id),
                "first_name" => stripslashes($getUserdetails->first_name),
                "last_name" => stripslashes($getUserdetails->last_name),
                "company_name" => stripslashes($getUserdetails->company_name),
                "email" => stripslashes($getUserdetails->email),
                "type" => stripslashes($getUserdetails->type),
                "profile_image" => stripslashes($profile_image),
                "mobile_number" => stripslashes($getUserdetails->mobile_number),
                "is_active" => stripslashes($getUserdetails->is_active),
				"registration_date" => stripslashes($getUserdetails->registration_date),
				"paypal_business_email" => stripslashes($getUserdetails->paypal_business_email),
				"bio" => stripslashes($getUserdetails->bio),
                "address" => stripslashes($getUserdetails->address),
                "gender" => stripslashes($getUserdetails->gender),
                "zip_code" => stripslashes($getUserdetails->zip_code),
				"twitter_url" => stripslashes($getUserdetails->twitter_url),
				"linkdin_url" => stripslashes($getUserdetails->linkdin_url),
				"youtube_url" => stripslashes($getUserdetails->youtube_url),
                "facebook_url" => stripslashes($getUserdetails->facebook_url),
                "nick_name" => stripslashes($getUserdetails->nick_name),
				"alternate_email" => stripslashes($getUserdetails->alternate_email),
				"city" => stripslashes($getUserdetails->city),
				"state" => stripslashes($getUserdetails->state),
				"country" => stripslashes($getUserdetails->country),
				"telephone_country_code" => stripslashes($getUserdetails->telephone_country_code),
				"telephone_area_code" => stripslashes($getUserdetails->telephone_area_code),
				"telephone_number" => stripslashes($getUserdetails->telephone_number),
				"fax_country_code" => stripslashes($getUserdetails->fax_country_code),
				"fax_area_code" => stripslashes($getUserdetails->fax_area_code),
				"fax_number" => stripslashes($getUserdetails->fax_number),
				"job_title" => stripslashes($getUserdetails->job_title),
				"shop_address" => stripslashes($getUserdetails->shop_address),
				"shop_vat" => stripslashes($getUserdetails->shop_vat),
				"shop_city" => stripslashes($getUserdetails->shop_city),
				"shop_company_reg_no" => stripslashes($getUserdetails->shop_company_reg_no),
				"shop_country" => stripslashes($getUserdetails->shop_country),
				"shop_zip_code" => stripslashes($getUserdetails->shop_zip_code),
				"balance" => stripslashes($getUserdetails->balance),
				"shipping_full_name" => stripslashes($getUserdetails->shipping_full_name),
				"shipping_address" => stripslashes($getUserdetails->shipping_address),
				"shipping_city" => stripslashes($getUserdetails->shipping_city),
				"shipping_state" => stripslashes($getUserdetails->shipping_state),
				"shipping_country" => stripslashes($getUserdetails->shipping_country),
				"shipping_zip_code" => stripslashes($getUserdetails->shipping_zip_code),
				"my_latitude" => stripslashes($getUserdetails->my_latitude),
                "my_longitude" => stripslashes($getUserdetails->my_longitude));


             $to = $email;

            $subject = "twop.com- Thank you for registering";
            $TemplateMessage = "Wellcome and thank you for registering at twop.com!<br />";
            $TemplateMessage .= "Your account has now been created and you can login using your email address and password by visiting our App<br />";
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);

         

            $db = null;
            //echo json_encode($user);
        } catch (PDOException $e) {
            //error_log($e->getMessage(), 3, '/var/tmp/php.log');
            $data['last_id'] = '';
            $data['Ack'] = '0';
			$data['msg'] = 'Registration Error !!!';
        }
    } else {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Email address already exists';
    }
    echo json_encode($data);
	exit;
}


function updateProfile() {
    //error_log('addWine\n', 3, '/var/tmp/php.log');
    $data = array();
    $app = new Slim();

//    echo $paramValue = $app->request->get('fname');
/*    $request = Slim::getInstance()->request();
    $body = json_decode($request->getBody());
    //$body = ($request->post());
    //echo 'Hi';

    $name = $body->name;
    $expname = explode(" ", $name);

    $phone = $body->user_id;
    $first_name = $body->first_name;
    $b_address1 = $body->b_address1;
    $my_latitude = $body->my_latitude;
    $my_longitude = $body->my_longitude;
    $user_id = $body->user_id;*/
	
	
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$first_name = $body['first_name'];
	$last_name = $body['last_name'];
	$nick_name = $body['nick_name'];
	$gender = $body['gender'];
	$email = $body['email'];
	$alternate_email = $body['alternate_email'];
	$city = $body['city'];
	$state = $body['state'];
	$country = $body['country'];
	$zip_code = $body['zip_code'];
	$telephone_country_code = $body['telephone_country_code'];
	$telephone_number = $body['telephone_number'];
	$fax_country_code = $body['fax_country_code'];
	$fax_area_code = $body['fax_area_code'];
	$fax_number = $body['fax_number'];
	$mobile_number = $body['mobile_number'];
	$job_title = $body['job_title'];
	$address = $body['address'];
	$telephone_area_code = $body['telephone_area_code'];
	$shop_address = $body['shop_address'];
	$shop_city = $body['shop_city'];
	$shop_country = $body['shop_country'];
	$shop_zip_code = $body['shop_zip_code'];
	$shop_vat = $body['shop_vat'];
	$shop_company_reg_no = $body['shop_company_reg_no'];
	$user_id = $body['user_id'];

//   print_r($body);
//   exit;
//$password = md5($body['password']);
//    $my_latitude = $body['my_latitude'];
//    $my_longitude = $body['my_longitude'];
//    echo $paramValue = $app->request->post('fname');
//exit;
    $sql = "UPDATE users SET first_name=:first_name, last_name=:last_name, nick_name=:nick_name, gender=:gender, email=:email, alternate_email=:alternate_email, city=:city, state=:state, country=:country, zip_code=:zip_code, telephone_country_code=:telephone_country_code, telephone_number=:telephone_number, fax_country_code=:fax_country_code, fax_area_code=:fax_area_code, fax_number=:fax_number, mobile_number=:mobile_number, job_title=:job_title, address=:address, telephone_area_code=:telephone_area_code, shop_address=:shop_address, shop_city=:shop_city, shop_country=:shop_country, shop_zip_code=:shop_zip_code, shop_vat=:shop_vat, shop_company_reg_no=:shop_company_reg_no WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("first_name", $first_name);
        $stmt->bindParam("last_name", $last_name);
        $stmt->bindParam("nick_name", $nick_name);
        $stmt->bindParam("gender", $gender);
        $stmt->bindParam("email", $email);
        $stmt->bindParam("alternate_email", $alternate_email);
        $stmt->bindParam("city", $city);
		$stmt->bindParam("state", $state);
		$stmt->bindParam("country", $country);
		$stmt->bindParam("zip_code", $zip_code);
		$stmt->bindParam("telephone_country_code", $telephone_country_code);
		$stmt->bindParam("telephone_number", $telephone_number);
		$stmt->bindParam("fax_country_code", $fax_country_code);
		$stmt->bindParam("fax_area_code", $fax_area_code);
		$stmt->bindParam("fax_number", $fax_number);
		$stmt->bindParam("mobile_number", $mobile_number);
		$stmt->bindParam("job_title", $job_title);
		$stmt->bindParam("address", $address);
		$stmt->bindParam("telephone_area_code", $telephone_area_code);
		$stmt->bindParam("shop_address", $shop_address);
		$stmt->bindParam("shop_city", $shop_city);
		$stmt->bindParam("shop_country", $shop_country);
		$stmt->bindParam("shop_zip_code", $shop_zip_code);
		$stmt->bindParam("shop_vat", $shop_vat);
		$stmt->bindParam("shop_company_reg_no", $shop_company_reg_no);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $data['last_id'] = $user_id;
        $data['Ack'] = '1';
        $data['msg'] = 'Profile Updated Successfully...';

        $sql1 = "SELECT * FROM users WHERE id=:id";
        //$db = getConnection();
        $stmt1 = $db->prepare($sql1);
        $stmt1->bindParam("id", $user_id);
        $stmt1->execute();
		
		
		$getUserdetails = $stmt1->fetchObject();
		
		
	if($getUserdetails->profile_image!=''){
$profile_image=SITE_URL.'app/webroot/user_images/'.$getUserdetails->profile_image;
}
else{
$profile_image='';
}

             $data['UserDetails'] = array(
			    "user_id" => stripslashes($getUserdetails->id),
                "first_name" => stripslashes($getUserdetails->first_name),
                "last_name" => stripslashes($getUserdetails->last_name),
                "company_name" => stripslashes($getUserdetails->company_name),
                "email" => stripslashes($getUserdetails->email),
                "type" => stripslashes($getUserdetails->type),
                "profile_image" => stripslashes($profile_image),
                "mobile_number" => stripslashes($getUserdetails->mobile_number),
                "is_active" => stripslashes($getUserdetails->is_active),
				"registration_date" => stripslashes($getUserdetails->registration_date),
				"paypal_business_email" => stripslashes($getUserdetails->paypal_business_email),
				"bio" => stripslashes($getUserdetails->bio),
                "address" => stripslashes($getUserdetails->address),
                "gender" => stripslashes($getUserdetails->gender),
                "zip_code" => stripslashes($getUserdetails->zip_code),
				"twitter_url" => stripslashes($getUserdetails->twitter_url),
				"linkdin_url" => stripslashes($getUserdetails->linkdin_url),
				"youtube_url" => stripslashes($getUserdetails->youtube_url),
                "facebook_url" => stripslashes($getUserdetails->facebook_url),
                "nick_name" => stripslashes($getUserdetails->nick_name),
				"alternate_email" => stripslashes($getUserdetails->alternate_email),
				"city" => stripslashes($getUserdetails->city),
				"state" => stripslashes($getUserdetails->state),
				"country" => stripslashes($getUserdetails->country),
				"telephone_country_code" => stripslashes($getUserdetails->telephone_country_code),
				"telephone_area_code" => stripslashes($getUserdetails->telephone_area_code),
				"telephone_number" => stripslashes($getUserdetails->telephone_number),
				"fax_country_code" => stripslashes($getUserdetails->fax_country_code),
				"fax_area_code" => stripslashes($getUserdetails->fax_area_code),
				"fax_number" => stripslashes($getUserdetails->fax_number),
				"job_title" => stripslashes($getUserdetails->job_title),
				"shop_address" => stripslashes($getUserdetails->shop_address),
				"shop_vat" => stripslashes($getUserdetails->shop_vat),
				"shop_city" => stripslashes($getUserdetails->shop_city),
				"shop_company_reg_no" => stripslashes($getUserdetails->shop_company_reg_no),
				"shop_country" => stripslashes($getUserdetails->shop_country),
				"shop_zip_code" => stripslashes($getUserdetails->shop_zip_code),
				"balance" => stripslashes($getUserdetails->balance),
				"shipping_full_name" => stripslashes($getUserdetails->shipping_full_name),
				"shipping_address" => stripslashes($getUserdetails->shipping_address),
				"shipping_city" => stripslashes($getUserdetails->shipping_city),
				"shipping_state" => stripslashes($getUserdetails->shipping_state),
				"shipping_country" => stripslashes($getUserdetails->shipping_country),
				"shipping_zip_code" => stripslashes($getUserdetails->shipping_zip_code),
				"my_latitude" => stripslashes($getUserdetails->my_latitude),
                "my_longitude" => stripslashes($getUserdetails->my_longitude));


        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
        //print_r($e);
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['userDetails'] = '';
        $data['last_id'] = '';
        $data['Ack'] = '0';
		$data['msg'] = 'Error!!!';
    }
    echo json_encode($data);
    exit;
}


	function updatePhoto() {
	
	$data = array();
	$app = new Slim();
	$request = Slim::getInstance()->request();
	
	//$body = json_decode($request->getBody());
	//print_r($request->post("id"));
	//die();
	try {
	$db = getConnection();
	
	//print_r($_FILES['image']['tmp_name']);
	//echo $id;
	//exit();
	//print_r($body);
	//exit();
	
	
	if ($_FILES['profile_image']['tmp_name'] != '') {
	$id = $request->post("user_id");
	
	$target_path = "../app/webroot/user_images/";
	
//	$target_path = "user_images/";
	$userfile_name = $_FILES['profile_image']['name'];
	$userfile_tmp = $_FILES['profile_image']['tmp_name'];
	$profile_image = time() . $userfile_name;
	$img = $target_path . $profile_image;
	move_uploaded_file($userfile_tmp, $img);
	
	$sqlimg = "UPDATE users SET profile_image=:profile_image WHERE id=:id";
	$stmt1 = $db->prepare($sqlimg);
	$stmt1->bindParam("id", $id);
	$stmt1->bindParam("profile_image", $profile_image);
	$stmt1->execute();
	
	
	$data['id'] = $id;
	$data['Ack'] = '1';
	$data['msg'] = 'Image Added.';
	} else {
	$data['id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Image Not Added.';
	}
	
	$db = null;
	} catch (PDOException $e) {
	$data['id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Image Not Added. Please Try Again.';
	}
	echo json_encode($data);
	exit;
}




function forgotPassword() {

    //error_log('addWine\n', 3, '/var/tmp/php.log');
    $data = array();
	
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$email = $body['email'];
	
	
    $byeamil = findByConditionArray(array('email' => $email), 'users');
    if (!empty($byeamil)) {



        $sql = "SELECT * FROM users WHERE email=:email ";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();

        $to = $email;
        $password = rand(1111, 9999);


        $sql = "UPDATE users SET pass_app=:pass_app WHERE email=:email";
        $stmt = $db->prepare($sql);
        $stmt->bindParam("pass_app", md5($password));
        $stmt->bindParam("email", $email);
        $stmt->execute();

        $subject = "twop.com- Your Password Request";
        $TemplateMessage = "Hello " . $getUserdetails->fname . "<br />";
        $TemplateMessage .= "You have asked for your new password. Your Password is below :<br />";
        $TemplateMessage .= "Password :" . $password;

        $TemplateMessage .= "Thanks,<br />";
        $TemplateMessage .= "twop.com<br />";



        $header = "From:info@twop.com \r\n";
        // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html\r\n";

        $retval = mail($to, $subject, $TemplateMessage, $header);

        $db = null;
        $data['Ack'] = '1';
        $data['msg'] = 'Mail Send Successfully';
    } else {
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'Email not found in our database';
    }


    echo json_encode($data);
	exit;
}


function facebookSignup() {
    //error_log('addWine\n', 3, '/var/tmp/php.log');
    $data = array();
    $app = new Slim();
//    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());
    $fb_user_id = $body['fb_user_id'];

//    echo $paramValue = $app->request->post('fname');
//exit;
    $details1 = findByConditionArray(array('fb_user_id' => $fb_user_id), 'users');

    try {
        if (!empty($details1)) {
            $details = $details1['0'];
            $data['Ack'] = '1';
            $data['userDetails'] = array(
                "fname" => stripslashes($details['fname']),
                "lname" => stripslashes($details['lname']),
                "email" => stripslashes($details['email']),
                "phone" => stripslashes($details['phone']),
                "b_address1" => stripslashes($details['b_address1']),
                "b_address2" => stripslashes($details['b_address2']),
                "b_street" => stripslashes($details['b_street']),
                "b_city" => stripslashes($details['b_city']),
                "b_state" => stripslashes($details['b_state']),
                "b_country" => stripslashes($details['b_country']),
                "building_no" => stripslashes($details['building_no']),
                "zone" => stripslashes($details['zone']),
                "my_latitude" => stripslashes($details['my_latitude']),
                "my_longitude" => stripslashes($details['my_longitude']),
                "notes" => stripslashes($details['notes']),
                "id" => stripslashes($details['id']),
                "fb_id" => stripslashes($details['fb_user_id']),
                "image" => stripslashes($image_url));
            ;
        } else {
            $fname = $body['fname'];
            $lname = $body['lname'];
            $email = $body['email'];

            $byeamil = findByConditionArray(array('email' => $email), 'users');
            //   if (empty($byeamil)) {
            $sql = "INSERT INTO users (fname, lname, email, fb_user_id) VALUES (:fname, :lname, :email, :fb_user_id)";
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("fname", $fname);
            $stmt->bindParam("lname", $lname);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("fb_user_id", $fb_user_id);
            $stmt->execute();
            $lastID = $db->lastInsertId();
            //$data['last_id'] = $lastID;
            $data['Ack'] = '1';

            $sql = "SELECT * FROM users WHERE id=:id ";
            //$db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $lastID);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();


			$data['UserDetails'] = array(
			"first_name" => stripslashes($getUserdetails->first_name),
			"last_name" => stripslashes($getUserdetails->last_name),
			"company_name" => stripslashes($getUserdetails->company_name),
			"email" => stripslashes($getUserdetails->email),
			"type" => stripslashes($getUserdetails->type),
			"profile_image" => stripslashes($getUserdetails->profile_image),
			"mobile_number" => stripslashes($getUserdetails->mobile_number),
			"is_active" => stripslashes($getUserdetails->is_active),
			"address" => stripslashes($getUserdetails->address),
			"gender" => stripslashes($getUserdetails->gender),
			"zip_code" => stripslashes($getUserdetails->zip_code),
			"city" => stripslashes($getUserdetails->city),
			"state" => stripslashes($getUserdetails->state),
			"country" => stripslashes($getUserdetails->country));
            /*            } else {
              $data['Ack'] = '0';
              $data['message'] = 'email already exists.';
              } */
        }







        /*        $subject = "freshqatar.com- Thank you for registering";

          $TemplateMessage = "Wellcome and thank you for registering at freshqatar.com!<br />";
          $TemplateMessage .= "Your account has now been created and you can login using your email address and password by visiting our App<br />";
          $TemplateMessage .= "Thanks,<br />";
          $TemplateMessage .= "freshqatar.com<br />";

          $mail1 = new PHPMailer;
          $mail1->FromName = 'freshqatar.com';
          $mail1->From = 'info@freshqatar.com';
          $mail1->Subject = $subject;
          $mail1->Body = stripslashes($TemplateMessage);
          $mail1->AltBody = stripslashes($TemplateMessage);
          $mail1->IsHTML(true);
          $mail1->AddAddress($email, "freshqatar.com"); //info@salaryleak.com
          $mail1->Send();
         */
        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['last_id'] = '';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}

function login() {

	$data = array();
	$allshops = array();
	$allCategories=array();
	$allSubCategories=array();
    $app = new Slim();
//    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());
    //echo 'Hi';
    //var_dump($body);
	
    $email = $body['email'];
    $password = $body['password'];



   $sql = "SELECT * FROM users WHERE email=:email AND pass_app=:pass_app";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->bindParam("pass_app", md5($password));
        $stmt->execute();
        $stmt->queryString;
       //  print_r(DB::getQueryLog());
        $user = $stmt->fetchObject();
        $userCount = $stmt->rowCount();
        if ($userCount == 0) {
            $data['user_id'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'Login Error';
        } else {
            $data['user_id'] = $user->id;
            $data['Ack'] = 1;
            $data['msg'] = 'Loggedin Successfully';


            $sql = "SELECT * FROM users WHERE id=:id ";
            //$db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $user->id);
            $stmt->execute();
            $getUserdetails = $stmt->fetchObject();

          if($getUserdetails->profile_image!=''){
$profile_image=SITE_URL.'app/webroot/user_images/'.$getUserdetails->profile_image;
}
else{
$profile_image='';
}

             $data['UserDetails'] = array(
			    "user_id" => stripslashes($getUserdetails->id),
                "first_name" => stripslashes($getUserdetails->first_name),
                "last_name" => stripslashes($getUserdetails->last_name),
                "company_name" => stripslashes($getUserdetails->company_name),
                "email" => stripslashes($getUserdetails->email),
                "type" => stripslashes($getUserdetails->type),
                "profile_image" => stripslashes($profile_image),
                "mobile_number" => stripslashes($getUserdetails->mobile_number),
                "is_active" => stripslashes($getUserdetails->is_active),
				"registration_date" => stripslashes($getUserdetails->registration_date),
				"paypal_business_email" => stripslashes($getUserdetails->paypal_business_email),
				"bio" => stripslashes($getUserdetails->bio),
                "address" => stripslashes($getUserdetails->address),
                "gender" => stripslashes($getUserdetails->gender),
                "zip_code" => stripslashes($getUserdetails->zip_code),
				"twitter_url" => stripslashes($getUserdetails->twitter_url),
				"linkdin_url" => stripslashes($getUserdetails->linkdin_url),
				"youtube_url" => stripslashes($getUserdetails->youtube_url),
                "facebook_url" => stripslashes($getUserdetails->facebook_url),
                "nick_name" => stripslashes($getUserdetails->nick_name),
				"alternate_email" => stripslashes($getUserdetails->alternate_email),
				"city" => stripslashes($getUserdetails->city),
				"state" => stripslashes($getUserdetails->state),
				"country" => stripslashes($getUserdetails->country),
				"telephone_country_code" => stripslashes($getUserdetails->telephone_country_code),
				"telephone_area_code" => stripslashes($getUserdetails->telephone_area_code),
				"telephone_number" => stripslashes($getUserdetails->telephone_number),
				"fax_country_code" => stripslashes($getUserdetails->fax_country_code),
				"fax_area_code" => stripslashes($getUserdetails->fax_area_code),
				"fax_number" => stripslashes($getUserdetails->fax_number),
				"job_title" => stripslashes($getUserdetails->job_title),
				"shop_address" => stripslashes($getUserdetails->shop_address),
				"shop_vat" => stripslashes($getUserdetails->shop_vat),
				"shop_city" => stripslashes($getUserdetails->shop_city),
				"shop_company_reg_no" => stripslashes($getUserdetails->shop_company_reg_no),
				"shop_country" => stripslashes($getUserdetails->shop_country),
				"shop_zip_code" => stripslashes($getUserdetails->shop_zip_code),
				"balance" => stripslashes($getUserdetails->balance),
				"shipping_full_name" => stripslashes($getUserdetails->shipping_full_name),
				"shipping_address" => stripslashes($getUserdetails->shipping_address),
				"shipping_city" => stripslashes($getUserdetails->shipping_city),
				"shipping_state" => stripslashes($getUserdetails->shipping_state),
				"shipping_country" => stripslashes($getUserdetails->shipping_country),
				"shipping_zip_code" => stripslashes($getUserdetails->shipping_zip_code),
				"my_latitude" => stripslashes($getUserdetails->my_latitude),
                "my_longitude" => stripslashes($getUserdetails->my_longitude));

// GET MY SHOP DETAILS

    $user_id=$user->id;
	$sql = "SELECT * FROM shops WHERE user_id=:user_id";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user->id);
	$stmt->execute();
	$getshops = $stmt->fetchAll(PDO::FETCH_OBJ);
	$count = $stmt->rowCount();
	if ($count > 0) {
	foreach ($getshops as $shops) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	if($shops->logo!=''){
	$logo=SITE_URL . 'app/webroot/shop_images/' . $shops->logo;
	}
	else{
	$logo='';
	}
	if($shops->cover_photo!=''){
	$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $shops->cover_photo;
	}
	else{
	$cover_photo='';
	}
	
	
	// GET CATEGORIES  ======================================================
	
	
	$sqlStoreCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->categories .")";
	$stmtStoreCategoryDetails = $db->prepare($sqlStoreCategoryDetails);
	$stmtStoreCategoryDetails->execute();
	$getStoreCategoryDetails = $stmtStoreCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allCategories);
	$allCategories=array();
	foreach ($getStoreCategoryDetails as $shops_categories) {
    $allCategories[]=array('ID' => $shops_categories->id,
	                       'NAME' => $shops_categories->name);
	}
	// ======================================================================
	
	// GET SUBCATEGORIES  ======================================================
	
	
	$sqlStoreSubCategoryDetails = "SELECT  * FROM categories WHERE `id` IN(". $shops->sub_categories .")";
	$stmtStoreSubCategoryDetails = $db->prepare($sqlStoreSubCategoryDetails);
	$stmtStoreSubCategoryDetails->execute();
	$getStoreSubCategoryDetails = $stmtStoreSubCategoryDetails->fetchAll(PDO::FETCH_OBJ);
	
	unset($allSubCategories);
	$allSubCategories=array();
	foreach ($getStoreSubCategoryDetails as $shops_sub_categories) {
    $allSubCategories[]=array('ID' => $shops_sub_categories->id,
	                       'NAME' => $shops_sub_categories->name);
	}
	// ======================================================================	
	
	
	$sqlStoreOwnerDetails = "SELECT  * FROM users WHERE `id`='" . $shops->user_id . "'";
	$stmtStoreOwnerDetails = $db->prepare($sqlStoreOwnerDetails);
	$stmtStoreOwnerDetails->execute();
	$getStoreOwnerDetails = $stmtStoreOwnerDetails->fetchObject();	
	$paypal_business_email =$getStoreOwnerDetails->paypal_business_email;	
	
	
	
	$allshops[] = array(
	"id" => stripslashes($shops->id),
	"user_id" => stripslashes($shops->user_id),
	"name" => stripslashes(strip_tags($shops->name)),
	"description" => stripslashes($shops->description),
	"categories" => $allCategories,
	"sub_categories" => $allSubCategories,
	"facebook" => stripslashes($shops->facebook),
	"twitter" => stripslashes($shops->twitter),
	"linkedin" => stripslashes($shops->linkedin),
	"pinterest" => stripslashes($shops->pinterest),
	"youtube" => stripslashes($shops->youtube),
	"is_active" => stripslashes($shops->is_active),
	"created_at" => stripslashes($shops->created_at),
	"paid_on" => stripslashes($shops->paid_on),
	"last_date" => stripslashes($shops->last_date),
	"paypal_business_email" => stripslashes($paypal_business_email),
	"logo" => stripslashes($logo),
	"cover_photo" => stripslashes($cover_photo));
	
	
	
	}
	$data['allshops'] = $allshops;

	} else {
	$data['allshops'] = '';

	}
	
	
	
	
	


        }
        //$user->Ack = '1';
        $db = null;
        //    print_r($user);
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Login Error!!!';
    }

    echo json_encode($data);
	exit;
}



function emptyCart($userid) {
    $data = array();
    $sql = "DELETE FROM freshquater_cart WHERE userid=:userid";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userid", $userid);
        $stmt->execute();
        $db = null;
        $data['Ack'] = '1';
        $data['msg'] = 'Cart Is Empty Now';
    } catch (PDOException $e) {
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error!!!';
    }

    echo json_encode($data);
    exit;
}

function removeProductFromCart() {
    $data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$prd_id = $body['prd_id'];
	
	
   $sql = "DELETE FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("prd_id", $prd_id);
        $stmt->execute();
        $db = null;
        $data['Ack'] = '1';
        $data['msg'] = 'Item Removed Successfully';
    } catch (PDOException $e) {
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error!!!';
    }

    echo json_encode($data);
    exit;
}

function addToCart() {

    $data = array();
	$productImagesData = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$prd_id = $body['prd_id'];
	$quantity = $body['quantity'];
	$soldprice_buy = $body['soldprice_buy'];
	

    try {

        $sql = "SELECT * FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("prd_id", $prd_id);
        $stmt->execute();
        $product = $stmt->fetchObject();

        $count = $stmt->rowCount();
        if ($count == 0) {
		

		$sqlProductDetails = "SELECT * FROM products WHERE id=:id ";
		//$db = getConnection();
		$stmtProduct = $db->prepare($sqlProductDetails);
		$stmtProduct->bindParam("id", $prd_id);
		$stmtProduct->execute();
		$getProductdetails = $stmtProduct->fetchObject();
			

    
		$productImage = "select * FROM product_images WHERE `product_id`='" . $prd_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		$productImages='';
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as  $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		//if($key==0){
		$productImages=$img_products->name;
		//}
		break;
		}
		}


			

            $sql = "INSERT INTO temp_carts (user_id, shop_id, prd_id, name, image, price, quantity, shipping_address, shipping_time, processing_time, product_woner_id, pay_amt, cdate) VALUES (:user_id, :shop_id, :prd_id, :name, :image, :price, :quantity, :shipping_address, :shipping_time, :processing_time, :product_woner_id, :pay_amt, :cdate)";
          //  $db = getConnection();
            $stmtCartInsert = $db->prepare($sql);
            $stmtCartInsert->bindParam("user_id", $user_id);
            $stmtCartInsert->bindParam("shop_id", $getProductdetails->shop_id);
			$stmtCartInsert->bindParam("prd_id", $prd_id);
			$stmtCartInsert->bindParam("name", $getProductdetails->name);
			$stmtCartInsert->bindParam("image", $productImages);
			$stmtCartInsert->bindParam("price", $soldprice_buy);
			$stmtCartInsert->bindParam("quantity", $quantity);
			$stmtCartInsert->bindParam("shipping_address", $getProductdetails->shipping_time);
			$stmtCartInsert->bindParam("shipping_time", $getProductdetails->shipping_time);
			$stmtCartInsert->bindParam("processing_time", $getProductdetails->processing_time);
			$stmtCartInsert->bindParam("product_woner_id", $getProductdetails->user_id);
			$stmtCartInsert->bindParam("pay_amt", $soldprice_buy);
			$stmtCartInsert->bindParam("cdate", date('Y-m-d H:i:s'));
            $stmtCartInsert->execute();
			$sql1 = "DELETE FROM wishlists WHERE user_id=:user_id AND product_id=:prd_id ";
                //$db = getConnection();
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("user_id", $user_id);
                $stmt1->bindParam("prd_id", $prd_id);
                $stmt1->execute();
            $data['last_id'] = $db->lastInsertId();
            $data['Ack'] = '1';
            $data['msg'] = 'Product Added To Cart';

        } else {

            if ($quantity == 0) {
                $sql = "DELETE FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id ";
                //$db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("prd_id", $prd_id);
                $stmt->execute();
                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Cart Updated';
            } else {
                $status = 0;
                $sql = "UPDATE temp_carts SET quantity=:quantity WHERE user_id=:user_id AND prd_id=:prd_id";
                $db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("prd_id", $prd_id);
                $stmt->bindParam("quantity", $quantity);
                $stmt->execute();

                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Product Updated Successfully';
            }
        }
		
		
		 $data['user_id'] = $user_id;

			// GET CART DETAILS 
			// ============================================================================
			$sqlcart = "SELECT * FROM temp_carts WHERE user_id=:user_id";
			//  $db = getConnection();
			$stmtcart = $db->prepare($sqlcart);
			$stmtcart->bindParam("user_id", $user_id);
			$stmtcart->execute();
			$getCartProducts = $stmtcart->fetchAll(PDO::FETCH_OBJ);
			
			$count = $stmtcart->rowCount();
			if ($count > 0) {
			$totalCartAmount=0;
			foreach ($getCartProducts as $cartProducts) {
			
			
			$totalCartAmount=$totalCartAmount+($cartProducts->pay_amt*$cartProducts->quantity);	
			
			
			$allproducts[] = array(
			"user_id" => stripslashes($cartProducts->user_id),
			"shop_id" => stripslashes($cartProducts->shop_id),
			"prd_id" => stripslashes($cartProducts->prd_id),
			"name" => stripslashes($cartProducts->name),
			"price" => stripslashes($cartProducts->price),
			"quantity" => stripslashes($cartProducts->quantity),
			"shipping_address" => stripslashes($cartProducts->shipping_address),
			"shipping_time" => stripslashes($cartProducts->shipping_time),
			"processing_time" => stripslashes($cartProducts->processing_time),
			"product_woner_id" => stripslashes($cartProducts->product_woner_id),
			"pay_amt" => stripslashes($cartProducts->pay_amt),
			"image" => SITE_URL . $cartProducts->image,
			"cdate" => stripslashes($cartProducts->cdate));
			
			}
			
			
			// GET CART TOTAL AMOUNT
			
/*			$sqlCartTotal = "SELECT CAST(SUM(pay_amt) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
			$stmtCartTotal = $db->prepare($sqlCartTotal);
			$stmtCartTotal->execute();
			$getCartTotal = $stmtCartTotal->fetchObject();	
			$cartElementCount = $stmtCartTotal->rowCount();
			if($cartElementCount>0){
			$data['all_amount'] = $getCartTotal->total;	
			}
			else{
			$data['all_amount'] = 0;	
			}*/
			
			$data['all_amount'] = $totalCartAmount;
			// GET CART TOTAL NUMBER
			
			$sqlCartTotalQuantity = "SELECT CAST(SUM(quantity) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
			$stmtCartTotalQuantity = $db->prepare($sqlCartTotalQuantity);
			$stmtCartTotalQuantity->execute();
			$getCartTotalQuantity = $stmtCartTotalQuantity->fetchObject();	
			$cartElementCountQuantity = $stmtCartTotalQuantity->rowCount();
			if($cartElementCountQuantity>0){
			$data['cart_quantity'] = $getCartTotalQuantity->total;	
			}
			else{
			$data['cart_quantity'] = 0;	
			}				
			
			
			$data['all_cart_items'] = $allproducts;
			
			$sqlAdminPercentage = "SELECT * FROM site_settings WHERE id='1'";
	$stmtAdminPercentage = $db->prepare($sqlAdminPercentage);
	$stmtAdminPercentage->execute();
	$getAdminPercentage = $stmtAdminPercentage->fetchObject();

	$data['admin_percentage'] = $getAdminPercentage->admin_percentage;
	$data['admin_paypal_email'] = $getAdminPercentage->paypal_email;
	$data['admin_paypal_app_id'] = $getAdminPercentage->paypal_app_id;
	$data['admin_paypal_api_username'] = $getAdminPercentage->paypal_api_username;
	$data['admin_paypal_api_password'] = $getAdminPercentage->paypal_api_password;
	$data['admin_paypal_api_signature'] = $getAdminPercentage->paypal_api_signature;
	
	
	$sqlStoreOwnerDetails = "SELECT  * FROM users WHERE `id`='" . $store_owner . "'";
	$stmtStoreOwnerDetails = $db->prepare($sqlStoreOwnerDetails);
	$stmtStoreOwnerDetails->execute();
	$getStoreOwnerDetails = $stmtStoreOwnerDetails->fetchObject();	
	$paypal_business_email =$getStoreOwnerDetails->paypal_business_email;	
	
	$data['shop_paypal_email'] = $paypal_business_email;
	
	$data['Ack'] = 1;
			
			
			
			

        } else {

            $data['all_cart_items'] = '';
			$data['all_amount'] = 0;	
			$data['cart_quantity'] = 0;	
            $data['Ack'] = 0;
        }
		
		



        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
	
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error';
    }
    echo json_encode($data);
	exit;
}


function editCart() {

    $data = array();
	$productImagesData = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$prd_id = $body['prd_id'];
	$quantity = $body['quantity'];
	

    try {

       $sql = "SELECT * FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("prd_id", $prd_id);
        $stmt->execute();
        $product = $stmt->fetchObject();
        $count = $stmt->rowCount();
    
	

            if ($quantity == 0) {
                $sql = "DELETE FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id ";
                //$db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("prd_id", $prd_id);
                $stmt->execute();
                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Cart Updated Successfully';
            } else {
                $status = 0;
                $sql = "UPDATE temp_carts SET quantity=:quantity WHERE user_id=:user_id AND prd_id=:prd_id";
                $db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("prd_id", $prd_id);
                $stmt->bindParam("quantity", $quantity);
                $stmt->execute();

                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Cart Updated Successfully';
            }
        
	
	
	
		
		
		 $data['user_id'] = $user_id;

			// GET CART DETAILS 
			// ============================================================================
			$sqlcart = "SELECT * FROM temp_carts WHERE user_id=:user_id";
			//  $db = getConnection();
			$stmtcart = $db->prepare($sqlcart);
			$stmtcart->bindParam("user_id", $user_id);
			$stmtcart->execute();
			$getCartProducts = $stmtcart->fetchAll(PDO::FETCH_OBJ);
			
			$count = $stmtcart->rowCount();
			$totalCartAmount=0;
			if ($count > 0) {
			foreach ($getCartProducts as $cartProducts) {
			
		$totalCartAmount=$totalCartAmount+($cartProducts->pay_amt*$cartProducts->quantity);		
			
			$allproducts[] = array(
			"user_id" => stripslashes($cartProducts->user_id),
			"shop_id" => stripslashes($cartProducts->shop_id),
			"prd_id" => stripslashes($cartProducts->prd_id),
			"name" => stripslashes($cartProducts->name),
			"price" => stripslashes($cartProducts->price),
			"quantity" => stripslashes($cartProducts->quantity),
			"shipping_address" => stripslashes($cartProducts->shipping_address),
			"shipping_time" => stripslashes($cartProducts->shipping_time),
			"processing_time" => stripslashes($cartProducts->processing_time),
			"product_woner_id" => stripslashes($cartProducts->product_woner_id),
			"pay_amt" => stripslashes($cartProducts->pay_amt),
			"image" => SITE_URL . $cartProducts->image,
			"cdate" => stripslashes($cartProducts->cdate));
			
			}
			
			
			// GET CART TOTAL AMOUNT
			
			$sqlCartTotal = "SELECT CAST(SUM(pay_amt) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
			$stmtCartTotal = $db->prepare($sqlCartTotal);
			$stmtCartTotal->execute();
			$getCartTotal = $stmtCartTotal->fetchObject();	
			$cartElementCount = $stmtCartTotal->rowCount();
			if($cartElementCount>0){
			$data['all_amount'] = $getCartTotal->total;	
			}
			else{
			$data['all_amount'] = 0;	
			}
			$data['all_amount']=$totalCartAmount;
			
			// GET CART TOTAL NUMBER
			
			$sqlCartTotalQuantity = "SELECT CAST(SUM(quantity) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
			$stmtCartTotalQuantity = $db->prepare($sqlCartTotalQuantity);
			$stmtCartTotalQuantity->execute();
			$getCartTotalQuantity = $stmtCartTotalQuantity->fetchObject();	
			$cartElementCountQuantity = $stmtCartTotalQuantity->rowCount();
			if($cartElementCountQuantity>0){
			$data['cart_quantity'] = $getCartTotalQuantity->total;	
			}
			else{
			$data['cart_quantity'] = 0;	
			}				
			
			
			$data['all_cart_items'] = $allproducts;
			
			
			
			

        } else {

            $data['all_cart_items'] = '';
			$data['all_amount'] = 0;	
			$data['cart_quantity'] = 0;	
            $data['Ack'] = 0;
        }
		
		



        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error';
    }
    echo json_encode($data);
	exit;
}



	function getCart() {
	$data = array();
	$allproducts = array();
	$productImagesData = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	
	
	
	try {
	
	$sql = "SELECT * FROM temp_carts WHERE user_id=:user_id ORDER BY id DESC";
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->execute();
	$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
	
	$count = $stmt->rowCount();
	if ($count > 0) {
	$totalCartAmount=0;
	foreach ($getproducts as $products) {
	
	$store_owner=$products->product_woner_id;
	
	$productDetails = "select * FROM products WHERE `id`='" . $products->prd_id . "'";
	//echo '<br>';
	$stmtProductDetails = $db->query($productDetails);
	$productData = $stmtProductDetails->fetchObject();
	
	
	unset($productImagesData);
	$productImagesData = array();
	$productImage = "select * FROM product_images WHERE `product_id`='" . $products->prd_id . "'";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
	
	$totalCartAmount=$totalCartAmount+($products->pay_amt*$products->quantity);
	
	
	$allproducts[] = array(
	"user_id" => stripslashes($products->user_id),
	"shop_id" => stripslashes($products->shop_id),
	"prd_id" => stripslashes(strip_tags($products->prd_id)),
	"name" => stripslashes(strip_tags($products->name)),
	"price" => stripslashes($products->price),
	"unit_type" => stripslashes($productData->unit_type),
	"is_featured" => stripslashes($productData->is_featured),
	"quantity" => stripslashes($products->quantity),
	"shipping_address" => stripslashes($products->shipping_address),
	"shipping_time" => stripslashes($products->shipping_time),
	"processing_time" => stripslashes($products->processing_time),
	"product_woner_id" => stripslashes($products->product_woner_id),
	"pay_amt" => stripslashes($products->pay_amt),
	"image" => $productImagesData,
	"cdate" => stripslashes($cdate));
	}
	
	$data['all_cart_items'] = $allproducts;
	
	// GET CART TOTAL AMOUNT
	
	/*	$sqlCartTotal = "SELECT CAST(SUM(pay_amt) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
	$stmtCartTotal = $db->prepare($sqlCartTotal);
	$stmtCartTotal->execute();
	$getCartTotal = $stmtCartTotal->fetchObject();	
	$cartElementCount = $stmtCartTotal->rowCount();
	if($cartElementCount>0){
	$data['all_amount'] = $getCartTotal->total;	
	}
	else{
	$data['all_amount'] = 0;	
	}*/
	$data['all_amount'] = $totalCartAmount;
	
	// GET CART TOTAL NUMBER
	
	$sqlCartTotalQuantity = "SELECT CAST(SUM(quantity) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
	$stmtCartTotalQuantity = $db->prepare($sqlCartTotalQuantity);
	$stmtCartTotalQuantity->execute();
	$getCartTotalQuantity = $stmtCartTotalQuantity->fetchObject();	
	$cartElementCountQuantity = $stmtCartTotalQuantity->rowCount();
	if($cartElementCountQuantity>0){
	$data['cart_quantity'] = $getCartTotalQuantity->total;	
	}
	else{
	$data['cart_quantity'] = 0;	
	}		

	$sqlAdminPercentage = "SELECT * FROM site_settings WHERE id='1'";
	$stmtAdminPercentage = $db->prepare($sqlAdminPercentage);
	$stmtAdminPercentage->execute();
	$getAdminPercentage = $stmtAdminPercentage->fetchObject();

	$data['admin_percentage'] = $getAdminPercentage->admin_percentage;
	$data['admin_paypal_email'] = $getAdminPercentage->paypal_email;
	$data['admin_paypal_app_id'] = $getAdminPercentage->paypal_app_id;
	$data['admin_paypal_api_username'] = $getAdminPercentage->paypal_api_username;
	$data['admin_paypal_api_password'] = $getAdminPercentage->paypal_api_password;
	$data['admin_paypal_api_signature'] = $getAdminPercentage->paypal_api_signature;
	
	
	$sqlStoreOwnerDetails = "SELECT  * FROM users WHERE `id`='" . $store_owner . "'";
	$stmtStoreOwnerDetails = $db->prepare($sqlStoreOwnerDetails);
	$stmtStoreOwnerDetails->execute();
	$getStoreOwnerDetails = $stmtStoreOwnerDetails->fetchObject();	
	$paypal_business_email =$getStoreOwnerDetails->paypal_business_email;	
	
	$data['shop_paypal_email'] = $paypal_business_email;
	
	$data['Ack'] = 1;
	} else {
	
	$data['all_cart_items'] = $allproducts;
	$data['all_amount'] = 0;	
	$data['cart_quantity'] = 0;	
	$data['Ack'] = 0;
	}
	} catch (PDOException $e) {
	$data['all_cart_items'] = $allproducts;
	$data['all_amount'] = 0;	
	$data['cart_quantity'] = 0;	
	$data['Ack'] = 0;
	}
	echo json_encode($data);
	exit;
}

function userDetails() {             

    $data = array();
    $app = new Slim();
    //    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());

    $id = $body['user_id'];

    try {

        $sql = "SELECT * FROM users WHERE id=:id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("id", $id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();
        $userCount = $stmt->rowCount();
        if ($userCount == 0) {
            $data['user_id'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No such User';
        } else {
            $data['user_id'] = $user->id;
            $data['Ack'] = 1;
            $data['msg'] = '';


if($getUserdetails->profile_image!=''){
$profile_image=SITE_URL.'app/webroot/user_images/'.$getUserdetails->profile_image;
}
else{
$profile_image='';
}

             $data['UserDetails'] = array(
			    "user_id" => stripslashes($getUserdetails->id),
                "first_name" => stripslashes($getUserdetails->first_name),
                "last_name" => stripslashes($getUserdetails->last_name),
                "company_name" => stripslashes($getUserdetails->company_name),
                "email" => stripslashes($getUserdetails->email),
                "type" => stripslashes($getUserdetails->type),
                "profile_image" => stripslashes($profile_image),
                "mobile_number" => stripslashes($getUserdetails->mobile_number),
                "is_active" => stripslashes($getUserdetails->is_active),
				"registration_date" => stripslashes($getUserdetails->registration_date),
				"paypal_business_email" => stripslashes($getUserdetails->paypal_business_email),
				"bio" => stripslashes($getUserdetails->bio),
                "address" => stripslashes($getUserdetails->address),
                "gender" => stripslashes($getUserdetails->gender),
                "zip_code" => stripslashes($getUserdetails->zip_code),
				"twitter_url" => stripslashes($getUserdetails->twitter_url),
				"linkdin_url" => stripslashes($getUserdetails->linkdin_url),
				"youtube_url" => stripslashes($getUserdetails->youtube_url),
                "facebook_url" => stripslashes($getUserdetails->facebook_url),
                "nick_name" => stripslashes($getUserdetails->nick_name),
				"alternate_email" => stripslashes($getUserdetails->alternate_email),
				"city" => stripslashes($getUserdetails->city),
				"state" => stripslashes($getUserdetails->state),
				"country" => stripslashes($getUserdetails->country),
				"telephone_country_code" => stripslashes($getUserdetails->telephone_country_code),
				"telephone_area_code" => stripslashes($getUserdetails->telephone_area_code),
				"telephone_number" => stripslashes($getUserdetails->telephone_number),
				"fax_country_code" => stripslashes($getUserdetails->fax_country_code),
				"fax_area_code" => stripslashes($getUserdetails->fax_area_code),
				"fax_number" => stripslashes($getUserdetails->fax_number),
				"job_title" => stripslashes($getUserdetails->job_title),
				"shop_address" => stripslashes($getUserdetails->shop_address),
				"shop_vat" => stripslashes($getUserdetails->shop_vat),
				"shop_city" => stripslashes($getUserdetails->shop_city),
				"shop_company_reg_no" => stripslashes($getUserdetails->shop_company_reg_no),
				"shop_country" => stripslashes($getUserdetails->shop_country),
				"shop_zip_code" => stripslashes($getUserdetails->shop_zip_code),
				"balance" => stripslashes($getUserdetails->balance),
				"shipping_full_name" => stripslashes($getUserdetails->shipping_full_name),
				"shipping_address" => stripslashes($getUserdetails->shipping_address),
				"shipping_city" => stripslashes($getUserdetails->shipping_city),
				"shipping_state" => stripslashes($getUserdetails->shipping_state),
				"shipping_country" => stripslashes($getUserdetails->shipping_country),
				"shipping_zip_code" => stripslashes($getUserdetails->shipping_zip_code),
				"my_latitude" => stripslashes($getUserdetails->my_latitude),
                "my_longitude" => stripslashes($getUserdetails->my_longitude));

        }
        //$user->Ack = '1';
        $db = null;
        //    print_r($user);
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'No such User';
    }

    echo json_encode($data);
	exit;
}



		function dashboard() {
		$data = array();
		$allorders = array();
		$allproducts = array();
		
		$app = new Slim();
		//    echo $paramValue = $app->request->get('fname');
		$request = Slim::getInstance()->request();
		//$user = json_decode($request->getBody());
		$body = ($request->post());
		
		$user_id = $body['user_id'];
		
		try {
		
// DATA FOR BUYER ==================================================================================		
		
		$sql = "SELECT * FROM order_details WHERE user_id=:user_id and (order_status='U' or order_status='C') order by `id` DESC";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getorders = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$awaiting_shipment = $count;
		
		} else {
		$awaiting_shipment = 0;
		
		}
		
		
		// GET Awaiting Payments =======================================================
		
		
		$sql = "SELECT * FROM temp_carts WHERE user_id=:user_id";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$awaiting_payment = $count;
		} else {
		$awaiting_payment = 0;
		}	
		
		// GET Awaiting Delivery =======================================================
		
		
		$sql = "SELECT * FROM order_details WHERE user_id=:user_id and order_status='S' order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$awaiting_delivery= $count;
		} else {
		$awaiting_delivery = 0;
		}
		
		// GET Dispute =======================================================
		
		
		$sql = "SELECT * FROM order_details WHERE user_id=:user_id and order_status='DP' order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$dispute= $count;
		} else {
		$dispute = 0;
		}	
		
		// GET Dispute =======================================================
		
		
		$sql = "SELECT * FROM order_details WHERE user_id=:user_id and order_status='F' order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$finish= $count;
		} else {
		$finish = 0;
		}
		
		$sql = "SELECT * FROM comments WHERE to_user_id=:user_id and buyer_is_delete=0 and is_read=0 group by thread_id order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$message= $count;
		} else {
		$message = 0;
		}						
		
		
		$data['buyer']=array(
		                        'messages' => $message,
		                      'awaiting_payment' => $awaiting_payment,
		                      'awaiting_shipment' => $awaiting_shipment,
		                     
							  'awaiting_delivery'=> $awaiting_delivery,
							
							  'dispute' =>$dispute,
							  'complete' => $finish);
							  
							  
							  
	// END OF BUYER DATA =======================================================
	
	// DATA FOR SELLER =========================================================
	
	
 $sql = "SELECT * FROM order_details WHERE owner_id=:owner_id order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("owner_id", $user_id);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
		
		$sql = "SELECT * FROM order_details WHERE owner_id=:user_id and order_status='U' order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$seller_awaiting_processing= $count;
		} else {
		$seller_awaiting_processing = 0;
		}
		
		$sql = "SELECT * FROM order_details WHERE owner_id=:user_id and order_status='DP' order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$seller_dispute= $count;
		} else {
		$seller_dispute = 0;
		}
		
		$sql = "SELECT * FROM order_details WHERE owner_id=:user_id and order_status='F' order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$seller_complete= $count;
		} else {
		$seller_complete = 0;
		}
		
		
		$sql = "SELECT * FROM order_details WHERE  owner_id=:user_id and (order_status='U' or order_status='C' or order_status='S') and seller_is_view=0 order by `id` DESC";
		//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		$seller_awaiting_shipment= $count;
		} else {
		$seller_awaiting_shipment = 0;
		}
		
		
		
		
				
		
		
		
	
		$data['seller']=array(
		
		                      'messages' => $message,
							  'awaiting_processing' => $seller_awaiting_processing,
		                      'awaiting_shipment' => $seller_awaiting_shipment,
							  'dispute' => $seller_dispute,
							   'complete' =>$seller_complete
						
							  );							  
							  
							  
		$data['Ack'] = 1;	
		
		
		} catch (PDOException $e) {
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		$data['Ack'] = 0;
		$data['msg'] = 'Data Error';
		}
		echo json_encode($data);
		exit;
}






function settings() {             

    $data = array();
    try {

        $sql = "SELECT * FROM site_settings WHERE id='1'";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $getDetails = $stmt->fetchObject();

            $data['Ack'] = 1;
            $data['msg'] = '';

             $data['site_settings'] = array(
			    "admin_email" => stripslashes($getDetails->admin_email),
                "paypal_email" => stripslashes($getDetails->paypal_email),
                "paypal_developer_email" => stripslashes($getDetails->paypal_developer_email),
                "paypal_app_id" => stripslashes($getDetails->paypal_app_id),
                "paypal_api_username" => stripslashes($getDetails->paypal_api_username),
                "paypal_api_password" => stripslashes($getDetails->paypal_api_password),
                "paypal_api_signature" => stripslashes($getDetails->paypal_api_signature),
				"admin_percentage" => stripslashes($getDetails->admin_percentage),
                "phone" => stripslashes($getDetails->phone),
				"mobile" => stripslashes($getDetails->mobile),
				"address" => stripslashes($getDetails->address),
				"website" => stripslashes($getDetails->website),
                "facebook_url" => stripslashes($getDetails->facebook_url),
                "twitter_url" => stripslashes($getDetails->twitter_url),
                "linkdin_url" => stripslashes($getDetails->linkdin_url),
				"youtube_url" => stripslashes($getDetails->youtube_url),
				"free_listings" => stripslashes($getDetails->free_listings),
				"shop_price_per_month" => stripslashes($getDetails->shop_price_per_month),
				"can_post_number_of_listing" => stripslashes($getDetails->can_post_number_of_listing),
				"price_per_listing" => stripslashes($getDetails->price_per_listing),
				"contact_email" => stripslashes($getDetails->contact_email));

        
		
		
        $db = null;
        //    print_r($user);
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'No such User';
    }

    echo json_encode($data);
	exit;
}


function saveShippingAddress() {
    //error_log('addWine\n', 3, '/var/tmp/php.log');
    $data = array();
    $app = new Slim();
//    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());
    //echo 'Hi';
    //var_dump($body);
	$full_name = $body['full_name'];
	$street = $body['street'];
	$apartment = $body['apartment'];
	$city = $body['city'];
	$state = $body['state'];
	$zip_code = $body['zip_code'];
	$phn_no = $body['phn_no'];
	$country = $body['country'];
	$is_primary = 1;
	$user_id = $body['user_id'];
    //$password = md5($body['password']);
//    $my_latitude = $body['my_latitude'];
//    $my_longitude = $body['my_longitude'];
//    echo $paramValue = $app->request->post('fname');
//exit;

		 $db = getConnection();
	    $user_query = "select * FROM shipping_addresses WHERE `user_id`='" . $user_id . "'";
		$stmtUserQuery = $db->query($user_query);
		$getUser = $stmtUserQuery->fetchAll(PDO::FETCH_OBJ);
		
		 $isUserExists = $stmtUserQuery->rowCount();	
		 
		 if($isUserExists==0){		 

        $sql = "INSERT INTO shipping_addresses (full_name, street, apartment, city, state, zip_code, phn_no, country, user_id, is_primary) VALUES (:full_name, :street, :apartment, :city, :state, :zip_code, :phn_no, :country, :user_id, :is_primary)";
	
	}
	else{
	
    $sql = "UPDATE shipping_addresses SET full_name=:full_name, street=:street, apartment=:apartment, city=:city, state=:state, zip_code=:zip_code, phn_no=:phn_no, country=:country, is_primary=:is_primary WHERE user_id=:user_id";
	
	}
	
//	echo  $sql;
	
    try {
     //   $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("full_name", $full_name);
        $stmt->bindParam("street", $street);
        $stmt->bindParam("apartment", $apartment);
        $stmt->bindParam("city", $city);
        $stmt->bindParam("state", $state);
        $stmt->bindParam("zip_code", $zip_code);
        $stmt->bindParam("phn_no", $phn_no);
		$stmt->bindParam("country", $country);
		$stmt->bindParam("is_primary", $is_primary);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
		
        $data['last_id'] = $user_id;
        $data['Ack'] = '1';
        $data['msg'] = 'Shipping Address Saved Successfully';

        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['last_id'] = '';
        $data['msg'] = 'Error!!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}


function getShippingAddress() {             

    $data = array();
    $app = new Slim();
    //    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());

    $user_id = $body['user_id'];

    try {

        $sql = "SELECT * FROM shipping_addresses WHERE user_id=:user_id AND `is_primary`='1'";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getUserdetails = $stmt->fetchObject();
        $userCount = $stmt->rowCount();
        if ($userCount == 0) {
		     $data['ShippingDetails'] = '';
            $data['user_id'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No Shipping Address Found For this User';
        } else {
            $data['user_id'] = $user_id;
            $data['Ack'] = 1;
            $data['msg'] = '';

             $data['ShippingDetails'] = array(
			    "user_id" => stripslashes($getUserdetails->id),
                "full_name" => stripslashes($getUserdetails->full_name),
                "street" => stripslashes($getUserdetails->street),
                "apartment" => stripslashes($getUserdetails->apartment),
                "city" => stripslashes($getUserdetails->city),
                "state" => stripslashes($getUserdetails->state),
                "zip_code" => stripslashes($getUserdetails->zip_code),
                "phn_no" => stripslashes($getUserdetails->phn_no),
				"country" => stripslashes($getUserdetails->country));

        }
        //$user->Ack = '1';
        $db = null;
        //    print_r($user);
    } catch (PDOException $e) {
        $data['user_id'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'No such User';
    }

    echo json_encode($data);
	exit;
}



function changePassword() {
    //error_log('addWine\n', 3, '/var/tmp/php.log');
    $data = array();
    $app = new Slim();
//    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());
    //echo 'Hi';
    //var_dump($body);
    $pass_app = $body['password'];
    $user_id = $body['user_id'];
    //$password = md5($body['password']);
    //    $my_latitude = $body['my_latitude'];
    //    $my_longitude = $body['my_longitude'];
    //    echo $paramValue = $app->request->post('fname');
    //exit;
    $sql = "UPDATE users SET pass_app=:pass_app WHERE id=:id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("pass_app", md5($pass_app));
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $data['last_id'] = $user_id;
        $data['Ack'] = '1';

        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['last_id'] = '';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}



    function changeEmail() {
    //error_log('addWine\n', 3, '/var/tmp/php.log');
    $data = array();
    $app = new Slim();
//    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());
    //echo 'Hi';
    //var_dump($body);
    $email = $body['email'];
    $user_id = $body['user_id'];
	//echo 'aaa';
		//$emailGet = $stmtEmailQuery->fetchAll(PDO::FETCH_OBJ);
		
		 $db = getConnection();
	    $email_query = "select * FROM users WHERE `email`='" . $email . "' AND `id`<>'".$user_id."'";
		$stmtEmailQuery = $db->query($email_query);
		$getEmail = $stmtEmailQuery->fetchAll(PDO::FETCH_OBJ);
		
		 $isImageExists = $stmtEmailQuery->rowCount();		
		

		
		if($isImageExists==0){

		
    $sql = "UPDATE users SET email=:email WHERE id=:id";
    try {
      //  $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("email", $email);
        $stmt->bindParam("id", $user_id);
        $stmt->execute();
        $data['last_id'] = $user_id;
        $data['Ack'] = '1';
		$data['msg'] = 'Email Updated Successfully';
		
		

        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
		$data['last_id'] = '';
		$data['Ack'] = '0';
		$data['msg'] = 'Error!!!';		
    }
	
	}
		else{
		$data['last_id'] = '';
		$data['Ack'] = '2';
		$data['msg'] = 'Email Already Exists';
		
		}
    echo json_encode($data);
    exit;
}

function addToWishlist() {
    $data = array();

	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$product_id = $body['product_id'];
	//$store_id = $body['store_id'];
	//$price = $body['price'];
	

    $sql = "SELECT * FROM wishlists WHERE user_id=:user_id AND product_id=:product_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
        $isExistsWishlist = $stmt->fetchObject();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $sql = "INSERT INTO wishlists (user_id, product_id,date) VALUES (:user_id, :product_id,:date)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("product_id", $product_id);
			$stmt->bindParam("date", date('Y-m-d'));
            $stmt->execute();
            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Added In Your Wishlist';
            $db = null;
        } else {
            $data['last_id'] = '';
            $data['Ack'] = '2';
            $data['msg'] = 'Already In Your Wishlist';
            $db = null;
        }
        //echo json_encode($user);
    } catch (PDOException $e) {
	
      // print_r($e);
       // exit();
        $data['last_id'] = '';
        $data['msg'] = 'Error!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}

function removeFromWishlist() { 
    $data = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$product_id = $body['product_id'];
	
	
    $sql = "DELETE FROM wishlists WHERE user_id=:user_id AND product_id=:product_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
        $db = null;
        $data['Ack'] = '1';
        $data['msg'] = 'Removed from your wishlist';
    } catch (PDOException $e) {
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error!!!';
    }
    echo json_encode($data);
    exit;
}





function getWishlist() { 
    $data = array();
    $allproducts = array();
	$productImagesData = array();
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	
    try {

        $sql = "SELECT * FROM wishlists WHERE user_id=:user_id ORDER BY id DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $products) {

			$productDetails = "select * FROM products WHERE `id`='" . $products->product_id . "'";
			$stmtProductDetails = $db->query($productDetails);
			$productData = $stmtProductDetails->fetchObject();
			
			$catidid=$productData->category_id;
			$catn = "select * FROM categories WHERE `id`='" . $catidid . "'";
			$stmtcatDetails = $db->query($catn);
			$catData = $stmtcatDetails->fetchObject();
			$catname=$catData->name;
				

			unset($productImagesData);
			$productImages = array();
			$productImage = "select * FROM  product_images WHERE `product_id`='" . $products->product_id . "'";
			$stmtProductImage = $db->query($productImage);
			$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
			
			$isImageExists = $stmtProductImage->rowCount();
			if ($isImageExists > 0) {
			
			//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
			foreach ($productImages as $img_products) {
			//echo '<pre>';
			//print_r($img_products);
			$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
			}
			}
			else
			{
			$productImagesData=array();
			 }


                $allproducts[] = array(
                    "id" => stripslashes($productData->id),
                    "name" => stripslashes($productData->name),
                    "sku" => stripslashes(strip_tags($productData->sku)),
					"category_id" => stripslashes($productData->category_id),
					"category_name" => stripslashes($catname),
					"sub_category_id" => stripslashes($productData->sub_category_id),
					"is_featured" => stripslashes($productData->is_featured),
					"unit_type" => stripslashes($productData->unit_type),
					"quantity_lot" => stripslashes($productData->quantity_lot),
					"price_lot" => stripslashes($productData->price_lot),
					"sale_on" => stripslashes($productData->sale_on),
					"discount" => stripslashes($productData->discount),
					"start_date" => stripslashes($productData->start_date),
					"end_date" => stripslashes($productData->end_date),
					"created_at" => stripslashes($productData->created_at),
					"return_policy" => stripslashes($productData->return_policy),
					"item_specification" => stripslashes($productData->item_specification),
					"item_description" => stripslashes($productData->item_description),
					"delivery_terms" => stripslashes($productData->delivery_terms),
                    "views" => stripslashes($productData->views),
					"last_view_date" => stripslashes($productData->last_view_date),
					"total_rate" => stripslashes($productData->total_rate),
					"rate_count" => stripslashes($productData->rate_count),
                    "image" => $productImagesData);
					
					
					
					
					
            }
            $data['all_products'] = $allproducts;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
        } else {
            $data['all_products'] = '';
            $data['Ack'] = 2;
            $data['msg'] = 'No Records Found';
        }
    } catch (PDOException $e) {
	
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}

function follow() {
    $data = array();

	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$shop_id = $body['shop_id'];
	//$store_id = $body['store_id'];
	//$price = $body['price'];
	

    $sql = "SELECT * FROM  follows WHERE user_id=:user_id AND shop_id=:shop_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("shop_id", $shop_id);
        $stmt->execute();
        $isExistsWishlist = $stmt->fetchObject();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $sql = "INSERT INTO follows (user_id, shop_id,date) VALUES (:user_id, :shop_id,:date)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("shop_id", $shop_id);
			$stmt->bindParam("date", gmdate('Y-m-d H:i:s'));
            $stmt->execute();
            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Following Shop';
            $db = null;
        } else {
            $data['last_id'] = '';
            $data['Ack'] = '2';
            $data['msg'] = 'Already Followed';
            $db = null;
        }
        //echo json_encode($user);
    } catch (PDOException $e) {
	
      // print_r($e);
       // exit();
        $data['last_id'] = '';
        $data['msg'] = 'Error!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}

function unfollow() { 
    $data = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$shop_id = $body['shop_id'];
	
	
    $sql = "DELETE FROM  follows WHERE user_id=:user_id AND shop_id=:shop_id";
    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("shop_id", $shop_id);
        $stmt->execute();
        $db = null;
        $data['Ack'] = '1';
        $data['msg'] = 'Unfollowed Shop';
    } catch (PDOException $e) {
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error!!!';
    }
    echo json_encode($data);
    exit;
}
function myfollow() {
    $data = array();
	$productImagesData = array();
	$allshops = array();
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	
/*	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$key = $body['key'];*/
	
    try {
       
		
// GET FEATURED STORES

// ==================================================
        $is_active=1;
	
        $sql = "SELECT * FROM follows WHERE user_id=:user_id ORDER BY id ASC";
        $db = getConnection();
        $stmt2 = $db->prepare($sql);
        //$stmt2->bindParam("is_active", $is_active);
		$stmt2->bindParam("user_id", $user_id);
        $stmt2->execute();
        $getshops = $stmt2->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt2->rowCount();
          if ($count > 0) {
            foreach ($getshops as $shops) {
			
			$shopDetails = "select * FROM  shops WHERE `id`='" . $shops->shop_id . "' and `is_active`=1";
			$stmtShopDetails = $db->query($shopDetails);
			$shopData = $stmtShopDetails->fetchObject();
			
			if($shopData->logo!=''){
			$logo=SITE_URL . 'app/webroot/shop_images/' . $shopData->logo;
			}
			else{
			$logo='';
			}
			if($shopData->cover_photo!=''){
			$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $shopData->cover_photo;
			}
			else{
			$cover_photo='';
			}


			$storeProductCount = "select * FROM products WHERE `shop_id`='" . $shopData->id . "'";
			$stmtproCount = $db->query($storeProductCount);
			$totalProductCount = $stmtproCount->rowCount();
			
			
			 $sql1 = "SELECT * FROM follows WHERE shop_id=:shop_id ";
		     $stmt1 = $db->prepare($sql1);
             $stmt1->bindParam("shop_id", $shopData->id);
             $stmt1->execute();
		     $count1 = $stmt1->rowCount();
		     if($count1>0)
		     {
		     $in_follow=1;
		     }
		    else
		    {
		    $in_follow=0;
		    }
			
						

                $allshops[] = array(
                    "id" => stripslashes($shopData->id),
                    "user_id" => stripslashes($shopData->user_id),
                    "name" => stripslashes(strip_tags($shopData->name)),
					"description" => stripslashes($shopData->description),
					"categories" => stripslashes($shopData->categories),
					"sub_categories" => stripslashes($shopData->sub_categories),
					"facebook" => stripslashes($shopData->facebook),
					"twitter" => stripslashes($shopData->twitter),
					"linkedin" => stripslashes($shopData->linkedin),
					"pinterest" => stripslashes($shopData->pinterest),
					"youtube" => stripslashes($shopData->youtube),
					"is_active" => stripslashes($shopData->is_active),
					"created_at" => stripslashes($shopData->created_at),
					"paid_on" => stripslashes($shopData->paid_on),
					"last_date" => stripslashes($shopData->last_date),
					"total_product_count" => $totalProductCount,
					"logo" => stripslashes($logo),
					"in_follow" => stripslashes($in_follow),
					"cover_photo" => stripslashes($cover_photo));
					
					
					
            }
            $data['allshops'] = $allshops;
          
        } else {
            $data['allshops'] = '';
         
        }
		
		
	 $data['Ack'] = 1;	
		
    } catch (PDOException $e) {
	    print_r($e);
        $data['allshops'] = '';
        $data['Ack'] = 0;
    }
/*echo '<pre>';
print_r($data);	
echo '</pre>';*/
	
    echo json_encode($data);
    exit;
}


function getOrderListBuyer() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	$alldelivery = array();
	$alldispute = array();

	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$a='U';
	$b='C';
    try {

        $sql = "SELECT * FROM order_details WHERE user_id=:user_id and(order_status=:a or order_status=:b) order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("a", $a);
		$stmt->bindParam("b", $b);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();
		
		$productcount = "select * FROM ratings WHERE `product_id`='" . $orders->product_id . "' and `user_id`='".$user_id."'";
		$stmtProductcount = $db->query($productcount);
		$productcount = $stmtProductcount->fetchAll(PDO::FETCH_OBJ);
		
		$isratecount = $stmtProductcount->rowCount();
		
		
		$sqlorderDetails = "SELECT  * FROM order_details WHERE `id`='" . $orders->id . "' and `cancel_id`!=0 and `order_status`='C'";
		$stmtordercount = $db->query($sqlorderDetails);
		$ordercount = $stmtordercount->fetchAll(PDO::FETCH_OBJ);
		
		//$isordercount = $stmtordertcount->rowCount();
		if(count($ordercount)>0)
		{
		$cancel_request_sent=1;
		}
		else
		{
		$cancel_request_sent=0;
		}
		
		$order_status=$orders->order_status;
		$cancel_user_id=$orders->cancel_user_id;
		$order_user_id=$orders->user_id;
		$extend_processing_time=$orders->extend_processing_time;
		$buyer_responce_processing_time	=$orders->buyer_responce_processing_time;
		$seller_accept_shipment=$orders->seller_accept_shipment;
		
		if($order_status=='C' && $order_user_id==$cancel_user_id){
                                            $CancelText='You Cancelled the order.';
                                        }else{
                                            $CancelText='Seller Cancelled the order.';
                                        }
										
								
                                                if($order_status=='C'){
												
												$message_status=$CancelText;
												
												                 }
												elseif($extend_processing_time==1 && $buyer_responce_processing_time==0){ 
												$message_status="Seller Request for Extend Processing Time";
												}
												elseif($seller_accept==0){ 
											     $message_status= "Awaiting Shipment";
												}else
												{
                                                $message_status=" Goods Awaiting Acceptance";
                                                
                                                 }

                            if($extend_processing_time==1 && $buyer_responce_processing_time==0)  
							{
							$extend_processing_request=1;
							}
							else
							{
							$extend_processing_request=0;
							}  
                                             
	     $sqltrackDetails = "SELECT  * FROM track_details WHERE `order_details_id`='" . $orders->id . "'";
		$stmttrackDetails = $db->query($sqltrackDetails);
		$stmttrackDetails->execute();
			$gettrackDetails = $stmttrackDetails->fetchObject();
			$tracking_no=$gettrackDetails->tracking_no;
			$web_address=$gettrackDetails->web_address;
		
			$istrackcount = $stmttrackDetails->rowCount();
			if($istrackcount>0)
			{
			$add_track=1;
			}
			else
			{
			$add_track=0;
			}
			
		
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"product_id" => stripslashes($orders->product_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"rate_count" => stripslashes($isratecount),
				"cancel_request_sent" => stripslashes($cancel_request_sent),
				"message_status" => stripslashes($message_status),
				"extend_processing_request" => stripslashes($extend_processing_request),
				"add_track" => stripslashes($add_track),
					"tracking_no" => stripslashes($tracking_no),
					"web_address" => stripslashes($web_address),
					
				"notes" => stripslashes($orders->notes));
				
				
			
				
				
				
				
            }
            $data['orders_awaiting_shipment'] = $allorders;
         
        } else {
            $data['orders_awaiting_shipment'] = $allorders;
           
        }
		
		
	// GET Awaiting Payments =======================================================
	
	
		$sql = "SELECT * FROM temp_carts WHERE user_id=:user_id";
//		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		foreach ($getproducts as $products) {
		
		$productDetails = "select * FROM products WHERE `id`='" . $products->prd_id . "'";
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $products->prd_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $products->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();
		
		
		$productcount = "select * FROM ratings WHERE `product_id`='" . $products->prd_id . "' and `user_id`='".$user_id."'";
		$stmtProductcount = $db->query($productcount);
		$productcount = $stmtProductcount->fetchAll(PDO::FETCH_OBJ);
		
		$isratecount = $stmtProductcount->rowCount();
		
        $order_id='';
		
		
		
		
		
		$allproducts[] = array(
		"temp_id"=>stripslashes($products->id),
		"user_id" => stripslashes($products->user_id),
		"order_id" => stripslashes($order_id),
		"shop_id" => stripslashes($products->shop_id),
		"store_name" => stripslashes($getStoreDetails->name),
		"prd_id" => stripslashes(strip_tags($products->prd_id)),
		"name" => stripslashes($productData->name),
		"sku" => stripslashes(strip_tags($productData->sku)),
		"item_specification" => stripslashes($productData->item_specification),
		"item_description" => stripslashes($productData->item_description),
		"delivery_terms" => stripslashes($productData->delivery_terms),
		"image" => $productImagesData,
		"price" => stripslashes($products->price),
		"quantity" => stripslashes($products->quantity),
		"shipping_address" => stripslashes($products->shipping_address),
		"shipping_time" => stripslashes($products->shipping_time),
		"processing_time" => stripslashes($products->processing_time),
		"product_woner_id" => stripslashes($products->product_woner_id),
		"pay_amt" => stripslashes($products->pay_amt),
		"rate_count" => stripslashes($isratecount),
		"cdate" => stripslashes($products->cdate),
	
		);
		}
		
		$data['orders_awaiting_payment'] = $allproducts;
		} else {
		
		$data['orders_awaiting_payment'] = $allproducts;

		}	
		
		//Awaiting deleivery
		 $d="S";
		 $sql1 = "SELECT * FROM order_details WHERE user_id=:user_id and order_status=:d  order by `id` DESC";
      //  $db = getConnection();
        $stmt12 = $db->prepare($sql1);
        $stmt12->bindParam("user_id", $user_id);
		$stmt12->bindParam("d", $d);
        $stmt12->execute();
        $getorders1 = $stmt12->fetchAll(PDO::FETCH_OBJ);
		
		//print_r($getorders1);
		//exit;

        $count = $stmt12->rowCount();
        if ($count > 0) {
            foreach ($getorders1 as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();
		
		$productcount = "select * FROM ratings WHERE `product_id`='" . $orders->product_id . "' and `user_id`='".$user_id."'";
		$stmtProductcount = $db->query($productcount);
		$productcount = $stmtProductcount->fetchAll(PDO::FETCH_OBJ);
		
		$isratecount = $stmtProductcount->rowCount();
		
		
		$sqlorderDetails = "SELECT  * FROM order_details WHERE `id`='" . $orders->id . "' and `cancel_id`!=0 and `order_status`='C'";
		$stmtordercount = $db->query($sqlorderDetails);
		$ordercount = $stmtordercount->fetchAll(PDO::FETCH_OBJ);
		
		//$isordercount = $stmtordertcount->rowCount();
		if(count($ordercount)>0)
		{
		$cancel_request_sent=1;
		}
		else
		{
		$cancel_request_sent=0;
		}
		
		$extend_processing_time1=$orders->extend_processing_time;
		$buyer_responce_processing_time1=$orders->buyer_responce_processing_time;
		$seller_accept_shipment1=$orders->seller_accept_shipment;
		
        //if($extend_processing_time1==1 && $buyer_responce_processing_time1==0){
		//$message_status1="Seller Request for Extend Processing Time";
		//}
                                          
		
		if($extend_processing_time1==1 && $buyer_responce_processing_time1==0)  
							{
							$message_status1="Seller Request for Extend Processing Time";
							$extend_processing_request1=1;
							}
							else
							{
							$message_status1="";
							$extend_processing_request1=0;
							}  
		
		
		
		 $sqltrackDetails = "SELECT  * FROM track_details WHERE `order_details_id`='" . $orders->id . "'";
		$stmttrackDetails = $db->query($sqltrackDetails);
		$stmttrackDetails->execute();
		$gettrackDetails = $stmttrackDetails->fetchObject();
			$tracking_no=$gettrackDetails->tracking_no;
			$web_address=$gettrackDetails->web_address;
		
			$istrackcount = $stmttrackDetails->rowCount();
			if($istrackcount>0)
			{
			$add_track=1;
			}
			else
			{
			$add_track=0;
			}
		
		
	
	
				$alldelivery[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"product_id" => stripslashes($orders->product_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"rate_count" => stripslashes($isratecount),
				"cancel_request_sent" => stripslashes($cancel_request_sent),
					"message_status" => stripslashes($message_status1),
						"extend_processing_request" => stripslashes($extend_processing_request1),
					"add_track" => stripslashes($add_track),
					"tracking_no" => stripslashes($tracking_no),
					"web_address" => stripslashes($web_address),
				"notes" => stripslashes($orders->notes));
				
				
			
				
				
				
				
            }
            $data['orders_awaiting_delivery'] = $alldelivery;
         
        } else {
            $data['orders_awaiting_delivery'] = $alldelivery;
           
        }
		
		
		//Buyer Dispute
		 $de="DP";
		 $sql2 = "SELECT * FROM order_details WHERE user_id=:user_id and order_status=:e  order by `id` DESC";
      //  $db = getConnection();
        $stmt13 = $db->prepare($sql2);
        $stmt13->bindParam("user_id", $user_id);
		$stmt13->bindParam("e", $de);
        $stmt13->execute();
        $getorders12 = $stmt13->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt13->rowCount();
        if ($count > 0) {
            foreach ($getorders12 as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();
		
		$productcount = "select * FROM ratings WHERE `product_id`='" . $orders->product_id . "' and `user_id`='".$user_id."'";
		$stmtProductcount = $db->query($productcount);
		$productcount = $stmtProductcount->fetchAll(PDO::FETCH_OBJ);
		
		$isratecount = $stmtProductcount->rowCount();
		
		
		$sqlorderDetails = "SELECT  * FROM order_details WHERE `id`='" . $orders->id . "' and `cancel_id`!=0 and `order_status`='C'";
		$stmtordercount = $db->query($sqlorderDetails);
		$ordercount = $stmtordercount->fetchAll(PDO::FETCH_OBJ);
		
		//$isordercount = $stmtordertcount->rowCount();
		if(count($ordercount)>0)
		{
		$cancel_request_sent=1;
		}
		else
		{
		$cancel_request_sent=0;
		}
		 $sqltrackDetails = "SELECT  * FROM track_details WHERE `order_details_id`='" . $orders->id . "'";
		$stmttrackDetails = $db->query($sqltrackDetails);
		$stmttrackDetails->execute();
			$trackcount = $stmttrackDetails->fetchAll(PDO::FETCH_OBJ);
		
			$istrackcount = $stmttrackDetails->rowCount();
			if($istrackcount>0)
			{
			$add_track=1;
			}
			else
			{
			$add_track=0;
			}
			
			
	    $sqlcancelDetails = "SELECT * FROM disputes WHERE `order_details_id`='" . $orders->id . "' order by id desc limit 1";
		$stmtcancelDetails = $db->query($sqlcancelDetails);
		$stmtcancelDetails->execute();
		$getcancelDetails = $stmtcancelDetails->fetchObject();	
		 $isdisputedetails = $stmtcancelDetails->rowCount(); 
	    $is_response=$getcancelDetails->seller_response;
		$is_close=$getcancelDetails->is_close;
		$ddate=$getcancelDetails->cdate;
		$reason=$getcancelDetails->select_reason;
		$details=$getcancelDetails->dispute_details;
		$dispute_id=$getcancelDetails->id;
		$receive_order=$getcancelDetails->receive_order;
		$refund_request=$getcancelDetails->refund_request;
		$seller_responce=$getcancelDetails->seller_response;
		$seller_dispute_action=$getcancelDetails->seller_dispute_action;
		$is_close=$getcancelDetails->is_close;
		
		 
		
		
		if($isdisputedetails >0)
		{
		    if($seller_responce==0 && $seller_dispute_action==0)
		       {
		        $dispute_status=1;
		        }
		     elseif($seller_responce==1 && $seller_dispute_action==1)
		         {
		         $dispute_status=2;
		          }
		        elseif($seller_responce==1 && $seller_dispute_action==2)
		           {
		         $dispute_status=3;
		            }
		} 
		else
		{
		 $dispute_status=0;
		}
		
		$order = "select * FROM  orders WHERE `id`='" . $orders->order_id . "'";
		//echo '<br>';
		$stmtorder = $db->query($order);
		$orderData = $stmtorder->fetchObject();
		$order_date=$orderData->order_date;
		$owner_id=$orderData->owner_id;
		
	
	
				$alldispute[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"user_id" => stripslashes($owner_id),
				"product_id" => stripslashes($orders->product_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"rate_count" => stripslashes($isratecount),
				"cancel_request_sent" => stripslashes($cancel_request_sent),
				"problem" => stripslashes($details),
				"reason" => stripslashes($reason),
				"receive_order" => stripslashes($receive_order),
				"refund_request" => stripslashes($refund_request),
				"dispute_id" => stripslashes($dispute_id),
				"order_date" => stripslashes($order_date),
				"dispute_date" => stripslashes($ddate),
				"add_track" => stripslashes($add_track),
					"dispute_status" => stripslashes($dispute_status),
				"notes" => stripslashes($orders->notes));
				
			  }
            $data['orders_awaiting_dispute'] = $alldispute;
         
        } else {
            $data['orders_awaiting_dispute'] = $alldispute;
           
        }
		
		
		
		
			$data['Ack'] = 1;	
		
		
		
		
    } catch (PDOException $e) {
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}



function getPurchaseHistoryBuyer() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
    try {

        $sql = "SELECT * FROM order_details WHERE user_id=:user_id  and order_status='F' order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
		//$stmt->bindParam("order_status",'D');
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);


        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();
		
		$sqlratingDetails = "SELECT  * FROM ratings WHERE `order_details_id`='" . $orders->id. "' and `user_id`='".$user_id."' and `product_id`='".$orders->product_id."'";
		$stmtRateDetails = $db->prepare($sqlratingDetails );
		$stmtRateDetails->execute();
		$getRateDetails = $stmtRateDetails->fetchObject();
		$isratecount = $stmtRateDetails->rowCount();
		if($isratecount>0)
		{
		$is_rate=1;
		}
		else
		{
		$is_rate=0;
		}
		
		$sqldisputeDetails = "SELECT  * FROM disputes WHERE `order_details_id`='" . $orders->id . "' and `seller_response`=0 and `seller_dispute_action`=0 order by id desc limit 1";
		$stmtdisputeDetails = $db->prepare($sqldisputeDetails);
		$stmtdisputeDetails->execute();
		$getdisputeDetails = $stmtdisputeDetails->fetchObject();
	    $newrequestcount = $stmtdisputeDetails->rowCount();
		if($newrequestcount>0)
		{
		$is_dispute_new_request=1;
		}
		else
		{
		$is_dispute_new_request=0;
		}
		$order = "select * FROM  orders WHERE `id`='" . $orders->order_id . "'";
		//echo '<br>';
		$stmtorder = $db->query($order);
		$orderData = $stmtorder->fetchObject();
		$order_date=$orderData->order_date;
	
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"product_id" => stripslashes($orders->product_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"rating" => stripslashes($getRateDetails->rating),
				"is_rate" => stripslashes($is_rate),
				"is_dispute_new_request" => stripslashes($is_dispute_new_request),
				"order_date" => stripslashes($order_date),
				"notes" => stripslashes($orders->notes));
				
				
            }
            $data['orders_purchase_list'] = $allorders;
         
        } else {
            $data['orders_purchase_list'] = $allorders;
           
        }
		
			$data['Ack'] = 1;	
		
		
		
		
    } catch (PDOException $e) {
	//print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}


function getOrderListSeller() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
    try {

        $sql = "SELECT * FROM order_details WHERE owner_id=:owner_id order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("owner_id", $user_id);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();	
		
		$sqlorderDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='C'";
		$stmtorderDetails = $db->prepare($sqlorderDetails);
		$stmtorderDetails->execute();
		$getorderDetails = $stmtorderDetails->fetchObject();	
        $isorderdetails = $stmtorderDetails->rowCount(); 
		$order_status=$getorderDetails->order_status;
		
		$sqlordDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='S'";
		$stmtordDetails = $db->prepare($sqlordDetails);
		$stmtordDetails->execute();
		$getordDetails = $stmtordDetails->fetchObject();	
        $isorddetails = $stmtordDetails->rowCount(); 
		
		
		
		
		$sqlorderrDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "'";
		$stmtorderrDetails = $db->prepare($sqlorderrDetails);
		$stmtorderrDetails->execute();
		$getorderrDetails = $stmtorderrDetails->fetchObject();	
        $isorderrdetails = $stmtorderrDetails->rowCount(); 
		$orderr_status=$getorderrDetails->order_status;
		$extend_processing_time=$getorderrDetails->extend_processing_time;
		$buyer_responce_processing_time=$getorderrDetails->buyer_responce_processing_time;
		$seller_accept_shipment=$getorderrDetails->seller_accept_shipment;
		
		$sqlcancelfirstDetails = "SELECT * FROM cancel_orders WHERE `order_details_id`='" . $orders->id . "' order by `id` ASC limit 1";
		$stmtcancelfirstDetails = $db->prepare($sqlcancelfirstDetails);
		$stmtcancelfirstDetails->execute();
		$getcancelfirstDetails = $stmtcancelfirstDetails->fetchObject();
		$reason=$getcancelfirstDetails->select_reason;
		
		
		$sqlcancelDetails = "SELECT * FROM cancel_orders WHERE `order_details_id`='" . $orders->id . "' order by `id` DESC limit 1";
		$stmtcancelDetails = $db->prepare($sqlcancelDetails);
		$stmtcancelDetails->execute();
		$getcancelDetails = $stmtcancelDetails->fetchObject();
		$seller_responce=$getcancelDetails->seller_responce;	
		// $iscancel = $stmtcancelDetails->rowCount(); 
		$is_response=$getcancelDetails->seller_responce;
		
		
		$order = "select * FROM  orders WHERE `id`='" . $orders->order_id . "'";
		//echo '<br>';
		$stmtorder = $db->query($order);
		$orderData = $stmtorder->fetchObject();
		$order_date=$orderData->order_date;
		
		
		 $sqldisputeDetails = "SELECT * FROM disputes WHERE `order_details_id`='" . $orders->id . "' order by id desc limit 1";
		$stmtdisputeDetails = $db->prepare($sqldisputeDetails);
		$stmtdisputeDetails->execute();
		$getdisputeDetails =$stmtdisputeDetails->fetchObject();	
         $isdisputedetails = $stmtdisputeDetails->rowCount(); 
		 
		$seller_responce1=$getdisputeDetails->seller_response;
		$seller_dispute_action=$getdisputeDetails->seller_dispute_action;
		$is_close=$getdisputeDetails->is_close;
		$ddate=$getdisputeDetails->cdate;
		$reason1=$getdisputeDetails->select_reason;
		$dispute_id=$getdisputeDetails->id;
		
		
			
	  
		
		if($isdisputedetails >0)
		{
		    if($seller_responce1==0 && $seller_dispute_action==0)
		       {
		        $dispute_status=1;
		        }
		     elseif($seller_responce1==1 && $seller_dispute_action==1)
		         {
		         $dispute_status=2;
		          }
		        elseif($seller_responce1==1 && $seller_dispute_action==2)
		           {
		         $dispute_status=3;
		            }
		} 
		else
		{
		 $dispute_status=0;
		}
		
		
		if($is_response==0)
		{
		$iscancel=1;
		}
		else
		{
		$iscancel=0;
		}
		if($is_response==1)
		{
		$isaccept=1;
		}
		else
		{
		$isaccept=0;
		}
		if($is_response==2)
		{
		$isreject=1;
		}
		else
		{
		$isreject=0;
		}
		if($is_response==3)
		{
		$iscancelown=1;
		}
		else
		{
		$iscancelown=0;
		}
		
	
		
		if($iscancel==1 && $isorderdetails >0)
		{
		$is_cancel_request="Yes";
		}
		else
		{
		$is_cancel_request="No";
		}
		
		if($isaccept==1 && $isorderdetails >0)
		{
		$is_accept_request="Yes";
		}
		else
		{
		$is_accept_request="No";
		}
		
		if($isreject==1 && $isorddetails >0)
		{
		$is_reject_request="Yes";
		}
		else
		{
		$is_reject_request="No";
		}
		if($iscancelown==1 && $isorderdetails >0)
		{
		$cancel_status="Yes";
		}
		else
		{
		$cancel_status="No";
		}
		
		if($extend_processing_time==1 && $buyer_responce_processing_time==0)
		{
		$extend_time_request="Yes";
		}
		else
		{
		$extend_time_request="No";
		}
		if($seller_accept_shipment==1 && $orderr_status=='S')
		{
		$add_tracking="Yes";
		}
		else
		{
		$add_tracking="No";
		}
		
		if($orderr_status=='C' && $seller_responce==0){
		$status_cancel="Order Cancelled - Waiting Action";
		}
		elseif($orderr_status=='C'  && $seller_responce==1){
		$status_cancel="You Accepted Cancelled Order from buyer";
		}
		elseif($orderr_status=='S' && $seller_responce==2)
		{
		$status_cancel="You Reject Cancelled Order from buyer";
		}
		elseif($orderr_status=='C' && $seller_responce==3)
		{
		$status_cancel="You Cancelled the Order";
		}
		elseif($seller_accept_shipment==0)
		{
        $status_cancel="Awaiting Shipment";
         if($extend_processing_time==1 && $buyer_responce_processing_time==0)
		       {
             $status_cancel="Extended delivery time requested";
               }
			   elseif($extend_processing_time==1 && $buyer_responce_processing_time==1)
			   {
              $status_cancel="Extended delivery time accepted";
               }
			  elseif($extend_processing_time==1 && $buyer_responce_processing_time==2)
			   {
               $status_cancel="Extended delivery time rejected";
               }
         }
		elseif($seller_accept_shipment==1 && $orderr_status=='S'){
		  $status_cancel="Dispatched";
		}
		
		
		elseif($orderr_status=='DP')
		{
		   if($seller_responce==0 && $seller_dispute_action==0)
		   {
		        $status_cancel="Buyer Dispute Product.";
		   }
		   if($seller_responce==1 && $seller_dispute_action==1)
		   {
		        $status_cancel="You Accepted Dispute Product.";
		   }
		     if($seller_responce==1 && $seller_dispute_action==2)
			 {
			    $status_cancel="You Rejected Dispute Product.";
			 }
		}
		
		if($orderr_status=='DP')
		{
		$is_dispute=1;
		}
		else
		{
		$is_dispute=0;
		}
		if($orderr_status=='F')
		{
		$finish_status="Goods  Delivered";
		$finish_status_message="Finish";
		$is_complete=1;
		}
		else
		{
		$is_complete=0;
		}
		
			
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"product_id" => stripslashes($orders->product_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"is_cancel_request" => stripslashes($is_cancel_request),
				"is_accept_request" => stripslashes($is_accept_request),
				"is_reject_request" => stripslashes($is_reject_request),
				"is_reject_request" => stripslashes($is_reject_request),
				"cancel_status" => stripslashes($cancel_status),
				"cancel_status_message" => stripslashes($status_cancel),
				"extend_time_request" => stripslashes($extend_time_request),
				"add_tracking" => stripslashes($add_tracking),
				"dispute_status" => stripslashes($dispute_status),
				"order_date" => stripslashes($order_date),
				"dispute_date" => stripslashes($ddate),
				"dispute_id" => stripslashes($dispute_id),
				"is_dispute" => stripslashes($is_dispute),
				"dispute_reason" => stripslashes($reason1),
				"is_complete" => stripslashes($is_complete),
				"finish_status" => stripslashes($finish_status),
				"finish_status_message" => stripslashes($finish_status_message),
				"reason" => stripslashes($reason),
				"notes" => stripslashes($orders->notes));
				
				
            }
			$data['orders_all'] = $allorders;
			$data['Ack'] = 1;
        } else {
		$data['orders_all'] = $allorders;
		$data['Ack'] = 0;
		$data['msg'] = 'No Records Found..';
        }	
		
		
		
		
    } catch (PDOException $e) {
	print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}



function getOederDetails() {
    $data = array();
    $allproducts = array();
	$productImagesData = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$order_id = $body['order_id'];
	
	
		try {
		
		$sql = "SELECT * FROM order_details WHERE order_id=:order_id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("order_id", $order_id);
		$stmt->execute();
		$getProducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		foreach ($getProducts as $products) {
		
		$productDetails = "select * FROM products WHERE `id`='" . $products->product_id . "'";
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $products->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
	$sqlShopName = "SELECT  * FROM shops WHERE `id`='" . $products->category_id . "'";
	$stmtShopName = $db->prepare($sqlShopName);
	$stmtShopName->execute();
	$getShopDetails = $stmtShopName->fetchObject();			
		
		
		$allproducts[] = array(
		"id" => stripslashes($products->id),
		"product_id" => stripslashes($products->product_id),
		"product_name" => stripslashes($productData->name),
		"product_image" => $productImagesData,
		"shop_id" => stripslashes($products->shop_id),
		"shop_name" => stripslashes($getShopDetails->name),
		"owner_id" => stripslashes($products->owner_id),
		"cancel_transcation_id" => stripslashes($products->cancel_transcation_id),
		"quantity" => stripslashes($products->quantity),
		"shipping_cost" => stripslashes($products->shipping_cost),
		"coupon_id" => stripslashes($products->coupon_id),
		"coupon_percentage" => stripslashes($products->coupon_percentage),
		"price" => stripslashes($products->price),
		"coupon_percentage" => stripslashes($products->coupon_percentage),
		"amount" => stripslashes($products->amount),
		"order_status" => stripslashes($products->order_status),
		"user_type" => stripslashes($products->user_type),
		"extend_processing_time" => stripslashes($products->extend_processing_time),
		"buyer_accept_dispute" => stripslashes($products->buyer_accept_dispute),
		"cancel_user_id" => stripslashes($products->cancel_user_id),
		"cancel_id" => stripslashes($products->cancel_id),
		"seller_accept_shipment" => stripslashes($products->seller_accept_shipment),
		"seller_is_view" => stripslashes($products->seller_is_view),
		"delivery_date" => stripslashes($products->delivery_date),
		"order_received_date" => stripslashes($products->order_received_date)
		);
		
		}
		
		$sql = "SELECT * FROM orders WHERE id=:id ";
		//$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $order_id);
		$stmt->execute();
		$orderDetails = $stmt->fetchObject();
		
		if ($orderDetails->status == "0") {
		$order_status = "Processing Order";
		}
		if ($orderDetails->status == "1") {
		$order_status = "Delivered";
		}
		if ($orderDetails->status == "2") {
		$order_status = "Completed";
		}
		
		$data['order_details'] = array(
		"id" => stripslashes($orderDetails->id),
		"user_id" => stripslashes($orderDetails->user_id),
		"store_id" => stripslashes($orderDetails->store_id),
		"store_woner_id" => stripslashes($orderDetails->store_woner_id),
		"total_amount" => stripslashes($orderDetails->total_amount),
		"order_date" => stripslashes($orderDetails->order_date),
		"transaction_id" => stripslashes($orderDetails->transaction_id),
		"shipping_address" => stripslashes($orderDetails->shipping_address),
		"pay_key" => stripslashes($orderDetails->pay_key),
		"payment_date" => stripslashes($orderUserdetails->payment_date),
		"notes" => stripslashes($orderUserdetails->notes),
		"allproducts" => $allproducts);
		
		
		$data['Ack'] = 1;
		$data['msg'] = 'Records Found';
		} else {
		$data['order_details'] = '';
		$data['Ack'] = 2;
		$data['msg'] = 'No Records Found';
		}
		} catch (PDOException $e) {
        $data['order_details'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
	
/*	echo '<pre>';
	print_r($data);
	echo '</pre>';*/
    echo json_encode($data);
    exit;
}




		function checkout() {
		$data = array();
		$app = new Slim();
		$app->config('debug', true);
		//    echo $paramValue = $app->request->get('fname');
		$request = Slim::getInstance()->request();
		//$user = json_decode($request->getBody());
		$body = ($request->post());
		
		$user_id = $body['user_id'];
		$store_id = $body['store_id'];
		$total_amount = $body['total_amount'];
		$buyer_amount = $body['buyer_amount'];
		$admin_amount = $body['admin_amount'];
		$admin_paid= $body['admin_paid'];
		$paypal_fee = $body['paypal_fee'];
		$transaction_id = $body['transaction_id'];
		$shipping_address = $body['shipping_address'];
		$pay_key = $body['pay_key'];
		$notes = $body['notes'];
		$payment_date=date('Y-m-d');
		$order_date=date('Y-m-d');
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $store_id . "'";
		try {	
		$db = getConnection();
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();	
		$store_woner_id =$getStoreDetails->user_id;		

		
		
		$sql = "INSERT INTO orders (user_id, store_id, store_woner_id, total_amount, buyer_amount, admin_amount, paypal_fee, order_date, transaction_id, shipping_address, pay_key, payment_date, admin_paid, notes) VALUES (:user_id, :store_id, :store_woner_id, :total_amount, :buyer_amount, :admin_amount, :paypal_fee, :order_date, :transaction_id, :shipping_address, :pay_key, :payment_date, :admin_paid, :notes)";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("store_id", $store_id);
		$stmt->bindParam("store_woner_id", $store_woner_id);
		$stmt->bindParam("total_amount", $total_amount);
		$stmt->bindParam("buyer_amount", $buyer_amount);
		$stmt->bindParam("admin_amount", $admin_amount);
		$stmt->bindParam("paypal_fee", $paypal_fee);
		$stmt->bindParam("order_date", $order_date);
		$stmt->bindParam("transaction_id", $transaction_id);
		$stmt->bindParam("shipping_address", $shipping_address);
		$stmt->bindParam("pay_key", $pay_key);
		$stmt->bindParam("payment_date", $payment_date);
		$stmt->bindParam("admin_paid", $admin_paid);
		$stmt->bindParam("notes", $notes);
		$stmt->execute();
		// $stmt->debugDumpParams();
		$orderID = $db->lastInsertId();
       
		
		$sql = "SELECT * FROM temp_carts WHERE user_id=:user_id";
		//    $db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("user_id", $user_id);
		$stmt->execute();
		$getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);       
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		foreach ($getproducts as $products) {
		
		$productDetails = "select * FROM products WHERE id='" . $products->prd_id . "'";
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		$shipping_time=$productData->shipping_time;
		$processing_time=$productData->processing_time;
		$product_id=$products->prd_id;
		$price=$products->price;
		$quantity=$products->quantity;
		$amount=$products->pay_amt;
		$shipping_cost=0;
		$order_status='U';
		$user_type='1';
		//	$current_date = date('Y-m-d');
		if($shipping_time=='1-3 Days')
		{
		$shipping_time=3;
		}
		elseif($shipping_time=='4-6 Days')
		{
		$shipping_time=6;
		}
		elseif($shipping_time=='7-10 Days')
		{
		$shipping_time=10;
		}
		else
		{
		$shipping_time=15;
		}
		if($processing_time=='1-3 Days')
		{
		$processing_time=3;
		}
		elseif($processing_time=='4-6 Days')
		{
		$processing_time=6;
		}
		elseif($processing_time=='7-10 Days')
		{
		$processing_time=10;
		}
		else
		{
		$processing_time=15;
		}
		$total=$shipping_time+$processing_time;
		$current_date =gmdate('Y-m-d H:i:s');
		$date2 = date('Y-m-d  H:i:s', strtotime($current_date . "+" . $total . " days"));
		
		
		$insertOrderDetails = "insert into order_details (user_id, order_id, product_id , shop_id, owner_id, price, quantity, shipping_cost, amount,order_status,user_type,delivery_date) values(:user_id,:order_id,:product_id,:shop_id,:owner_id,:price,:quantity,:shipping_cost,:amount,:order_status,:user_type)";
		
		$stmt = $db->prepare($insertOrderDetails);
		$stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("order_id", $orderID);
		$stmt->bindParam("product_id", $product_id);
		$stmt->bindParam("shop_id", $store_id);
		$stmt->bindParam("owner_id", $store_woner_id);
		$stmt->bindParam("price", $price);
		$stmt->bindParam("quantity", $quantity);
		$stmt->bindParam("shipping_cost", $shipping_cost);
		$stmt->bindParam("amount", $amount);
		$stmt->bindParam("order_status", $order_status);
		$stmt->bindParam("user_type", $user_type);
		$stmt->bindParam("delivery_date", $date2);
		$stmt->execute();
		$orderDetailsID = $db->lastInsertId();
		// FOR MANAGING INVENTORIES		
		
		$type='-';
		$insertInventoryDetails = "insert into manage_inventories (product_id, order_id, order_details_id , type, quantity, price, user_id, comment, create_date) values(:product_id,:order_id,:order_details_id,:type,:quantity,:price,:user_id,:comment,:create_date)";
		
		$stmt = $db->prepare($insertInventoryDetails);
		$stmt->bindParam("product_id", $product_id);
		$stmt->bindParam("order_id", $orderID);
		$stmt->bindParam("order_details_id", $orderDetailsID);
		$stmt->bindParam("type", $type);
		$stmt->bindParam("quantity", $quantity);
		$stmt->bindParam("price", $price);
		$stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("comment", $notes);
		$stmt->bindParam("create_date", $order_date);
		$stmt->execute();		
		
		
		// FOR COMMENTS	
		
		$comment_type=0;
		$is_notification=1;
		$subject ='New Order Placed. Order ID'.$orderID;
		$comments ='You have received a new Order. The Order ID is'.$orderID;
		$file_name='';
		$is_read=0;
		$seller_is_flag=0;
		$cdate=date('Y-m-d H:i:s');
		
		
		$insertInventoryDetails = "insert into comments (user_id, to_user_id, comment_type , is_notification, order_id, order_details_id, thread_id, subject, comments, file_name, is_read, seller_is_flag, cdate) values(:user_id,:to_user_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:subject,:comments,:file_name,:is_read,:seller_is_flag,:cdate)";
		
		$stmt = $db->prepare($insertInventoryDetails);
		$stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("to_user_id", $store_woner_id);
		$stmt->bindParam("comment_type", $comment_type);
		$stmt->bindParam("is_notification", $is_notification);
		$stmt->bindParam("order_id", $orderID);
		$stmt->bindParam("order_details_id", $orderDetailsID);
		$stmt->bindParam("thread_id", $orderID);
		$stmt->bindParam("subject", $subject);
		$stmt->bindParam("comments", $comments);
		$stmt->bindParam("file_name", $file_name);
		$stmt->bindParam("is_read", $is_read);
		$stmt->bindParam("seller_is_flag", $seller_is_flag);
		$stmt->bindParam("cdate", $cdate);
		$stmt->execute();	
		
		
		$quantity_in_db=$productData->quantity-$quantity;
		$sold_quantity_in_db=$productData->sold_quantity+$quantity;		
	
	
	
		$sql = "UPDATE products SET quantity=:quantity, sold_quantity=:sold_quantity WHERE id=:id";
		$stmt = $db->prepare($sql);
		$stmt->bindParam("quantity", $quantity_in_db);
		$stmt->bindParam("sold_quantity", $sold_quantity_in_db);
		$stmt->bindParam("id", $product_id);
		$stmt->execute();	
		
		}
		
		}
		

		
		
// GET ORDER DETAILS FOR THE SUCCESS MAILS		
		
		$sql = "SELECT * FROM orders WHERE id=:id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $orderID);
		$stmt->execute();
		$count = $stmt->rowCount();
		$getOrderData = $stmt->fetchObject();
		
		$sql = "SELECT * FROM `users` WHERE id=:id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $getOrderData->user_id);
		$stmt->execute();
		$getUserDetails = $stmt->fetchObject();
		
		
		$sql = "SELECT * FROM order_details where order_id=:order_id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("order_id", $orderID);
		$stmt->execute();
		$getOrderdetail = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		
		$subject = "TWOP.com - Order " . $getOrderData->transaction_id;
		$TemplateMessage = '';
		//$TemplateMessage.="<img src='http://freshqatar.com/images/logo-new.png' /><br>";
		$TemplateMessage.= "<br>Thank you for your shopping at twop.com using our apps!<br>
		Your order has been received and is being processed.<br>";
		
		$TemplateMessage.= "<br>A new Order Received with the following details:<br/>";
		$TemplateMessage.="<h3>Order details For #" .$getOrderData->transaction_id . "</h3>";
		
		
		$TemplateMessage.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='table table-listing'>
		<tr>
		<td><ul>
		<li style='list-style:none; background-color:#009900;margin-bottom:6px; color:#ffffff'><b>Customer Details</b></li>
		<li style='list-style:none;'><span>Customer Name :</span>" . $getUserDetails->first_name . "&nbsp;" . $getUserDetails->last_name . "</li>
		<li style='list-style:none;'><span>Email :</span>" . $getUserDetails->email . "</li>
		<li style='list-style:none;'><span>Contact No :</span>" . $getUserDetails->mobile_number . "</li>
		<li style='list-style:none;'>&nbsp;</li>
		</ul></td>
		
		<td><ul>
		<li style='list-style:none; background-color:#009900;margin-bottom:6px; color:#ffffff'><b>Payment Details</b></li>
		<li style='list-style:none;'><span>Payment Type :</span>COD</li>
		<li style='list-style:none;'><span>Transaction ID :</span>" . $getOrderData->transaction_id . "</li>
		<li style='list-style:none;'><span>Amount :</span>" . $getOrderData->total_amount . " QR</li>
		<li style='list-style:none;'><span>Payment Date : </span>" . $getOrderData->payment_date . "</li>";
		
		
		
		
		
		$TemplateMessage.=" <li style='list-style:none;'><span>Customer Notes : </span>" .  $getOrderData->notes . "</li>";
		
		
		$TemplateMessage.="
		</ul></td>
		</tr>
		</table>";
		
		
		$TemplateMessage.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='table table-listing'>
		<tr>
		<th style='color:#FFFFFF; background-color:#009900;'>
		Item Name
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		Image
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		QTY
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		Price
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		Total
		</th>
		</tr>";
		
		
		$mailprice = 0;
		foreach ($getOrderdetail as $resultOrderDetails) {
		
		
		$sql = "SELECT * FROM `products` WHERE id=:id ";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $resultOrderDetails['productid']);
		$stmt->execute();
		$getProductDetails = $stmt->fetchObject();
		
		if ($getProductDetails->img == '') {
		$imgage = 'upload/no.png';
		} else {
		$imgage = '';
		}
		
		
		
		$TemplateMessage.="<tr>
		<td>
		" . $getProductDetails->name . "
		</td>
		<td>
		<img src=$imgage width='100' height='100'  border='0' align='center' alt='' />
		</td>
		<td>
		" . $resultOrderDetails['quantity'] . "
		</td>
		<td>
		" . $resultOrderDetails['price'] . "
		</td>
		<td>
		" . $total = $resultOrderDetails['amount'] .
		" QR</td>
		
		</tr>";
		$tpc = ($resultOrderDetails['quantity']) * ($getProductDetails->regular_price);
		$mailprice = $tpc + $mailprice;
		}
		
		$TemplateMessage.="</table>";
		

	// MAKING CART EMPTY
	
	$sql = "DELETE FROM temp_carts WHERE user_id=:user_id";
	$stmtEmptyCarts = $db->prepare($sql);
	$stmtEmptyCarts->bindParam("user_id", $user_id);
	$stmtEmptyCarts->execute();




		$db = null;
		
		
		
		$data['Ack'] = 1;
		$to = $email;
		
		// $subject = "freshqatar.com-order confirmation";
		// $TemplateMessage = "Hi #".$orderid."<br/>Your order submited sucessfully from our app at freshqatar.com!<br />";
		// $TemplateMessage .= "Thanks,<br />";
		//  $TemplateMessage .= "freshqatar.com<br />";
		
		
		
		$header = "From:info@twop.com \r\n";
		// $header .= "Cc:nits.soumen.com \r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html\r\n";
		
		$retval = mail($to, $subject, $TemplateMessage, $header);
		
		
		// admin
		
		/*$sql = "select * from `freshquater_tbladmin` where `id` = '1'";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		//$stmt->bindParam("id", $getOrderData->id);
		$stmt->execute();
		//$getOrderdetail = $stmt->fetchAll(PDO::FETCH_OBJ);
		//$getBillingDetails = $stmt->fetchObject();
		
		$rowAdminEmail = $stmt->fetch();
		
		
		//	$row = mysql_fetch_array(mysql_query("select * from `freshquater_tbladmin` where `id` = '1'"));
		$admin_email = $rowAdminEmail['email'];
		
		
		
		$ORDER_ID = $getOrderData->order_from_device . $getOrderData->unique_trans_id;
		
		//$admin_email='nits.sarojkumar@gmail.com';
		//$subject = "A New Order Has Been Placed";
		$subject = "New order-$ORDER_ID-$getOrderData->price QR-$getUserDetails->fname";
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$headers .= "From: info@freshqatar.com" . "\r\n" . "";
		mail($admin_email, $subject, $TemplateMessage, $headers);*/
		
		
		$data['Ack'] = 1;
		$data['msg'] = 'Payment Successful';
		

		
		
		
		} catch (PDOException $e) {
		$data['Ack'] = 0;
		$data['msg'] = 'Payment Failed';
		echo '{"error":{"text":'. $e->getMessage() .'}}';
		}
		echo json_encode($data);
		exit;
}


function allsearch() {
    $data = array();
    $allproducts = array();
	$productImagesData = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$key = $body['key'];
	
    try {
	     
		 //Product Search
        $sql3 = "SELECT * FROM products WHERE name LIKE :key  ORDER BY name";
        $db = getConnection();
        $stmt3 = $db->prepare($sql3);
        $query3 = "%" . $key . "%";
        $stmt3->bindParam("key", $query3);
        $stmt3->execute();
        $getproducts = $stmt3->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt3->rowCount();
		
        if ($count > 0) {
            foreach ($getproducts as $products) {

			unset($productImagesData);
			$productImages = array();
			$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "' limit 1";
			$stmtProductImage = $db->query($productImage);
			$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
			
			$isImageExists = $stmtProductImage->rowCount();
			if ($isImageExists > 0) {
			
			//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
			foreach ($productImages as $img_products) {
			//echo '<pre>';
			//print_r($img_products);
			$productImagesData=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
			}
			}
			else
			{
			$productImagesData="";
			}
			
			$type='P';
			
			
				
			//	print_r($productImagesData);

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
					 "image" => $productImagesData,
                    "type" => $type);
					
					
					
            }
            //$data['all_products'] = $allproducts;
            //$data['Ack'] = 1;
			
			
        } else {
            //$data['all_products'] = array();
            //$data['Ack'] = 0;
        }
		//Shop Search
		$db=null;
		$sql2 = "SELECT * FROM shops WHERE name LIKE :key ORDER BY name";
		 $db = getConnection();
        $stmt2= $db->prepare($sql2);
        $query2 ="%" . $key . "%";
        $stmt2->bindParam("key", $query2);
        $stmt2->execute();
        $getproducts = $stmt2->fetchAll(PDO::FETCH_OBJ);
        $count1 = $stmt2->rowCount();
		
        if ($count1 > 0) {
            foreach ($getproducts as $products) {
			
			if($products->logo!=''){
			$logo=SITE_URL . 'app/webroot/shop_images/' . $products->logo;
			}
			else{
			$logo='';
			}
			


		
			
			$type='S';
			
			

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
					 "image" => stripslashes($logo),
                    "type" => $type);
					
					
					
            }
            //$data['all_products'] = $allproducts;
           // $data['Ack'] = 1;
			
			
        } else {
            //$data['all_products'] = array();
            //$data['Ack'] = 0;
        }
		
		//Category Search
		$db=null;
		$sql1 = "SELECT * FROM categories WHERE name LIKE :key  ORDER BY name";
		 $db = getConnection();
        $stmt1 = $db->prepare($sql1);
        $query1 = "%" . $key . "%";
        $stmt1->bindParam("key", $query1);
        $stmt1->execute();
        $getproducts = $stmt1->fetchAll(PDO::FETCH_OBJ);
        $count2 = $stmt1->rowCount();
		
        if ($count2 > 0) {
            foreach ($getproducts as $products) {

		
			
			$type='C';
			
			
				
			//	print_r($productImagesData);

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
					 "image" => '',
                    "type" => $type);
					
					
					
            }
            //$data['all_products'] = $allproducts;
            //$data['Ack'] = 1;
			
			
        } else {
            //$data['all_products'] = array();
            //$data['Ack'] = 0;
        }
		if(!empty($allproducts)){
			$data['all_products'] = $allproducts;
            $data['Ack'] = 1;
		}else{
			$data['all_products'] = array();
            $data['Ack'] = 0;
		}
    } catch (PDOException $e) {
        $data['products'] = '';
        $data['Ack'] = 0;
    }
//print_r($data);	
	
    echo json_encode($data);
    exit;
}

function rateorder() {
    $data = array();

	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$product_id = $body['product_id'];
	$order_id= $body['order_id'];
	$order_detailsId= $body['order_detailsId'];
	$rating= $body['rating'];
	//$store_id = $body['store_id'];
	//$price = $body['price'];
	

    $sql = "SELECT * FROM ratings WHERE user_id=:user_id AND product_id=:product_id  AND order_id=:order_id AND order_details_id=:order_detailsId";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("product_id", $product_id);
		$stmt->bindParam("order_id", $order_id);
		$stmt->bindParam("order_detailsId", $order_detailsId);
		
        $stmt->execute();
        $isExistsWishlist = $stmt->fetchObject();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $sql = "INSERT INTO  ratings (user_id, product_id,rating,order_id,order_details_id,date_time) VALUES (:user_id, :product_id,:rating,:order_id,:order_detailsId,:date)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("product_id", $product_id);
			$stmt->bindParam("order_id", $order_id);
			$stmt->bindParam("order_detailsId", $order_detailsId);
			 $stmt->bindParam("rating", $rating);
			$stmt->bindParam("date", gmdate('Y-m-d H:i:s'));
            $stmt->execute();
            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Successfully Rated';
            $db = null;
        } else {
            $data['last_id'] = '';
            $data['Ack'] = '2';
            $data['msg'] = 'Already Rated';
            $db = null;
        }
        //echo json_encode($user);
    } catch (PDOException $e) {
	
      // print_r($e);
       // exit();
        $data['last_id'] = '';
        $data['msg'] = 'Error!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}

function OrderDetails() {
    $data = array();
    $allproducts = array();
	$productImagesData = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$order_details_id = $body['order_details_id'];
	
	
		try {
		
		$sql = "SELECT * FROM order_details WHERE id=:order_details_id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("order_details_id", $order_details_id);
		$stmt->execute();
		$getProducts = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		$count = $stmt->rowCount();
		if ($count > 0) {
		foreach ($getProducts as $products) {
		
		$productDetails = "select * FROM products WHERE `id`='" . $products->product_id . "'";
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $products->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
	$sqlShopName = "SELECT  * FROM shops WHERE `id`='" . $products->category_id . "'";
	$stmtShopName = $db->prepare($sqlShopName);
	$stmtShopName->execute();
	$getShopDetails = $stmtShopName->fetchObject();			
		
		
		$allproducts[] = array(
		"id" => stripslashes($products->id),
		"product_id" => stripslashes($products->product_id),
		"product_name" => stripslashes($productData->name),
		"product_image" => $productImagesData,
		"shop_id" => stripslashes($products->shop_id),
		"shop_name" => stripslashes($getShopDetails->name),
		"owner_id" => stripslashes($products->owner_id),
		"cancel_transcation_id" => stripslashes($products->cancel_transcation_id),
		"quantity" => stripslashes($products->quantity),
		"shipping_cost" => stripslashes($products->shipping_cost),
		"coupon_id" => stripslashes($products->coupon_id),
		"coupon_percentage" => stripslashes($products->coupon_percentage),
		"price" => stripslashes($products->price),
		"coupon_percentage" => stripslashes($products->coupon_percentage),
		"amount" => stripslashes($products->amount),
		"order_status" => stripslashes($products->order_status),
		"user_type" => stripslashes($products->user_type),
		"extend_processing_time" => stripslashes($products->extend_processing_time),
		"buyer_accept_dispute" => stripslashes($products->buyer_accept_dispute),
		"cancel_user_id" => stripslashes($products->cancel_user_id),
		"cancel_id" => stripslashes($products->cancel_id),
		"seller_accept_shipment" => stripslashes($products->seller_accept_shipment),
		"seller_is_view" => stripslashes($products->seller_is_view),
		"delivery_date" => stripslashes($products->delivery_date),
		"order_received_date" => stripslashes($products->order_received_date)
		);
		
		}
		
		$sql = "SELECT * FROM orders WHERE id=:id ";
		//$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $products->order_id);
		$stmt->execute();
		$orderDetails = $stmt->fetchObject();
		
		
		$sql = "SELECT * FROM users WHERE id=:id ";
		//$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $orderDetails->user_id);
		$stmt->execute();
		$userDetails = $stmt->fetchObject();
		$user_email=$userDetails->email;
		$user_phone=$userDetails->mobile_number;
		
		$sqlrating = "SELECT * FROM  ratings WHERE order_details_id=:id ";
		//$db = getConnection();
		$stmtrating = $db->prepare($sqlrating);
		$stmtrating->bindParam("id", $order_details_id);
		$stmtrating->execute();
		$rating = $stmtrating->fetchObject();
		$rate=$rating->rating;
		
		if ($orderDetails->status == "0") {
		$order_status = "Processing Order";
		}
		if ($orderDetails->status == "1") {
		$order_status = "Delivered";
		}
		if ($orderDetails->status == "2") {
		$order_status = "Completed";
		}
		$payment_method="Paypal";
		$replacement_days="";
		
		$data['order_details'] = array(
		"order_id" => stripslashes($orderDetails->id),
		"user_id" => stripslashes($orderDetails->user_id),
		"user_email" => stripslashes($user_email),
		"user_phone" => stripslashes($user_phone),
		"store_id" => stripslashes($orderDetails->store_id),
		"store_woner_id" => stripslashes($orderDetails->store_woner_id),
		"total_amount" => stripslashes($orderDetails->total_amount),
		"order_date" => stripslashes($orderDetails->order_date),
		"transaction_id" => stripslashes($orderDetails->transaction_id),
		"shipping_address" => stripslashes($orderDetails->shipping_address),
		"pay_key" => stripslashes($orderDetails->pay_key),
		"payment_date" => stripslashes($orderUserdetails->payment_date),
		"payment_method" => stripslashes($payment_method),
		"replacement_days" => stripslashes($replacement_days),
		"rate" => stripslashes($rate),
		"notes" => stripslashes($orderUserdetails->notes),
		"allproducts" => $allproducts);
		
		
		$data['Ack'] = 1;
		$data['msg'] = 'Records Found';
		} else {
		$data['order_details'] = '';
		$data['Ack'] = 2;
		$data['msg'] = 'No Records Found';
		}
		} catch (PDOException $e) {
        $data['order_details'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
	
/*	echo '<pre>';
	print_r($data);
	echo '</pre>';*/
    echo json_encode($data);
    exit;
}

function orderemail() {
    $data = array();

	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	$order_id= $body['order_id'];
	//$store_id = $body['store_id'];
	//$price = $body['price'];

    try {
        $db = getConnection();
       
       // GET ORDER DETAILS FOR THE SUCCESS MAILS		
		
		$sql = "SELECT * FROM orders WHERE id=:id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $order_id);
		$stmt->execute();
		$count = $stmt->rowCount();
		$getOrderData = $stmt->fetchObject();
		
		$sql = "SELECT * FROM `users` WHERE id=:id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $getOrderData->user_id);
		$stmt->execute();
		$getUserDetails = $stmt->fetchObject();
		$email=$getUserDetails->email;
		
		$sql = "SELECT * FROM order_details where order_id=:order_id";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("order_id",  $order_id);
		$stmt->execute();
		$getOrderdetail = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
		
		$subject = "TWOP.com - Order " . $getOrderData->transaction_id;
		$TemplateMessage = '';
		//$TemplateMessage.="<img src='http://freshqatar.com/images/logo-new.png' /><br>";
		$TemplateMessage.= "<br>Thank you for your shopping at twop.com using our apps!<br>";
		
		
		$TemplateMessage.="<h3>Order details For #" .$getOrderData->transaction_id . "</h3>";
		
		
		$TemplateMessage.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='table table-listing'>
		<tr>
		<td><ul>
		<li style='list-style:none; background-color:#009900;margin-bottom:6px; color:#ffffff'><b>Customer Details</b></li>
		<li style='list-style:none;'><span>Customer Name :</span>" . $getUserDetails->first_name . "&nbsp;" . $getUserDetails->last_name . "</li>
		<li style='list-style:none;'><span>Email :</span>" . $getUserDetails->email . "</li>
		<li style='list-style:none;'><span>Contact No :</span>" . $getUserDetails->mobile_number . "</li>
		<li style='list-style:none;'>&nbsp;</li>
		</ul></td>
		
		<td><ul>
		<li style='list-style:none; background-color:#009900;margin-bottom:6px; color:#ffffff'><b>Payment Details</b></li>
		<li style='list-style:none;'><span>Payment Type :</span>Paypal</li>
		<li style='list-style:none;'><span>Transaction ID :</span>" . $getOrderData->transaction_id . "</li>
		<li style='list-style:none;'><span>Amount :</span>" . $getOrderData->total_amount . " QR</li>
		<li style='list-style:none;'><span>Payment Date : </span>" . $getOrderData->payment_date . "</li>";
		
		
		
		
		
		$TemplateMessage.=" <li style='list-style:none;'><span>Customer Notes : </span>" .  $getOrderData->notes . "</li>";
		
		
		$TemplateMessage.="
		</ul></td>
		</tr>
		</table>";
		
		
		$TemplateMessage.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='table table-listing'>
		<tr>
		<th style='color:#FFFFFF; background-color:#009900;'>
		Item Name
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		Image
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		QTY
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		Price
		</th>
		<th style='color:#FFFFFF; background-color:#009900'>
		Total
		</th>
		</tr>";
		
		
		$mailprice = 0;
		//print_r($getOrderdetail);
		//exit;
		foreach ($getOrderdetail as $resultOrderDetails) {
		
		
		$sql = "SELECT * FROM `products` WHERE id=:id ";
		$db = getConnection();
		$stmt = $db->prepare($sql);
		$stmt->bindParam("id", $resultOrderDetails['product_id']);
		$stmt->execute();
		$getProductDetails = $stmt->fetchObject();
		
		$productImage = "select * FROM product_images WHERE `product_id`='" . $getProductDetails->id . "' limit 1";
	$stmtProductImage = $db->query($productImage);
	$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
	
	$isImageExists = $stmtProductImage->rowCount();
	if ($isImageExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productImages as $img_products) {
	//echo '<pre>';
	//print_r($img_products);
	$productImagesData=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
	}
	}
		
		/*if ($getProductDetails->img == '') {
		$imgage = 'upload/no.png';
		} else {
		$imgage = 'app/webroot/product_images'.$getProductDetails->img;
		}*/
		
		
		
		$TemplateMessage.="<tr>
		<td>
		" . $getProductDetails->name . "
		</td>
		<td>
		<img src=$productImagesData width='100' height='100'  border='0' align='center' alt='' />
		</td>
		<td>
		" . $resultOrderDetails['quantity'] . "
		</td>
		<td>
		" . $resultOrderDetails['price'] . "
		</td>
		<td>
		" . $total = $resultOrderDetails['amount'] .
		" QR</td>
		
		</tr>";
		$tpc = ($resultOrderDetails['quantity']) * ($getProductDetails->regular_price);
		$mailprice = $tpc + $mailprice;
		}
		
		$TemplateMessage.="</table>";
		

	// MAKING CART EMPTY


        $db = null;
		$to = $email;
		
		// $subject = "freshqatar.com-order confirmation";
		// $TemplateMessage = "Hi #".$orderid."<br/>Your order submited sucessfully from our app at freshqatar.com!<br />";
		// $TemplateMessage .= "Thanks,<br />";
		//  $TemplateMessage .= "freshqatar.com<br />";
		
		
		
		$header = "From:info@twop.com \r\n";
		// $header .= "Cc:nits.soumen.com \r\n";
		$header .= "MIME-Version: 1.0\r\n";
		$header .= "Content-type: text/html\r\n";
		
		$retval = mail($to, $subject, $TemplateMessage, $header);
		$data['Ack'] = 1;
        //echo json_encode($user);
    } catch (PDOException $e) {
	
      // print_r($e);
       // exit();
        $data['last_id'] = '';
        $data['msg'] = 'Error!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}



function buynow() {

    $data = array();
	$productImagesData = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$prd_id = $body['prd_id'];
	$quantity = $body['quantity'];
	$soldprice_buy = $body['soldprice_buy'];
	

    try {

        $sql = "SELECT * FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("prd_id", $prd_id);
        $stmt->execute();
        $product = $stmt->fetchObject();
		

        $count = $stmt->rowCount();
        if ($count == 0) {
		

		$sqlProductDetails = "SELECT * FROM products WHERE id=:id ";
		$stmtProduct = $db->prepare($sqlProductDetails);
		$stmtProduct->bindParam("id", $prd_id);
		$stmtProduct->execute();
		$getProductdetails = $stmtProduct->fetchObject();
			
        //print_r($getProductdetails);
    
		$productImage = "select * FROM product_images WHERE `product_id`='" . $prd_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		$productImages='';
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as  $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		//if($key==0){
		$productImages=$img_products->name;
		//}
		break;
		}
		}


			

            $sql = "INSERT INTO temp_carts (user_id, shop_id, prd_id, name, image, price, quantity, shipping_address, shipping_time, processing_time, product_woner_id, pay_amt, cdate) VALUES (:user_id, :shop_id, :prd_id, :name, :image, :price, :quantity, :shipping_address, :shipping_time, :processing_time, :product_woner_id, :pay_amt, :cdate)";
          //  $db = getConnection();
            $stmtCartInsert = $db->prepare($sql);
            $stmtCartInsert->bindParam("user_id", $user_id);
            $stmtCartInsert->bindParam("shop_id", $getProductdetails->shop_id);
			$stmtCartInsert->bindParam("prd_id", $prd_id);
			$stmtCartInsert->bindParam("name", $getProductdetails->name);
			$stmtCartInsert->bindParam("image", $productImages);
			$stmtCartInsert->bindParam("price", $soldprice_buy);
			$stmtCartInsert->bindParam("quantity", $quantity);
			$stmtCartInsert->bindParam("shipping_address", $getProductdetails ->shipping_time);
			$stmtCartInsert->bindParam("shipping_time", $getProductdetails ->shipping_time);
			$stmtCartInsert->bindParam("processing_time",$getProductdetails->processing_time);
			$stmtCartInsert->bindParam("product_woner_id", $getProductdetails ->user_id);
			$stmtCartInsert->bindParam("pay_amt", $soldprice_buy);
			$stmtCartInsert->bindParam("cdate", date('Y-m-d H:i:s'));
            $stmtCartInsert->execute();
			$sql1 = "DELETE FROM wishlists WHERE user_id=:user_id AND product_id=:prd_id ";
                //$db = getConnection();
                $stmt1 = $db->prepare($sql1);
                $stmt1->bindParam("user_id", $user_id);
                $stmt1->bindParam("prd_id", $prd_id);
                $stmt1->execute();
            $data['last_id'] = $db->lastInsertId();
            $data['Ack'] = '1';
            $data['msg'] = 'Product Added Successfully ';

        } else {

            if ($quantity == 0) {
                $sql = "DELETE FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id ";
                //$db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("prd_id", $prd_id);
                $stmt->execute();
                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Cart Updated';
            } else {
                $status = 0;
                $sql = "UPDATE temp_carts SET quantity=:quantity WHERE user_id=:user_id AND prd_id=:prd_id";
                $db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("prd_id", $prd_id);
                $stmt->bindParam("quantity", $quantity);
                $stmt->execute();

                $data['last_id'] = '';
                $data['Ack'] = '1';
                $data['msg'] = 'Product Updated Successfully';
            }
        }
		
		
		 $data['user_id'] = $user_id;

			// GET CART DETAILS 
			// ============================================================================
			$sqlcart = "SELECT * FROM temp_carts WHERE user_id=:user_id AND prd_id=:prd_id";
			//  $db = getConnection();
			$stmtcart = $db->prepare($sqlcart);
			$stmtcart->bindParam("user_id", $user_id);
			$stmtcart->bindParam("prd_id", $prd_id);
			$stmtcart->execute();
			$getCartProducts = $stmtcart->fetchAll(PDO::FETCH_OBJ);
			
			$count = $stmtcart->rowCount();
			if ($count > 0) {
			$totalCartAmount=0;
			foreach ($getCartProducts as $cartProducts) {
			
			
			$totalCartAmount=$totalCartAmount+($cartProducts->pay_amt*$cartProducts->quantity);	
			
			
			$allproducts[] = array(
			"user_id" => stripslashes($cartProducts->user_id),
			"shop_id" => stripslashes($cartProducts->shop_id),
			"prd_id" => stripslashes($cartProducts->prd_id),
			"name" => stripslashes($cartProducts->name),
			"price" => stripslashes($cartProducts->price),
			"quantity" => stripslashes($cartProducts->quantity),
			"shipping_address" => stripslashes($cartProducts->shipping_address),
			"shipping_time" => stripslashes($cartProducts->shipping_time),
			"processing_time" => stripslashes($cartProducts->processing_time),
			"product_woner_id" => stripslashes($cartProducts->product_woner_id),
			"pay_amt" => stripslashes($cartProducts->pay_amt),
			"image" => SITE_URL . $cartProducts->image,
			"cdate" => stripslashes($cartProducts->cdate));
			
			}
			
			
			// GET CART TOTAL AMOUNT
			
/*			$sqlCartTotal = "SELECT CAST(SUM(pay_amt) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "'";
			$stmtCartTotal = $db->prepare($sqlCartTotal);
			$stmtCartTotal->execute();
			$getCartTotal = $stmtCartTotal->fetchObject();	
			$cartElementCount = $stmtCartTotal->rowCount();
			if($cartElementCount>0){
			$data['all_amount'] = $getCartTotal->total;	
			}
			else{
			$data['all_amount'] = 0;	
			}*/
			
			$data['all_amount'] = $totalCartAmount;
			// GET CART TOTAL NUMBER
			
			$sqlCartTotalQuantity = "SELECT CAST(SUM(quantity) AS SIGNED) as total FROM temp_carts WHERE `user_id`='" . $user_id . "' and `prd_id`='".$prd_id."'";
			$stmtCartTotalQuantity = $db->prepare($sqlCartTotalQuantity);
			$stmtCartTotalQuantity->execute();
			$getCartTotalQuantity = $stmtCartTotalQuantity->fetchObject();	
			$cartElementCountQuantity = $stmtCartTotalQuantity->rowCount();
			if($cartElementCountQuantity>0){
			$data['cart_quantity'] = $getCartTotalQuantity->total;	
			}
			else{
			$data['cart_quantity'] = 0;	
			}				
			
			
			$data['all_cart_items'] = $allproducts;
			
			$sqlAdminPercentage = "SELECT * FROM site_settings WHERE id='1'";
	$stmtAdminPercentage = $db->prepare($sqlAdminPercentage);
	$stmtAdminPercentage->execute();
	$getAdminPercentage = $stmtAdminPercentage->fetchObject();

	$data['admin_percentage'] = $getAdminPercentage->admin_percentage;
	$data['admin_paypal_email'] = $getAdminPercentage->paypal_email;
	$data['admin_paypal_app_id'] = $getAdminPercentage->paypal_app_id;
	$data['admin_paypal_api_username'] = $getAdminPercentage->paypal_api_username;
	$data['admin_paypal_api_password'] = $getAdminPercentage->paypal_api_password;
	$data['admin_paypal_api_signature'] = $getAdminPercentage->paypal_api_signature;
	
	
	$sqlStoreOwnerDetails = "SELECT  * FROM users WHERE `id`='" . $store_owner . "'";
	$stmtStoreOwnerDetails = $db->prepare($sqlStoreOwnerDetails);
	$stmtStoreOwnerDetails->execute();
	$getStoreOwnerDetails = $stmtStoreOwnerDetails->fetchObject();	
	$paypal_business_email =$getStoreOwnerDetails->paypal_business_email;	
	
	$data['shop_paypal_email'] = $paypal_business_email;
	
	$data['Ack'] = 1;
			
			
			
			

        } else {

            $data['all_cart_items'] = '';
			$data['all_amount'] = 0;	
			$data['cart_quantity'] = 0;	
            $data['Ack'] = 0;
        }
		
		



        $db = null;
        //echo json_encode($user);
    } catch (PDOException $e) {
	//print_r($e);
        //error_log($e->getMessage(), 3, '/var/tmp/php.log');
        $data['last_id'] = '';
        $data['Ack'] = '0';
        $data['msg'] = 'There are some Error';
    }
    echo json_encode($data);
	exit;
}

function mybuyerinbox() { 
    $data = array();
    
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$order_id=$body['order_id'];
	$name=$body['name'];
			

	
	
    try {
	     
	    
  
		$sql = "SELECT MAX(`id`) as ct FROM comments WHERE to_user_id=:user_id and buyer_is_delete=0 group by thread_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getmessages = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
       
	        //print_r($getmessages);
			//exit;
	   
	        
            foreach ($getmessages as $messages) {
			   $commnet_id[]= $messages->ct;
			}
		
			
			$imp = implode(',',array_unique($commnet_id));
			
			if($imp!='')
			{
			  $imp = $imp;
			}
			else
			{
			 $imp = "'"."'";
			}
			
			if($name!='')
			{
			$sql2="select * from `users` where first_name LIKE '%".$name."%' or last_name LIKE '%".$name."%'";
			$stmtuserDetailss = $db->query($sql2);
            $getuser = $stmtuserDetailss->fetchAll(PDO::FETCH_OBJ);
			foreach ($getuser as $userscom)
			{
			$u_id[]=$userscom->id;
			}
			$impp = implode(',',array_unique($u_id));
			}
			
			if($impp!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `user_id` in($impp) order by id DESC";
			}
			elseif($order_id!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `order_id`='".$order_id."' order by id DESC";
			}
			else
			{
			$sql1 = "SELECT * from comments WHERE id IN($imp) order by id DESC";
			}
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("user_id", $user_id);
            $stmt1->execute();
            $getmessages_all = $stmt1->fetchAll(PDO::FETCH_OBJ);
			
				if($getmessages_all)
			{
			
			
			//print_r($getmessages_all);
			//exit;
             foreach ($getmessages_all as $messages) {
			 
			 $userDetails = "select * FROM users WHERE `id`='" .$messages->user_id. "'";
			$stmtuserDetails = $db->query($userDetails);
			$userData = $stmtuserDetails->fetchObject();
			$full_name=$userData->first_name.' '.$userData->last_name;
			 
			 
			 
			 
			 
			  $allmessages[] = array(
                    "message_id" => stripslashes($messages->id),
					 "from_id" => $messages->user_id,
					  "to_id" => stripslashes($user_id),
                    "from_name" => stripslashes($full_name),
                    "subject" => stripslashes(strip_tags($messages->subject)),
					 "comment" => stripslashes(strip_tags($messages->comments)),
					  "comment_type" => stripslashes(strip_tags($messages->comment_type)),
					    "order_id" => stripslashes($messages->order_id),
						 "order_details_id" => stripslashes($messages->order_details_id),
						  "thread_id" => stripslashes($messages->thread_id),
						   "buyer_is_flag" => stripslashes($messages->buyer_is_flag),
					      "cdate" => stripslashes($messages->cdate));
			 
			 }
			 $data['all_messages'] = $allmessages;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
			}
			else
			{
			$data['all_messages'] = array();
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
			}
		
			}
         catch (PDOException $e) {
	      print_r($e);
        $data['all_messages'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}

function mysellerinbox() { 
    $data = array();
    
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$order_id=$body['order_id'];
	$name=$body['name'];
			

	
	
    try {
	     
	    
  
		$sql = "SELECT MAX(`id`) as ct FROM comments WHERE to_user_id=:user_id and seller_is_delete=0 group by thread_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getmessages = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
       
	        //print_r($getmessages);
			//exit;
	   
	        
            foreach ($getmessages as $messages) {
			   $commnet_id[]= $messages->ct;
			}
		
			
			$imp = implode(',',array_unique($commnet_id));
			
			if($imp!='')
			{
			  $imp = $imp;
			}
			else
			{
			 $imp = "'"."'";
			}
			
			if($name!='')
			{
			$sql2="select * from `users` where first_name LIKE '%".$name."%' or last_name LIKE '%".$name."%'";
			$stmtuserDetailss = $db->query($sql2);
            $getuser = $stmtuserDetailss->fetchAll(PDO::FETCH_OBJ);
			foreach ($getuser as $userscom)
			{
			$u_id[]=$userscom->id;
			}
			$impp = implode(',',array_unique($u_id));
			}
			
			if($impp!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `user_id` in($impp) order by id DESC";
			}
			elseif($order_id!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `order_id`='".$order_id."' order by id DESC";
			}
			else
			{
			$sql1 = "SELECT * from comments WHERE id IN($imp) order by id DESC";
			}
			
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("user_id", $user_id);
            $stmt1->execute();
            $getmessages_all = $stmt1->fetchAll(PDO::FETCH_OBJ);
			
			if($getmessages_all)
			{
			
			
			//print_r($getmessages_all);
			//exit;
             foreach ($getmessages_all as $messages) {
			 
			 $userDetails = "select * FROM users WHERE `id`='" .$messages->user_id. "'";
			$stmtuserDetails = $db->query($userDetails);
			$userData = $stmtuserDetails->fetchObject();
			$full_name=$userData->first_name.' '.$userData->last_name;
			 
			 
			 
			 
			 
			  $allmessages[] = array(
                    "message_id" => stripslashes($messages->id),
					 "from_id" => $messages->user_id,
					  "to_id" => stripslashes($user_id),
                    "from_name" => stripslashes($full_name),
                    "subject" => stripslashes(strip_tags($messages->subject)),
					 "comment" => stripslashes(strip_tags($messages->comments)),
					  "comment_type" => stripslashes(strip_tags($messages->comment_type)),
					    "order_id" => stripslashes($messages->order_id),
						 "order_details_id" => stripslashes($messages->order_details_id),
						  "thread_id" => stripslashes($messages->thread_id),
						   "seller_is_flag" => stripslashes($messages->seller_is_flag),
					      "cdate" => stripslashes($messages->cdate));
			 
			 }
			 $data['all_messages'] = $allmessages;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
			}
			else
			{
			$data['all_messages'] = array();
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
			}
		
		
            
			}
         catch (PDOException $e) {
	      print_r($e);
        $data['all_messages'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}




function mybuyersent() { 
    $data = array();
    
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
    $is_notification=0;
	$buyer_is_delete=0;
	
	
    try {
	     
        $sql = "SELECT * FROM comments WHERE user_id=:user_id  and is_notification=:is_notification and buyer_is_delete=:buyer_is_delete ORDER BY id DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("is_notification", $is_notification);
		$stmt->bindParam("buyer_is_delete", $buyer_is_delete);
        $stmt->execute();
        $getmessages = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getmessages as $messages) {

			$userDetails = "select * FROM users WHERE `id`='" . $messages->to_user_id . "'";
			$stmtuserDetails = $db->query($userDetails);
			$userData = $stmtuserDetails->fetchObject();
			$full_name=$userData->first_name.' '.$userData->last_name;
			
			$favDetails = "select * FROM message_favorite WHERE `user_id`='" . $user_id. "' and `message_id`='".$messages->id."'";
			$stmtfavDetails = $db->query($favDetails);
			 $stmtfavDetails ->execute();
			$favData = $stmtfavDetails->fetchObject();
			 $count3 = $stmtfavDetails->rowCount();
			 if($count3>0)
			 {
			 $is_favorite=1;
			 }
			 else
			 {
			 $is_favorite=0;
			 
			 }
			$is_set=0;
			$allmessages[] = array(
                    "message_id" => stripslashes($messages->id),
					 "from_id" => stripslashes($user_id),
					  "to_id" => stripslashes($userData->id),
                    "to_name" => stripslashes($full_name),
                    "subject" => stripslashes(strip_tags($messages->subject)),
					 "comment" => stripslashes(strip_tags($messages->comments)),
					  "comment_type" => stripslashes(strip_tags($messages->comment_type)),
					    "order_id" => stripslashes($messages->order_id),
						 "order_details_id" => stripslashes($messages->order_details_id),
						  "thread_id" => stripslashes($messages->thread_id),
					      "cdate" => stripslashes($messages->cdate));
					
					
					
            }
            $data['all_messages'] = $allmessages;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
        } else {
            $data['all_messages'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
        }
    } catch (PDOException $e) {
	print_r($e);
        $data['all_messages'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}

function mysellersent() { 
    $data = array();
    
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
    $is_notification=0;
	$seller_is_delete=0;
	
	
    try {
	     
        $sql = "SELECT * FROM comments WHERE user_id=:user_id  and is_notification=:is_notification and seller_is_delete=:seller_is_delete ORDER BY id DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("is_notification", $is_notification);
		$stmt->bindParam("seller_is_delete", $seller_is_delete);
        $stmt->execute();
        $getmessages = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getmessages as $messages) {

			$userDetails = "select * FROM users WHERE `id`='" . $messages->to_user_id . "'";
			$stmtuserDetails = $db->query($userDetails);
			$userData = $stmtuserDetails->fetchObject();
			$full_name=$userData->first_name.' '.$userData->last_name;
			
			$favDetails = "select * FROM message_favorite WHERE `user_id`='" . $user_id. "' and `message_id`='".$messages->id."'";
			$stmtfavDetails = $db->query($favDetails);
			 $stmtfavDetails ->execute();
			$favData = $stmtfavDetails->fetchObject();
			 $count3 = $stmtfavDetails->rowCount();
			 if($count3>0)
			 {
			 $is_favorite=1;
			 }
			 else
			 {
			 $is_favorite=0;
			 
			 }
			$is_set=0;
			$allmessages[] = array(
                    "message_id" => stripslashes($messages->id),
					 "from_id" => stripslashes($user_id),
					  "to_id" => stripslashes($userData->id),
                    "to_name" => stripslashes($full_name),
                    "subject" => stripslashes(strip_tags($messages->subject)),
					 "comment" => stripslashes(strip_tags($messages->comments)),
					  "comment_type" => stripslashes(strip_tags($messages->comment_type)),
					    "order_id" => stripslashes($messages->order_id),
						 "order_details_id" => stripslashes($messages->order_details_id),
						  "thread_id" => stripslashes($messages->thread_id),
					      "cdate" => stripslashes($messages->cdate));
					
					
					
            }
            $data['all_messages'] = $allmessages;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
        } else {
            $data['all_messages'] = '';
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
        }
    } catch (PDOException $e) {
	print_r($e);
        $data['all_messages'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}

function mybuyerfolder() { 
    $data = array();
    
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$order_id=$body['order_id'];
	$name=$body['name'];
			

	
	
    try {
	     
	    
  
		$sql = "SELECT MAX(`id`) as ct FROM comments WHERE to_user_id=:user_id and buyer_is_delete=0 and buyer_is_flag=1 group by thread_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getmessages = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
       
	        //print_r($getmessages);
			//exit;
	   
	        
            foreach ($getmessages as $messages) {
			   $commnet_id[]= $messages->ct;
			}
		
			
			$imp = implode(',',array_unique($commnet_id));
			
			if($imp!='')
			{
			  $imp = $imp;
			}
			else
			{
			 $imp = "'"."'";
			}
			
			if($name!='')
			{
			$sql2="select * from `users` where first_name LIKE '%".$name."%' or last_name LIKE '%".$name."%'";
			$stmtuserDetailss = $db->query($sql2);
            $getuser = $stmtuserDetailss->fetchAll(PDO::FETCH_OBJ);
			foreach ($getuser as $userscom)
			{
			$u_id[]=$userscom->id;
			}
			$impp = implode(',',array_unique($u_id));
			}
			
			if($impp!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `user_id` in($impp) order by id DESC";
			}
			elseif($order_id!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `order_id`='".$order_id."' order by id DESC";
			}
			else
			{
			$sql1 = "SELECT * from comments WHERE id IN($imp) order by id DESC";
			}
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("user_id", $user_id);
            $stmt1->execute();
            $getmessages_all = $stmt1->fetchAll(PDO::FETCH_OBJ);
			
				if($getmessages_all)
			{
			
			
			//print_r($getmessages_all);
			//exit;
             foreach ($getmessages_all as $messages) {
			 
			 $userDetails = "select * FROM users WHERE `id`='" .$messages->user_id. "'";
			$stmtuserDetails = $db->query($userDetails);
			$userData = $stmtuserDetails->fetchObject();
			$full_name=$userData->first_name.' '.$userData->last_name;
			 
			 
			 
			 
			 
			  $allmessages[] = array(
                    "message_id" => stripslashes($messages->id),
					 "from_id" => $messages->user_id,
					  "to_id" => stripslashes($user_id),
                    "from_name" => stripslashes($full_name),
                    "subject" => stripslashes(strip_tags($messages->subject)),
					 "comment" => stripslashes(strip_tags($messages->comments)),
					  "comment_type" => stripslashes(strip_tags($messages->comment_type)),
					    "order_id" => stripslashes($messages->order_id),
						 "order_details_id" => stripslashes($messages->order_details_id),
						  "thread_id" => stripslashes($messages->thread_id),
						   "buyer_is_flag" => stripslashes($messages->buyer_is_flag),
					      "cdate" => stripslashes($messages->cdate));
			 
			 }
			 $data['all_messages'] = $allmessages;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
			}
			else
			{
			$data['all_messages'] = array();
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
			}
		
			}
         catch (PDOException $e) {
	      print_r($e);
        $data['all_messages'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}


function mysellerfolder() { 
    $data = array();
    
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$order_id=$body['order_id'];
	$name=$body['name'];
			

	
	
    try {
	     
	    
  
		$sql = "SELECT MAX(`id`) as ct FROM comments WHERE to_user_id=:user_id and seller_is_delete=0 and seller_is_flag=1 group by thread_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getmessages = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
       
	        //print_r($getmessages);
			//exit;
	   
	        
            foreach ($getmessages as $messages) {
			   $commnet_id[]= $messages->ct;
			}
		
			
			$imp = implode(',',array_unique($commnet_id));
			
			if($imp!='')
			{
			  $imp = $imp;
			}
			else
			{
			 $imp = "'"."'";
			}
			
			if($name!='')
			{
			$sql2="select * from `users` where first_name LIKE '%".$name."%' or last_name LIKE '%".$name."%'";
			$stmtuserDetailss = $db->query($sql2);
            $getuser = $stmtuserDetailss->fetchAll(PDO::FETCH_OBJ);
			foreach ($getuser as $userscom)
			{
			$u_id[]=$userscom->id;
			}
			$impp = implode(',',array_unique($u_id));
			}
			
			if($impp!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `user_id` in($impp) order by id DESC";
			}
			elseif($order_id!='')
			{
			$sql1="SELECT * from comments WHERE id IN($imp) and `order_id`='".$order_id."' order by id DESC";
			}
			else
			{
			$sql1 = "SELECT * from comments WHERE id IN($imp) order by id DESC";
			}
			
            $stmt1 = $db->prepare($sql1);
            $stmt1->bindParam("user_id", $user_id);
            $stmt1->execute();
            $getmessages_all = $stmt1->fetchAll(PDO::FETCH_OBJ);
			
			if($getmessages_all)
			{
			
			
			//print_r($getmessages_all);
			//exit;
             foreach ($getmessages_all as $messages) {
			 
			 $userDetails = "select * FROM users WHERE `id`='" .$messages->user_id. "'";
			$stmtuserDetails = $db->query($userDetails);
			$userData = $stmtuserDetails->fetchObject();
			$full_name=$userData->first_name.' '.$userData->last_name;
			 
			 
			 
			 
			 
			  $allmessages[] = array(
                    "message_id" => stripslashes($messages->id),
					 "from_id" => $messages->user_id,
					  "to_id" => stripslashes($user_id),
                    "from_name" => stripslashes($full_name),
                    "subject" => stripslashes(strip_tags($messages->subject)),
					 "comment" => stripslashes(strip_tags($messages->comments)),
					  "comment_type" => stripslashes(strip_tags($messages->comment_type)),
					    "order_id" => stripslashes($messages->order_id),
						 "order_details_id" => stripslashes($messages->order_details_id),
						  "thread_id" => stripslashes($messages->thread_id),
					      "cdate" => stripslashes($messages->cdate));
			 
			 }
			 $data['all_messages'] = $allmessages;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
			}
			else
			{
			$data['all_messages'] = array();
            $data['Ack'] = 0;
            $data['msg'] = 'No Records Found';
			}
		
		
            
			}
         catch (PDOException $e) {
	      print_r($e);
        $data['all_messages'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}


function message_favorite() {
    $data = array();

	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$message_id = $body['message_id'];
	//$store_id = $body['store_id'];
	//$price = $body['price'];
	

    $sql = "SELECT * FROM   message_favorite WHERE user_id=:user_id AND message_id=:message_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("message_id", $message_id);
        $stmt->execute();
        $isExistsWishlist = $stmt->fetchObject();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $sql = "INSERT INTO message_favorite (user_id, message_id,date) VALUES (:user_id, :message_id,:date)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("message_id", $message_id);
			$stmt->bindParam("date", gmdate('Y-m-d H:i:s'));
            $stmt->execute();
            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Favorite Message';
            $db = null;
        } else {
            $data['last_id'] = '';
            $data['Ack'] = '2';
            $data['msg'] = 'Already Added';
            $db = null;
        }
        //echo json_encode($user);
    } catch (PDOException $e) {
	
      // print_r($e);
       // exit();
        $data['last_id'] = '';
        $data['msg'] = 'Error!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}
	function deletebuyerinbox() {
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$thread_id = $body['thread_id'];

	
	
	$sql = "UPDATE comments SET buyer_is_delete=1  WHERE thread_id IN($thread_id)";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
    $stmt->execute();
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Message Removed Successfully';
	} catch (PDOException $e) {
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}
function deletesellerinbox() {
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$thread_id = $body['thread_id'];

	
	
	$sql = "UPDATE comments SET seller_is_delete=1  WHERE thread_id IN($thread_id)";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
    $stmt->execute();
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Message Removed Successfully';
	} catch (PDOException $e) {
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}
function messagedetails() { 
    $data = array();
    
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$thread_id = $body['thread_id'];

	
	
    try {
	     
        $sql = "SELECT * FROM comments WHERE thread_id=:thread_id ORDER BY id DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("thread_id", $thread_id);
        $stmt->execute();
        $getmessages = $stmt->fetchAll(PDO::FETCH_OBJ);
		
		

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getmessages as $messages) {

			$userDetails = "select * FROM users WHERE `id`='" . $messages->user_id . "'";
			$stmtuserDetails = $db->query($userDetails);
			$userData = $stmtuserDetails->fetchObject();
			$full_name=$userData->first_name.' '.$userData->last_name;
			
			
			$userDetails1 = "select * FROM users WHERE `id`='" . $messages->to_user_id . "'";
			$stmtuserDetails1 = $db->query($userDetails1);
			$userData1 = $stmtuserDetails1->fetchObject();
			$full_name1=$userData1->first_name.' '.$userData1->last_name;
			
			/*$favDetails = "select * FROM message_favorite WHERE `user_id`='" . $user_id. "' and `message_id`='".$messages->id."'";
			$stmtfavDetails = $db->query($favDetails);
			 $stmtfavDetails ->execute();
			$favData = $stmtfavDetails->fetchObject();
			 $count3 = $stmtfavDetails->rowCount();
			 if($count3>0)
			 {
			 $is_favorite=1;
			 }
			 else
			 {
			 $is_favorite=0;
			 
			 }*/
		 $sql6 = "UPDATE comments SET is_read=1  WHERE `id`='".$messages->id."' ";
	
		$stmt6 = $db->prepare($sql6);
        $stmt6->execute();
              
			  if ($messages->file_name != '') {
                    $filename =SITE_URL . 'app/webroot/message_img/' . $messages->file_name;
                } else {
                    $filename = '';
                }
				
				if($messages->comments!='' && $messages->file_name=='')
		{
		$type=1;
		}
		elseif($messages->file_name!= '' && $messages->comments!='' )
		{
		$type=2;
		}
		
		if($userData->profile_image!=''){
          $profile_image=SITE_URL.'app/webroot/user_images/'.$userData->profile_image;
                      }
                  else{
                $profile_image='';
                      }

			
			$allmessages[] = array(
                    "message_id" => stripslashes($messages->id),
					 "from_id" => stripslashes($userData->id),
					  "to_id" => stripslashes($userData1->id),
                    "from_name" => stripslashes($full_name),
					  "to_name" => stripslashes($full_name1),
					   "from_image" => stripslashes($profile_image),
                    "subject" => stripslashes(strip_tags($messages->subject)),
					 "comment" => stripslashes(strip_tags($messages->comments)),
					 "file_name" => stripslashes(strip_tags($filename)),
					  "comment_type" => stripslashes(strip_tags($messages->comment_type)),
					    "order_id" => stripslashes($messages->order_id),
						 "order_details_id" => stripslashes($messages->order_details_id),
						  "thread_id" => stripslashes($messages->thread_id),
						    "type" => stripslashes($type),
					      "cdate" => stripslashes($messages->cdate));
					
					
					
					
            }
            $data['all_messages'] = $allmessages;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
        } else {
            $data['all_messages'] = '';
            $data['Ack'] = 2;
            $data['msg'] = 'No Records Found';
        }
    } catch (PDOException $e) {
	print_r($e);
        $data['all_messages'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';
    }
    echo json_encode($data);
    exit;
}

function messagereply() {
    $data = array();

	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$to_user_id = $body['to_user_id'];
	$message_id = $body['message_id'];
	$comments = $body['comments'];
	//$store_id = $body['store_id'];
	//$price = $body['price'];
	

    $sql = "SELECT * FROM  comments WHERE id=:message_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("message_id", $message_id);
        $stmt->execute();
        $commentsdetails = $stmt->fetchObject();
		$user_id=$user_id;
		$store_woner_id=$commentsdetails->user_id;
		$comment_type=$commentsdetails->comment_type;
		$is_notification=$commentsdetails->is_notification;
		$orderID=$commentsdetails->order_id;
		$orderDetailsID=$commentsdetails->order_details_id;
		$thread_id=$commentsdetails->thread_id;
		 if($commentsdetails->subject!=''){
                        $str_pos = strpos($commentsdetails->subject, 'Re:');
                        if ($str_pos === false) {
                            $subject='Re: '.$commentsdetails->subject;
                        }else{
                            $subject=$commentsdetails->subject;
                        }
                    }else{
                        $subject='';
                    }
		//$subject="Re:".$commentsdetails->subject;
		$comments=$comments;
		$is_read=0;
		$folder_id=$commentsdetails->folder_id;
		$cdate= gmdate('Y-m-d H:i:s');
        $count = $stmt->rowCount();
        if ($count > 0) {
		
		
		          if ($_FILES['message_photo']['tmp_name'] != '') {
	                                  $target_path = "../app/webroot/message_img/";
	                                  $userfile_name = $_FILES['message_photo']['name'];
	                                  $userfile_tmp = $_FILES['message_photo']['tmp_name'];
	                                  $message_photo = rand(1000,99999).'_'. strtolower($userfile_name);
	                                  $img = $target_path . $message_photo;
	                                  move_uploaded_file($userfile_tmp, $img);
									  }
									  else
									  {
									  $message_photo='';
									  }
		     
            $insertInventoryDetails = "insert into comments (user_id, to_user_id, comment_type , is_notification, order_id, order_details_id, thread_id, subject, comments, file_name, is_read,folder_id, cdate) values(:user_id,:to_user_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:subject,:comments,:file_name,:is_read,:folder_id,:cdate)";
		
		$stmt = $db->prepare($insertInventoryDetails);
		$stmt->bindParam("user_id", $user_id);
		$stmt->bindParam("to_user_id", $to_user_id);
		$stmt->bindParam("comment_type", $comment_type);
		$stmt->bindParam("is_notification", $is_notification);
		$stmt->bindParam("order_id", $orderID);
		$stmt->bindParam("order_details_id", $orderDetailsID);
		$stmt->bindParam("thread_id", $thread_id);
		$stmt->bindParam("subject", $subject);
		$stmt->bindParam("comments", $comments);
		$stmt->bindParam("file_name", $message_photo);
		$stmt->bindParam("is_read", $is_read);
		$stmt->bindParam("folder_id", $folder_id);
		$stmt->bindParam("cdate", $cdate);
		$stmt->execute();	
		
            $lastID = $db->lastInsertId();
            $data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'Message Inserted';
            $db = null;
        } else {
            $data['last_id'] = '';
            $data['Ack'] = '2';
            $data['msg'] = 'Already Added';
            $db = null;
        }
        //echo json_encode($user);
    } catch (PDOException $e) {
	
      // print_r($e);
       // exit();
        $data['last_id'] = '';
        $data['msg'] = 'Error!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}
function addfeedback() {
    $data = array();

	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	$order_details_id = $body['order_details_id'];
	$user_id = $body['user_id'];
	$rate_this = $body['rate_this'];
	$product_description = $body['product_description'];
	$seller_communication = $body['seller_communication'];
	$ship_item = $body['ship_item'];
	$rating=($rate_this + $product_description +$seller_communication +$ship_item)/4;
	$date= gmdate('Y-m-d H:i:s');
	//$store_id = $body['store_id'];
	//$price = $body['price'];
	

    $sql = "SELECT * FROM ratings WHERE user_id=:user_id AND order_details_id=:order_details_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("order_details_id", $order_details_id);
        $stmt->execute();
        $isExistsWishlist = $stmt->fetchObject();
		$count = $stmt->rowCount();
		
		$orderDetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		$stmtorderDetails = $db->query($orderDetails);
		$orderData = $stmtorderDetails->fetchObject();
		$rated_to=$orderData->user_id;
		$product_id=$orderData->product_id;
		$shop_id=$orderData->shop_id;
		$order_id=$orderData->order_id;
		
		
		
        if ($count == 0) {
            $sql2 = "INSERT INTO  ratings (product_id,shop_id,order_details_id,order_id,rated_to,user_id,rate_this,product_description,seller_communication,ship_item,rating,date_time) VALUES (:product_id, :shop_id,:order_details_id,:order_id,:rated_to,:user_id,:rate_this,:product_description,:seller_communication,:ship_item,:rating,:date)";

            $stmt2 = $db->prepare($sql2);
          
            $stmt2->bindParam("product_id", $product_id);
			$stmt2->bindParam("shop_id", $shop_id);
			$stmt2->bindParam("order_details_id", $order_details_id);
			$stmt2->bindParam("order_id", $order_id);
			$stmt2->bindParam("rated_to", $rated_to);
			$stmt2->bindParam("user_id", $user_id);
			$stmt2->bindParam("rate_this", $rate_this);
			$stmt2->bindParam("product_description", $product_description);
			$stmt2->bindParam("seller_communication", $seller_communication);
			$stmt2->bindParam("ship_item", $ship_item);
			$stmt2->bindParam("rating", $rating);
			$stmt2->bindParam("date",$date);
            $stmt2->execute();
            $lastID = $db->lastInsertId();
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $rate_count=$productData->rate_count +1;
			
			$sql1 = "UPDATE products SET total_rate=:total_rate,rate_count=:rate_count  WHERE id=:id";
	        $stmt1 = $db->prepare($sql1);
	        $stmt1->bindParam("total_rate", $rating);
	        $stmt1->bindParam("rate_count", $rate_count);
			$stmt1->bindParam("id", $product_id);
	        $stmt1->execute();
            
			
			$data['last_id'] = $lastID;
            $data['Ack'] = '1';
            $data['msg'] = 'You Feedback Added';
            $db = null;
        } else {
            $data['last_id'] = '';
            $data['Ack'] = '2';
            $data['msg'] = 'Already Feedback Added';
            $db = null;
        }
        //echo json_encode($user);
    } catch (PDOException $e) {
	
    // print_r($e);

        $data['last_id'] = '';
        $data['msg'] = 'Error!!';
        $data['Ack'] = '0';
    }
    echo json_encode($data);
    exit;
}

	function removetemcart() {
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$temp_id= $body['temp_id'];
	
	
	
	$sql = "DELETE FROM temp_carts WHERE id=:temp_id";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("temp_id", $temp_id);
	$stmt->execute();
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Product Removed Successfully';
	} catch (PDOException $e) {
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}


  function cancelorder() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$select_reason= $body['select_reason'];
	$details= $body['details'];
	$date=gmdate('Y-m-d H:i:s');
	$order_status='C';
	$user_type=2;
	
	$sql = "INSERT INTO cancel_orders(order_details_id,user_id,select_reason,description,cdate) VALUES (:order_details_id, :user_id,:select_reason,:details,:date)";
	
	try {
	
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("order_details_id", $order_details_id);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("select_reason", $select_reason);
	$stmt->bindParam("details", $details);
	$stmt->bindParam("date", $date);
	$stmt->execute();
	$lastID = $db->lastInsertId();
	
	
	        $sql1 = "UPDATE order_details SET user_type=:user_type,cancel_user_id=:user_id,order_status=:order_status,cancel_id=:cancel_id  WHERE id=:order_details_id";
	        $stmt1 = $db->prepare($sql1);
	        $stmt1->bindParam("order_details_id", $order_details_id);
			$stmt1->bindParam("user_id", $user_id);
	        $stmt1->bindParam("user_type", $user_type);
			$stmt1->bindParam("order_status", $order_status);
			$stmt1->bindParam("cancel_id", $lastID);
	        $stmt1->execute();
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails = $db->query($orderdetails);
		    $orderData = $stmtorderDetails->fetchObject();
			$NewOrderId = $val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Product cancelled by buyer for '.$select_reason.'. Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$comments=$details.' <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=5;
			$is_notification=1;
			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :owner_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("owner_id", $owner_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("order_details_id", $order_details_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			$userDetails = "select * FROM users WHERE `id`='" . $owner_id . "'";
		    $stmtuserDetails = $db->query($userDetails);
		    $userData = $stmtuserDetails->fetchObject();
		    $user_name=$userData->first_name;
			$email=$userData->email;
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData = $stmtbuyerDetails->fetchObject();
		    $buyer_name=$buyerData->first_name.' '.$buyerData->last_name;
	        
		    $to = $email;
			
		

            $subject = $buyer_name.'Cancelled Your Product';
            $TemplateMessage = $buyer_name.'has cancelled his order on product name'.$product_name.'and order ID'.$orderData->order_id.'on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
	
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Product Cancelled';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}
function selleracceptcancel() {

	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$order_details_id= $body['order_details_id'];
	$select_reason= $body['select_reason'];
	$details= $body['details'];
	$user_id= $body['user_id'];
	$transaction_id= $body['transaction_id'];
	$seller_response=1;
	$date=gmdate('Y-m-d H:i:s');
	$order_status="C";

	$user_type=2;
	
	        $ordercancelDetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
			$db = getConnection();
		    $stmtordercancelDetails = $db->query($ordercancelDetails);
		    $ordercancelData = $stmtordercancelDetails->fetchObject();
		    $cancel_user_id=$ordercancelData->user_id;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $cancel_user_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name;
			$email=$cancelData->email;
			
	
	
	$sql = "INSERT INTO cancel_orders(order_details_id,user_id,select_reason,seller_responce,description,cancel_transcation_id,cdate) VALUES (:order_details_id, :user_id,:select_reason,:seller_response,:details,:transaction_id,:date)";
	
	try {
	
	
	$stmt = $db->prepare($sql);
	$stmt->bindParam("order_details_id", $order_details_id);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("select_reason", $select_reason);
	$stmt->bindParam("details", $details);
	$stmt->bindParam("seller_response", $seller_response);
	$stmt->bindParam("transaction_id", $transaction_id);
	$stmt->bindParam("date", $date);
	$stmt->execute();
	$lastID = $db->lastInsertId();
	
	
	$sql1 = "UPDATE order_details SET user_type=:user_type,cancel_user_id=:user_id,order_status=:order_status,cancel_id=:cancel_id  WHERE id=:order_details_id";
	        $stmt1 = $db->prepare($sql1);
	        $stmt1->bindParam("order_details_id", $order_details_id);
			$stmt1->bindParam("user_id", $user_id);
	        $stmt1->bindParam("user_type", $user_type);
			$stmt1->bindParam("order_status", $order_status);
			$stmt1->bindParam("cancel_id", $lastID);
	        $stmt1->execute();
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Seller accepted cancelled order request by buyer.Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$actual_quantity=$productData->quantity;
			$original_quantity=$order_quantity+$actual_quantity;
			
			$sql5 = "UPDATE products SET quantity=:quantity WHERE id=:product_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("quantity", $original_quantity);
			$stmt5->bindParam("product_id", $product_id);
	       
	        $stmt5->execute();
			
			$comments='Seller accepted cancelled order request by buyer <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=5;
			$is_notification=1;
			$type_inventory='+';
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			$sql6 = "INSERT INTO manage_inventories (user_id,product_id,order_id,order_details_id,type,quantity,comment,create_date,price) VALUES (:user_id, :product_id,:order_id,:order_details_id,:type,:quantity,:comments,:date,:price)";
	         $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_details_id", $order_details_id);
	        $stmt6->bindParam("user_id", $user_id);
	        $stmt6->bindParam("product_id", $product_id);
	        $stmt6->bindParam("order_id", $order_id);
			$stmt6->bindParam("comments", $comments);
			$stmt6->bindParam("quantity",$order_quantity);
			$stmt6->bindParam("type",$type_inventory);
			$stmt6->bindParam("price",$order_price);
			$stmt6->bindParam("date", $cdate);
	        $stmt6->execute();
			
	        
		    $to = $email;
			
			
			$subject = 'Seller Accepted Cancellation of Product';
            $TemplateMessage = 'Seller has cancelled his order on product name '.$product_name.'and order ID'.$orderData->order_id.'on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Seller Accepted';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}
function sellerrejectcancel() {

	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$order_details_id= $body['order_details_id'];
	$select_reason= $body['select_reason'];
	$details= $body['details'];
	$user_id= $body['user_id'];
	$seller_response=2;
	$date=gmdate('Y-m-d H:i:s');
	$order_status="S";

	$user_type=2;
	
	        $ordercancelDetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
			$db = getConnection();
		    $stmtordercancelDetails = $db->query($ordercancelDetails);
		    $ordercancelData = $stmtordercancelDetails->fetchObject();
		    $cancel_user_id=$ordercancelData->user_id;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $cancel_user_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name;
			$email=$cancelData->email;
			
	
	
	$sql = "INSERT INTO cancel_orders(order_details_id,user_id,select_reason,seller_responce,description,cdate) VALUES (:order_details_id, :user_id,:select_reason,:seller_response,:details,:date)";
	
	try {
	
	
	$stmt = $db->prepare($sql);
	$stmt->bindParam("order_details_id", $order_details_id);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("select_reason", $select_reason);
	$stmt->bindParam("details", $details);
	$stmt->bindParam("seller_response", $seller_response);
	$stmt->bindParam("date", $date);
	$stmt->execute();
	$lastID = $db->lastInsertId();
	
	
	$sql1 = "UPDATE order_details SET user_type=:user_type,cancel_user_id=:user_id,order_status=:order_status,cancel_id=:cancel_id  WHERE id=:order_details_id";
	        $stmt1 = $db->prepare($sql1);
	        $stmt1->bindParam("order_details_id", $order_details_id);
			$stmt1->bindParam("user_id", $user_id);
	        $stmt1->bindParam("user_type", $user_type);
			$stmt1->bindParam("order_status", $order_status);
			$stmt1->bindParam("cancel_id", $lastID);
	        $stmt1->execute();
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Seller rejected cancelled order request by buyer.Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$buyer_id=$orderData->user_id;
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			
			
			$comments='Seller rejected cancelled order request by buyer<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=5;
			$is_notification=1;
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
	        
		    $to = $email;
			
			
			$subject = 'Seller rejected cancelled order request by buyer';
            $TemplateMessage = 'Seller reject cancelled order request by buyer on product name '.$product_name.'and order ID'.$orderData->order_id.'on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Seller Rejected';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

  function sellercancelorder() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$select_reason= $body['select_reason'];
	$details= $body['details'];
	$date=gmdate('Y-m-d H:i:s');
	$order_status='C';
	$user_type=2;
	$seller_responce=3;
	$transaction_id=$body['transaction_id'];
	$sql = "INSERT INTO cancel_orders(order_details_id,user_id,select_reason,description,cdate,cancel_transcation_id,seller_responce) VALUES (:order_details_id, :user_id,:select_reason,:details,:date,:transaction_id,:seller_responce)";
	
	try {
	
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("order_details_id", $order_details_id);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("select_reason", $select_reason);
	$stmt->bindParam("details", $details);
	$stmt->bindParam("transaction_id", $transaction_id);
	$stmt->bindParam("seller_responce", $seller_responce);
	$stmt->bindParam("date", $date);
	$stmt->execute();
	$lastID = $db->lastInsertId();
	
	 $sql1 = "UPDATE order_details SET user_type=:user_type,cancel_user_id=:user_id,order_status=:order_status,cancel_id=:cancel_id  WHERE id=:order_details_id";
	        $stmt1 = $db->prepare($sql1);
	        $stmt1->bindParam("order_details_id", $order_details_id);
			$stmt1->bindParam("user_id", $user_id);
	        $stmt1->bindParam("user_type", $user_type);
			$stmt1->bindParam("order_status", $order_status);
			$stmt1->bindParam("cancel_id", $lastID);
	        $stmt1->execute();
			
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Product cancelled by seller.Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$actual_quantity=$productData->quantity;
			$original_quantity=$order_quantity+$actual_quantity;
			
			$sql5 = "UPDATE products SET quantity=:quantity WHERE id=:product_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("quantity", $original_quantity);
			$stmt5->bindParam("product_id", $product_id);
	       
	        $stmt5->execute();
			
			
			$comments='Product cancelled by seller<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=4;
			$is_notification=1;
			$type_inventory='-';
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $orderData->user_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name;
			$email=$cancelData->email;
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			$sql6 = "INSERT INTO manage_inventories (user_id,product_id,order_id,order_details_id,type,quantity,comment,create_date,price) VALUES (:user_id, :product_id,:order_id,:order_details_id,:type,:quantity,:comments,:date,:price)";
	         $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_details_id", $order_details_id);
	        $stmt6->bindParam("user_id", $user_id);
	        $stmt6->bindParam("product_id", $product_id);
	        $stmt6->bindParam("order_id", $order_id);
			$stmt6->bindParam("comments", $comments);
			$stmt6->bindParam("quantity",$order_quantity);
			$stmt6->bindParam("price",$order_price);
			$stmt6->bindParam("type",$type_inventory);
			$stmt6->bindParam("date", $cdate);
	        $stmt6->execute();
			
			 $to = $email;
			
			
			$subject = 'Seller Cancelled the Order';
            $TemplateMessage = 'Seller has cancelled his order on product name '.$product_name.'and order ID'.$orderData->order_id.'on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
	
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Seller Order Cancelled';
	} catch (PDOException $e) {
	//print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}
 function extendprocessingtime() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$select_reason= $body['select_reason'];
	$details= $body['details'];
	$date=gmdate('Y-m-d H:i:s');
	$order_status='C';
	$user_type=2;
	$seller_responce=3;
	$transaction_id=$body['transaction_id'];
	$time_by=$body['Timeby'];
	$extend_processing_time=1;
	$sql = "INSERT INTO extend_processing_times(order_details_id,seller_id,order_id,no_of_day,request_date) VALUES (:order_details_id,:user_id,:order_id,:Timeby,:date)";
	
	try {
	
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("order_details_id", $order_details_id);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("order_id", $order_id);
	$stmt->bindParam("Timeby", $time_by);
	$stmt->bindParam("date", $date);
	$stmt->execute();
	$lastID = $db->lastInsertId();
	
	$sql5 = "UPDATE order_details SET extend_processing_time=:extend_processing_time WHERE id=:order_details_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("extend_processing_time", $extend_processing_time);
			$stmt5->bindParam("order_details_id", $order_details_id);
			$stmt5->execute();
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Seller Extend Processing Time for.Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$actual_quantity=$productData->quantity;
			$original_quantity=$order_quantity+$actual_quantity;
			
			
			
			
			$comments='Seller extend the processing time by'.$time_by.' days of your order for delivery confirmation at the right time. <br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=8;
			$is_notification=1;
		
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $orderData->user_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name;
			$email=$cancelData->email;
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			$to = $email;
			
			
			$subject = 'Seller Extend Processing Time';
            $TemplateMessage = 'Seller extended the processing time by'.$time_by.' days of your order for delivery confirmation at the right time.'.$product_name.'and order ID'.$orderData->order_id.'on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			
    
    $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Extend Processing Time';
	} catch (PDOException $e) {
	//print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function getawaitingshipmentSeller() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$a="U";
	$b="C";
	$c="S";
	$seller_is_view=0;
	
    try {

        $sql = "SELECT * FROM order_details WHERE owner_id=:owner_id and (order_status=:a or order_status=:b or order_status=:c) and seller_is_view=:seller_is_view order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("owner_id", $user_id);
		$stmt->bindParam("a", $a);
		$stmt->bindParam("b", $b);
		$stmt->bindParam("c", $c);
		$stmt->bindParam("seller_is_view", $seller_is_view);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();	
		
		$sqlorderDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='C'";
		$stmtorderDetails = $db->prepare($sqlorderDetails);
		$stmtorderDetails->execute();
		$getorderDetails = $stmtorderDetails->fetchObject();	
        $isorderdetails = $stmtorderDetails->rowCount(); 
		$order_status=$getorderDetails->order_status;
		
		$sqlordDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='S'";
		$stmtordDetails = $db->prepare($sqlordDetails);
		$stmtordDetails->execute();
		$getordDetails = $stmtordDetails->fetchObject();	
        $isorddetails = $stmtordDetails->rowCount(); 
		
		
		
		
		$sqlorderrDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "'";
		$stmtorderrDetails = $db->prepare($sqlorderrDetails);
		$stmtorderrDetails->execute();
		$getorderrDetails = $stmtorderrDetails->fetchObject();	
        $isorderrdetails = $stmtorderrDetails->rowCount(); 
		$orderr_status=$getorderrDetails->order_status;
		$extend_processing_time=$getorderrDetails->extend_processing_time;
		$buyer_responce_processing_time=$getorderrDetails->buyer_responce_processing_time;
		$seller_accept_shipment=$getorderrDetails->seller_accept_shipment;
		
		$sqlcancelfirstDetails = "SELECT * FROM cancel_orders WHERE `order_details_id`='" . $orders->id . "' order by `id` ASC limit 1";
		$stmtcancelfirstDetails = $db->prepare($sqlcancelfirstDetails);
		$stmtcancelfirstDetails->execute();
		$getcancelfirstDetails = $stmtcancelfirstDetails->fetchObject();
		$reason=$getcancelfirstDetails->select_reason;
		
		
		$sqlcancelDetails = "SELECT * FROM cancel_orders WHERE `order_details_id`='" . $orders->id . "' order by `id` DESC limit 1";
		$stmtcancelDetails = $db->prepare($sqlcancelDetails);
		$stmtcancelDetails->execute();
		$getcancelDetails = $stmtcancelDetails->fetchObject();
		$seller_responce=$getcancelDetails->seller_responce;	
		// $iscancel = $stmtcancelDetails->rowCount(); 
		$is_response=$getcancelDetails->seller_responce;
		if($is_response==0)
		{
		$iscancel=1;
		}
		else
		{
		$iscancel=0;
		}
		if($is_response==1)
		{
		$isaccept=1;
		}
		else
		{
		$isaccept=0;
		}
		if($is_response==2)
		{
		$isreject=1;
		}
		else
		{
		$isreject=0;
		}
		if($is_response==3)
		{
		$iscancelown=1;
		}
		else
		{
		$iscancelown=0;
		}
		
	
		
		if($iscancel==1 && $isorderdetails >0)
		{
		$is_cancel_request="Yes";
		}
		else
		{
		$is_cancel_request="No";
		}
		
		if($isaccept==1 && $isorderdetails >0)
		{
		$is_accept_request="Yes";
		}
		else
		{
		$is_accept_request="No";
		}
		
		if($isreject==1 && $isorddetails >0)
		{
		$is_reject_request="Yes";
		}
		else
		{
		$is_reject_request="No";
		}
		if($iscancelown==1 && $isorderdetails >0)
		{
		$cancel_status="Yes";
		}
		else
		{
		$cancel_status="No";
		}
		
		if($extend_processing_time==1 && $buyer_responce_processing_time==0)
		{
		$extend_time_request="Yes";
		}
		else
		{
		$extend_time_request="No";
		}
		if($seller_accept_shipment==1 && $orderr_status=='S')
		{
		$add_tracking="Yes";
		}
		else
		{
		$add_tracking="No";
		}
		
		
		
		if($orderr_status=='C' && $seller_responce==0){
		$status_cancel="Order Cancelled - Waiting Action";
		}
		elseif($orderr_status=='C'  && $seller_responce==1){
		$status_cancel="You Accepted Cancelled Order from buyer";
		}
		elseif($orderr_status=='S' && $seller_responce==2)
		{
		$status_cancel="You Reject Cancelled Order from buyer";
		}
		elseif($orderr_status=='C' && $seller_responce==3)
		{
		$status_cancel="You Cancelled the Order";
		}
		elseif($seller_accept_shipment==0)
		{
        $status_cancel="Awaiting Shipment";
         if($extend_processing_time==1 && $buyer_responce_processing_time==0)
		       {
             $status_cancel="Extended delivery time requested";
               }
			   elseif($extend_processing_time==1 && $buyer_responce_processing_time==1)
			   {
              $status_cancel="Extended delivery time accepted";
               }
			  elseif($extend_processing_time==1 && $buyer_responce_processing_time==2)
			   {
               $status_cancel="Extended delivery time rejected";
               }
         }
		elseif($seller_accept_shipment==1 && $orderr_status=='S'){
		  $status_cancel="Dispatched";
		}
			
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"product_id" => stripslashes($orders->product_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"is_cancel_request" => stripslashes($is_cancel_request),
				"is_accept_request" => stripslashes($is_accept_request),
				"is_reject_request" => stripslashes($is_reject_request),
				"is_reject_request" => stripslashes($is_reject_request),
				"cancel_status" => stripslashes($cancel_status),
				"cancel_status_message" => stripslashes($status_cancel),
				"extend_time_request" => stripslashes($extend_time_request),
				"add_tracking" => stripslashes($add_tracking),
				"reason" => stripslashes($reason),
				"notes" => stripslashes($orders->notes));
				
				
            }
			$data['orders_all'] = $allorders;
			$data['Ack'] = 1;
        } else {
		$data['orders_all'] = $allorders;
		$data['Ack'] = 0;
		$data['msg'] = 'No Records Found..';
        }	
		
		
		
		
    } catch (PDOException $e) {
	//print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';

    }
    echo json_encode($data);
    exit;
}

function getdisputeSeller() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$a="DP";
	
	
    try {

        $sql = "SELECT * FROM order_details WHERE owner_id=:owner_id and order_status=:a order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("owner_id", $user_id);
		$stmt->bindParam("a", $a);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();	
		
		$sqlorderDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='C'";
		$stmtorderDetails = $db->prepare($sqlorderDetails);
		$stmtorderDetails->execute();
		$getorderDetails = $stmtorderDetails->fetchObject();	
        $isorderdetails = $stmtorderDetails->rowCount(); 
		$order_status=$getorderDetails->order_status;
		
		$sqlordDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='S'";
		$stmtordDetails = $db->prepare($sqlordDetails);
		$stmtordDetails->execute();
		$getordDetails = $stmtordDetails->fetchObject();	
        $isorddetails = $stmtordDetails->rowCount(); 
		
		
		
		
		$sqlorderrDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "'";
		$stmtorderrDetails = $db->prepare($sqlorderrDetails);
		$stmtorderrDetails->execute();
		$getorderrDetails = $stmtorderrDetails->fetchObject();	
        $isorderrdetails = $stmtorderrDetails->rowCount(); 
		$orderr_status=$getorderrDetails->order_status;
		$buyer_id=$getorderrDetails->user_id;
		
		
		
		
		$sqlcancelDetails = "SELECT * FROM disputes WHERE `order_details_id`='" . $orders->id . "' order by id desc limit 1";
		$stmtcancelDetails = $db->query($sqlcancelDetails);
		$stmtcancelDetails->execute();
		$getcancelDetails = $stmtcancelDetails->fetchObject();	
		 $isdisputedetails = $stmtcancelDetails->rowCount(); 
	    $is_response=$getcancelDetails->seller_response;
		$is_close=$getcancelDetails->is_close;
		$ddate=$getcancelDetails->cdate;
		$reason=$getcancelDetails->select_reason;
		$details=$getcancelDetails->dispute_details;
		$dispute_id=$getcancelDetails->id;
		$receive_order=$getcancelDetails->receive_order;
		$refund_request=$getcancelDetails->refund_request;
		$seller_responce=$getcancelDetails->seller_response;
		$seller_dispute_action=$getcancelDetails->seller_dispute_action;
		$is_close=$getcancelDetails->is_close;
		
		 
		
		
		if($isdisputedetails >0)
		{
		    if($seller_responce==0 && $seller_dispute_action==0)
		       {
		        $dispute_status=1;
		        }
		     elseif($seller_responce==1 && $seller_dispute_action==1)
		         {
		         $dispute_status=2;
		          }
		        elseif($seller_responce==1 && $seller_dispute_action==2)
		           {
		         $dispute_status=3;
		            }
		} 
		else
		{
		 $dispute_status=0;
		}
		
		$order = "select * FROM  orders WHERE `id`='" . $orders->order_id . "'";
		//echo '<br>';
		$stmtorder = $db->query($order);
		$orderData = $stmtorder->fetchObject();
		$order_date=$orderData->order_date;
		
		
	                         if($seller_response==1 && $is_close==0){
                                        
                                         $status_cancel= "Respond";
                                        
                                            }elseif($is_close==1){
                                                $status_cancel="Closed";
                                            }else{
                                              $status_cancel= "Awaiting Response";
                                            }
                                       
		
			
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"product_id" => stripslashes($orders->product_id),
				"user_id" => stripslashes($buyer_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"cancel_status_message" => stripslashes($status_cancel),
				"problem" => stripslashes($details),
				"reason" => stripslashes($reason),
				"receive_order" => stripslashes($receive_order),
				"refund_request" => stripslashes($refund_request),
				"order_date" => stripslashes($order_date),
				"dispute_date" => stripslashes($ddate),
				"dispute_id" => stripslashes($dispute_id),
				"dispute_status" => stripslashes($dispute_status),
                "notes" => stripslashes($orders->notes));
				
				
            }
			$data['orders_all'] = $allorders;
			$data['Ack'] = 1;
        } else {
		$data['orders_all'] = $allorders;
		$data['Ack'] = 0;
		$data['msg'] = 'No Records Found..';
        }	
		
		
		
		
    } catch (PDOException $e) {
	//print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';

    }
    echo json_encode($data);
    exit;
}

function getfinishSeller() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	$a="F";
	
	
    try {

        $sql = "SELECT * FROM order_details WHERE owner_id=:owner_id and order_status=:a order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("owner_id", $user_id);
		$stmt->bindParam("a", $a);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$productDetails = "select * FROM products WHERE `id`='" . $orders->product_id . "'";
		//echo '<br>';
		$stmtProductDetails = $db->query($productDetails);
		$productData = $stmtProductDetails->fetchObject();
		
		
		unset($productImagesData);
		$productImagesData = array();
		$productImage = "select * FROM product_images WHERE `product_id`='" . $orders->product_id . "'";
		$stmtProductImage = $db->query($productImage);
		$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		}
		}
		
		
		$sqlStoreDetails = "SELECT  * FROM shops WHERE `id`='" . $orders->shop_id . "'";
		$stmtStoreDetails = $db->prepare($sqlStoreDetails);
		$stmtStoreDetails->execute();
		$getStoreDetails = $stmtStoreDetails->fetchObject();	
		
		$sqlorderDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='C'";
		$stmtorderDetails = $db->prepare($sqlorderDetails);
		$stmtorderDetails->execute();
		$getorderDetails = $stmtorderDetails->fetchObject();	
        $isorderdetails = $stmtorderDetails->rowCount(); 
		$order_status=$getorderDetails->order_status;
		
		$sqlordDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "' and `order_status`='S'";
		$stmtordDetails = $db->prepare($sqlordDetails);
		$stmtordDetails->execute();
		$getordDetails = $stmtordDetails->fetchObject();	
        $isorddetails = $stmtordDetails->rowCount(); 
		
		
		
		
		$sqlorderrDetails = "SELECT * FROM order_details WHERE `id`='" . $orders->id . "'";
		$stmtorderrDetails = $db->prepare($sqlorderrDetails);
		$stmtorderrDetails->execute();
		$getorderrDetails = $stmtorderrDetails->fetchObject();	
        $isorderrdetails = $stmtorderrDetails->rowCount(); 
		$orderr_status=$getorderrDetails->order_status;
	
		
	    $finish_status="Goods  Delivered";
		$finish_status_message="Finish";
		
		
		
		
		
			
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"order_id" => stripslashes($orders->order_id),
				"product_id" => stripslashes($orders->product_id),
				"name" => stripslashes($productData->name),
				"sku" => stripslashes(strip_tags($productData->sku)),
				"item_specification" => stripslashes($productData->item_specification),
				"item_description" => stripslashes($productData->item_description),
				"delivery_terms" => stripslashes($productData->delivery_terms),
				"image" => $productImagesData,
				"shop_id" => stripslashes($orders->shop_id),
				"store_name" => stripslashes($getStoreDetails->name),
				"price" => stripslashes($orders->amount),
				"quantity" => stripslashes($orders->quantity),
				"order_status" => stripslashes($orders->order_status),
				"delivery_date" => stripslashes($orders->delivery_date),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"finish_status" => stripslashes($finish_status),
				"finish_status_message" => stripslashes($finish_status_message),
				"reason" => stripslashes($reason),
				"notes" => stripslashes($orders->notes));
				
				
            }
			$data['orders_all'] = $allorders;
			$data['Ack'] = 1;
        } else {
		$data['orders_all'] = $allorders;
		$data['Ack'] = 0;
		$data['msg'] = 'No Records Found..';
        }	
		
		
		
		
    } catch (PDOException $e) {
	//print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';

    }
    echo json_encode($data);
    exit;
}
function addtrack() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$date=gmdate('Y-m-d H:i:s');
	$package_weight= $body['package_weight'];
	$package_size1= $body['package_size1'];
	$package_size2= $body['package_size2'];
	$package_size3= $body['package_size3'];
	$tracking_no= $body['tracking_no'];
	$web_address= $body['web_address'];
	$seller_accept_shipment=1;
	$order_status="S";
	$sql = "INSERT INTO track_details(order_details_id,package_weight,package_size1,package_size2,package_size3,tracking_no,web_address,cdate) VALUES (:order_details_id,:package_weight,:package_size1,:package_size2,:package_size3,:tracking_no,:web_address,:date)";
	
	try {
	
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("order_details_id", $order_details_id);
	$stmt->bindParam("package_weight", $package_weight);
	$stmt->bindParam("package_size1", $package_size1);
	$stmt->bindParam("package_size2", $package_size2);
	$stmt->bindParam("package_size3", $package_size3);
	$stmt->bindParam("tracking_no", $tracking_no);
	$stmt->bindParam("web_address", $web_address);
	$stmt->bindParam("date", $date);
	$stmt->execute();
	$lastID = $db->lastInsertId();
	
	 $sql1 = "UPDATE order_details SET order_status=:order_status,seller_accept_shipment=:seller_accept_shipment  WHERE id=:order_details_id";
	        $stmt1 = $db->prepare($sql1);
	        $stmt1->bindParam("order_details_id", $order_details_id);
			$stmt1->bindParam("order_status", $order_status);
			$stmt1->bindParam("seller_accept_shipment", $seller_accept_shipment);
	        $stmt1->execute();
			
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Add Tracking Details.Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
	
			
			
			$comments='Seller add tracking details<br />The Order ID is '.$NewOrderId;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=4;
			$is_notification=1;
			$type_inventory='-';
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $orderData->user_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name;
			$email=$cancelData->email;
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
			
			 $to = $email;
			
			
			$subject = 'Add Tracking Details';
            $TemplateMessage = 'Seller added tracking details<br />The Order ID is '.$NewOrderId.'on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
	
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Seller added tracking details';
	} catch (PDOException $e) {
	//print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

 function acceptextendprocessingtime() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$type=1;
	
	try {
	
	$db = getConnection();
	
	        $processingDetails = "select * FROM extend_processing_times WHERE `order_details_id`='" . $order_details_id . "' order by id desc";
		    $stmtprocessingDetails = $db->query($processingDetails);
		    $processingData = $stmtprocessingDetails->fetchObject();
			$no_days=$processingData->no_of_day;
	
	        
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Buyer Accepted Extend Processing Time for.Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			$delivery_date=$orderData->delivery_date;
			$new_delivery_date=date('Y-m-d H:i:s', strtotime($delivery_date . "+" . $no_days . " days"));
			$buyer_responce_date=gmdate('Y-m-d H:i:s');
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$buyer_processing_time=1;
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData =  $stmtbuyerDetails->fetchObject();
		    $user_name=$cancelData->first_name.' '.$cancelData->last_name;
			$buyer_email=$buyerData->email;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $owner_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name;
			$email=$cancelData->email;
			
			$sql5 = "UPDATE extend_processing_times SET buyer_id=:buyer_id,type=:type,pre_delivery_date=:pre_delivery_date,buyer_responce_date=:buyer_responce_date WHERE order_details_id=:order_details_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("buyer_id", $buyer_id);
			$stmt5->bindParam("type", $type);
			$stmt5->bindParam("pre_delivery_date", $delivery_date);
			$stmt5->bindParam("buyer_responce_date", $buyer_responce_date);
			$stmt5->bindParam("order_details_id", $order_details_id);
			$stmt5->execute();
			
			$sql6 = "UPDATE order_details SET buyer_responce_processing_time=:buyer_processing_time,delivery_date=:delivery_date WHERE id=:order_details_id";
	        $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("buyer_processing_time", $buyer_processing_time);
			$stmt6->bindParam("delivery_date", $new_delivery_date);
			$stmt6->bindParam("order_details_id", $order_details_id);
			$stmt6->execute();
			
			
			
			
			$comments=$buyer_name.' accepted extend  processing time by '.$no_days.' days .<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=8;
			$is_notification=1;
		
			
			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :owner_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("owner_id",$owner_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
			
			 $to = $email;
			
			
			$subject = 'Accept Extend Processing Time';
            $TemplateMessage = $buyer_name.' Accepted Extend Processing Time<br />The Order ID is  '.$NewOrderId.' and Product Name is '.$product_name.' on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			
		
			
			
    
    $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Buyer Accepted Extend Processing Time';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}
 function rejectextendprocessingtime() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$type=2;
	
	try {
	
	$db = getConnection();
	
	        $processingDetails = "select * FROM extend_processing_times WHERE `order_details_id`='" . $order_details_id . "' order by id desc";
		    $stmtprocessingDetails = $db->query($processingDetails);
		    $processingData = $stmtprocessingDetails->fetchObject();
			$no_days=$processingData->no_of_day;
	
	        
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Buyer Rejected Extend Processing time for,Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			$delivery_date=$orderData->delivery_date;
			$new_delivery_date=date('Y-m-d H:i:s', strtotime($delivery_date . "+" . $no_days . " days"));
			$buyer_responce_date=gmdate('Y-m-d H:i:s');
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$buyer_processing_time=2;
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData =  $stmtbuyerDetails->fetchObject();
		    $buyer_name=$buyerData->first_name.' '.$buyerData->last_name;
			$buyer_email=$buyerData->email;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $owner_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name.' '.$cancelData->last_name;
			$email=$cancelData->email;
			
			$sql5 = "UPDATE extend_processing_times SET buyer_id=:buyer_id,type=:type,pre_delivery_date=:pre_delivery_date,buyer_responce_date=:buyer_responce_date WHERE order_details_id=:order_details_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("buyer_id", $buyer_id);
			$stmt5->bindParam("type", $type);
			$stmt5->bindParam("pre_delivery_date", $delivery_date);
			$stmt5->bindParam("buyer_responce_date", $buyer_responce_date);
			$stmt5->bindParam("order_details_id", $order_details_id);
			$stmt5->execute();
			
			$sql6 = "UPDATE order_details SET buyer_responce_processing_time=:buyer_processing_time WHERE id=:order_details_id";
	        $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("buyer_processing_time", $buyer_processing_time);
			$stmt6->bindParam("order_details_id", $order_details_id);
			$stmt6->execute();
			
			
			
			
			$comments=$buyer_name.' rejected extend  processing time by '.$no_days.' days .<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=8;
			$is_notification=1;
		
			
			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :owner_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("owner_id",$owner_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
			
			 $to = $email;
			
			
			$subject = 'Reject Extend Processing Time';
            $TemplateMessage = $buyer_name.' rejected extend processing time<br />The Order ID is  '.$NewOrderId.' and Product Name is '.$product_name.' on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			
		
			
			
    
    $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Buyer Rejected Extend Processing Time';
	} catch (PDOException $e) {
	//print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function buyerreceivedorder() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$order_status="F";
	$order_received_date=gmdate('Y-m-d H:i:s');
	try {
	
	$db = getConnection();
	
	        $sql6 = "UPDATE order_details SET order_status=:order_status,order_received_date=:order_received_date WHERE id=:order_details_id";
	        $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_status", $order_status);
			$stmt6->bindParam("order_received_date", $order_received_date);
			$stmt6->bindParam("order_details_id", $order_details_id);
			$stmt6->execute();
	
	        
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Buyer received the order properly. Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
		
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData =  $stmtbuyerDetails->fetchObject();
		    $buyer_name=$buyerData->first_name.' '.$buyerData->last_name;
			$buyer_email=$buyerData->email;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $owner_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name.' '.$cancelData->last_name;
			$email=$cancelData->email;
			
			
			
			
			
			
			
			$comments=' Buyer received the order properly. .<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=7;
			$is_notification=1;
		
			
			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :owner_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("owner_id",$owner_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
			
		
			
			
		
			
			
    
    $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Buyer Received Order';
	} catch (PDOException $e) {
	//print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function opendispute() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$order_status="DP";
	$dispute_date=gmdate('Y-m-d H:i:s');
	$receive_order=$body['receive_order'];
	$payment_amount=$body['payment_amount'];
	$refund_request=$body['refund_request'];
	$select_reason=$body['select_reason'];
	$details=$body['details'];
	$date=gmdate('Y-m-d H:i:s');
	try {
	
	$db = getConnection();
	
	        $sql6 = "UPDATE order_details SET order_status=:order_status WHERE id=:order_details_id";
	        $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_status", $order_status);
			$stmt6->bindParam("order_details_id", $order_details_id);
			$stmt6->execute();
	        
			
			$sql4 = "INSERT INTO disputes (order_details_id,receive_order,payment_received,refund_request,select_reason,dispute_details,cdate) VALUES (:order_details_id, :receive_order,:payment_received,:refund_request,:select_reason,:dispute_details,:date)";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("order_details_id", $order_details_id);
	        $stmt4->bindParam("receive_order", $receive_order);
	        $stmt4->bindParam("payment_received",$payment_amount);
	        $stmt4->bindParam("refund_request", $refund_request);
			$stmt4->bindParam("select_reason", $select_reason);
			$stmt4->bindParam("dispute_details", $details);
			$stmt4->bindParam("date", $date);
	        $stmt4->execute();
			$lastID = $db->lastInsertId();
			
			$disputedetails = "select * FROM disputes WHERE `id`='" . $lastID . "'";
		    $stmtdisputeDetails = $db->query($disputedetails);
		    $disputeData =  $stmtdisputeDetails->fetchObject();
			$dispute_id=$lastID;
			$dispute_details1= $disputeData->dispute_details;
			$reason= $disputeData->select_reason;
			$receive_order1= $disputeData->receive_order;
			$refund_request1= $disputeData->refund_request;
	        $return_goods= "No";
			$payment_received1= $disputeData->payment_received;
			$action= "Open Dispute";
			$user_type=1;
			
			$sql4 = "INSERT INTO dispute_messages(dispute_id,user_id,reason,received_goods,refund_request,return_goods,refund_amount,action,user_type,cdate) VALUES (:dispute_id, :user_id,:dispute_details,:receive_order,:refund_request,:return_goods,:payment_received,:action,:user_type,:date)";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("dispute_id", $dispute_id);
			 $stmt4->bindParam("user_id", $user_id);
	        $stmt4->bindParam("receive_order", $receive_order1);
	        $stmt4->bindParam("payment_received",$payment_received1);
	        $stmt4->bindParam("refund_request", $refund_request1);
			$stmt4->bindParam("dispute_details", $dispute_details1);
			$stmt4->bindParam("return_goods", $return_goods);
			$stmt4->bindParam("action", $action);
			$stmt4->bindParam("user_type", $user_type);
			$stmt4->bindParam("date", $date);
	        $stmt4->execute();
			
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Buyer open dispute for,'.$reason .' Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
		
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData =  $stmtbuyerDetails->fetchObject();
		    $buyer_name=$buyerData->first_name.' '.$buyerData->last_name;
			$buyer_email=$buyerData->email;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $owner_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name.' '.$cancelData->last_name;
			$email=$cancelData->email;
			
			
			
			
			
			
			
			$comments=$dispute_details1.'<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=6;
			$is_notification=1;
		
			
			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :owner_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("owner_id",$owner_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
			$to = $email;
			
			
			$subject = 'Buyer Disputed Your Product';
            $TemplateMessage = $buyer_name.' Disputed Your Product<br />The Order ID is  '.$NewOrderId.' and Product Name is '.$product_name.' on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			
		
			
			
		
			
			
    
    $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Open Dispute';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}


function acceptdisputebyseller() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$dispute_id=$body['dispute_id'];
	$refund_request=$body['refund_request'];
	$dispute_date=gmdate('Y-m-d H:i:s');
	$payment_amount=$body['payment_amount'];
	$details=$body['details'];
	$date=gmdate('Y-m-d H:i:s');
	$recive_goods="No";
	$user_type=2;
	$seller_response=1;
	$action="Seller accept dispute";
	$seller_dispute_action=1;
	$is_close=1;
	$cancel_transaction_id=$body['cancel_transaction_id'];
	try {
	
	$db = getConnection();
	
	      /*  $sql6 = "UPDATE order_details SET order_status=:order_status WHERE id=:order_details_id";
	        $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_status", $order_status);
			$stmt6->bindParam("order_details_id", $order_details_id);
			$stmt6->execute();*/
	        
			
			$sql4 = "UPDATE disputes SET seller_response=:seller_response,seller_dispute_action=:seller_dispute_action,is_close=:is_close,cancel_transcation_id=:cancel_transcation_id WHERE id=:dispute_id";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("dispute_id", $dispute_id);
			$stmt4->bindParam("seller_response", $seller_response);
			$stmt4->bindParam("seller_dispute_action", $seller_dispute_action);
			$stmt4->bindParam("cancel_transcation_id", $cancel_transcation_id);
			$stmt4->bindParam("is_close", $is_close);
	        $stmt4->execute();
			
			
			$disputedetails = "select * FROM disputes WHERE `id`='" . $dispute_id . "'";
		    $stmtdisputeDetails = $db->query($disputedetails);
		    $disputeData =  $stmtdisputeDetails->fetchObject();
			//$refund_request= $disputeData->refund_request;
	        $return_goods= "No";
			
			$sql4 = "INSERT INTO dispute_messages(dispute_id,user_id,reason,received_goods,refund_request,return_goods,refund_amount,action,user_type,cdate) VALUES (:dispute_id, :user_id,:dispute_details,:recive_goods,:refund_request,:return_goods,:payment_received,:action,:user_type,:date)";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("dispute_id", $dispute_id);
			 $stmt4->bindParam("user_id", $user_id);
	        $stmt4->bindParam("recive_goods", $recive_goods);
	        $stmt4->bindParam("payment_received",$payment_amount);
	        $stmt4->bindParam("refund_request", $refund_request);
			$stmt4->bindParam("dispute_details", $details);
			$stmt4->bindParam("return_goods", $return_goods);
			$stmt4->bindParam("action", $action);
			$stmt4->bindParam("user_type", $user_type);
			$stmt4->bindParam("date", $date);
	        $stmt4->execute();
			
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Seller Accept dispute. Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$actual_quantity=$productData->quantity;
			$original_quantity=$order_quantity+$actual_quantity;
			
			$sql5 = "UPDATE products SET quantity=:quantity WHERE id=:product_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("quantity", $original_quantity);
			$stmt5->bindParam("product_id", $product_id);
	       
	        $stmt5->execute();
		
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData =  $stmtbuyerDetails->fetchObject();
		    $buyer_name=$buyerData->first_name.' '.$buyerData->last_name;
			$buyer_email=$buyerData->email;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $buyer_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name.' '.$cancelData->last_name;
			$email=$cancelData->email;
			
			
			
			
			
			
			
			$comments='Seller Accept dispute<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=6;
			$is_notification=1;
		    $type_inventory="+";
			$comment="Seller Accept Dispute";
			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			$sql6 = "INSERT INTO manage_inventories (user_id,product_id,order_id,order_details_id,type,quantity,comment,create_date,price) VALUES (:user_id, :product_id,:order_id,:order_details_id,:type,:quantity,:comments,:date,:price)";
	         $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_details_id", $order_details_id);
	        $stmt6->bindParam("user_id", $user_id);
	        $stmt6->bindParam("product_id", $product_id);
	        $stmt6->bindParam("order_id", $order_id);
			$stmt6->bindParam("comments", $comment);
			$stmt6->bindParam("quantity",$order_quantity);
			$stmt6->bindParam("price",$order_price);
			$stmt6->bindParam("type",$type_inventory);
			$stmt6->bindParam("date", $cdate);
	        $stmt6->execute();
			
			
			$to = $email;
			
			
			$subject = 'Seller accepted your product dispute';
            $TemplateMessage = 'Seller Accept dispute<br />The Order ID is  '.$NewOrderId.' and Product Name is '.$product_name.' on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			
		 $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Accept Dispute Seller';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function rejectdisputebyseller() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$dispute_id=$body['dispute_id'];
	$dispute_date=gmdate('Y-m-d H:i:s');
	$payment_amount='';
	$details=$body['details'];
	$date=gmdate('Y-m-d H:i:s');
	$recive_goods="No";
	$user_type=2;
	$seller_response=1;
	$action="Seller reject dispute";
	$seller_dispute_action=2;


	try {
	
	$db = getConnection();
	
	      /*  $sql6 = "UPDATE order_details SET order_status=:order_status WHERE id=:order_details_id";
	        $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_status", $order_status);
			$stmt6->bindParam("order_details_id", $order_details_id);
			$stmt6->execute();*/
	        
			
			$sql4 = "UPDATE disputes SET seller_response=:seller_response,seller_dispute_action=:seller_dispute_action WHERE id=:dispute_id";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("dispute_id", $dispute_id);
			$stmt4->bindParam("seller_response", $seller_response);
			$stmt4->bindParam("seller_dispute_action", $seller_dispute_action);
	        $stmt4->execute();
			
			
			$disputedetails = "select * FROM disputes WHERE `id`='" . $dispute_id . "'";
		    $stmtdisputeDetails = $db->query($disputedetails);
		    $disputeData =  $stmtdisputeDetails->fetchObject();
			$refund_request='';
	        $return_goods= "No";
			
			$sql4 = "INSERT INTO dispute_messages(dispute_id,user_id,reason,received_goods,refund_request,return_goods,refund_amount,action,user_type,cdate) VALUES (:dispute_id, :user_id,:dispute_details,:recive_goods,:refund_request,:return_goods,:payment_received,:action,:user_type,:date)";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("dispute_id", $dispute_id);
			 $stmt4->bindParam("user_id", $user_id);
	        $stmt4->bindParam("recive_goods", $recive_goods);
	        $stmt4->bindParam("payment_received",$payment_amount);
	        $stmt4->bindParam("refund_request", $refund_request);
			$stmt4->bindParam("dispute_details", $details);
			$stmt4->bindParam("return_goods", $return_goods);
			$stmt4->bindParam("action", $action);
			$stmt4->bindParam("user_type", $user_type);
			$stmt4->bindParam("date", $date);
	        $stmt4->execute();
			
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Seller Reject dispute. Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$actual_quantity=$productData->quantity;
			$original_quantity=$order_quantity+$actual_quantity;
			
			$sql5 = "UPDATE products SET quantity=:quantity WHERE id=:product_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("quantity", $original_quantity);
			$stmt5->bindParam("product_id", $product_id);
	       
	        $stmt5->execute();
		
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData =  $stmtbuyerDetails->fetchObject();
		    $buyer_name=$buyerData->first_name.' '.$buyerData->last_name;
			$buyer_email=$buyerData->email;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $buyer_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name.' '.$cancelData->last_name;
			$email=$cancelData->email;
			
			
			
			
			
			
			
			$comments=$details.' Seller Reject dispute<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=6;
			$is_notification=1;
		    			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
			
			$to = $email;
			
			
			$subject = 'Seller rejected your product dispute';
            $TemplateMessage = 'Seller Accept dispute<br />The Order ID is  '.$NewOrderId.' and Product Name is '.$product_name.' on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			
		 $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Reject Dispute Seller';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function buyeracceptdispute() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_id= $body['order_id'];
	$user_id= $body['user_id'];
	$order_details_id= $body['order_details_id'];
	$dispute_id=$body['dispute_id'];
	$dispute_date=gmdate('Y-m-d H:i:s');
	$payment_amount=0.00;
	$details='';
	$date=gmdate('Y-m-d H:i:s');
	$recive_goods="No";
	$return_goods="No";
	$user_type=2;
	$action="Buyer accept the dispute rejected by seller";
	$is_close=1;


	try {
	
	$db = getConnection();
	
	      /*  $sql6 = "UPDATE order_details SET order_status=:order_status WHERE id=:order_details_id";
	        $stmt6 = $db->prepare($sql6);
	        $stmt6->bindParam("order_status", $order_status);
			$stmt6->bindParam("order_details_id", $order_details_id);
			$stmt6->execute();*/
	        
			
			$sql4 = "UPDATE disputes SET is_close=:is_close WHERE id=:dispute_id";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("dispute_id", $dispute_id);
			  $stmt4->bindParam("is_close", $is_close);
	        $stmt4->execute();
			
			
			$disputedetails = "select * FROM disputes WHERE `id`='" . $dispute_id . "'";
		    $stmtdisputeDetails = $db->query($disputedetails);
		    $disputeData =  $stmtdisputeDetails->fetchObject();
			$refund_request='';
			
			$sql4 = "INSERT INTO dispute_messages(dispute_id,user_id,reason,received_goods,refund_request,return_goods,refund_amount,action,user_type,cdate) VALUES (:dispute_id, :user_id,:dispute_details,:recive_goods,:refund_request,:return_goods,:payment_received,:action,:user_type,:date)";
	         $stmt4 = $db->prepare($sql4);
	        $stmt4->bindParam("dispute_id", $dispute_id);
			 $stmt4->bindParam("user_id", $user_id);
	        $stmt4->bindParam("recive_goods", $recive_goods);
	        $stmt4->bindParam("payment_received",$payment_amount);
	        $stmt4->bindParam("refund_request", $refund_request);
			$stmt4->bindParam("dispute_details", $details);
			$stmt4->bindParam("return_goods", $return_goods);
			$stmt4->bindParam("action", $action);
			$stmt4->bindParam("user_type", $user_type);
			$stmt4->bindParam("date", $date);
	        $stmt4->execute();
			
			
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Buyer accepted the dispute rejected by you. Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;
			$order_received_date=$orderData->order_received_date;
			$buyer_accept_dispute=1;
			
			 if($order_received_date=='0000-00-00 00:00:00'){
                   $new_order_status='S';
                }else{
                    $new_order_status='F';
                }
			
			$productDetails = "select * FROM products WHERE `id`='" . $product_id . "'";
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			$actual_quantity=$productData->quantity;
			$original_quantity=$order_quantity+$actual_quantity;
			
			$sql5 = "UPDATE order_details SET buyer_accept_dispute=:buyer_accept_dispute,order_status=:order_status WHERE id=:order_details_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("order_status",  $new_order_status);
			$stmt5->bindParam("order_details_id", $order_details_id);
			$stmt5->bindParam("buyer_accept_dispute", $buyer_accept_dispute);
	       
	        $stmt5->execute();
		
			
			$buyerDetails = "select * FROM users WHERE `id`='" . $user_id . "'";
		    $stmtbuyerDetails = $db->query($buyerDetails);
		    $buyerData =  $stmtbuyerDetails->fetchObject();
		    $buyer_name=$buyerData->first_name.' '.$buyerData->last_name;
			$buyer_email=$buyerData->email;
			
			$canceluserDetails = "select * FROM users WHERE `id`='" . $owner_id . "'";
		    $stmtcancelDetails = $db->query($canceluserDetails);
		    $cancelData = $stmtcancelDetails->fetchObject();
		    $user_name=$cancelData->first_name.' '.$cancelData->last_name;
			$email=$cancelData->email;
			
			
			
			
			
			
			
			$comments=$details.'Buyer accepted the dispute rejected by you.<br />The Order ID is '.$NewOrderId.'.<br /> Product Name :'.$product_name;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=6;
			$is_notification=1;
		    			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,comments,cdate) VALUES (:user_id, :buyer_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $user_id);
	        $stmt3->bindParam("buyer_id",$buyer_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
			
			
			
			$to = $email;
			
			
			$subject = 'Buyer accepted the dispute rejected by you';
            $TemplateMessage = 'Buyer accepted the dispute rejected by you<br />The Order ID is  '.$NewOrderId.' and Product Name is '.$product_name.' on TWOP<br />';
          
            $TemplateMessage .= "Thanks,<br />";
            $TemplateMessage .= "twop.com<br />";



            $header = "From:info@twop.com \r\n";
            // $header .= "Cc:nits.sarojkumar@gmail.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);
			
			
		 $db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Buyer Accepted Dispute Reject';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function buyercanceldispute() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_details_id= $body['order_details_id'];
	


	try {
	
	$db = getConnection();
	
	
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			
			$order_received_date=$orderData->order_received_date;
			
			
			 if($order_received_date=='0000-00-00 00:00:00'){
                   $new_order_status='S';
                }else{
                    $new_order_status='F';
                }
			
		
			$sql5 = "UPDATE order_details SET order_status=:order_status WHERE id=:order_details_id";
	        $stmt5 = $db->prepare($sql5);
	        $stmt5->bindParam("order_status",  $new_order_status);
			$stmt5->bindParam("order_details_id", $order_details_id);
	       
	        $stmt5->execute();
		
		$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Buyer Cancel Dispute';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function disputemessage() {
	
	
	$data = array();
	
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	
	$order_details_id= $body['order_details_id'];
	$comments= $body['comments'];
	$from_id= $body['from_id'];
	$to_id= $body['to_id'];
    $order_id= $body['order_id'];

	try {
	
	$db = getConnection();
	            
				
				if ($_FILES['message_photo']['tmp_name'] != '') {
	                                  $target_path = "../app/webroot/message_img/";
	                                  $userfile_name = $_FILES['message_photo']['name'];
	                                  $userfile_tmp = $_FILES['message_photo']['tmp_name'];
	                                  $message_photo = rand(1000,99999).'_'. strtolower($userfile_name);
	                                  $img = $target_path . $message_photo;
	                                  move_uploaded_file($userfile_tmp, $img);
									  }
									  else
									  {
									  $message_photo='';
									  }
									  
									  
									  
			$commentdetails = "select * FROM comments WHERE `order_id`='" . $order_id . "' and `comment_type`=0";
		    $stmtcommentDetails = $db->query($commentdetails);
		    $commentData = $stmtcommentDetails->fetchObject();
		    $thread_id=$commentData->thread_id;
			$folder_id=$commentData->folder_id;
			
			$val = 10000000;
			
			$orderdetails = "select * FROM order_details WHERE `id`='" . $order_details_id . "'";
		    $stmtorderDetails =$db->query($orderdetails);
		    $orderData =$stmtorderDetails->fetchObject();
			$NewOrderId =$val.$orderData->order_id;
			$owner_id=$orderData->owner_id;
			$subject='Re: to dispute for Order ID: '.$NewOrderId;
			$product_id=$orderData->product_id;
			$order_quantity=$orderData->quantity;
			$order_price=$orderData->price;
			$buyer_id=$orderData->user_id;					  
									  
									  
									  
		    $comments=$comments;
			$cdate= gmdate('Y-m-d H:i:s');
			$comment_type=1;
			$is_notification=0;
		    			
			
			
			
			$sql3 = "INSERT INTO comments (user_id,to_user_id,comment_type,is_notification,order_id,order_details_id,thread_id,folder_id,subject,file_name,comments,cdate) VALUES (:user_id, :to_id,:comment_type,:is_notification,:order_id,:order_details_id,:thread_id,:folder_id,:subject,:file_name,:comments,:date)";
	         $stmt3 = $db->prepare($sql3);
	        $stmt3->bindParam("order_details_id", $order_details_id);
	        $stmt3->bindParam("user_id", $from_id);
	        $stmt3->bindParam("to_id",$to_id);
	        $stmt3->bindParam("order_id", $order_id);
			$stmt3->bindParam("thread_id", $thread_id);
			$stmt3->bindParam("folder_id", $folder_id);
			$stmt3->bindParam("subject", $subject);
			$stmt3->bindParam("comments", $comments);
			$stmt3->bindParam("comment_type", $comment_type);
			$stmt3->bindParam("is_notification", $is_notification);
			$stmt3->bindParam("file_name", $message_photo);
	        $stmt3->bindParam("date", $cdate);
	        $stmt3->execute();
	
	
		
		$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Message send successfully';
	} catch (PDOException $e) {
	print_r($e);
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
	//echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
	
	echo json_encode($data);
	exit;
}

function disputehistory() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$dispute_id = $body['dispute_id'];
	
	
    try {

        $sql = "SELECT * FROM dispute_messages WHERE dispute_id=:dispute_id  order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("dispute_id", $dispute_id);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$toDetails = "select * FROM users WHERE `id`='" . $orders->to_id . "'";
		//echo '<br>';
		$stmttoDetails = $db->query($toDetails);
		$toData = $stmttoDetails->fetchObject();
		
		$user_type=$orders->user_type;
		                       if($user_type==1){
                                            $user_type_text='Buyer';
                                        }elseif($user_type==2){
                                            $user_type_text='Seller';
                                        }elseif($user_type==3){
                                            $user_type_text='TWOP';
                                        }else{
                                            $user_type_text='Buyer';
                                        }
	
		
	  $dispute_id=$orders->dispute_id;
	  $receive_goods=$orders->received_goods;
	  $return_goods=$orders->return_goods;
	  $refund_amount=$orders->refund_amount;
	  $date=$orders->cdate;
	  $action=$orders->action;
	  $reason=$orders->reason;
	  
		
		
		
		
			
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"dispute_id" => stripslashes($dispute_id),
				"user_type_text" => stripslashes($user_type_text),
				"receive_goods" => stripslashes($receive_goods),
				"return_goods" => stripslashes($return_goods),
				"refund_amount" => stripslashes($refund_amount),
				"date" => stripslashes($date),
				"action" => stripslashes($action),
				"reason" => stripslashes($reason),
				);
				
				
            }
			$data['orders_all'] = $allorders;
			$data['Ack'] = 1;
        } else {
		$data['orders_all'] = $allorders;
		$data['Ack'] = 0;
		$data['msg'] = 'No Records Found..';
        }	
		
		
		
		
    } catch (PDOException $e) {
	//print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';

    }
    echo json_encode($data);
    exit;
}

function messagehistory() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$order_details_id = $body['order_details_id'];
	$comment_type = 1;
	
    try {

        $sql = "SELECT * FROM comments WHERE order_details_id=:order_details_id and comment_type=:comment_type  order by `id` ASC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("order_details_id", $order_details_id);
		 $stmt->bindParam("comment_type", $comment_type);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$toDetails = "select * FROM users WHERE `id`='" . $orders->to_user_id. "'";
		//echo '<br>';
		$stmttoDetails = $db->query($toDetails);
		$toData = $stmttoDetails->fetchObject();
		$to_id=$toData->id;
		$to_name=$toData->first_name.' '.$toData->last_name;
		
		$fromDetails = "select * FROM users WHERE `id`='" . $orders->user_id. "'";
		//echo '<br>';
		$stmtfromDetails = $db->query($fromDetails);
		$fromData = $stmtfromDetails->fetchObject();
		$from_id=$fromData->id;
		$from_name=$fromData->first_name.' '.$fromData->last_name;
		
		
		
	   $message_date=$orders->cdate;
	   $message=$orders->comments;
	   
	    if ($orders->file_name != '') {
                    $filename =SITE_URL . 'app/webroot/message_img/' . $orders->file_name;
                } else {
                    $filename = '';
                }
		
		if($orders->comments!='')
		{
		$type=1;
		}
		elseif($orders->file_name!= '')
		{
		$type=2;
		}
		
			
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"to_id" => stripslashes($to_id),
				"to_name" => stripslashes($to_name),
				"from_id" => stripslashes($from_id),
				"from_name" => stripslashes($from_name),
				"message_date" => stripslashes($message_date),
				"message" => stripslashes($message),
				"file_name"=>stripslashes($filename),
				"type"=>stripslashes($type),
				);
				
				
            }
			$data['orders_all'] = $allorders;
			$data['Ack'] = 1;
        } else {
		$data['orders_all'] = $allorders;
		$data['Ack'] = 0;
		$data['msg'] = 'No Records Found..';
        }	
		
		
		
		
    } catch (PDOException $e) {
	//print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';

    }
    echo json_encode($data);
    exit;
}

function sellerfeedbacklist() {
    $data = array();
    $allorders = array();
	$allproducts = array();
	$allrating = array();
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
    try {

        $sql = "SELECT * FROM shops WHERE user_id=:user_id order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

/*                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }*/

		$ratingDetails = "select * FROM  ratings WHERE `shop_id`='" . $orders->id. "'";
		//echo '<br>';
		$stmtratingDetails = $db->query($ratingDetails);
		 $stmtratingDetails->execute();
		$rating = $stmtratingDetails->fetchAll(PDO::FETCH_OBJ);
		 $ratingcount = $stmtratingDetails->rowCount();
		
		if($ratingcount>0){
		
		foreach($rating as $getratings)
		{
		
		
		    $productDetails = "select * FROM products WHERE `id`='" . $getratings->product_id. "'";
		//echo '<br>';
		    $stmtproductDetails = $db->query($productDetails);
		    $productData = $stmtproductDetails->fetchObject();
		    $product_name=$productData->name;
			
			unset($productImagesData);
		   $productImagesData = array();
		   $productImage = "select * FROM product_images WHERE `product_id`='" . $getratings->product_id . "' limit 1";
		   $stmtProductImage = $db->query($productImage);
		   $productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
		
		$isImageExists = $stmtProductImage->rowCount();
		if ($isImageExists > 0) {
		
		//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
		foreach ($productImages as $img_products) {
		//echo '<pre>';
		//print_r($img_products);
		$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
		  }
		}
		
		       $allrating[] = array(
				"id" => stripslashes($getratings->id),
				"product_id" => stripslashes($getratings->product_id),
				"product_name" => stripslashes($product_name),
				"product_image" => $productImagesData,
				"shop_id" => stripslashes($getratings->shop_id),
				"rating" => stripslashes($getratings->rating),
				"date" => stripslashes($getratings->date_time));
		
		
		    $ratingavg = "select *,AVG(`product_description`) as pd,AVG(`ship_item`) as sp,AVG(`rate_this`) as ac,AVG(`seller_communication`) as sa FROM  ratings WHERE `shop_id`='" . $orders->id. "'";
		    $stmtratingDetailss = $db->query($ratingavg);
		    $ratingalls = $stmtratingDetailss->fetchObject();
		    $product_describe = number_format($ratingalls->pd,1);
			$shipment_delivery = number_format($ratingalls->sp,1);
			$acurate =  number_format($ratingalls->ac,1);
			$satisfiction = number_format($ratingalls->sa,1);
		
		
		}
	}
		
		
			
				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"shop_name" => stripslashes($orders->name),
				"create_date" => stripslashes($orders->created_at),
				"accuracy" => stripslashes($acurate),
				"satisfiction" => stripslashes($satisfiction),
				"product_describe" => stripslashes($product_describe),
				"shipment_delivery" => stripslashes($shipment_delivery)
				);
				
				
            }
			$data['orders_all'] = $allrating;
			$data['shopdetails'] = $allorders;
			$data['Ack'] = 1;
        } else {
		$data['orders_all'] = $allrating;
		$data['Ack'] = 0;
		$data['msg'] = 'No Records Found..';
        }	
		
		
		
		
    } catch (PDOException $e) {
	print_r($e);
        $data['all_products'] = '';
        $data['Ack'] = 0;
        $data['msg'] = 'Data Error';

    }
    echo json_encode($data);
    exit;
}

function sellerreport() {
 
    
    $data = array();
    $allproducts = array();
	$productImagesData = array();


	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	
	
	$user_id = $body['user_id'];
	$from_date = $body['from_date'];
	$to_date = $body['to_date'];
	$stars = $body['stars'];
	
	
	//$in_wishlist = $body['in_wishlist'];
	

		
    try {
	
	    
        $sql = "SELECT * FROM products WHERE user_id=:user_id";
	
	    if($from_date!='' && $to_date=='')
		{
		$sql.=" AND (created_at >= '".$from_date."')";
		}
		elseif($from_date=='' && $to_date!='')
		{
        $sql.=" AND (created_at <= '".$to_date."')";
		}
		elseif($from_date!='' && $to_date!='')
		{
        $sql.=" AND (created_at BETWEEN '".$from_date."' AND '".$to_date."')";
		}
		elseif($stars!='')
		{
        $sql.=" AND (total_rate = '".$stars."')";
		}
		else
		{
		 $sql.=" ORDER BY sold_quantity DESC";
		}
		
		
		
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);
        $count = $stmt->rowCount();
		
		
	   
	   
	    if ($count > 0) {
            foreach ($getproducts as $products) {

			unset($productImagesData);
			$productImagesData = array();
			$productImage = "select * FROM product_images WHERE `product_id`='" . $products->id . "'";
			$stmtProductImage = $db->query($productImage);
			$productImages = $stmtProductImage->fetchAll(PDO::FETCH_OBJ);
			
			$isImageExists = $stmtProductImage->rowCount();
			if ($isImageExists > 0) {
			
			//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
			foreach ($productImages as $img_products) {
			//echo '<pre>';
			//print_r($img_products);
			$productImagesData[]=SITE_URL . 'app/webroot/product_images/' . $img_products->name;
			}
			}
			
			
			
	
			
			
			
			
				
			//	print_r($productImagesData);

                $allproducts[] = array(
                    "id" => stripslashes($products->id),
                    "name" => stripslashes($products->name),
                    "sku" => stripslashes($products->sku),
					"stars" => stripslashes($products->total_rate),
					"quantity" => stripslashes($products->quantity),
					"sold_quantity" => stripslashes($products->sold_quantity));
					
					
					
					
            }
            $data['all_products'] = $allproducts;
            $data['Ack'] = 1;
        } else {
            $data['products'] = '';
            $data['Ack'] = 0;
        }
    } catch (PDOException $e) {
	     print_r($e);
        $data['products'] = '';
        $data['Ack'] = 0;
    }
//print_r($data);	
	
    echo json_encode($data);
    exit;
}
function homemembership() {
    $data = array();
    $allmembership = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	
	
	$user_id = $body['user_id'];
	$today_date=gmdate('Y-m-d H:i:s');

    $sql = "select * FROM  site_settings  WHERE id=1";
//  exit;
    try {
        $db = getConnection();
		$stmt = $db->query($sql);
        $stmt->execute();
        $getmembership = $stmt->fetchAll(PDO::FETCH_OBJ);

        //print_r($getcategories);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getmembership as $membership) {
			
			$shopDetails = "select * FROM shops WHERE `user_id`='" . $user_id. "'";
		    $stmtshopDetails = $db->query($shopDetails);
		    $shopData = $stmtshopDetails->fetchObject();
		    $shop_last_date=$shopData->last_date;
			$shop_id=$shopData->id;
			
			if($today_date>$shop_last_date)
			{
			$renew_status=1;
			}
			else
			{
			$renew_status=0;
			}
			
          

			$allmembership[] = array(
			"shop_id" => stripslashes($shop_id),
			"shop_price_per_month" => stripslashes($membership->shop_price_per_month),
			"can_post_number_of_listing" => stripslashes($membership->can_post_number_of_listing),
			"price_per_listing" => stripslashes($membership->price_per_listing),
			"price_per_listing" => stripslashes($membership->price_per_listing),
			"renew_status" => stripslashes($renew_status));
					
					
            }
            $data['all_membership'] = $allmembership;
            $data['Ack'] = 1;
        } else {
            $data['all_membership'] = '';
            $data['Ack'] = 0;
        }

        $db = null;
        //    echo '{"categories": ' . json_encode($categories) . '}';
    } catch (PDOException $e) {
        $data['all_membership'] = '';
        $data['Ack'] = 0;
    }

    echo json_encode($data);
    exit;
}

	function renewpayment() {
	
	$data = array();
	$app = new Slim();
	$request = Slim::getInstance()->request();
	$body = ($request->post());
	
	$shop_id = $body['shop_id'];
	$user_id = $body['user_id'];
    $transaction_id = $body['transaction_id'];
	$payment_status = "Completed";
	$paid_amount = $body['paid_amount'];
	$paid_on=date('Y-m-d H:i:s');
	$is_active=1;
	$last_date=date('Y-m-d H:i:s', strtotime("+30 days"));
	
	
	$sql = "UPDATE shops SET is_active=:is_active, paid_on=:paid_on, last_date=:last_date  WHERE id=:id";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("is_active", $is_active);
	$stmt->bindParam("paid_on", $paid_on);
	$stmt->bindParam("last_date", $last_date);
	$stmt->bindParam("id", $shop_id);
	$stmt->execute();
	
	$sql6 = "INSERT INTO payments (userid, amount, datetime, status, transaction_id) VALUES (:user_id, :paid_amount, :paid_on, :payment_status, :transaction_id)";

	$stmt6 = $db->prepare($sql6);
	$stmt6->bindParam("user_id", $user_id);
	$stmt6->bindParam("paid_amount", $paid_amount);
	$stmt6->bindParam("paid_on", $paid_on);
	$stmt6->bindParam("payment_status", $payment_status);
	$stmt6->bindParam("transaction_id", $transaction_id);
	$stmt6->execute();
	//   
	
	$lastID = $db->lastInsertId();
	$data['last_id'] = $lastID;
	$data['Ack'] = '1';
	$data['msg'] = 'Shop Payment Completed Successfully...';
	
	
	
	$db = null;
	//echo json_encode($user);
	} catch (PDOException $e) {
	print_r($e);
	//error_log($e->getMessage(), 3, '/var/tmp/php.log');
	$data['last_id'] = '';
	$data['Ack'] = '0';
	$data['msg'] = 'Error !!!';
	}
	
	
	
	
	echo json_encode($data);
	exit;
	}

function getpaypalemail() {
    $data = array();
    $allemail = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());

    $sql = "select * FROM  site_settings  WHERE id=1";
//  exit;
    try {
        $db = getConnection();
		$stmt = $db->query($sql);
        $stmt->execute();
        $setting = $stmt->fetchObject();

        //print_r($getcategories);

        $count = $stmt->rowCount();
        if ($count > 0) {

			$paypal_email=$setting->paypal_email;
			
          

			$allemail[] = array(
			"paypal_email" => stripslashes($paypal_email));
					
					
           
            $data['all_email'] = $allemail;
            $data['Ack'] = 1;
        } else {
            $data['all_email'] = '';
            $data['Ack'] = 0;
        }

        $db = null;
        //    echo '{"categories": ' . json_encode($categories) . '}';
    } catch (PDOException $e) {
        $data['all_email'] = '';
        $data['Ack'] = 0;
    }

    echo json_encode($data);
    exit;
}


?>
