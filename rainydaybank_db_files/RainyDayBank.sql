-- Run this script directly in the MySQL server query window it will automatically create the database and all the database objects.
DROP DATABASE IF EXISTS RainyDayBank;
CREATE DATABASE RainyDayBank;

USE RainyDayBank;

-- Create CUSTOMER table
DROP TABLE IF EXISTS CUSTOMER;
CREATE TABLE CUSTOMER (
    Cust_id char(8)                 NOT NULL,
    Fname varchar(25)               NOT NULL,
    Lname varchar(25)               NOT NULL,
    Place_of_birth varchar(25)      NOT NULL,
    Telephone_num char(10)          NOT NULL,
    Email varchar(50)               NOT NULL,
    City varchar(25)                NOT NULL,
    Zip char(5)                     NOT NULL,
    Street_name varchar(25)         NOT NULL,
    Street_num varchar(5)           NOT NULL,
    State char(2)                   NOT NULL,
    primary key (Cust_id),
    CONSTRAINT uk_Email unique (Email),
    CONSTRAINT uk_Telephone_cust unique (Telephone_num)
);

-- Create BANK_BRANCH table
DROP TABLE IF EXISTS BANK_BRANCH;
CREATE TABLE BANK_BRANCH (
    Branch_id char(8)               NOT NULL,
    Telephone_num char(10)          NOT NULL,
    Branch_name char(25)            NOT NULL,
    Location_num char(8)            NOT NULL,
    City varchar(25)                NOT NULL,
    Zip char(5)                     NOT NULL,
    Street_name varchar(25)         NOT NULL,
    Street_num varchar(5)           NOT NULL,
    State char(2)                   NOT NULL,
    primary key (Branch_id),
    CONSTRAINT uk_Telephone_bank unique (Telephone_num)
);

-- Create COMPLAINT table
DROP TABLE IF EXISTS COMPLAINT;
CREATE TABLE COMPLAINT (
    Cust_id char(8)                 NOT NULL,
    Date_filed date                 NOT NULL,
    From_who varchar(25)            NOT NULL,
    Reference_person varchar(25)    NOT NULL,
    Complaint_subject varchar(15)   NOT NULL,
    Complaint varchar(50)           NOT NULL,
    Reference char(8)               NOT NULL,
    primary key (Cust_id, Date_filed),
    foreign key (Cust_id) references CUSTOMER(Cust_id),
    CONSTRAINT uk_Reference unique (Reference)
);

-- Create PRODUCT_SUPPLIER table
DROP TABLE IF EXISTS PRODUCT_SUPPLIER;
CREATE TABLE PRODUCT_SUPPLIER (
    Company_name varchar(25)       NOT NULL,
    Supplier_code  char(8)         NOT NULL,
    Telephone_num char(10)         NOT NULL,
    Term int                       NOT NULL,
    Product_cost_per_term float(10,2) NOT NULL,
    City varchar(25)               NOT NULL,
    Zip char(5)                    NOT NULL,
    Street_name varchar(25)        NOT NULL,
    Street_num varchar(5)          NOT NULL,
    State char(2)                  NOT NULL,
    primary key (Company_name),
    CONSTRAINT uk_Telephone_supplier unique (Telephone_num),
    CONSTRAINT uk_Supplier_code unique (Supplier_code)
);

-- Create PRODUCT table
DROP TABLE IF EXISTS PRODUCT;
CREATE TABLE PRODUCT (
    Product_code char(8)            NOT NULL,
    Supplier_ref_code char(8)       NOT NULL,
    Product_name  varchar(25)       NOT NULL,
    Min_balance   float(10,2)       NOT NULL,
    Product_type  varchar(15)       NOT NULL,
    Interest_rt   float(10,2)       NOT NULL,
    Prod_description varchar(255)    NOT NULL,
    primary key (Product_code),
    foreign key (Supplier_ref_code) references PRODUCT_SUPPLIER(Supplier_code)
);

