CREATE TABLE Order (
    OrderID int AUTO_INCREMENT PRIMARY KEY,
    DateIssued DATE,
    DateReceived DATE,
    TotalPrice int,
    PaymentCode int,
    UserId int,
    TripId int,
    ReceiptId int,
);;

CREATE TABLE Item (
    ItemId int AUTO_INCREMENT PRIMARY KEY,
    ItemName var(25),
    Price int,
    MadeIn var(25),
    DeptCode int,
);

CREATE TABLE User (
    UserId int AUTO_INCREMENT PRIMARY KEY,
    FullName var(50),
    TelephoneNum int,
    Email var(50),
    Address var(50),
    PostalCode var(10),
    LoginId var(25),
    Password var(25),
    Balance int,
);

CREATE TABLE Trip (
    TripId int AUTO_INCREMENT PRIMARY KEY,
    SourceCode var(10),
    DestinationCode var(10),
    Distance int,
    TruckId int,
    Price int,
);

CREATE TABLE Truck (
    TruckId int AUTO_INCREMENT PRIMARY KEY,
    TruckCode var(10),
    AvailabilityCode var(10),
);

CREATE TABLE Shopping (
    ReceiptId int AUTO_INCREMENT PRIMARY KEY,
    StoreCode var(10),
    TotalPrice int,
);
