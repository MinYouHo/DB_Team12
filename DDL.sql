CREATE TABLE User (
    UserID VARCHAR(20) PRIMARY KEY,
    UserName VARCHAR(20) NOT NULL,
    Password VARCHAR(20) NOT NULL,
    Email VARCHAR(254) NOT NULL,
    Phone VARCHAR(20),
    Birth DATE,
    Permission INT NOT NULL CHECK (Permission IN (0, 1))
);

CREATE TABLE Company (
    CompanyID VARCHAR(20) PRIMARY KEY,
    CompanyName VARCHAR(20) NOT NULL,
    Industry VARCHAR(20) NOT NULL
);

CREATE TABLE Follow (
    UserID VARCHAR(20),
    CompanyID VARCHAR(20),
    PRIMARY KEY (UserID, CompanyID),
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (CompanyID) REFERENCES Company(CompanyID)
);

CREATE TABLE Stock (
    CompanyID VARCHAR(20),
    Date VARCHAR(20),
    Price INT NOT NULL,
    PRIMARY KEY (CompanyID, Date),
    FOREIGN KEY (CompanyID) REFERENCES Company(CompanyID)
);

CREATE TABLE Trade (
    TradeID INT AUTO_INCREMENT PRIMARY KEY,
    UserID VARCHAR(20),
    CompanyID VARCHAR(20),
    TransType INT NOT NULL CHECK (TransType IN (0, 1)),
    Amount INT NOT NULL,
    FOREIGN KEY (UserID) REFERENCES User(UserID),
    FOREIGN KEY (CompanyID) REFERENCES Company(CompanyID)
);

CREATE TABLE Quarter (
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
