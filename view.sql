CREATE OR REPLACE VIEW  itemsview AS
SELECT items.* , categories.* FROM items 
INNER JOIN  categories on  items.items_cat = categories.categories_id


// يعني اعملي حقل favorite  وهمي قيمته = 1 في جدول itemsview 
SELECT itemsview.* , 1 AS favorite FROM itemsview 
//وهات المشترك بين جدول itemsview و favorite عندما favorite.favorite_itemsid = itemsview.items_id
INNER JOIN favorite ON favorite.favorite_itemsid = itemsview.items_id AND
// وكذلك عندماfavorite.favorite_usersid = 37
favorite.favorite_usersid = 37
// بالاضافة الي ماسبق هاتلي
UNION ALL
// كل الحقول في جدول itemsview مع اضافة حقل favorite وتكون قيمته = 0
SELECT itemsview.* ,0 AS favorite FROM itemsview 
// وذلك بدون ان يساوي حقل items_id الشرط الاول كله
WHERE items_id != ( SELECT itemsview.items_id FROM itemsview
INNER JOIN favorite ON favorite.favorite_itemsid = itemsview.items_id AND
favorite.favorite_usersid = 37 );


CREATE OR REPLACE VIEW myfavorite AS
SELECT favorite.* , items.* , users.users_id FROM favorite
INNER JOIN users ON users.users_id = favorite.favorite_usersid
INNER JOIN items ON items.items_id = favorite.favorite_itemsid 


// هات كمية او عدد المنتج المضاف للمفضلة
SELECT COUNT(cart.cart_id) AS countitems FROM cart WHERE cart.cart_usersid = $usersid AND cart.cart_itemsid = $itemsid 


//اعملي جدول cartview اجمعلي فية السعر والعدد وهات بقية الاعمدة اللي في 
//items ,cart من خلال grop by كلا من cart_usersid ,cart_itemsid
CREATE OR REPLACE VIEW cartview AS
SELECT SUM(items.items_price - items_price * items_discount / 100) AS itemsprice , COUNT(cart_itemsid) AS countitems,items.*,cart.* FROM cart 
INNER JOIN items ON items.items_id = cart.cart_itemsid
WHERE cart_orders = 0
GROUP BY cart.cart_usersid , cart.cart_itemsid , cart.cart_orders

//بناءا علي رقم usersid و رقم itemsid وما تقرب عليهم


SELECT SUM(cartview.itemsprice) AS totalprice , sum(cartview.countitems) as totalitems FROM cartview
WHERE cartview.cart_usersid = 40
GROUP BY cartview.cart_usersid 


CREATE OR REPLACE VIEW ordersview AS
SELECT orders.*,address.* FROM orders
LEFT JOIN address ON address.address_id = orders.orders_address


CREATE OR REPLACE VIEW ordersdetailsview AS
SELECT SUM(items.items_price - items_price * items_discount / 100) AS itemsprice , COUNT(cart_itemsid) AS countitems,items.*,cart.* FROM cart 
INNER JOIN items ON items.items_id = cart.cart_itemsid
WHERE cart_orders != 0
GROUP BY cart.cart_usersid , cart.cart_itemsid , cart.cart_orders


CREATE OR REPLACE VIEW itemstopsellingview AS
SELECT COUNT(cart.cart_id) AS countitems , cart.*, items.* , (items_price - (items_price * items_discount /100)) AS itemspricediscount FROM cart
INNER JOIN items ON cart.cart_itemsid = items.items_id
WHERE cart.cart_orders != 0 
GROUP BY cart.cart_itemsid