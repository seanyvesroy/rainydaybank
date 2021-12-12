-- script to create trigger which inserts into external offers when a product sells >= 250

delimiter #
CREATE TRIGGER ORDER_LEVEL_250 AFTER INSERT ON ORDERS
FOR EACH ROW
BEGIN
    IF ((SELECT COUNT(New.Product_code) FROM ORDERS WHERE Product_code = NEW.Product_code) >= 250) THEN
        INSERT INTO EXTERNAL_OFFERS(Product_name, Product_type, Action, Quantity, Date_of_submission)
            VALUES(NEW.Product_name, NEW.Product_type, 'Offer Product to Capitol One', 1, NEW.Date_ordered);
    END IF;
END #

delimiter ;