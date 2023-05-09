-- DROP TABLES

drop table MenuItem1;
drop table MenuItem2;
drop table MenuItemHasOrder;
drop table DeliveryDriver2;
drop table Customer2;
drop table Coupon2;
drop table Coupon;
drop table Delivery;
drop table Employer;
drop table Restaurant2;
drop table Order1;
drop table DeliveryDriver1;
drop table Customer1;
drop table Pickup;
drop table Order2;
drop table Restaurant1;

-- CREATE TABLES 

CREATE TABLE Employer (
  employer_name CHAR(20),
  employer_location CHAR(20),
  PRIMARY KEY(employer_name, employer_location)
);

grant select on Employer to public;

CREATE TABLE Restaurant1 (
  r_name CHAR(20),
  type CHAR(20),
  address CHAR(20),
  PRIMARY KEY(r_name, address)
);

grant select on Restaurant1 to public;

CREATE TABLE Restaurant2 (
  r_name CHAR(20),
  address CHAR(20),
  rating INTEGER,
  PRIMARY KEY(r_name, address, rating)
);

grant select on Restaurant2 to public;

CREATE TABLE MenuItem1(
  r_name CHAR(20) NOT NULL,
  address CHAR(20) NOT NULL,
  item_name CHAR(20),
  price DOUBLE PRECISION,
  PRIMARY KEY (r_name, address, item_name),
  FOREIGN KEY(r_name, address) REFERENCES Restaurant1(r_name, address) ON DELETE CASCADE
);

grant select on MenuItem1 to public;

CREATE TABLE MenuItem2 (
  r_name CHAR(20) NOT NULL,
  address CHAR(20) NOT NULL,
  item_name CHAR(20),
  cooking_time INTEGER,
  PRIMARY KEY (r_name, address, item_name, cooking_time),
  FOREIGN KEY(r_name, address) REFERENCES Restaurant1(r_name, address) ON DELETE CASCADE
);

grant select on MenuItem2 to public;

CREATE TABLE Order1 (
  order_num INTEGER NOT NULL,
  order_subtotal DOUBLE PRECISION,
  order_total DOUBLE PRECISION,
  PRIMARY KEY(order_num)
);

grant select on Order1 to public;

CREATE TABLE Order2 (
  order_num INTEGER NOT NULL,
  order_status CHAR(20),
  r_name CHAR(20),
  address CHAR(20),
  PRIMARY KEY(order_num),
  FOREIGN KEY(r_name, address) REFERENCES Restaurant1(r_name, address)
);

grant select on Order2 to public;

CREATE TABLE MenuItemHasOrder (
  order_num INTEGER NOT NULL,
  r_name CHAR(20) NOT NULL,
  address CHAR(20) NOT NULL,
  item_name CHAR(20) NOT NULL,
  PRIMARY KEY(order_num, r_name, address, item_name),
  FOREIGN KEY(order_num) REFERENCES Order1(order_num),
  FOREIGN KEY(r_name, address) REFERENCES Restaurant1(r_name, address) ON DELETE CASCADE
);

grant select on MenuItemHasOrder to public;

CREATE TABLE DeliveryDriver1 (
  driver_id INTEGER NOT NULL,
  driver_name CHAR(20),
  telephone INTEGER,
  PRIMARY KEY(driver_id)
);

grant select on DeliveryDriver1 to public;

CREATE TABLE DeliveryDriver2 (
  driver_id INTEGER NOT NULL,
  rating INTEGER,
  employer_name CHAR(20),
  employer_location CHAR(20),
  PRIMARY KEY(
    driver_id,
    rating,
    employer_name,
    employer_location
  ),
  FOREIGN KEY(employer_name, employer_location) REFERENCES Employer(employer_name, employer_location)
);

grant select on DeliveryDriver2 to public;

CREATE TABLE Customer1 (
  customer_id INTEGER NOT NULL,
  customer_name CHAR(20),
  address CHAR(20),
  telephone INTEGER,
  email CHAR(30),
  PRIMARY KEY(customer_id)
);

grant select on Customer1 to public;

CREATE TABLE Customer2 (
  customer_id INTEGER,
  current_location CHAR(20),
  order_num INTEGER,
  UNIQUE(order_num),
  PRIMARY KEY(customer_id, current_location, order_num),
  FOREIGN KEY(order_num) REFERENCES Order2(order_num)
);

grant select on Customer2 to public;

CREATE TABLE Pickup (
  order_num INTEGER,
  pickup_time TIMESTAMP,
  pickup_location CHAR(20),
  PRIMARY KEY (order_num)
);

grant select on Pickup to public;

