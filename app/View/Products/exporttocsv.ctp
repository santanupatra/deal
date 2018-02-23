<?php

//foreach($headers as $header):

     $csv_output .="Name , ";
     $csv_output .="SKU , ";
     $csv_output .="Quantity , ";
     $csv_output .="Categories , ";
     $csv_output .="Price , ";
     $csv_output .="Size , ";
     $csv_output .="Color , ";
     $csv_output .="Material , ";
     $csv_output .="Shipping Time , ";
     $csv_output .="Image , ";
     $csv_output .="Item Weight , ";
     //$csv_output .="Item Description , ";
//endforeach;
$csv_output .="\n";
//pr($values);exit;
if(!empty($values)){
foreach($values as $value):

     $csv_output .=$value['Product']['name'].", ";
     $csv_output .=$value['Product']['product_code'].", ";
     $csv_output .=$value['Product']['quantity'].", ";
     $csv_output .=$value['Category']['name'].", ";
     $csv_output .=$value['Product']['price'].", ";
     $csv_output .=str_replace(',','/',$value['Product']['size']).", ";
     $csv_output .=$value['Product']['color'].", ";
     $csv_output .=$value['Product']['material'].", ";
     $csv_output .=$value['ShippingDay']['ship_day'].", ";
     $csv_output .=$value['ProductImage'][0]['name'].", ";
     $csv_output .=$value['Product']['package_weight'].", ";
     //$csv_output .=$value['Product']['item_description'].", ";
     
     $csv_output .="\n";

endforeach;

}
else{
echo "There is no data to export.";
}

$filename = "export_".date("Y-m-d_H-i",time());
header("Content-type: application/vnd.ms-excel");
header("Content-disposition: csv" . date("Y-m-d") . ".csv");
header("Content-disposition: filename=".$filename.".csv");

print $csv_output;

exit;
?>