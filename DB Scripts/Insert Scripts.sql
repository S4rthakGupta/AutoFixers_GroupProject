INSERT INTO Customers (name, email, phone_number) VALUES
('Abhishek Chachad', 'abhi@gmail.com', '4613148651'),
('Sarthak Gupta', 'sarthak@gmail.com', '9794612124'),
('Shakila Sam', 'shak@gmail.com', '7856324568'),
('Virat Kohli', 'vinit@gmail.com', '4445556666'),
('Rohit Sharma', 'rohit@gmail.com', '7778889999');

INSERT INTO Parts ( name, price, stock) VALUES
('Oil Filter', 15.99, 50),
('Brake Pads', 45.99, 30),
('Tire', 75.99, 20),
('Battery', 100.99, 10),
('Spark Plug', 5.99, 100);

INSERT INTO Services (name, cost, duration) VALUES
('Oil Change', 29.99, 30),
('Brake Inspection', 49.99, 45),
('Tire Rotation', 19.99, 20),
('Battery Replacement', 99.99, 60),
('Engine Check', 59.99, 40);

INSERT INTO Vehicles (customer_id, make, model, year) VALUES
('1', 'Toyota', 'Corolla', 2015),
('2', 'Honda', 'Civic', 2018),
('3', 'Ford', 'Focus', 2012),
('4', 'Chevrolet', 'Malibu', 2016),
('5', 'Nissan', 'Sentra', 2019);

INSERT INTO Appointments (customer_id, vehicle_id, date, service_id) VALUES
('1', '1', '2024-08-10', '1'),
('2', '2', '2024-08-12', '2'),
('3', '3', '2024-08-15', '3'),
('4', '4', '2024-08-20', '4'),
('5', '5', '2024-08-25', '5');
