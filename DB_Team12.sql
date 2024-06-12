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
('user001','Emily Johnson','passemily','johnson@gmail.com','0974-868-375','1993/10/4',0),
('user002','Michael Smith','passmichael','smith@gmail.com','0977-518-193','1979/6/14',0),
('user003','Sophia Williams','passsophia','williams@gmail.com','0911-487-538','1968/9/28',0),
('user004','Daniel Brown','passdaniel','brown@gmail.com','0953-630-088','2000/1/10',0),
('user005','Olivia Davis','a','davis@gmail.com','0917-789-291','1982/12/7',1),
('user006','Ethan Wilson','passethan','wilson@gmail.com','0923-997-577','1990/6/28',0),
('user007','Ava Jones','passava','jones@gmail.com','0903-622-501','1984/9/7',0),
('user008','Matthew Taylor','passmatthew','taylor@gmail.com','0972-746-123','1986/5/12',0),
('user009','Isabella Martinez','passisabella','martinez@gmail.com','0932-181-383','1980/9/1',0),
('user010','Alexander Anderson','passalexander','anderson@gmail.com','0927-202-855','1993/1/20',0),
('user011','Mia Thompson','passmia','thompson@gmail.com','0907-271-096','1977/6/25',0),
('user012','William White','passwilliam','white@gmail.com','0909-133-634','1980/10/25',0),
('user013','Charlotte Garcia','passcharlotte','garcia@gmail.com','0902-180-714','2000/12/18',0),
('user014','James Robinson','passjames','robinson@gmail.com','0943-275-328','1979/7/20',0),
('user015','Amelia Lee','passamelia','lee@gmail.com','0900-258-493','1976/9/11',0),
('user016','Benjamin Clark','passbenjamin','clark@gmail.com','0923-427-269','1979/12/1',0),
('user017','Emma Rodriguez','passemma','rodriguez@gmail.com','0970-820-085','1976/4/17',0),
('user018','Jacob Hall','passjacob','hall@gmail.com','0985-372-438','1973/8/5',0),
('user019','Grace Scott','passgrace','scott@gmail.com','0925-984-501','1990/12/5',0),
('user020','Liam Carter','passliam','carter@gmail.com','0967-307-988','1983/2/6',0);

INSERT INTO Company (CompanyID, CompanyName, Industry) VALUES
('0001','InnovateTech Solutions','Technology'),
('0002','CyberNetics Corp','Technology'),
('0003','NanoByte Innovations','Technology'),
('0004','QuantumSoft Systems','Technology'),
('0005','Vertex Robotics','Technology'),
('0006','Medicare Biotech','Healthcare'),
('0007','Wellness Pharmaceuticals','Healthcare'),
('0008','HealthGuard Diagnostics','Healthcare'),
('0009','LifeCare Medical','Healthcare'),
('0010','NeuroHealth Therapeutics','Healthcare'),
('0011','Pinnacle Finance Group','Financial Services'),
('0012','Summit Investments','Financial Services'),
('0013','CapitalTrust Bank','Financial Services'),
('0014','EquityRise Financial','Financial Services'),
('0015','PrimeSecure Insurance','Financial Services'),
('0016','LuxuryLiving Brands','Consumer Discretionary'),
('0017','FashionVista Retail','Consumer Discretionary'),
('0018','TravelElite Experiences','Consumer Discretionary'),
('0019','GourmetDelights Foods','Consumer Discretionary'),
('0020','LeisureLand Resorts','Consumer Discretionary'),
('0021','DailyFresh Groceries','Consumer Staples'),
('0022','PureEssentials Household','Consumer Staples'),
('0023','NutriLife Foods','Consumer Staples'),
('0024','HomeSafe Products','Consumer Staples'),
('0025','ValueCare Supplies','Consumer Staples'),
('0026','EcoPower Resources','Energy'),
('0027','SolarWave Energy','Energy'),
('0028','FusionFuel Corporation','Energy'),
('0029','GreenEarth Oil & Gas','Energy'),
('0030','RenewablePulse Energy','Energy'),
('0031','AquaFlow Utilities','Utilities'),
('0032','UrbanGrid Power','Utilities'),
('0033','EverLight Electric','Utilities'),
('0034','PureAir Services','Utilities'),
('0035','GreenCity Waterworks','Utilities'),
('0036','GlobalMach Industries','Industrials'),
('0037','PrecisionWorks Manufacturing','Industrials'),
('0038','Skyline Engineering','Industrials'),
('0039','HeavyDuty Constructions','Industrials'),
('0040','RapidLogistics Freight','Industrials'),
('0041','GlobalConnect Networks','Telecommunications'),
('0042','TeleWave Communications','Telecommunications'),
('0043','NextGen Telecom','Telecommunications'),
('0044','UltraNet Services','Telecommunications'),
('0045','MetroLink Wireless','Telecommunications'),
('0046','UrbanOasis Properties','Real Estate'),
('0047','PrimeLand Realty','Real Estate'),
('0048','SkyHigh Developments','Real Estate'),
('0049','EcoHomes Real Estate','Real Estate'),
('0050','MetroPlaza Holdings','Real Estate');


