DROP SEQUENCE seq_users;
DROP SEQUENCE seq_trader;
DROP SEQUENCE seq_shops;
DROP SEQUENCE seq_review;
DROP SEQUENCE seq_shop_category;
DROP SEQUENCE seq_product_category;
DROP SEQUENCE seq_product;
DROP SEQUENCE seq_order;

CREATE SEQUENCE seq_users
    START WITH 1;
CREATE SEQUENCE seq_trader
    START WITH 1;
CREATE SEQUENCE seq_shops
    START WITH 1;
CREATE SEQUENCE seq_review
    START WITH 1;
CREATE SEQUENCE seq_shop_category
    START WITH 1;
CREATE SEQUENCE seq_product_category
    START WITH 1;
CREATE SEQUENCE seq_product
    START WITH 1;
CREATE SEQUENCE seq_order
    START WITH 1;