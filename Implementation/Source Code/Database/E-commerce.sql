DROP TABLE PRODUCT CASCADE CONSTRAINTS;
DROP TABLE PRODUCT_CATEGORY CASCADE CONSTRAINTS;
DROP TABLE SHOP CASCADE CONSTRAINTS;
DROP TABLE SHOP_CATEGORY CASCADE CONSTRAINTS;
DROP TABLE TRADERS CASCADE CONSTRAINTS;
DROP TABLE REVIEW CASCADE CONSTRAINTS;
DROP TABLE EUSER CASCADE CONSTRAINTS;
DROP TABLE TIME_SLOT CASCADE CONSTRAINTS;
DROP TABLE CART CASCADE CONSTRAINTS;
DROP TABLE PAYMENT CASCADE CONSTRAINTS;

CREATE TABLE  "PRODUCT" 
   (	"PRODUCT_ID" NUMBER(3,0), 
	"PRODUCT_SHOP_ID" NUMBER(3,0), 
	"PRODUCT_CATEGORY_ID" NUMBER(3,0), 
	"PRODUCT_NAME" VARCHAR2(50), 
	"PRODUCT_DESCRIPTION" VARCHAR2(255), 
	"PRODUCT_PRICE" NUMBER(5,0), 
	"PRODUCT_OFFER_TITLE" VARCHAR2(255), 
	"PRODUCT_DISCOUNT_PERCENT" NUMBER(10,2), 
	"PRODUCT_SPECIAL_FROM" VARCHAR2(25), 
	"PRODUCT_SPECIAL_TO" VARCHAR2(25), 
	"PRODUCT_QUANTITY" NUMBER(4,0), 
	"PRODUCT_ALLEGERY_INFO" VARCHAR2(255), 
	"PRODUCT_STATUS" VARCHAR2(5), 
	"PRODUCT_CREATED_AT" VARCHAR2(25), 
	"PRODUCT_UDATED_AT" VARCHAR2(25), 
	"PRODUCT_FEATURED" VARCHAR2(5), 
	"PRODUCT_IMAGE_PATH" VARCHAR2(255),
    "PRODUCT_MIN_ORDER" NUMBER, 
	"PRODUCT_MAX_ORDER" NUMBER, 
	 CONSTRAINT "PK_PRODUCT" PRIMARY KEY ("PRODUCT_ID") ENABLE
   ) ;
   
CREATE TABLE  "PRODUCT_CATEGORY" 
   (	"CATEGORY_ID" NUMBER(10,0), 
	"NAME" VARCHAR2(100) NOT NULL ENABLE, 
	"DESCRIPTION" VARCHAR2(255), 
	 CONSTRAINT "PRODUCT_CATEGORY_PK" PRIMARY KEY ("CATEGORY_ID") ENABLE
   ) ;

CREATE TABLE  "SHOP" 
   (	"SHOP_ID" NUMBER(10,0), 
	"TRADER_ID" NUMBER(10,0), 
	"SHOP_CATEGORY_ID" NUMBER(10,0), 
	"NAME" VARCHAR2(255) NOT NULL ENABLE, 
	"MANAGER" VARCHAR2(255) NOT NULL ENABLE, 
	"NUM_OF_STAFF" NUMBER(10,0), 
	"PHONE_LINE_1" VARCHAR2(20) NOT NULL ENABLE, 
	"PHONE_LINE_2" VARCHAR2(20), 
	"REG_NUM" VARCHAR2(100) NOT NULL ENABLE, 
	"MAILING_ADDR" VARCHAR2(100) NOT NULL ENABLE, 
	"LOGO" VARCHAR2(100), 
	"IS_ACTIVE" NUMBER(1,0), 
	 CONSTRAINT "SHOP_PK" PRIMARY KEY ("SHOP_ID") ENABLE
   ) ;

CREATE TABLE  "SHOP_CATEGORY" 
   (	"CATEGORY_ID" NUMBER(10,0), 
	"NAME" VARCHAR2(100) NOT NULL ENABLE, 
	"DESCRIPTION" VARCHAR2(255), 
	 CONSTRAINT "SHOP_CATEGORY_PK" PRIMARY KEY ("CATEGORY_ID") ENABLE
   ) ;