CREATE TABLE Delivery (
  order_num INTEGER,
  delivery_time TIMESTAMP,
  delivery_location CHAR(20),
  driver_id INTEGER,
  PRIMARY KEY(order_num),
  FOREIGN KEY(driver_id) REFERENCES DeliveryDriver1(driver_id)
);

grant select on Delivery to public;

CREATE TABLE Coupon2 (
  coupon_id INTEGER NOT NULL,
  value DOUBLE PRECISION,
  valid_until CHAR(11),
  r_name CHAR(20),
  address CHAR(20),
  PRIMARY KEY(coupon_id)
);

grant select on Coupon2 to public;

CREATE TABLE Coupon (
  coupon_id INTEGER NOT NULL,
  value DOUBLE PRECISION,
  valid_until CHAR(11),
  order_num INTEGER,
  r_name CHAR(20),
  address CHAR(20),
  PRIMARY KEY(coupon_id),
  UNIQUE(order_num),
  FOREIGN KEY(order_num) REFERENCES Order2(order_num),
  FOREIGN KEY(r_name, address) REFERENCES Restaurant1(r_name, address)
);

grant select on Coupon to public;

-- INSERT STATEMENTS 

-- EMPLOYER

insert into Employer(employer_name, employer_location)
values ('Bimbob Corporations', '123 Canada Way');

insert into Employer(employer_name, employer_location)
values ('Willy Corporations', '145 Bunny Ave');

insert into Employer(employer_name, employer_location)
values ('Munchy Studios', '142 Cat St');

insert into Employer(employer_name, employer_location)
values ('FoodIsland', '1542 Food St');

insert into Employer(employer_name, employer_location)
values ('BobyLand', '123 Bob St');

insert into Employer(employer_name, employer_location)
values ('CostcoLand', '123 Costco St');

-- RESTAURANT1

insert into Restaurant1(r_name, type, address)
values ('Good Hunter', 'German',  '123 Teyvat Drive');

insert into Restaurant1(r_name, type, address)
values ('Taco Fiesta', 'Mexican', '123 Queso Lane');

insert into Restaurant1(r_name, type, address)
values ('Venti Cafe', 'Cafe',  '333 Windrise Blvd');

insert into Restaurant1(r_name, type, address)
values ('Knockout Steakhouse', 'Steakhouse', '8888 Liyue Drive');

insert into Restaurant1(r_name, type, address)
values ('Ormos Diner', NULL, '8758 Sumeru Avenue');

-- RESTAURANT2

insert into Restaurant2(r_name, rating, address)
values ('Good Hunter', 5,  '123 Teyvat Drive');

insert into Restaurant2(r_name, rating, address)
values ('Knockout Steakhouse', 5, '8888 Liyue Drive');

insert into Restaurant2(r_name, rating, address)
values ('Taco Fiesta', 3, '123 Queso Lane');

insert into Restaurant2(r_name, rating, address)
values ('Venti Cafe', 4,  '333 Windrise Blvd');

insert into Restaurant2(r_name, rating, address)
values ('Ormos Diner', 2, '8758 Sumeru Avenue');

-- MENUITEM1

insert into MenuItem1(r_name, address, item_name, price) 
values ('Good Hunter', '123 Teyvat Drive', 'Schnitzel', '22.00');

insert into MenuItem1(r_name, address, item_name, price) 
values ('Taco Fiesta', '123 Queso Lane', 'Quesadilla', '15.99');

insert into MenuItem1(r_name, address, item_name, price) 
values ('Taco Fiesta', '123 Queso Lane', 'Tacos', '15.99');

insert into MenuItem1(r_name, address, item_name, price) 
values ('Taco Fiesta', '123 Queso Lane', 'Burrito Bowl', '15.99');

insert into MenuItem1(r_name, address, item_name, price) 
values ('Knockout Steakhouse', '8888 Liyue Drive', 'Beef Tenderloin', '55.00');

insert into MenuItem1(r_name, address, item_name, price) 
values ('Venti Cafe', '333 Windrise Blvd', 'Chai Tea Latte', '7.99');

insert into MenuItem1(r_name, address, item_name, price) 
values ('Ormos Diner', '8758 Sumeru Avenue', 'Cheeseburger', '10.00');

-- MENUITEM2

insert into MenuItem2(r_name, address, item_name, cooking_time) 
values ('Good Hunter', '123 Teyvat Drive', 'Schnitzel', 10);

insert into MenuItem2(r_name, address, item_name, cooking_time) 
values ('Taco Fiesta', '123 Queso Lane', 'Quesadilla', 15);

insert into MenuItem2(r_name, address, item_name, cooking_time) 
values ('Taco Fiesta', '123 Queso Lane', 'Tacos', 10);

insert into MenuItem2(r_name, address, item_name, cooking_time) 
values ('Knockout Steakhouse', '8888 Liyue Drive', 'Beef Tenderloin', 45);

