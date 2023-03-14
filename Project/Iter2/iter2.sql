CREATE TABLE Orders (
    OrderID int AUTO_INCREMENT PRIMARY KEY,
    DateIssued DATE,
    DateReceived DATE,
    TotalPrice int,
    PaymentCode int,
    UserId int,
    TripId int,
    ReceiptId int
);

CREATE TABLE Items (
    ItemId int AUTO_INCREMENT PRIMARY KEY,
    ItemName varchar(25),
    Price int,
    MadeIn varchar(25),
    DeptCode int
);

CREATE TABLE Users (
    UserId int AUTO_INCREMENT PRIMARY KEY,
    FullName varchar(50),
    TelephoneNum int,
    Email varchar(50),
    Address varchar(50),
    PostalCode varchar(10),
    LoginId varchar(25) UNIQUE,
    Password varchar(25),
    Balance int NOT NULL DEFAULT(0)
);

CREATE TABLE Trips (
    TripId int AUTO_INCREMENT PRIMARY KEY,
    SourceCode varchar(10),
    DestinationCode varchar(10),
    Distance int,
    TruckId int,
    Price int
);

CREATE TABLE Truck (
    TruckId int AUTO_INCREMENT PRIMARY KEY,
    TruckCode varchar(10),
    AvailabilityCode varchar(10)
);

CREATE TABLE ShoppingCart (
    ReceiptId int AUTO_INCREMENT PRIMARY KEY,
    StoreCode varchar(10),
    TotalPrice int
);