INSERT INTO Follow (UserID, CompanyID) VALUES
('user002','0044'),
('user017','0048'),
('user015','0003'),
('user019','0017'),
('user001','0021'),
('user004','0046'),
('user020','0041'),
('user002','0026'),
('user005','0001'),
('user010','0014'),
('user014','0006'),
('user002','0028'),
('user003','0047'),
('user012','0048'),
('user018','0025'),
('user006','0030'),
('user001','0020'),
('user007','0034'),
('user006','0045'),
('user001','0029'),
('user010','0039'),
('user017','0045'),
('user019','0036'),
('user020','0039'),
('user003','0045'),
('user019','0024'),
('user003','0039');

INSERT INTO Stock (CompanyID, Date, Price) VALUES
('0001', '2023-01-01', 150),
('0002', '2023-01-01', 200),
('0003', '2023-01-01', 250),
('0004', '2023-01-01', 100),
('0005', '2023-01-01', 300),
('0001', '2023-02-01', 155),
('0002', '2023-02-01', 205),
('0003', '2023-02-01', 255),
('0004', '2023-02-01', 105),
('0005', '2023-02-01', 305);

INSERT INTO Trade (UserID, CompanyID, TransType, Amount) VALUES
('user001', '0001', 0, 10),
('user002', '0002', 1, 20),
('user003', '0003', 0, 15),
('user004', '0004', 1, 5),
('user005', '0005', 0, 25),
('user001', '0002', 1, 10),
('user002', '0003', 0, 20),
('user003', '0004', 1, 15),
('user004', '0005', 0, 5),
('user005', '0001', 1, 25);