-- Create PAYMENT_SCHEDULE table
DROP TABLE IF EXISTS PAYMENT_SCHEDULE;
CREATE TABLE PAYMENT_SCHEDULE (
    Cust_id char(8)                 NOT NULL,
    Payment_amt float(10,2)         NOT NULL,
    Other_info varchar(25)          NOT NULL,
    Payment_date date               NOT NULL,
    Product_code char(8)            NOT NULL,
    primary key (Cust_id),
    foreign key (Cust_id) references CUSTOMER(Cust_id),
    foreign key (Product_code) references PRODUCT(Product_code)
);

-- Create CUST_TRANSACTION table
DROP TABLE IF EXISTS CUST_TRANSACTION;
CREATE TABLE CUST_TRANSACTION (
    Cust_id char(8)                NOT NULL,
    Product_code char(8)           NOT NULL,
    Trans_id char(8)               NOT NULL,
    Trans_type varchar(15)         NOT NULL,
    Trans_time varchar(7)          NOT NULL,
    Trans_date date                NOT NULL,
    Amount float(10,2)             NOT NULL,
    Note   varchar(255)            NOT NULL,  
    primary key (Cust_id, Product_code, Trans_id),
    foreign key (Cust_id) references CUSTOMER(Cust_id),
    foreign key (Product_code) references PRODUCT(Product_code)
);

-- Create PAYMENT_SOURCE table
DROP TABLE IF EXISTS PAYMENT_SOURCE;
CREATE TABLE PAYMENT_SOURCE (
    Payment_source varchar(25)     NOT NULL,
    Cust_id char(8)                NOT NULL,
    primary key (Payment_source, Cust_id),
    foreign key (Cust_id) references CUSTOMER(Cust_id)
);

-- Create ORDERS table
/*
    product_type not a foreign key, 
    it belonged to the ORDERS relationship
*/

DROP TABLE IF EXISTS ORDERS;
CREATE TABLE ORDERS (
    Cust_id char(8)                NOT NULL,
    Product_code char(8)           NOT NULL,
    Product_type  varchar(15)      NOT NULL,
    Remark varchar(255)            NOT NULL,
    Date_ordered date              NOT NULL,
    Time_ordered varchar(7)        NOT NULL,
    Initial_amt float(10,2)        NOT NULL,
    primary key (Cust_id, Product_code),
    foreign key (Cust_id) references CUSTOMER(Cust_id),
    foreign key (Product_code) references PRODUCT(Product_code)
);

-- Create HAS_EXCLUSIVE_RIGHTS table
DROP TABLE IF EXISTS HAS_EXCLUSIVE_RIGHTS;
CREATE TABLE HAS_EXCLUSIVE_RIGHTS (
    Cust_id char(8)                NOT NULL,
    Product_code char(8)           NOT NULL,
    primary key (Cust_id, Product_code),
    foreign key (Cust_id) references CUSTOMER(Cust_id),
    foreign key (Product_code) references PRODUCT(Product_code)
);

-- Create CARRIES table
DROP TABLE IF EXISTS CARRIES;
CREATE TABLE CARRIES (
    Branch_id char(8)               NOT NULL,
    Product_code char(8)            NOT NULL,
    primary key (Branch_id, Product_code),
    foreign key (Branch_id) references BANK_BRANCH(Branch_id),
    foreign key (Product_code) references PRODUCT(Product_code)
);

-- Create EXTERNAL_OFFERS table 
-- Affected by trigger (250 sales)
DROP TABLE IF EXISTS EXTERNAL_OFFERS
CREATE TABLE EXTERNAL_OFFERS (
    Product_name  varchar(25)      NOT NULL,
    Product_type  varchar(15)      NOT NULL,
    Action  varchar(50)            NOT NULL,
    Quantity int                   NOT NULL,
    Date_of_submission date        NOT NULL,
    primary key (Product_name, Action)
);

/* TEST */
-- Create supplier for Reverse Mortgages
INSERT INTO PRODUCT_SUPPLIER
VALUES ('Reverse Mortgages Co.', '12347899', '7149998888', 4, 1000.00, 'Fullerton', '90432', 'Albarn', '9999', 'CA');

-- Create Reverse Mortgages product & product_supplier
INSERT INTO PRODUCT
VALUES ('87873232', '12347899', 'Reverse Mortgages', 1000.00, 'mortgage', 4.00, 'A reverse mortgage is a type of loan for seniors ages 62 and older');