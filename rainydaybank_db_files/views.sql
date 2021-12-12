-- creates view for people who have not purchased reverse mortgages
CREATE VIEW NOT_PURCH_REV_MRT AS
SELECT Fname, Lname, Telephone_num FROM Customer 
WHERE Cust_id NOT IN (SELECT Cust_id FROM Orders WHERE Product_code = '87873232');

-- creates view for 401k buyers
CREATE VIEW MEGA_401K_BUYERS 
AS SELECT Fname, Lname 
FROM Customer, Orders WHERE Customer.Cust_id = Orders.Cust_id AND Product_code = '11113333';

-- creates view for products with sold greater than 50
CREATE VIEW GREATER_THAN_50_SOLD 
AS SELECT P.PRODUCT_NAME, P.PRODUCT_TYPE 
FROM PRODUCT AS P, ORDERS AS O 
WHERE P.PRODUCT_CODE = O.PRODUCT_CODE AND COUNT(O.PRODUCT_CODE) > 50  
GROUP BY O.PRODUCT_CODE;

-- creates view for products with sold greater than 50, with initial amount 
CREATE VIEW SOLD_MORE_THAN_50_INIT_G_1000 
AS SELECT p.product_name, p.product_type 
FROM product p, orders o 
WHERE p.product_code = o.product_code AND o.initial_amt > 1000.00 
GROUP BY o.product_code 
HAVING count(o.product_code) > 50;