insert into MenuItem2(r_name, address, item_name, cooking_time) 
values ('Venti Cafe',  '333 Windrise Blvd', 'Chai Tea Latte', 5);

insert into MenuItem2(r_name, address, item_name, cooking_time) 
values ('Ormos Diner', '8758 Sumeru Avenue', 'Cheeseburger', 7);

-- DELIVERYDRIVER1

insert into DeliveryDriver1(driver_id, driver_name, telephone)
values (12345, 'Bob McShingles', 123456736);

insert into DeliveryDriver1(driver_id, driver_name, telephone)
values (12346, 'Billiam Chengulus', 123241234);

insert into DeliveryDriver1(driver_id, driver_name, telephone)
values (12543, 'Levi Pantaloons', 18293829);

insert into DeliveryDriver1(driver_id, driver_name, telephone)
values (12362, 'Leviathan', 14222415);

insert into DeliveryDriver1(driver_id, driver_name, telephone)
values (12512, 'Thomas the Train', 13020338);

-- DELIVERYDRIVER2

insert into DeliveryDriver2(driver_id, rating, employer_name, employer_location)
values (12345, 4, 'Munchy Studios', '142 Cat St');

insert into DeliveryDriver2(driver_id, rating, employer_name, employer_location)
values (12346, 2, 'FoodIsland', '1542 Food St');

insert into DeliveryDriver2(driver_id, rating, employer_name, employer_location)
values (12543, 1, 'CostcoLand', '123 Costco St');

insert into DeliveryDriver2(driver_id, rating, employer_name, employer_location)
values (12362, 2, 'Munchy Studios', '142 Cat St');

insert into DeliveryDriver2(driver_id, rating, employer_name, employer_location)
values (12512, 3, 'Willy Corporations', '145 Bunny Ave');

-- ORDER1

insert into Order1(order_num, order_subtotal, order_total) 
values (1, '16.00', '18.65');

insert into Order1(order_num, order_subtotal, order_total) 
values (2, '55.00', '60.98');

insert into Order1(order_num, order_subtotal, order_total) 
values (3, '7.99', '8.88');

insert into Order1(order_num, order_subtotal, order_total) 
values (4, '10.00', '12.99');

insert into Order1(order_num, order_subtotal, order_total) 
values (5, '22.00', '24.88');

insert into Order1(order_num, order_subtotal, order_total) 
values (8, '30.00', '22.88');

-- ORDER2

insert into Order2 (order_num, order_status, r_name, address)
values (1, 'in progress', 'Good Hunter', '123 Teyvat Drive');

insert into Order2 (order_num, order_status, r_name, address)
values (2, 'complete', 'Venti Cafe', '333 Windrise Blvd');

insert into Order2 (order_num, order_status, r_name, address)
values (3, 'complete', 'Taco Fiesta', '123 Queso Lane');

insert into Order2 (order_num, order_status, r_name, address)
values (4, 'in progress', 'Knockout Steakhouse', '8888 Liyue Drive');

insert into Order2 (order_num, order_status, r_name, address)
values (5, 'in progress', 'Ormos Diner', '8758 Sumeru Avenue');

insert into Order2 (order_num, order_status, r_name, address)
values (8, 'in progress', 'Taco Fiesta', '123 Queso Lane');

-- COUPON

insert into Coupon(coupon_id, value, valid_until, order_num, r_name, address) 
values (1292394, '10.00', '2023-06-08', 1, 'Good Hunter', '123 Teyvat Drive');

insert into Coupon(coupon_id, value, valid_until, order_num, r_name, address) 
values (1292395, '10.00', '2023-06-08', 2, 'Venti Cafe', '333 Windrise Blvd');

insert into Coupon(coupon_id, value, valid_until, order_num, r_name, address) 
values (2874834, '20.00', '2023-02-14', 3, 'Taco Fiesta', '123 Queso Lane');

insert into Coupon(coupon_id, value, valid_until, order_num, r_name, address) 
values (0293488, '3.50', '2024-01-23', 4, 'Knockout Steakhouse', '8888 Liyue Drive');

insert into Coupon(coupon_id, value, valid_until, order_num, r_name, address) 
values (8888888, '1.00', '2024-07-20', 5, 'Ormos Diner', '8758 Sumeru Avenue');

-- COUPON2

insert into Coupon2(coupon_id, value, valid_until, r_name, address) 
values (1292394, '10.00', '2023-06-08','Good Hunter', '123 Teyvat Drive');

insert into Coupon2(coupon_id, value, valid_until, r_name, address) 
values (1292395, '10.00', '2023-06-08', 'Venti Cafe', '333 Windrise Blvd');

