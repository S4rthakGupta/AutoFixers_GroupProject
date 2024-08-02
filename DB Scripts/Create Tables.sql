USE auto_fixers;

CREATE TABLE Customers (
    customer_id CHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone_number VARCHAR(15) NOT NULL
);

CREATE TABLE Parts (
    part_id CHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    stock INT NOT NULL
);

CREATE TABLE Services (
    service_id CHAR(10) PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    cost DECIMAL(10, 2) NOT NULL,
    duration INT NOT NULL
);

CREATE TABLE Vehicles (
    vehicle_id CHAR(10) PRIMARY KEY,
    customer_id CHAR(10) NOT NULL,
    make VARCHAR(50) NOT NULL,
    model VARCHAR(50) NOT NULL,
    year INT NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id)
);

CREATE TABLE Appointments (
    appointment_id CHAR(10) PRIMARY KEY,
    customer_id CHAR(10) NOT NULL,
    vehicle_id CHAR(10) NOT NULL,
    date DATE NOT NULL,
    service_id CHAR(10) NOT NULL,
    FOREIGN KEY (customer_id) REFERENCES Customers(customer_id),
    FOREIGN KEY (vehicle_id) REFERENCES Vehicles(vehicle_id),
    FOREIGN KEY (service_id) REFERENCES Services(service_id)
);

