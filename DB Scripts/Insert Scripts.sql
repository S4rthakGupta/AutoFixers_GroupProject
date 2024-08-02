INSERT INTO Customers (customer_id, name, email, phone_number) VALUES
('CUST001', 'Abhishek Chachad', 'abhi@gmail.com', '4613148651'),
('CUST002', 'Sarthak Gupta', 'sarthak@gmail.com', '9794612124'),
('CUST003', 'Shakila Sam', 'shak@gmail.com', '7856324568'),
('CUST004', 'Virat Kohli', 'vinit@gmail.com', '4445556666'),
('CUST005', 'Rohit Sharma', 'tom@gmail.com', '7778889999');

INSERT INTO Parts (part_id, name, price, stock) VALUES
('PART001', 'Oil Filter', 15.99, 50),
('PART002', 'Brake Pads', 45.99, 30),
('PART003', 'Tire', 75.99, 20),
('PART004', 'Battery', 100.99, 10),
('PART005', 'Spark Plug', 5.99, 100);

INSERT INTO Services (service_id, name, cost, duration) VALUES
('SERV001', 'Oil Change', 29.99, 30),
('SERV002', 'Brake Inspection', 49.99, 45),
('SERV003', 'Tire Rotation', 19.99, 20),
('SERV004', 'Battery Replacement', 99.99, 60),
('SERV005', 'Engine Check', 59.99, 40);

INSERT INTO Vehicles (vehicle_id, customer_id, make, model, year) VALUES
('VEH001', 'CUST001', 'Toyota', 'Corolla', 2015),
('VEH002', 'CUST002', 'Honda', 'Civic', 2018),
('VEH003', 'CUST003', 'Ford', 'Focus', 2012),
('VEH004', 'CUST004', 'Chevrolet', 'Malibu', 2016),
('VEH005', 'CUST005', 'Nissan', 'Sentra', 2019);

INSERT INTO Appointments (appointment_id, customer_id, vehicle_id, date, service_id) VALUES
('APP001', 'CUST001', 'VEH001', '2024-08-10', 'SERV001'),
('APP002', 'CUST002', 'VEH002', '2024-08-12', 'SERV002'),
('APP003', 'CUST003', 'VEH003', '2024-08-15', 'SERV003'),
('APP004', 'CUST004', 'VEH004', '2024-08-20', 'SERV004'),
('APP005', 'CUST005', 'VEH005', '2024-08-25', 'SERV005');
