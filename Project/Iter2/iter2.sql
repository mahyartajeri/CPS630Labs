CREATE TABLE Users
(
  user_id INT
  AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR
  (50) NOT NULL,
  tel_no VARCHAR
  (20) NOT NULL,
  email VARCHAR
  (50) NOT NULL,
  address VARCHAR
  (100) NOT NULL,
  city_code VARCHAR
  (20) NOT NULL,
  login_id VARCHAR
  (50) NOT NULL,
  password VARCHAR
  (50) NOT NULL,
  balance DECIMAL
  (10, 2) NOT NULL
);

  CREATE TABLE Items
  (
    item_id INT
    AUTO_INCREMENT PRIMARY KEY,
  item_name VARCHAR
    (50) NOT NULL,
  price DECIMAL
    (10, 2) NOT NULL,
  made_in VARCHAR
    (50) NOT NULL,
  department_code VARCHAR
    (20) NOT NULL
);

    CREATE TABLE Purchases
    (
      receipt_id INT
      AUTO_INCREMENT PRIMARY KEY,
  store_code VARCHAR
      (20) NOT NULL,
  total_price DECIMAL
      (10, 2) NOT NULL
);

      CREATE TABLE Trucks
      (
        truck_id INT
        AUTO_INCREMENT PRIMARY KEY,
  truck_code VARCHAR
        (20) NOT NULL,
  availability_code VARCHAR
        (20) NOT NULL
);

        CREATE TABLE Trips
        (
          trip_id INT
          AUTO_INCREMENT PRIMARY KEY,
  source_code VARCHAR
          (20) NOT NULL,
  destination_code VARCHAR
          (20) NOT NULL,
  distance DECIMAL
          (10, 2) NOT NULL,
  truck_id INT NOT NULL,
  price DECIMAL
          (10, 2) NOT NULL,
  FOREIGN KEY
          (truck_id) REFERENCES Trucks
          (truck_id)
);

          CREATE TABLE Orders
          (
            order_id INT
            AUTO_INCREMENT PRIMARY KEY,
  date_issued DATE NOT NULL,
  date_received DATE NOT NULL,
  total_price DECIMAL
            (10, 2) NOT NULL,
  payment_code VARCHAR
            (20) NOT NULL,
  user_id INT NOT NULL,
  trip_id INT NOT NULL,
  receipt_id INT NOT NULL,
  FOREIGN KEY
            (user_id) REFERENCES Users
            (user_id),
  FOREIGN KEY
            (trip_id) REFERENCES Trips
            (trip_id),
  FOREIGN KEY
            (receipt_id) REFERENCES Purchases
            (receipt_id)
);

            CREATE TABLE ShoppingCart
            (
              user_id INT,
              item_id INT,

              PRIMARY KEY(user_id, item_id),
              FOREIGN KEY (user_id) REFERENCES Users (user_id),
              FOREIGN KEY (item_id) REFERENCES Items (item_id)
            );