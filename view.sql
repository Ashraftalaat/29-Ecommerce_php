CREATE VIEW  itemsview AS
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