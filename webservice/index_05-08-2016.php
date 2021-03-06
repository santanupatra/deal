<?php

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



function home() {
    $data = array();
    $allproducts = array();
	$productImagesData = array();
	$allshops = array();
	$allbanners = array();
/*	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$key = $body['key'];*/
	
    try {
        $sql = "SELECT * FROM products WHERE `is_featured`='Y' ORDER BY name";
        $db = getConnection();
        $stmt = $db->prepare($sql);
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
        $sql = "SELECT * FROM shops WHERE is_active=:is_active AND is_featured=:is_featured ORDER BY name DESC limit 4";

        $stmt2 = $db->prepare($sql);
        $stmt2->bindParam("is_active", $is_active);
		$stmt2->bindParam("is_featured", $is_featured);
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

        $sql3 = "SELECT * FROM banners WHERE 1";

        $stmt3 = $db->prepare($sql3);
        $stmt3->execute();
        $getbanners = $stmt3->fetchAll(PDO::FETCH_OBJ);
       $count = $stmt3->rowCount();
        if ($count > 0) {
            foreach ($getbanners as $banners) {
			
			if($shops->logo!=''){
			$banner_url=SITE_URL . 'app/webroot/banner_image/' . $banners->image;
			}
			else{
			$banner_url='';
			}

                $allbanners[] = array(
                    "id" => stripslashes($shops->id),
                    "title" => stripslashes($shops->title),
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
	
		
    try {
        $sql = "SELECT * FROM products WHERE category_id=:category_id ORDER BY name DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("category_id", $category_id);
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
			$logo=SITE_URL . 'app/webroot/shop_images/' . $img_products->name;
			}
			else{
			$logo='';
			}
			if($shops->cover_photo!=''){
			$cover_photo=SITE_URL . 'app/webroot/shop_images/' . $img_products->name;
			}
			else{
			$cover_photo='';
			}
			



				
			//	print_r($productImagesData);

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



	$sql = "INSERT INTO users (user_id, shop_id, name, sku, quantity, sold_quantity, category_id, sub_category_id, is_featured, unit_type, quantity_lot, price_lot, keywords, shipping_time, processing_time, sale_on, discount, start_date, end_date, package_weight, package_unit, package_size1, package_size2, package_size3, package_size_unit, status, return_policy, item_specification, item_description, delivery_terms) VALUES (:user_id, :shop_id, :name, :sku, :quantity, :sold_quantity, :category_id, :sub_category_id, :is_featured, :unit_type, :quantity_lot, :price_lot, :keywords, :shipping_time, :processing_time, :sale_on, :discount, :start_date, :end_date, :package_weight, :package_unit, :package_size1, :package_size2, :package_size3, :package_size_unit, :status, :return_policy, :item_specification, :item_description, :delivery_terms)";
	
	try {
	$db = getConnection();
	$stmt = $db->prepare($sql);
	$stmt->bindParam("user_id", $user_id);
	$stmt->bindParam("shop_id", $last_name);
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
	$is_active = 0;
	$created_at = date('Y-m-d H:i:s');
	
	$logo='';
	$cover_photo='';
	
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
	$db = getConnection();
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





	function productDetails() {
	$data = array();
	$allproducts = array();
	$productImagesData = array();
	$productAllReviews = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$id = $body['prd_id'];
	
	
	try {
	$sql = "SELECT * FROM products WHERE id=:id";
	$db = getConnection();
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
	
	
	$productReviews = "select * FROM ratings WHERE `product_id`='" . $products->id . "'";
	$stmtProductReview = $db->query($productReviews);
	$productAllReviews = $stmtProductReview->fetchAll(PDO::FETCH_OBJ);
	
	$isReviewExists = $stmtProductReview->rowCount();
	if ($isReviewExists > 0) {
	
	//	$image_url = SITE_URL . 'upload/product/' . $productImages->image;
	foreach ($productAllReviews as $reviews) {
	//echo '<pre>';
	//print_r($img_products);
	$productAllReviews[]=array(
	"product_id" => stripslashes($reviews->product_id),
	"shop_id" => stripslashes($reviews->shop_id),
	"user_id" => stripslashes($reviews->user_id),
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
	"productReviews" => $productAllReviews,
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
	$stmt->bindParam("prd_id", $prd_id);
	$stmt->execute();
	$db = null;
	$data['Ack'] = '1';
	$data['msg'] = 'Product Removed Successfully';
	} catch (PDOException $e) {
	$data['Ack'] = '0';
	$data['msg'] = 'There are some Error!!!';
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
            $TemplateMessage = "Wellcome and thank you for registering at freshqatar.com!<br />";
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
			$stmtCartInsert->bindParam("price", $getProductdetails->price_lot);
			$stmtCartInsert->bindParam("quantity", $quantity);
			$stmtCartInsert->bindParam("shipping_address", $getProductdetails->shipping_time);
			$stmtCartInsert->bindParam("shipping_time", $getProductdetails->shipping_time);
			$stmtCartInsert->bindParam("processing_time", $getProductdetails->processing_time);
			$stmtCartInsert->bindParam("product_woner_id", $getProductdetails->user_id);
			$stmtCartInsert->bindParam("pay_amt", $getProductdetails->price_lot);
			$stmtCartInsert->bindParam("cdate", date('Y-m-d H:i:s'));
            $stmtCartInsert->execute();
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
                $data['Ack'] = '2';
                $data['msg'] = 'Product Updated Successfully';
            }
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
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	
	
	
    try {

        $sql = "SELECT * FROM temp_carts WHERE user_id=:user_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $products) {

/*                $productDetails = "select * FROM freshquater_product WHERE `id`='" . $products->productid . "'";
                $stmtProductDetails = $db->query($productDetails);
                $productData = $stmtProductDetails->fetchObject();

                if ($productData->img == '') {
                    $image_url = SITE_URL . 'upload/no.png';
                } else {
                    $image_url = SITE_URL . 'upload/product/' . $productData->img;
                }*/

                $allproducts[] = array(
                    "user_id" => stripslashes($products->user_id),
                    "shop_id" => stripslashes($products->shop_id),
                    "prd_id" => stripslashes(strip_tags($products->prd_id)),
                    "name" => stripslashes(strip_tags($products->name)),
                    "price" => stripslashes($products->price),
					"quantity" => stripslashes($products->quantity),
					"shipping_address" => stripslashes($products->shipping_address),
					"shipping_time" => stripslashes($products->shipping_time),
					"processing_time" => stripslashes($products->processing_time),
					"product_woner_id" => stripslashes($products->product_woner_id),
					"pay_amt" => stripslashes($products->pay_amt),
					"image" => SITE_URL . $products->image,
                    "cdate" => stripslashes($cdate));
            }

            $data['all_cart_items'] = $allproducts;
            $data['Ack'] = 1;
        } else {

            $data['all_cart_items'] = '';
            $data['Ack'] = 0;
        }
    } catch (PDOException $e) {
        $data['all_cart_items'] = '';
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
	$is_primary = $body['is_primary'];
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

        $sql = "INSERT INTO shipping_addresses (full_name, street, apartment, city, state, zip_code, phn_no, country, user_id) VALUES (:full_name, :street, :apartment, :city, :state, :zip_code, :phn_no, :country, :user_id)";
	
	}
	else{
	
    $sql = "UPDATE shipping_addresses SET full_name=:full_name, street=:street, apartment=:apartment, city=:city, state=:state, zip_code=:zip_code, phn_no=:phn_no, country=:country WHERE user_id=:user_id";
	
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
	$store_id = $body['store_id'];
	

    $sql = "SELECT * FROM wishlist WHERE user_id=:user_id AND product_id=:product_id";

    try {
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("product_id", $product_id);
        $stmt->execute();
        $isExistsWishlist = $stmt->fetchObject();
        $count = $stmt->rowCount();
        if ($count == 0) {
            $sql = "INSERT INTO wishlist (user_id, product_id, store_id, date) VALUES (:user_id, :product_id, :store_id, :date)";

            $stmt = $db->prepare($sql);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("product_id", $product_id);
			$stmt->bindParam("store_id", $store_id);
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
	
	
    $sql = "DELETE FROM wishlist WHERE user_id=:user_id AND product_id=:product_id";
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
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
	
    try {

        $sql = "SELECT * FROM wishlist WHERE user_id=:user_id";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $products) {

			$productDetails = "select * FROM freshquater_product WHERE `id`='" . $products->product_id . "'";
			$stmtProductDetails = $db->query($productDetails);
			$productData = $stmtProductDetails->fetchObject();
				

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


                $allproducts[] = array(
                    "id" => stripslashes($productData->id),
                    "name" => stripslashes($productData->name),
                    "sku" => stripslashes(strip_tags($productData->sku)),
					"category_id" => stripslashes($productData->category_id),
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

function getOrderList() {
    $data = array();
    $allorders = array();
	
	$app = new Slim();
	//    echo $paramValue = $app->request->get('fname');
	$request = Slim::getInstance()->request();
	//$user = json_decode($request->getBody());
	$body = ($request->post());
	
	$user_id = $body['user_id'];
	
    try {

        $sql = "SELECT * FROM orders WHERE user_id=:user_id order by `id` DESC";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("user_id", $user_id);
        $stmt->execute();
        $getorders = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getorders as $orders) {

                if ($orders->status == "0") {
                    $order_status = "Processing Order";
                }
                if ($orders->status == "1") {
                    $order_status = "Delivered";
                }
                if ($orders->status == "2") {
                    $order_status = "Completed";
                }

                //$tans_id=$products->order_from_device.$products->unique_trans_id;


				$allorders[] = array(
				"id" => stripslashes($orders->id),
				"user_id" => stripslashes($orders->user_id),
				"store_id" => stripslashes($orders->store_id),
				"store_woner_id" => stripslashes($orders->store_woner_id),
				"total_amount" => stripslashes($orders->total_amount),
				"order_date" => stripslashes($orders->order_date),
				"transaction_id" => stripslashes($orders->transaction_id),
				"shipping_address" => stripslashes($orders->shipping_address),
				"pay_key" => stripslashes($orders->pay_key),
				"payment_date" => stripslashes($orders->payment_date),
				"notes" => stripslashes($orders->notes));
				
				
            }
            $data['allorders'] = $allorders;
            $data['Ack'] = 1;
            $data['msg'] = 'Records Found';
        } else {
            $data['allorders'] = '';
            $data['Ack'] = 0;
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

function getOederDetails() {
    $data = array();
    $allproducts = array();
	
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
		
		
		
		$allproducts[] = array(
		"id" => stripslashes($products->id),
		"product_id" => stripslashes($products->product_id),
		"shop_id" => stripslashes($products->shop_id),
		"owner_id" => stripslashes($products->owner_id),
		"cancel_transcation_id" => stripslashes($products->cancel_transcation_id),
		"quantity" => stripslashes($products->quantity),
		"shipping_cost" => stripslashes($products->shipping_cost),
		"coupon_id" => stripslashes($products->coupon_id),
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
    //    echo $paramValue = $app->request->get('fname');
    $request = Slim::getInstance()->request();
    //$user = json_decode($request->getBody());
    $body = ($request->post());

    $user_id = $body['user_id'];
    $fname = $body['fname'];
    $lname = $body['lname'];
    $b_address1 = $body['b_address1'];
    $b_address2 = $body['b_address2'];
    $b_state = $body['b_state'];
    $b_city = $body['b_city'];
    $b_postal = $body['b_postal'];
    $phone = $body['phone'];
    $email = $body['email'];
    $special_instructions = $body['special_instructions'];

    /* if($special_instructions=="")
      {
      $special_instructions='';
      }
      else
      {
      $special_instructions = $body['special_instructions'];
      } */

    $total_price = $body['total_price'];
    $today = date("Y-m-d H:i:s");
    // $unique_trans_id=time();
    $status = 1;

    $sql = "INSERT INTO freshquater_billing (billing_fname, billing_lname, billing_add, email, billing_city, billing_zip, billing_state, billing_ephone, shiping_fname, shiping_lname, shiping_add, email1, shiping_city, shiping_state, shiping_zip, shiping_ephone) VALUES (:fname, :lname, :b_address1, :email, :b_city, :b_postal, :b_state, :phone, :shiping_fname, :shiping_lname, :shiping_add, :email1, :shiping_city, :shiping_state, :shiping_zip, :shiping_ephone)";


    try {

        $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("fname", $fname);
        $stmt->bindParam("lname", $lname);
        $stmt->bindParam("b_address1", $b_address1);
        $stmt->bindParam("email", $email);
        $stmt->bindParam("b_city", $b_city);
        $stmt->bindParam("b_postal", $b_postal);
        $stmt->bindParam("b_state", $b_state);
        $stmt->bindParam("phone", $phone);
        $stmt->bindParam("shiping_fname", $fname);
        $stmt->bindParam("shiping_lname", $lname);
        $stmt->bindParam("shiping_add", $b_address1);
        $stmt->bindParam("email1", $email);
        $stmt->bindParam("shiping_city", $b_city);
        $stmt->bindParam("shiping_state", $b_state);
        $stmt->bindParam("shiping_zip", $b_postal);
        $stmt->bindParam("shiping_ephone", $phone);
        $stmt->execute();
        $billingID = $db->lastInsertId();


        $sql = "SELECT IFNULL(MAX(unique_trans_id),0) as max_id FROM freshquater_orders WHERE `payment_status` =  '1' and order_from_device='M'";
        $db = getConnection();
        $stmt = $db->prepare($sql);
        //$stmt->bindParam("id", $getOrderData->id);
        $stmt->execute();
        //$getOrderdetail = $stmt->fetchAll(PDO::FETCH_OBJ);
        //$getBillingDetails = $stmt->fetchObject();

        $rowMaxid = $stmt->fetch();


        //$queryMaxId="SELECT IFNULL(MAX(unique_trans_id),0) as max_id FROM freshquater_orders WHERE `payment_status` =  '1' and order_from_device='M' ";
//$resMaxid=mysql_query($queryMaxId);
//$rowMaxid=mysql_fetch_assoc($resMaxid);

        if ($rowMaxid['max_id'] == 0) {
            $max_id = 1000;
        } else {
            $max_id = $rowMaxid['max_id'] + 1;
        }




        $order_from_device = 'M';
        $payment_status = 1;

        $sqlorder = "INSERT INTO freshquater_orders (special_instructions, user_id, price, f_name, l_name, address1, state, phone, city, zip, unique_trans_id, status, billing_id, date,order_from_device,payment_status) VALUES (:special_instructions, :user_id, :price, :f_name, :l_name, :address1, :state, :phone, :city, :zip,
     :unique_trans_id, :status, :billing_id, :date,:order_from_device,:payment_status)";


        $stmt = $db->prepare($sqlorder);
        $stmt->bindParam("special_instructions", $special_instructions);
        $stmt->bindParam("user_id", $user_id);
        $stmt->bindParam("price", $total_price);
        $stmt->bindParam("f_name", $fname);
        $stmt->bindParam("l_name", $lname);
        $stmt->bindParam("address1", $b_address1);
        $stmt->bindParam("state", $b_state);
        $stmt->bindParam("phone", $phone);
        $stmt->bindParam("city", $b_city);
        $stmt->bindParam("zip", $b_postal);
        $stmt->bindParam("unique_trans_id", $max_id);
        $stmt->bindParam("status", $status);
        $stmt->bindParam("billing_id", $billingID);
        $stmt->bindParam("date", $today);
        $stmt->bindParam("order_from_device", $order_from_device);
        $stmt->bindParam("payment_status", $payment_status);
        $stmt->execute();
        $orderid = $db->lastInsertId();

        $sql = "SELECT * FROM freshquater_cart WHERE userid=:userid";
//    $db = getConnection();
        $stmt = $db->prepare($sql);
        $stmt->bindParam("userid", $user_id);
        $stmt->execute();
        $getproducts = $stmt->fetchAll(PDO::FETCH_OBJ);

        $count = $stmt->rowCount();
        if ($count > 0) {
            foreach ($getproducts as $products) {

                $productDetails = "select * FROM freshquater_product WHERE id='" . $products->productid . "'";
                $stmtProductDetails = $db->query($productDetails);
                $productData = $stmtProductDetails->fetchObject();



                $current_date = date('Y-m-d');

                $insertOrderDetails = "insert into freshquater_tblorderdetails (orderid,productid,quantity , user_id,date ) values(:orderid,:productid,:quantity,:user_id,:date)";

                $stmt = $db->prepare($insertOrderDetails);
                $stmt->bindParam("orderid", $orderid);
                $stmt->bindParam("productid", $productData->id);
                $stmt->bindParam("quantity", $products->quantity);
                $stmt->bindParam("user_id", $user_id);
                $stmt->bindParam("date", $current_date);
                $stmt->execute();
            }



            $sql = "SELECT * FROM freshquater_orders WHERE id=:id";
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $orderid);
            $stmt->execute();
            $count = $stmt->rowCount();


            $getOrderData = $stmt->fetchObject();
            if ($getOrderData->special_instructions != "") {
                $special_instructions = $getOrderData->special_instructions;
            } else {
                $special_instructions = 'No such notes !';
            }

            $sql = "SELECT * FROM `freshquater_user` WHERE id=:id ";
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $getOrderData->user_id);
            $stmt->execute();
            $getUserDetails = $stmt->fetchObject();

            $sql = "SELECT * FROM `freshquater_billing` WHERE billing_id=:billing_id ";
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("billing_id", $getOrderData->billing_id);
            $stmt->execute();
            $getBillingDetails = $stmt->fetchObject();


            $sql = "SELECT * FROM freshquater_tblorderdetails where orderid=:id ";
            $db = getConnection();
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $getOrderData->id);
            $stmt->execute();
            //$getOrderdetail = $stmt->fetchAll(PDO::FETCH_OBJ);
            //$getBillingDetails = $stmt->fetchObject();

            $getOrderdetail = $stmt->fetchAll(PDO::FETCH_ASSOC);







            $subject = "FreshQatar.com - Order " . $getOrderData->order_from_device . $getOrderData->unique_trans_id;
            $TemplateMessage = '';
            $TemplateMessage.="<img src='http://freshqatar.com/images/logo-new.png' /><br>";
            $TemplateMessage.= "<br>Thank you for your shopping at freshqatar.com using our apps!<br>
	Your order has been received and is being processed.<br>
	To view your order, <a href='http://freshqatar.com/order.php'>click here</a><br>Our driver will call you within 30 minutes to confirm the order delivery time.<br>There will be a slight difference in the amount depending on the daily fresh products availability. <br>Our standard delivery time starts from 3pm until 10pm daily.Please keep the cash handy for the delivery boy and check the items delivered.<br>For any suggestion or changes, please call 55431523 or send email to info@freshqatar.com";

            $TemplateMessage.= "<br>A new Order Received with the following details:<br/>";
            $TemplateMessage.="<h3>Order details For #" . $getOrderData->order_from_device . $getOrderData->unique_trans_id . "</h3>";


            $TemplateMessage.="<table width='100%' cellspacing='0' cellpadding='0' border='0' class='table table-listing'>
	<tr>
	<td><ul>
	<li style='list-style:none; background-color:#009900;margin-bottom:6px; color:#ffffff'><b>Customer Details</b></li>
	<li style='list-style:none;'><span>Customer Name :</span>" . $getUserDetails->fname . "&nbsp;" . $getUserDetails->lname . "</li>
	<li style='list-style:none;'><span>Email :</span>" . $getUserDetails->email . "</li>
	<li style='list-style:none;'><span>Contact No :</span>" . $getUserDetails->phone . "</li>
	<li style='list-style:none;'>&nbsp;</li>
	</ul></td>
	
	<td><ul>
	<li style='list-style:none; background-color:#009900;margin-bottom:6px; color:#ffffff'><b>Payment Details</b></li>
	<li style='list-style:none;'><span>Payment Type :</span>COD</li>
	<li style='list-style:none;'><span>Transaction ID :</span>" . $getOrderData->order_from_device . $getOrderData->unique_trans_id . "</li>
	<li style='list-style:none;'><span>Amount :</span>" . $getOrderData->price . " QR</li>
	<li style='list-style:none;'><span>Payment Date : </span>" . $getOrderData->date . "</li>";





            $TemplateMessage.=" <li style='list-style:none;'><span>Customer Notes : </span>" . $special_instructions . "</li>";


            $TemplateMessage.="
	</ul></td>
	</tr>
	<tr>
	<td><ul>
	<li style='list-style:none; background-color:#009900;margin-bottom:6px; color:#ffffff'><b>Billing Details</b></li>
	<li style='list-style:none;'><span>Address :</span>" . $getBillingDetails->billing_add . "</li>
	<!--    <li><span>City :</span>" . $getBillingDetails->billing_city . "</li>
	<li style='list-style:none;'><span>Zip:</span>" . $getBillingDetails->billing_zip . "</li>
	<li style='list-style:none;'><span>State : </span>" . $getBillingDetails->billing_state . "</li>-->
	<li style='list-style:none;'><span>Phone : </span>" . $getBillingDetails->billing_ephone . "</li>
	<li style='list-style:none;'><span>Email : </span>" . $getUserDetails->email . "</li>";

            if ($getUserDetails->my_latitude != '' && $getUserDetails->my_longitude) {
                $TemplateMessage.="<li style='list-style:none;'><span><a href='http://maps.google.com/maps?q=" . $getUserDetails->my_latitude . "," . $getUserDetails->my_longitude . "'>Click Here</a> for GPS Location</li>";
            }


            $TemplateMessage.="</ul></td>
	<!--<td><ul>
	<li style='list-style:none; background-color:#009900;'><b>Shipping Details</b></li>
	<li style='list-style:none;'><span>Address :</span>" . $getBillingDetails->shiping_add . "</li>
	<li style='list-style:none;'><span>City :</span>" . $getBillingDetails->shiping_city . "</li>
	<li style='list-style:none;'><span>Zip:</span>" . $getBillingDetails->shiping_zip . "</li>
	<li style='list-style:none;'><span>State : </span>" . $getBillingDetails->shiping_state . "</li>
	</ul></td>-->
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


                $sql = "SELECT * FROM `freshquater_product` WHERE id=:id ";
                $db = getConnection();
                $stmt = $db->prepare($sql);
                $stmt->bindParam("id", $resultOrderDetails['productid']);
                $stmt->execute();
                $getProductDetails = $stmt->fetchObject();

                if ($getProductDetails->img == '') {
                    $imgage = 'upload/no.png';
                } else {
                    $imgage = 'http://freshqatar.com/upload/product/' . $getProductDetails->img;
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
	" . $getProductDetails->regular_price . "
	</td>
	<td>
	" . $total = ($resultOrderDetails['quantity']) * ($getProductDetails->regular_price) .
                        " QR</td>
	
	</tr>";
                $tpc = ($resultOrderDetails['quantity']) * ($getProductDetails->regular_price);
                $mailprice = $tpc + $mailprice;
            }

            $TemplateMessage.="</table>";






            $sql = "DELETE FROM freshquater_cart WHERE userid=:userid";
            $stmt = $db->prepare($sql);
            $stmt->bindParam("userid", $user_id);
            $stmt->execute();
            $db = null;



            $data['Ack'] = 1;
            $to = $email;

            // $subject = "freshqatar.com-order confirmation";
            // $TemplateMessage = "Hi #".$orderid."<br/>Your order submited sucessfully from our app at freshqatar.com!<br />";
            // $TemplateMessage .= "Thanks,<br />";
            //  $TemplateMessage .= "freshqatar.com<br />";



            $header = "From:info@freshqatar.com \r\n";
            // $header .= "Cc:nits.soumen.com \r\n";
            $header .= "MIME-Version: 1.0\r\n";
            $header .= "Content-type: text/html\r\n";

            $retval = mail($to, $subject, $TemplateMessage, $header);


            // admin

            $sql = "select * from `freshquater_tbladmin` where `id` = '1'";
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
            mail($admin_email, $subject, $TemplateMessage, $headers);
        } else {
            $data['Ack'] = 0;
        }
    } catch (PDOException $e) {
        $data['Ack'] = 2;
        //echo '{"error":{"text":'. $e->getMessage() .'}}';
    }
    echo json_encode($data);
    exit;
}


?>
