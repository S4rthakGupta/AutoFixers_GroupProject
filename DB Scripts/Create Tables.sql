USE auto_fixers;


DROP TABLE if exists Appointments;
DROP TABLE if exists Parts;
DROP TABLE if exists Services;
DROP TABLE if exists Vehicles;
DROP TABLE if exists Customers;


CREATE TABLE Customers (
    customer_id INT auto_increment PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL
);

CREATE TABLE Parts (
    part_id INT auto_increment PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);

CREATE TABLE Services (
    service_id INT auto_increment PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cost DECIMAL(10, 2) NOT NULL,
    duration INT NOT NULL
);

CREATE TABLE Vehicles (
    vehicle_id INT auto_increment PRIMARY KEY,
    customer_id INT NOT NULL,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);

CREATE TABLE Appointments (
    appointment_id INT auto_increment PRIMARY KEY,
    customer_id INT NOT NULL,
    vehicle_id INT NOT NULL,
    date DATE NOT NULL,
    service_id INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (vehicle_id) REFERENCES Vehicles(vehicle_id),
    FOREIGN KEY (service_id) REFERENCES Services(service_id)
);

