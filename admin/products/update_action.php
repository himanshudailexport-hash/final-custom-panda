<?php
include "../../config/db.php";
header('Content-Type: application/json');

$response=['status'=>'error','message'=>'Something went wrong'];

if($_SERVER['REQUEST_METHOD']=='POST'){

$id=(int)$_POST['id'];

$product=$conn->query("SELECT * FROM products WHERE id=$id")->fetch_assoc();

$name=$_POST['name'];
$category_id=$_POST['category_id'];
$price=$_POST['price'];
$stock=$_POST['stock'];
$discount_price=$_POST['discount_price'];
$sku_id=$_POST['sku_id'];
$color=$_POST['color'];
$size=$_POST['size'];
$description=$_POST['description'];
$fabric=$_POST['fabric'];
$rating=$_POST['rating'];

$new_arrivals=$_POST['new_arrivals'];
$best_sales=$_POST['best_sales'];
$trending=$_POST['trending'];

$brand_name=$_POST['brand_name'];

$uploadDir="../../uploads/products/";

function updateImg($key,$old,$dir){

if(!empty($_FILES[$key]['name'])){

if($old && file_exists("../../".$old)){
unlink("../../".$old);
}

$path=$dir.time().'_'.basename($_FILES[$key]['name']);

move_uploaded_file($_FILES[$key]['tmp_name'],$path);

return $path;
}

return $old;
}

$img1=updateImg('img1',$product['img1'],$uploadDir);
$img2=updateImg('img2',$product['img2'],$uploadDir);
$img3=updateImg('img3',$product['img3'],$uploadDir);
$img4=updateImg('img4',$product['img4'],$uploadDir);

$stmt=$conn->prepare("

UPDATE products SET

name=?,category_id=?,price=?,stock=?,discount_price=?,sku_id=?,color=?,size=?,description=?,fabric=?,

new_arrivals=?,best_sales=?,trending=?,brand_name=?,rating=?,

img1=?,img2=?,img3=?,img4=?

WHERE id=?

");

$stmt->bind_param(

"siiiisssssiiisdssssi",

$name,
$category_id,
$price,
$stock,
$discount_price,
$sku_id,
$color,
$size,
$description,
$fabric,
$new_arrivals,
$best_sales,
$trending,
$brand_name,
$rating,
$img1,
$img2,
$img3,
$img4,
$id

);

if($stmt->execute()){

$response=[
'status'=>'success',
'message'=>'Product Updated Successfully'
];

}

}

echo json_encode($response); 