INSERT INTO Quarter (CompanyID, Quarter, MarketValue, Dividend, EPS, BVPS, Sale) VALUES
('0001','2023-Q1',27278931,16,23,58,19607517),
('0001','2023-Q2',28479077,19,14,39,18765795),
('0001','2023-Q3',33770148,27,19,46,12386994),
('0001','2023-Q4',37619998,11,20,46,17538671),
('0001','2024-Q1',35483942,19,24,65,16075524),
('0002','2023-Q1',31306637,2,3,114,34370300),
('0002','2023-Q2',25711547,5,2,100,19828760),
('0002','2023-Q3',21006574,3,2,88,25566011),
('0002','2023-Q4',23406622,5,1,84,20902803),
('0002','2024-Q1',26453971,2,1,117,35205870),
('0003','2023-Q1',106049308,14,7,56,13315215),
('0003','2023-Q2',101397466,12,12,65,11099445),
('0003','2023-Q3',119508658,9,11,67,16085441),
('0003','2023-Q4',107973956,10,11,67,11093071),
('0003','2024-Q1',110695098,6,10,39,12715998),
('0004','2023-Q1',20862537,5,23,81,39374875),
('0004','2023-Q2',24303565,11,23,103,29584224),
('0004','2023-Q3',21945442,6,33,100,27715059),
('0004','2023-Q4',20634522,13,42,114,40488131),
('0004','2024-Q1',22082415,6,43,90,28173364),
('0005','2023-Q1',80269487,21,40,20,81672732),
('0005','2023-Q2',71428142,13,34,17,78613560),
('0005','2023-Q3',77522198,15,15,25,92146635),
('0005','2023-Q4',79144984,20,28,22,76020223),
('0005','2024-Q1',83947470,12,13,17,72745912),
('0006','2023-Q1',79258284,1,28,24,24263863),
('0006','2023-Q2',91983220,2,26,22,25186508),
('0006','2023-Q3',106241406,2,27,20,36265124),
('0006','2023-Q4',114329053,3,22,27,36516438),
('0006','2024-Q1',99380891,1,26,16,28747963),
('0007','2023-Q1',8985806,7,32,60,25478468),
('0007','2023-Q2',7726304,4,35,66,25232672),
('0007','2023-Q3',7211603,5,45,55,30075014),
('0007','2023-Q4',7097288,6,51,50,34919916),
('0007','2024-Q1',6480894,4,49,54,21673111),
('0008','2023-Q1',37250512,16,13,19,20326783),
('0008','2023-Q2',33693316,6,25,17,19225781),
('0008','2023-Q3',29366681,18,24,13,27667463),
('0008','2023-Q4',24077825,8,38,13,24714503),
('0008','2024-Q1',21476212,10,13,20,25864822),
('0009','2023-Q1',79842988,16,21,45,84964186),
('0009','2023-Q2',90189187,13,60,43,63483375),
('0009','2023-Q3',93315492,6,33,63,65888756),
('0009','2023-Q4',97003062,14,29,63,67413057),
('0009','2024-Q1',81058273,6,46,56,83038590),
('0010','2023-Q1',47401030,6,18,83,40437673),
('0010','2023-Q2',47115408,10,18,110,47246363),
('0010','2023-Q3',51300337,10,40,100,49863933),
('0010','2023-Q4',56884371,6,32,106,50847859),
('0010','2024-Q1',64690215,6,17,85,70901734),
('0011','2023-Q1',103013726,13,28,19,69952707),
('0011','2023-Q2',90902979,11,34,31,41060368),
('0011','2023-Q3',106663759,23,22,31,46687831),
('0011','2023-Q4',113036212,15,45,19,56725283),
('0011','2024-Q1',108913565,8,22,29,51592180),
('0012','2023-Q1',89780180,16,1,45,8441645),
('0012','2023-Q2',79248382,9,1,49,6759271),
('0012','2023-Q3',71602239,13,3,43,6788179),
('0012','2023-Q4',59252049,8,3,59,7624756),
('0012','2024-Q1',68177499,23,1,57,9605642),
('0013','2023-Q1',17860022,21,18,79,17680997),
('0013','2023-Q2',16761267,10,13,63,16026793),
('0013','2023-Q3',14278493,8,21,62,14923605),
('0013','2023-Q4',12542423,11,28,45,11782450),
('0013','2024-Q1',14872767,10,14,66,17725126),
('0014','2023-Q1',66960051,9,2,25,69998588),
('0014','2023-Q2',78601594,7,2,21,84950658),
('0014','2023-Q3',92117357,5,1,22,75797129),
('0014','2023-Q4',102169845,4,3,26,101491601),
('0014','2024-Q1',120387004,7,1,23,86563458),
('0015','2023-Q1',39720110,27,18,49,52503261),
('0015','2023-Q2',37254258,27,17,44,34829134),
('0015','2023-Q3',36944282,23,36,52,36996983),
('0015','2023-Q4',40877120,16,19,49,57235816),
('0015','2024-Q1',34100990,17,36,34,48612300),
('0016','2023-Q1',45338778,3,31,74,57465031),
('0016','2023-Q2',44001626,3,30,78,46837843),
('0016','2023-Q3',52325728,1,29,73,67933093),
('0016','2023-Q4',48610328,3,47,81,62617371),
('0016','2024-Q1',55672871,2,19,50,63885481),
('0017','2023-Q1',96050175,18,16,88,73060735),
('0017','2023-Q2',94047941,15,17,56,55654865),
('0017','2023-Q3',94928122,5,48,86,54287285),
('0017','2023-Q4',113411241,8,49,97,59841462),
('0017','2024-Q1',128823985,6,29,80,60672574),
('0018','2023-Q1',40399487,3,6,61,56369296),
('0018','2023-Q2',37833694,3,5,64,73148467),
('0018','2023-Q3',42651920,3,4,53,61373284),
('0018','2023-Q4',34645387,3,5,83,83775419),
('0018','2024-Q1',32091745,3,4,71,72560922),
('0019','2023-Q1',8949105,20,20,33,35292121),
('0019','2023-Q2',9244910,17,33,35,29076774),
('0019','2023-Q3',10905549,20,22,20,21024519),
('0019','2023-Q4',10569243,13,24,27,21856777),
('0019','2024-Q1',10460693,11,58,24,34999175),
('0020','2023-Q1',29297469,1,26,75,7148861),
('0020','2023-Q2',33668821,3,63,87,8602491),
('0020','2023-Q3',31407721,1,40,96,5241749),
('0020','2023-Q4',29323512,3,24,88,5509198),
('0020','2024-Q1',34519799,3,46,79,8256702),
('0021','2023-Q1',84605894,18,0,54,92726504),
('0021','2023-Q2',80407645,18,0,53,69337815),
('0021','2023-Q3',70948507,27,0,69,102778544),
('0021','2023-Q4',84652509,26,0,57,93167611),
('0021','2024-Q1',80407514,14,0,41,66057007),
('0022','2023-Q1',83139468,5,37,65,44096912),
('0022','2023-Q2',69852585,8,37,38,47213638),
('0022','2023-Q3',65567955,5,13,52,34560799),
('0022','2023-Q4',55407564,8,30,52,44513883),
('0022','2024-Q1',44360576,9,28,46,37511752),
('0023','2023-Q1',54050380,2,41,9,86137965),
('0023','2023-Q2',61140716,2,54,8,88381499),
('0023','2023-Q3',62245811,1,50,13,92502409),
('0023','2023-Q4',56249622,1,20,11,88483441),
('0023','2024-Q1',62306048,1,43,10,98117003),
('0024','2023-Q1',86973218,2,44,39,49949406),
('0024','2023-Q2',77361274,5,64,59,83935939),
('0024','2023-Q3',63289246,5,29,47,69504889),
('0024','2023-Q4',61553409,4,50,39,81953483),
('0024','2024-Q1',64134294,4,68,38,72976610),
('0025','2023-Q1',114932457,10,12,70,22954506),
('0025','2023-Q2',102315042,13,27,62,20044138),
('0025','2023-Q3',82590501,7,14,56,18991345),
('0025','2023-Q4',93221554,12,26,43,21215385),
('0025','2024-Q1',79649128,13,25,63,18843926),
('0026','2023-Q1',29016061,22,4,84,48350484),
('0026','2023-Q2',24312431,25,13,68,39859350),
('0026','2023-Q3',21851475,17,4,83,31898680),
('0026','2023-Q4',23959553,32,11,86,50519700),
('0026','2024-Q1',20736744,9,4,71,31631354),
('0027','2023-Q1',9083410,17,25,49,21181994),
('0027','2023-Q2',9821221,7,15,62,25471990),
('0027','2023-Q3',7962255,6,18,50,26898188),
('0027','2023-Q4',8436961,12,25,64,24824886),
('0027','2024-Q1',8035556,10,27,42,23535228),
('0028','2023-Q1',60458144,11,20,53,35955091),
('0028','2023-Q2',55539610,25,17,41,57868927),
('0028','2023-Q3',46692501,15,16,46,54150851),
('0028','2023-Q4',50422908,28,15,47,43939082),
('0028','2024-Q1',49398825,28,21,40,33877494),
('0029','2023-Q1',20924679,19,66,45,84008752),
('0029','2023-Q2',17486101,10,50,36,74599172),
('0029','2023-Q3',15541258,16,32,52,112672744),
('0029','2023-Q4',15721364,12,48,43,61277080),
('0029','2024-Q1',12577500,13,72,50,80501659),
('0030','2023-Q1',18065442,9,24,22,12738256),
('0030','2023-Q2',17674393,21,26,29,12251086),
('0030','2023-Q3',15530472,9,23,24,19880666),
('0030','2023-Q4',12739512,17,15,26,14497201),
('0030','2024-Q1',13436892,15,14,27,19760671),
('0031','2023-Q1',5314250,21,23,82,41992524),
('0031','2023-Q2',5472019,6,15,101,34796442),
('0031','2023-Q3',6556559,16,13,119,27803703),
('0031','2023-Q4',6968055,15,26,77,34141023),
('0031','2024-Q1',6960495,17,21,103,43790986),
('0032','2023-Q1',76154572,16,4,36,50843136),
('0032','2023-Q2',73566719,13,3,47,53730752),
('0032','2023-Q3',87189953,10,5,51,47532540),
('0032','2023-Q4',70857744,7,7,52,44690563),
('0032','2024-Q1',77222637,11,10,36,39757538),
('0033','2023-Q1',107777858,15,14,40,79060111),
('0033','2023-Q2',98226730,12,19,57,69657680),
('0033','2023-Q3',100086434,6,33,66,49762502),
('0033','2023-Q4',105384731,8,13,60,76800868),
('0033','2024-Q1',122201881,12,45,51,48083126),
('0034','2023-Q1',66855131,12,54,105,43369774),
('0034','2023-Q2',62089423,12,25,91,48712771),
('0034','2023-Q3',69946734,10,58,62,44284228),
('0034','2023-Q4',70451371,32,45,79,46696058),
('0034','2024-Q1',70918838,22,42,77,42628646),
('0035','2023-Q1',92462967,12,6,101,18264387),
('0035','2023-Q2',94635415,10,7,89,13684871),
('0035','2023-Q3',82782064,13,11,128,16561219),
('0035','2023-Q4',80337594,9,9,119,15036893),
('0035','2024-Q1',68099723,12,16,117,15122154),
('0036','2023-Q1',64854018,25,22,43,15012818),
('0036','2023-Q2',54839218,15,14,50,18466721),
('0036','2023-Q3',52571653,10,8,46,18078002),
('0036','2023-Q4',56073583,16,21,54,21142908),
('0036','2024-Q1',62305705,21,25,39,15169836),
('0037','2023-Q1',8177991,26,25,21,13523734),
('0037','2023-Q2',9218013,18,22,21,8414940),
('0037','2023-Q3',8903375,20,18,20,13894266),
('0037','2023-Q4',9171813,18,19,17,13210439),
('0037','2024-Q1',9273084,19,10,20,10081313),
('0038','2023-Q1',57549548,2,21,10,89395261),
('0038','2023-Q2',52203594,5,39,8,69000138),
('0038','2023-Q3',44542028,5,26,13,114339987),
('0038','2023-Q4',39979292,6,27,11,121799292),
('0038','2024-Q1',44836573,2,47,8,113299227),
('0039','2023-Q1',19045919,19,60,98,63558097),
('0039','2023-Q2',20646851,31,65,56,62385056),
('0039','2023-Q3',21203568,14,43,68,51954916),
('0039','2023-Q4',24622645,31,61,83,69844905),
('0039','2024-Q1',25900018,30,41,70,65426421),
('0040','2023-Q1',21845719,21,6,35,64362970),
('0040','2023-Q2',18807402,14,10,59,73715215),
('0040','2023-Q3',15187187,12,9,62,64646189),
('0040','2023-Q4',17155987,9,19,37,54799259),
('0040','2024-Q1',17442389,15,10,62,73745672),
('0041','2023-Q1',72764003,17,0,106,4572989),
('0041','2023-Q2',59604303,21,0,84,5527063),
('0041','2023-Q3',54971232,7,0,95,4484777),
('0041','2023-Q4',57220657,6,0,104,4432962),
('0041','2024-Q1',63260059,11,0,83,4867186),
('0042','2023-Q1',7580150,4,29,57,55537208),
('0042','2023-Q2',6518072,7,26,39,54376370),
('0042','2023-Q3',7096782,6,22,52,63611535),
('0042','2023-Q4',6206677,8,23,48,41177071),
('0042','2024-Q1',6329162,9,21,47,54718557),
('0043','2023-Q1',59195593,16,7,23,50345802),
('0043','2023-Q2',65315314,7,4,20,48425995),
('0043','2023-Q3',73070194,25,7,14,50896607),
('0043','2023-Q4',75304276,25,6,21,56493089),
('0043','2024-Q1',73565431,8,7,16,58713168),
('0044','2023-Q1',7212911,10,11,98,61298087),
('0044','2023-Q2',8161562,5,6,108,82722848),
('0044','2023-Q3',9003699,10,4,64,88230836),
('0044','2023-Q4',8747857,8,10,87,90007076),
('0044','2024-Q1',10165011,9,6,70,89696321),
('0045','2023-Q1',61493032,17,3,122,69160392),
('0045','2023-Q2',64457013,9,2,109,99991108),
('0045','2023-Q3',53560279,26,1,91,56657400),
('0045','2023-Q4',53345847,13,1,92,57697053),
('0045','2024-Q1',47483466,30,2,122,94543094),
('0046','2023-Q1',65630867,8,7,23,21872708),
('0046','2023-Q2',75751536,11,7,15,17104084),
('0046','2023-Q3',63922565,7,3,19,17020040),
('0046','2023-Q4',66704111,10,6,15,14403809),
('0046','2024-Q1',77936207,10,8,14,20701268),
('0047','2023-Q1',7597935,5,15,80,76213257),
('0047','2023-Q2',7989510,15,11,82,61298604),
('0047','2023-Q3',6519685,6,7,75,48765259),
('0047','2023-Q4',6298524,8,13,70,48662383),
('0047','2024-Q1',7433857,11,24,78,85116258),
('0048','2023-Q1',80364265,6,24,23,37881092),
('0048','2023-Q2',74008985,12,45,29,30366349),
('0048','2023-Q3',79761147,12,39,17,39525012),
('0048','2023-Q4',85142819,12,38,19,39535068),
('0048','2024-Q1',77183086,16,28,22,43975628),
('0049','2023-Q1',87053737,17,21,9,11202167),
('0049','2023-Q2',102765485,16,23,10,14706450),
('0049','2023-Q3',103721220,18,13,12,11567986),
('0049','2023-Q4',114790273,9,38,11,17449006),
('0049','2024-Q1',110717244,14,21,9,15838805),
('0050','2023-Q1',6576025,25,13,75,4726757),
('0050','2023-Q2',6484243,11,17,63,4781136),
('0050','2023-Q3',6225274,11,35,83,6188268),
('0050','2023-Q4',6385070,19,26,65,4578191),
('0050','2024-Q1',5923603,21,30,81,5212788);