insert into Coupon2(coupon_id, value, valid_until, r_name, address) 
values (2874834, '20.00', '2023-02-14', 'Taco Fiesta', '123 Queso Lane');

insert into Coupon2(coupon_id, value, valid_until, r_name, address) 
values (0293488, '3.50', '2024-01-23','Knockout Steakhouse', '8888 Liyue Drive');

insert into Coupon2(coupon_id, value, valid_until, r_name, address) 
values (8888888, '1.00', '2024-07-20','Ormos Diner', '8758 Sumeru Avenue');

-- PICKUP

insert into Pickup(order_num, pickup_time, pickup_location) 
values (6, timestamp '2017-10-12 10:00:00', '123 Teyvat Drive');

insert into Pickup(order_num, pickup_time, pickup_location) 
values (7, timestamp '2017-10-12 11:30:30', '333 Windrise Blvd');

insert into Pickup(order_num, pickup_time, pickup_location) 
values (8, timestamp '2017-10-12 13:00:00', '123 Queso Lane');

insert into Pickup(order_num, pickup_time, pickup_location) 
values (9, timestamp '2017-10-12 23:30:00', '8888 Liyue Drive');

insert into Pickup(order_num, pickup_time, pickup_location) 
values (10, timestamp '2017-10-12 17:00:59', '8758 Sumeru Avenue');

-- CUSTOMER1

insert into Customer1(customer_id, customer_name, address, telephone, email) 
values (22839, 'Hello Kitty', '123 Bubu Lane', '1110987812', 'hellokitty123@hello.ca' );

insert into Customer1(customer_id, customer_name, address, telephone, email) 
values (77893, 'Sailor Sam', '567 Christmas Way', '1087651234', 'samsails@sailor.net');

insert into Customer1(customer_id, customer_name, address, telephone, email) 
values (88293, 'Min Yoongi', '8901 Hogwarts Court', '1905324444', 'minyooo@gmail.com');

insert into Customer1(customer_id, customer_name, address, telephone, email) 
values (92893, 'Yae Miko', '9348 Winter Street', '1335670921', 'yaemiko@hotmail.com');

insert into Customer1(customer_id, customer_name, address, telephone, email) 
values (10181, 'Snow White', '483 Midnight Blvd', '1678920987', 'snowwhite10@disney.ca');

-- CUSTOMER2

insert into Customer2(customer_id, current_location, order_num) 
values (22839,'123 Bubu Lane', 1);

insert into Customer2(customer_id, current_location, order_num) 
values (77893, '567 Christmas Way', 2);

insert into Customer2(customer_id, current_location, order_num) 
values (88293, '8901 Hogwarts Court', 3);

insert into Customer2(customer_id, current_location, order_num) 
values (92893, '9348 Winter Street', 4);

insert into Customer2(customer_id, current_location, order_num) 
values (10181, '483 Midnight Blvd', 5);

-- DELIVERY

insert into Delivery(order_num, delivery_time, delivery_location, driver_id) 
values (1, timestamp '2017-10-12 19:10:00', '123 Bubu Lane', 12543);

insert into Delivery(order_num, delivery_time, delivery_location, driver_id) 
values (2, timestamp '2017-10-12 11:30:30', '567 Christmas Way', 12346);

insert into Delivery(order_num, delivery_time, delivery_location, driver_id) 
values (3, timestamp '2017-10-12 13:00:00', 'Hogwarts Court', 12512);

insert into Delivery(order_num, delivery_time, delivery_location, driver_id) 
values (4, timestamp '2017-10-12 23:30:00', '9348 Winter Street', 12362);

insert into Delivery(order_num, delivery_time, delivery_location, driver_id) 
values (5, timestamp '2017-10-12 17:00:59', '483 Midnight Blvd', 12345);

--MENUITEMHASORDER 

insert into MenuItemHasOrder(order_num, r_name, address, item_name) 
values (3, 'Taco Fiesta', '123 Queso Lane', 'Quesadilla');

insert into MenuItemHasOrder(order_num, r_name, address, item_name) 
values (3, 'Taco Fiesta', '123 Queso Lane', 'Tacos');

insert into MenuItemHasOrder(order_num, r_name, address, item_name) 
values (4, 'Knockout Steakhouse', '8888 Liyue Drive', 'Beef Tenderloin');

insert into MenuItemHasOrder(order_num, r_name, address, item_name) 
values (2, 'Venti Cafe', '333 Windrise Blvd', 'Chai Tea Latte');

insert into MenuItemHasOrder(order_num, r_name, address, item_name) 
values (5, 'Ormos Diner', '8758 Sumeru Avenue', 'Cheeseburger');

insert into MenuItemHasOrder(order_num, r_name, address, item_name) 
values (1, 'Good Hunter', '123 Teyvat Drive', 'Schnitzel');

commit;


