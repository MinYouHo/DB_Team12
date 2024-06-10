-- CREATE DATABASE IF NOT EXISTS `DB_Team12`;

USE `team12`;
-- DDL
CREATE TABLE IF NOT EXISTS `User` (
    UserID VARCHAR(20) PRIMARY KEY,
    UserName VARCHAR(20) NOT NULL,
    Password VARCHAR(20) NOT NULL,
    Email VARCHAR(254) NOT NULL,
    Phone VARCHAR(20),
    Birth DATE,
    Permission INT NOT NULL CHECK (Permission IN (0, 1))
);

CREATE TABLE IF NOT EXISTS `Company` (
    CompanyID VARCHAR(20) PRIMARY KEY,
    CompanyName VARCHAR(20) NOT NULL,
    Industry VARCHAR(20) NOT NULL
);

CREATE TABLE IF NOT EXISTS `Follow` (
    UserID VARCHAR(20),
    CompanyID VARCHAR(20),
    PRIMARY KEY (UserID, CompanyID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (CompanyID) REFERENCES Company(CompanyID)
);

CREATE TABLE IF NOT EXISTS `Stock` (
    CompanyID VARCHAR(20),
    Date VARCHAR(20),
    Price INT NOT NULL,
    PRIMARY KEY (CompanyID, Date),
    FOREIGN KEY (CompanyID) REFERENCES Company(CompanyID)
);

CREATE TABLE IF NOT EXISTS `Trade` (
    TradeID INT AUTO_INCREMENT PRIMARY KEY,
    UserID VARCHAR(20),
    CompanyID VARCHAR(20),
    TransType INT NOT NULL CHECK (TransType IN (0, 1)),
    Amount INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (CompanyID) REFERENCES Company(CompanyID)
);

CREATE TABLE IF NOT EXISTS `Quarter` (
    CompanyID VARCHAR(20),
    Quarter VARCHAR(20),
    MarketValue INT,
    Dividend FLOAT,
    EPS FLOAT,
    BVPS FLOAT,
    Sale INT,
    PRIMARY KEY (CompanyID, Quarter),
    FOREIGN KEY (CompanyID) REFERENCES Company(CompanyID)
);

-- INSERT
INSERT INTO User (UserID, UserName, Password, Email, Phone, Birth, Permission) VALUES
('user001', 'Alice', 'passAlice', 'alice@example.com', '123-456-7890', '1990-01-15', 1),
('user002', 'Bob', 'passBob', 'bob@example.com', '123-456-7891', '1985-06-23', 0),
('user003', 'Carol', 'passCarol', 'carol@example.com', '123-456-7892', '1992-12-11', 1),
('user004', 'David', 'passDavid', 'david@example.com', '123-456-7893', '1988-03-19', 0),
('user005', 'Eve', 'passEve', 'eve@example.com', '123-456-7894', '1995-07-07', 1);

INSERT INTO Company (CompanyID, CompanyName, Industry) VALUES
('comp001', 'TechCorp', 'Technology'),
('comp002', 'HealthInc', 'Healthcare'),
('comp003', 'FinServices', 'Finance'),
('comp004', 'EduSolutions', 'Education'),
('comp005', 'AgriGoods', 'Agriculture');

INSERT INTO Follow (UserID, CompanyID) VALUES
('user001', 'comp001'),
('user002', 'comp002'),
('user003', 'comp003'),
('user004', 'comp004'),
('user005', 'comp005'),
('user001', 'comp002'),
('user002', 'comp003'),
('user003', 'comp004'),
('user004', 'comp005'),
('user005', 'comp001');

INSERT INTO Stock (CompanyID, Date, Price) VALUES
('comp001', '2023-01-01', 150),
('comp002', '2023-01-01', 200),
('comp003', '2023-01-01', 250),
('comp004', '2023-01-01', 100),
('comp005', '2023-01-01', 300),
('comp001', '2023-02-01', 155),
('comp002', '2023-02-01', 205),
('comp003', '2023-02-01', 255),
('comp004', '2023-02-01', 105),
('comp005', '2023-02-01', 305);

INSERT INTO Trade (UserID, CompanyID, TransType, Amount) VALUES
('user001', 'comp001', 0, 10),
('user002', 'comp002', 1, 20),
('user003', 'comp003', 0, 15),
('user004', 'comp004', 1, 5),
('user005', 'comp005', 0, 25),
('user001', 'comp002', 1, 10),
('user002', 'comp003', 0, 20),
('user003', 'comp004', 1, 15),
('user004', 'comp005', 0, 5),
('user005', 'comp001', 1, 25);

INSERT INTO Quarter (CompanyID, Quarter, MarketValue, Dividend, EPS, BVPS, Sale) VALUES
('comp001', '2023-Q1', 1000000, 1.2, 3.5, 20.0, 500000),
('comp002', '2023-Q1', 2000000, 1.5, 4.0, 25.0, 1000000),
('comp003', '2023-Q1', 1500000, 1.3, 3.8, 22.0, 750000),
('comp004', '2023-Q1', 800000, 1.0, 2.5, 18.0, 400000),
('comp005', '2023-Q1', 1200000, 1.4, 3.9, 21.0, 600000),
('comp001', '2023-Q2', 1050000, 1.3, 3.6, 21.0, 520000),
('comp002', '2023-Q2', 2050000, 1.6, 4.1, 26.0, 1020000),
('comp003', '2023-Q2', 1550000, 1.4, 3.9, 23.0, 770000),
('comp004', '2023-Q2', 850000, 1.1, 2.6, 19.0, 420000),
('comp005', '2023-Q2', 1250000, 1.5, 4.0, 22.0, 620000);