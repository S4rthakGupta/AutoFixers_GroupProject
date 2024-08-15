CREATE DATABASE IF NOT EXISTS auto_fixers;

USE auto_fixers;

CREATE TABLE IF NOT EXISTS Customers (
    CustomerID INT AUTO_INCREMENT PRIMARY KEY,
    CustomerName VARCHAR(255) NOT NULL,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Phone VARCHAR(20)
);

CREATE TABLE IF NOT EXISTS Orders (
    OrderID INT AUTO_INCREMENT PRIMARY KEY,
    OrderDate DATE NOT NULL,
    CustomerID INT,
    FOREIGN KEY (CustomerID) REFERENCES Customers(CustomerID)
);

CREATE TABLE IF NOT EXISTS Parts (
    PartID INT AUTO_INCREMENT PRIMARY KEY,
    PartName VARCHAR(255) NOT NULL,
    PartDescription TEXT,
    Price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE IF NOT EXISTS OrderedParts (
    OrderedPartsID INT AUTO_INCREMENT PRIMARY KEY,
    OrderID INT NOT NULL,
    PartID INT NOT NULL,
    Quantity INT NOT NULL,
    FOREIGN KEY (OrderID) REFERENCES Orders(OrderID) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (PartID) REFERENCES Parts(PartID) ON DELETE CASCADE ON UPDATE CASCADE
);
