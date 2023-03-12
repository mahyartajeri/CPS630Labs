CREATE TABLE Order (
    OrderID int NOT NULL PRIMARY KEY,
    DateIssued DATE,
    DateReceived DATE,
    TotalPrice int,
    PaymentCode int,
    UserId int,
    TripId int,
    ReceiptId int,
);;

CREATE TABLE Item (
    ItemId int NOT NULL PRIMARY KEY,
    ItemName var(25),
    Price int,
    MadeIn var(25),
    DeptCode int,
);

CREATE TABLE User (
    UserId int NOT NULL PRIMARY KEY,
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
    TripId int NOT NULL PRIMARY KEY,
    SourceCode var(10),
    DestinationCode var(10),
    Distance int,
    TruckId int,
    Price int,
);

CREATE TABLE Truck (
    TruckId int NOT NULL PRIMARY KEY,
    TruckCode var(10),
    AvailabilityCode var(10),
);

CREATE TABLE Shopping (
    ReceiptId int NOT NULL PRIMARY KEY,
    StoreCode var(10),
    TotalPrice int,
);
