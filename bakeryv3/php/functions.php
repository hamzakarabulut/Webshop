<?php

/* Product List */

// function getAllItems(){
//     global $fpconnection;

//     $sql = "SELECT * FROM products";
//     $result = $fpconnection->query($sql);

//     return $result;
// }

/* Order List */

function getAllOrdersOfUser($user_id){
    global $fpconnection;

    $sql = "SELECT * FROM orders WHERE user_id=".$user_id;
    $result = $fpconnection->query($sql);

    return $result;
}

function getUser($user_id){
    global $fpconnection;

    $sql = "SELECT * FROM bakeryuser WHERE userId=".$user_id;
    $result = $fpconnection->query($sql);

    return $result->fetch_array(MYSQLI_ASSOC);
}

function getOrder($siparis_id){
    global $fpconnection;

    $sql = "SELECT * FROM orders WHERE id=".$siparis_id;
    $result = $fpconnection->query($sql);

    return $result->fetch_array(MYSQLI_ASSOC);
}

function getOrderedProducts($siparis_id){
    global $fpconnection;

    $sql = "SELECT * FROM order_items WHERE order_id=".$siparis_id;
    $result = $fpconnection->query($sql);

    return $result;
}

function addOrder($user_id, $shipment_type, $total, $shipment, $adress, $tel){
    global $fpconnection;
    
    $tarih = date("Y-m-d H:i:s");

    $sql = "INSERT INTO 
    orders(id, user_id, shipment_type, total, shipment, adress, tel, order_date) 
    VALUES
    (NULL, $user_id, '$shipment_type', $total, $shipment, '$adress', $tel, '$tarih' )";

   // SQL komutunu calistir
    if($fpconnection->query($sql) == TRUE){
        return $fpconnection->insert_id; //
    }
    else{
        var_dump($fpconnection->error);
        return false;
    }
}

function addProductsToOrder($order_id, $artikel_id, $quantity){
    global $fpconnection;
    
    $sql = "INSERT INTO 
    order_items(id, order_id, artikel_id, quantity) 
    VALUES
    (NULL, $order_id, $artikel_id, $quantity )";

   // SQL komutunu calistir
    if($fpconnection->query($sql) == TRUE){
        return true;
    }
    else{
        var_dump($fpconnection->error);
        return false;
    }
}

// function urunGetir($urun_id){
//     global $fpconnection;

//     $sql = "SELECT * FROM products WHERE id=".$urun_id;
//     $result = $fpconnection->query($sql);

//     return $result->fetch_array(MYSQLI_ASSOC);
// }

/* Cart */

function addToCart($user_id, $artikel_id){
    global $fpconnection;


    // Überprüfen Sie, ob sich Produkte im Warenkorb befinden
    $sql = "SELECT * FROM cart WHERE user_id=".$user_id." AND artikel_id=".$artikel_id;
    $result = $fpconnection->query($sql);

    
   if( mysqli_num_rows ( $result ) == 0 ){ // zum Warenkorb neuer Eintrag
    $sql = "INSERT INTO cart(id,user_id,artikel_id,quantity) VALUES
    (NULL, $user_id, $artikel_id, 1 )";

   }
   else{ // im Warenkorb gibt es bereits Proudukt deswegen erhöht die quantitiy
    $sql ="UPDATE cart  SET quantity=quantity + 1 WHERE user_id=".$user_id." AND artikel_id=".$artikel_id;
   }

   // SQL Abfrage
    if($fpconnection->query($sql) == TRUE){
        return true;
    }
    else{
        return false;
    }
}


function getCart($user_id){
    global $fpconnection;

    $sql = "SELECT * FROM cart WHERE user_id=".$user_id;
    $result = $fpconnection->query($sql);

    return $result;
}

function clearCart($user_id){
    global $fpconnection;

    $sql = "DELETE FROM cart WHERE user_id=".$user_id;
    $fpconnection->query($sql);
}

function getProduct($urun_id){
    global $fpconnection;

    $sql = "SELECT * FROM products WHERE id=".$urun_id;
    $result = $fpconnection->query($sql);

    return $result->fetch_array(MYSQLI_ASSOC);
}

function deleteProduct($id){
    global $fpconnection;

    $sql = "DELETE FROM cart WHERE id=".$id;
    return $fpconnection->query($sql);
}

function reduceAmount($id){
    global $fpconnection;
    $sql = "SELECT * FROM cart WHERE id='$id'";
    $result = $fpconnection->query($sql);
    if($result->num_rows > 0){
        mysqli_query($fpconnection, "UPDATE cart SET  quantity=quantity - 1 WHERE id='$id'");
    
        return $fpconnection->query($sql);
    }
}