CREATE TABLE  "TRADERS" 
   (	"TRADER_ID" NUMBER(10,0), 
	"USER_ID" NUMBER(10,0), 
	"NAME" VARCHAR2(255), 
	"PAN_NUMBER" NUMBER(20,0), 
	"BANK" VARCHAR2(255), 
	"MAILING_ADDR" VARCHAR2(255), 
	"SOCIAL_SECURITY" VARCHAR2(100), 
	"TRADER_HEAD" VARCHAR2(255), 
	"PROFILE_COMPLETE" NUMBER(1,0), 
	"BANK_ACC_NUM" VARCHAR2(100), 
	 CONSTRAINT "TRADER_PK" PRIMARY KEY ("TRADER_ID") ENABLE
   ) ;
   
CREATE TABLE  "REVIEW" 
   (	"REVIEW_ID" NUMBER(3,0), 
	"PRODUCT_ID" NUMBER(3,0), 
	"REVIEW_DESCRIPTION" VARCHAR2(300), 
	"REVIEW_CREATED" VARCHAR2(25), 
	"USER_ID" NUMBER(3,0), 
	"REVIEW_RATING" NUMBER,
    "SENTIMENT" VARCHAR2(40),
	 CONSTRAINT "PK_REVIEW" PRIMARY KEY ("REVIEW_ID") ENABLE
   ) ;

CREATE TABLE  "EUSER" 
   (	"USER_ID" NUMBER(3,0), 
	"USER_FIRST_NAME" VARCHAR2(80), 
	"USER_LAST_NAME" VARCHAR2(80), 
	"USER_ADDRESS" VARCHAR2(80), 
	"USER_EMAIL" VARCHAR2(80), 
	"USER_PASSWORD" VARCHAR2(80), 
	"ACTIVE" NUMBER(1,0), 
	"USER_TYPE" VARCHAR2(15), 
	"USER_CREATED_AT" VARCHAR2(25), 
	 CONSTRAINT "PK_EUSER" PRIMARY KEY ("USER_ID") ENABLE
   ) ;   

CREATE TABLE  "TIME_SLOT" 
   (	"TIME_SLOT_ID" NUMBER(10,0), 
	"DAY" VARCHAR2(10) NOT NULL ENABLE, 
	"START_TIME" VARCHAR2(10), 
	"END_TIME" VARCHAR2(10), 
	 CONSTRAINT "TIME_SLOT_PK" PRIMARY KEY ("TIME_SLOT_ID") ENABLE
   ) ;

CREATE TABLE  "CART" 
   (	"P_ID" NUMBER(10,0), 
	"QTY" NUMBER(10,0), 
	"IP_ADD" VARCHAR2(255), 
	"USERID" NUMBER
   ) ;
   
CREATE TABLE  "PAYMENT" 
   (	"PAYMENT_ID" NUMBER(10,0) NOT NULL ENABLE, 
	"INVOICE_ID" NUMBER(10,0), 
	"USER_EMAIL" VARCHAR2(255), 
	"TRADER_ID" NUMBER(10,0), 
	"PRICE" NUMBER, 
	"PAYMENT_DATE" DATE, 
	 CONSTRAINT "PK_PAYMENT" PRIMARY KEY ("PAYMENT_ID") ENABLE
   ) ;

ALTER TABLE  "PRODUCT" ADD FOREIGN KEY ("PRODUCT_SHOP_ID")
REFERENCES  "SHOP" ("SHOP_ID") ENABLE;
ALTER TABLE  "PRODUCT" ADD FOREIGN KEY ("PRODUCT_CATEGORY_ID")
REFERENCES  "PRODUCT_CATEGORY" ("CATEGORY_ID") ENABLE;
ALTER TABLE  "SHOP" ADD CONSTRAINT "SHOP_SHOP_CATEGORY_FK" FOREIGN KEY ("SHOP_CATEGORY_ID")
REFERENCES  "SHOP_CATEGORY" ("CATEGORY_ID") ENABLE;
ALTER TABLE  "SHOP" ADD CONSTRAINT "SHOP_TRADER_FK" FOREIGN KEY ("TRADER_ID")
REFERENCES  "EUSER" ("USER_ID") ENABLE;
ALTER TABLE  "TRADERS" ADD CONSTRAINT "TRADER_USER_FK" FOREIGN KEY ("USER_ID")
REFERENCES  "EUSER" ("USER_ID") ENABLE;
ALTER TABLE  "REVIEW" ADD FOREIGN KEY ("USER_ID")
REFERENCES  "EUSER" ("USER_ID") ENABLE;
ALTER TABLE  "REVIEW" ADD FOREIGN KEY ("PRODUCT_ID")
REFERENCES  "PRODUCT" ("PRODUCT_ID") ENABLE;


