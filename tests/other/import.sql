-- SQLite
DROP TABLE IF EXISTS products;
DROP TABLE IF EXISTS types;
DROP TABLE IF EXISTS alergies;
DROP TABLE IF EXISTS orders;
DROP TABLE IF EXISTS customers;


CREATE TABLE products (
id INT(10000) AUTO_INCREMENT NOT NULL UNIQUE PRIMARY KEY,
name TEXT(30) NOT NULL,
description VARCHAR(250) NOT NULL,
category INT(1) NOT NULL,
price FLOAT(2,2) NOT NULL,
image_src VARCHAR(150) NOT NULL);

CREATE TABLE types (
id INT(2) NOT NULL UNIQUE,
name VARCHAR(30) NOT NULL,
description VARCHAR(250) NOT NULL);

CREATE TABLE alergies (
product_id INT(1) AUTO_INCREMENT NOT NULL,
type TEXT(30) NOT NULL,
description VARCHAR(255) NOT NULL);

CREATE TABLE orders (
order_id INT  NOT NULL UNIQUE PRIMARY KEY,
customer_id INT NOT NULL,
time_ordered DATETIME NOT NULL,
complete BOOL NOT NULL);

CREATE TABLE customers (
customer_id INTEGER PRIMARY KEY AUTOINCREMENT,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
addres VARCHAR(255) NOT NULL,
home  INT(15) NOT NULL,
mobile INT(11) NOT NULL);

CREATE TABLE cart (
    cart_id INT(11) NOT NULL,
    product_name VARCHAR(100) NOT NULL,
    product_price VARCHAR(50) NOT NULL,
    product_src VARCHAR(255) NOT NULL,
    quantity INT(10) NOT NULL,
    total_price VARCHAR(100) NOT NULL,
    product_id VARCHAR(10) NOT NULL);

CREATE TABLE cart (
    basket_id INT(20),
    product_id INT(1000) NOT NULL,
    quantity INT(100) NOT NULL,
    total_price FLOAT(4) NOT NULL
)

CREATE TABLE address (
    customer_id VARCHAR(255) NOT NULL,
    1_line VARCHAR(255) NOT NULL,
    2_line VARCHAR(255) NOT NULL,
    3_line VARCHAR(255),
    region VARCHAR(255) NOT NULL,
    postcode VARCHAR(255) NOT NULL
    
);

CREATE TABLE purchases (
    basket_id INT(20) NOT NULL,
    customer_id VARCHAR(255) NOT NULL,
    product_id INT(255) NOT NULL,
    quantity INT(100) NOT NULL
);
INSERT INTO purchases ( basket_id, customer_id, product_id, quantity )

CREATE TABLE accounts (
customer_id INT NOT NULL UNIQUE PRIMARY KEY,
username VARCHAR(50) NOT NULL UNIQUE,
pass VARCHAR(255) NOT NULL);


ALTER TABLE types ADD CONSTRAINT types_id_products_type FOREIGN KEY (id) REFERENCES products(type);
ALTER TABLE alergies ADD CONSTRAINT alergies_product_id_products_id FOREIGN KEY (product_id) REFERENCES products(id);
ALTER TABLE orders ADD CONSTRAINT orders_customer_id_customers_customer_id FOREIGN KEY (customer_id) REFERENCES customers(customer_id);