/*Insert Admin's data in Euser Table*/
INSERT INTO euser(user_id, user_first_name, user_last_name, user_address, user_email, user_password, user_type, active) 
VALUES (seq_users.nextval, 'Nischal','Aryal','Baneshwor', 'nischalaryal11@gmail.com', 'Nepal123', 'Admin', '1');



/*Insert Trader's data in Euser Table*/
INSERT INTO euser(user_id, user_first_name, user_last_name, user_address, user_email, user_password, user_type, active) 
VALUES (seq_users.nextval, 'Hari','Giri','Koteshwor', '100robinhood@gmail.com', 'Nepal123', 'Trader', '1');

INSERT INTO euser(user_id, user_first_name, user_last_name, user_address, user_email, user_password, user_type, active) 
VALUES (seq_users.nextval, 'Manisha','Pokhrel','Kalimati', 'anzeelagiri68@gmail.com', 'Nepal123', 'Customer', '1');

INSERT INTO euser(user_id, user_first_name, user_last_name, user_address, user_email, user_password, user_type, active) 
VALUES (seq_users.nextval, 'Anugya','Sharma','Thapathali', 'anugyasharma981@gmail.com', 'Nepal123', 'Customer', '1');

INSERT INTO euser(user_id, user_first_name, user_last_name, user_address, user_email, user_password, user_type, active) 
VALUES (seq_users.nextval, 'Bibhuti','Bam','Pepsicola', 'psychofreakg@gmail.com', 'Nepal123', 'Customer', '1');

INSERT INTO euser(user_id, user_first_name, user_last_name, user_address, user_email, user_password, user_type, active) 
VALUES (seq_users.nextval, 'Kritika','Shahi','Nepalgunj', 'kritikashahi320@gmail.com', 'Nepal123', 'Trader', '1');



/*Insert into Shop_category table*/
insert into SHOP_CATEGORY values(seq_shop_category.nextval, 'Butchers', 'A butcher is a person who may slaughter animals, dress their flesh, sell their meat, or participate within any combination of these three tasks.' );
insert into SHOP_CATEGORY values(seq_shop_category.nextval, 'Greengrocer', 'A person who works in or owns a store that sells fresh vegetables and fruit.' );
insert into SHOP_CATEGORY values(seq_shop_category.nextval, 'Bakery', 'A bakery is an establishment that produces and sells flour-based food baked in an oven such as bread, cookies, cakes, donuts, pastries, and pies.' );
insert into SHOP_CATEGORY values(seq_shop_category.nextval, 'Fishmonger', 'A person or shop that sells fish for food.' );
insert into SHOP_CATEGORY values(seq_shop_category.nextval, 'Delicatessen', 'A delicatessen or "deli" is a retail establishment that sells a selection of fine, exotic, or foreign prepared foods.' );



/*Insert into Product_category table*/
INSERT INTO PRODUCT_CATEGORY VALUES(seq_product_category.nextval, 'Chicken','Chicken related meat cuts');
INSERT INTO PRODUCT_CATEGORY VALUES(seq_product_category.nextval, 'Fish','Fish meat');
INSERT INTO PRODUCT_CATEGORY VALUES(seq_product_category.nextval, 'Vegetables','Fresh vegetables');
INSERT INTO PRODUCT_CATEGORY VALUES(seq_product_category.nextval, 'Fruit','Various seasonal fruits');
INSERT INTO PRODUCT_CATEGORY VALUES(seq_product_category.nextval, 'Cakes and Cookies','Freshly prepared cakes and cookies');
INSERT INTO PRODUCT_CATEGORY VALUES(seq_product_category.nextval, 'Foreign prepared Foods','Foreign prepared Foods');