--
-- Products
--
INSERT INTO products (id, name, description, category, price, image_src) VALUES (1, 'Item 1', 'Description for item 1', 1, 5.99, 'src/img/01.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (2, 'Item 2', 'Description for item 2', 1, 5.99, 'src/img/02.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (3, 'Item 3', 'Description for item 3', 1, 5.99, 'src/img/03.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (4, 'Item 4', 'Description for item 4', 2, 5.99, 'src/img/04.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (5, 'Item 5', 'Description for item 5', 2, 5.99, 'src/img/05.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (6, 'Item 6', 'Description for item 6', 2, 5.99, 'src/img/06.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (7, 'Item 7', 'Description for item 7', 3, 5.99, 'src/img/07.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (8, 'Item 8', 'Description for item 8', 3, 5.99, 'src/img/08.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (9, 'Item 9', 'Description for item 9', 3, 5.99, 'src/img/09.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (10, 'Item 10', 'Description for item 10', 4, 5.99, 'src/img/10.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (11, 'Item 11', 'Description for item 11', 4, 5.99, 'src/img/11.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (12, 'Item 12', 'Description for item 12', 4, 5.99, 'src/img/12.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (13, 'Item 13', 'Description for item 13', 5, 5.99, 'src/img/13.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (14, 'Item 14', 'Description for item 14', 5, 5.99, 'src/img/14.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (15, 'Item 15', 'Description for item 15', 5, 5.99, 'src/img/15.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (16, 'Item 16', 'Description for item 16', 6, 5.99, 'src/img/16.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (17, 'Item 17', 'Description for item 17', 6, 5.99, 'src/img/17.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (18, 'Item 18', 'Description for item 18', 6, 5.99, 'src/img/18.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (19, 'Item 19', 'Description for item 19', 7, 5.99, 'src/img/19.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (20, 'Item 20', 'Description for item 20', 7, 5.99, 'src/img/20.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (21, 'Item 21', 'Description for item 21', 7, 5.99, 'src/img/21.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (22, 'Item 22', 'Description for item 22', 8, 5.99, 'src/img/22.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (23, 'Item 23', 'Description for item 23', 8, 5.99, 'src/img/23.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (24, 'Item 24', 'Description for item 24', 8, 5.99, 'src/img/24.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (25, 'Item 25', 'Description for item 25', 9, 5.99, 'src/img/25.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (26, 'Item 26', 'Description for item 26', 9, 5.99, 'src/img/26.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (27, 'Item 27', 'Description for item 27', 9, 5.99, 'src/img/27.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (28, 'Item 28', 'Description for item 28', 10, 5.99, 'src/img/28.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (29, 'Item 29', 'Description for item 29', 10, 5.99, 'src/img/29.jpg');
INSERT INTO products (id, name, description, category, price, image_src) VALUES (30, 'Item 30', 'Description for item 30', 10, 5.99, 'src/img/30.jpg');

-- Cakes - 0
INSERT INTO products (id, name, description, category, price, image_src) VALUES (0 , "Chocolate Fudge Cake", "Triple layer chocolate cake packed and finished off with chocolate fudge.", 0, 3.50, "src/img/0.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (1 , "Chocolate Lovin' Cake", "A real chocolate lovers cake! A triple layer chocolate cake packed with fudge and rich chocolate fudge.", 0, 4.00, "src/img/1.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (2 , "Caramel Shortcake", "A crumbly shortcake base topped with chocolate and caramel.", 0, 2.00, "src/img/2.jpg");
-- Cookies - 1
INSERT INTO products (id, name, description, category, price, image_src) VALUES (3 , "Cookie dough", "Partly cooked cookie dough, a sweet and stody", 1, 4.00, "src/img/3.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (4 , "Chocolate Chip Cookies", "A soft and doughy baked flat biscuit, perfect for snacking or add extras to make a desert", 1, 1.50, "src/img/4.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (5 , "Shortbread Cookies", "Mixing a very high ratio of fat (mainly butter), creating a more crumbly and texder type of cookie",  1, 3.00, "src/img/5.jpg");
-- Biscuits - 2
INSERT INTO products (id, name, description, category, price, image_src) VALUES (6 , "Macaroons", "A variety of flavours of macaroon biscuits.", 2, 4.00, "src/img/6.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (7 , "Scones", "A sweet, rich wedge-shaped biscuits that are usually made with cream as well as butter. Scones have a tender, heavy crumb and a slightly crusty brown top. Eggs can be added for flavor and rich color but result in  a slightly cakey texture.", 2, 3.50, "src/img/7.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (8 , "Rolled Biscuits", "A biscuit shaped and rolled into a circle, once baked it has a light and fluffy inside and a golden crisp outside.", 2, 2.00, "src/img/8.jpg");
-- Pasteries - 3
INSERT INTO products (id, name, description, category, price, image_src) VALUES (9 , "Profiteroles", "Choux pastry filled with fresh cream and covererd in chocolate", 3, 3.00, "src/img/9.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (10 , "Croissant", "Layers of puff pastry with a light and fluffy inside rolled into a crescent shape", 3, 1.25, "src/img/10.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (11 , "Col-au-vent", "An extremely light and fluffy pastry made with a hollow inside. Filled with a creame filling and strawberries.", 3, 4.50, "src/img/11.jpg");
--Sweets - 4 
INSERT INTO products (id, name, description, category, price, image_src) VALUES (12 , "Caramel Popcorn", "Popped popcorn covered with a rich caramel sauce.", 4, 3.00, "src/img/12.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (13 , "Fudge", "A mix of sugar, butter and milk, heated and cooked, consisting of a texture between fondant icing and hard caramel.", 0, 2.50, "src/img/13.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (14 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
--Custards and puddings - 5
INSERT INTO products (id, name, description, category, price, image_src) VALUES (15 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (16 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (17 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
-- Deep-fried - 6
INSERT INTO products (id, name, description, category, price, image_src) VALUES (18 , "Donuts", "", 0, 2.99, "src/img/18.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (19 , "Churros", "A variation on the typical donuts, where the batter is piped into a long and thin shape.", 6, 3.50, "src/img/19.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (20 , "Waffles", "A light and crispy product made by deep-frying a mix of dough.", 6, 3.00, "src/img/20.jpg");
-- Frozen - 7
INSERT INTO products (id, name, description, category, price, image_src) VALUES (21 , "Milkshake", "A drink made with ice-cream, milk and some type of flavourings.", 7, 2.50, "src/img/21.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (22 , "Ice Cream Sundae", "", 0, 2.99, "src/img/0.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (23 , "gelato", "", 0, 2.99, "src/img/0.jpg");
-- Gelatin - 8
INSERT INTO products (id, name, description, category, price, image_src) VALUES (24 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (25 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (26 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
-- Fruit - 9 
INSERT INTO products (id, name, description, category, price, image_src) VALUES (27 , "Chocolate Strawberries", "Fresh strawberries coated with a thick layer of chocolate", 9, 3.00, "src/img/27.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (28 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");
INSERT INTO products (id, name, description, category, price, image_src) VALUES (29 , "Chocolate Cake", "", 0, 2.99, "src/img/0.jpg");




--
-- Categories
--
-- SQLite
INSERT INTO types (id, name, description) VALUES (1, "Cakes", "A combination of flour, eggs, sugar, fats (oil or butter), leavening agents (yeast or baking powder) and sometimes milk and water.");
INSERT INTO types (id, name, description) VALUES (2, "Cookies", "Made with flour and sugar and shaped usually into a round and flat shape.");
INSERT INTO types (id, name, description) VALUES (3, "Biscuits", "");
INSERT INTO types (id, name, description) VALUES (4, "Pastries", "");
INSERT INTO types (id, name, description) VALUES (5, "Sweets", "");
INSERT INTO types (id, name, description) VALUES (6, "Custards and Puddings", "");
INSERT INTO types (id, name, description) VALUES (7, "Deep-fried", "");
INSERT INTO types (id, name, description) VALUES (8, "Frozen", "" );
INSERT INTO types (id, name, description) VALUES (9, "Gelatin", "");
INSERT INTO types (id, name, description) VALUES (10, "Fruit", "");
-------------------------------------------------------------------------
CREATE TABLE products (
id INT(255) AUTO_INCREMENT NOT NULL PRIMARY KEY,
name TEXT(30) NOT NULL,
description VARCHAR(250) NOT NULL,
category INT(1) NOT NULL,
price FLOAT(2,2) NOT NULL,
image_src VARCHAR(150) NOT NULL);

CREATE TABLE types (
id INT(2) NOT NULL UNIQUE,
name VARCHAR(30) NOT NULL,
description VARCHAR(250) NOT NULL);


CREATE TABLE alergies (
product_id INT(100) NOT NULL,
type TEXT(30) NOT NULL,
description VARCHAR(255) NOT NULL);

CREATE TABLE orders (
order_id INT  NOT NULL PRIMARY KEY,
customer_id INT NOT NULL,
time_ordered DATETIME,
complete BOOLEAN);

CREATE TABLE customers (
customer_id INTEGER PRIMARY KEY,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
email VARCHAR(50) NOT NULL,
addres VARCHAR(255) NOT NULL,
home  INT(15) NOT NULL,
mobile INT(11) NOT NULL);

