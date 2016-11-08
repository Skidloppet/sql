drop database SlitABSkidloppet;
create database SlitABSkidloppet;
use SlitABSkidloppet;
-- asdasd
-- Tabell för Skidloppet anställda
create table Ski(
skiID smallint not null auto_increment unique,
password varchar(32) not null,
firstName varchar(32) not null,
lastName varchar(32) not null,
email varchar(64),
number int(10) not null,
type ENUM('arenachef','other'),
regDate timestamp,
primary key (skiID)
)engine=innodb;


-- Tabell för Entrepenörer 
create table Ent (
entID smallint not null auto_increment unique, 
password varchar(32)not null,
firstName varchar(32)not null,
lastName varchar(32) not null,
email varchar (64),
number int(10) not null,
regDate timestamp,
primary key (entID)
)engine=innodb;


-- tabell för gruppering av platser (tex sträckor)
create table Place (
name varchar(32) not null,
info varchar(1024),
primary key (name)
)engine=innodb;
;

-- tabell för arbetsorder
create table WorkOrder (
orderID int not null auto_increment unique,
skiID smallint not null,
entID smallint null,
-- (entID) Kan inte tilldelas till en specifik entreprenör vid akut prio.
sentDate timestamp,
startDate timestamp,
-- kanske ha endDate också
priority enum('high','medium','low','akut'),
info varchar(1024),
primary key (orderID),
foreign key (skiID) references Ski(skiID),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- tabell för kundkommentarer
create table Comment(
commentID int auto_increment unique,
comment varchar(1024) not null,
alias varchar(32) not null,
date timestamp,
primary key (commentID)
)engine=innodb;


-- tabell för specifika platser
create table SubPlace (
name varchar(32) not null,
placeName varchar(32) not null,
entID smallint null,
length mediumint,
height smallint,
fakesnow smallint,
primary key (name),
foreign key (placeName) references Place(name),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- cannon är snökanon, model namn avgör om den är stationär
create table Cannon (
cannonID smallint not null auto_increment unique,
subPlaceName varchar(32),
model char (4) not null,
-- model visar om det är stationär eller ej
status enum('on','off','unplugged','broken'),
effect smallint,
-- effect och status tillsammans med N:M tabellens timestamp skall visa antal m2 snö tillverkat.
primary key (cannonID),
foreign key (subPlaceName) references SubPlace(name)
)engine=innodb;


-- Tabell för avrapportering av dagligt underhåll 
create table Report(
reportID int not null auto_increment unique,
entID smallint not null,
startDate timestamp,
workDate datetime,
-- workDate är nästa förväntade arbetspass
rating enum('1','2','3','4','5'),
underlay enum('1','2','3','4','5'),
edges enum('1','2','3','4','5'),
grip enum('1','2','3','4','5'),
depth DECIMAL(3,1),
-- depth är uppskattat snödjup efter dagligt underhåll
-- DECIMAL 3 integer 1 decimal. (t.ex. 123.1)
primary key (reportID),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- Tabell för Felmedelanden
-- Här måste man ange en entrepenör för att inte få error(ALTER Error (entID) när man accepterar en akut?!?)
create table Error (
errorID int not null auto_increment,
entID smallint null,
-- null entID för alla felanmälanden som skapas av motionärer
sentDate timestamp,
grade enum('low','medium','high','akut'),
errorDesc varchar(1024),
type enum('lights','tracks','dirt','trees','other') not null,
primary key (errorID),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- N:M tabell för rapporter till delsträckor
create table ReportSubPlace(
reportID int not null,
name varchar(32) not null,
-- Kanske lägga till datum för pågående arbete eller annat?
primary key (reportID, name),
foreign key (reportID) references Report(reportID),
foreign key (name) references SubPlace(name)
)engine=innodb;
-- SHOW engine innodb STATUS;


create table SubPlaceWorkOrder(
name varchar(32) not null,
orderID int not null,
-- Kanske lägga till datum för pågående arbete eller annat?
primary key (orderID, name),
foreign key (orderID) references WorkOrder(orderID),
foreign key (name) references SubPlace(name)
)engine=innodb;

create table ErrorSubPlace(
name varchar(32) not null,
errorID int not null,
-- Kanske lägga till datum för pågående arbete eller annat?
primary key (errorID, name),
foreign key (errorID) references Error(errorID),
foreign key (name) references SubPlace(name)
)engine=innodb;

create table CommentSubPlace(
CommentID int not null,
name varchar(32) not null,
-- Kanske lägga till datum för att ta bort gamla kommentarer?
primary key (commentID, name),
foreign key (commentID) references Comment(commentID),
foreign key (name) references SubPlace(name)
)engine=innodb;




insert into Ski (skiID, password, firstName, lastName, email, number, type, regDate) values
('1','pass','Tomas','Stormhagen','Tomas360@gmail.com','1234567891','arenachef','2016-11-01'),
('2','pass','Göran','Smith','g_smith@gmail.com','1234567892','other','2016-11-01'),
('3','pass','Ove','Svensson','OveSwag@hotmail.com','1234567893','other','2016-11-01');


insert into Ent (entID, password, firstName, lastName, email, number, regDate) values 
('1','pass','Stefan','Fridström','blatjoo@aol.com','1234567891','2016-11-01'),
('2','pass','Adrian','Abrahamsson','rotfs@hotmail.com','1234567892','2016-11-01'),
('3','pass','Philip','Svensson','asd@gmail.com','1234567893','2016-11-01');


insert into Place (name, info) values 
('Vattendrag','Vattendrag som är tillängliga för snötillverkning'),
('Delsträckor','Delsträckor som kan användas under vinterhalvåret'),
('Garage','Garage för pistmaskiner');


insert into WorkOrder (skiID, entID, sentDate, startDate, priority, info) values
('1','1',now(),'2016-11-02','akut','ligger en död uteliggare på spåret'),
('1','2',now(),'2016-11-03','high',''),
('1','3',now(),'2016-11-04','medium','');

/*
insert into Comment (comment, alias, date) values 
('blabla','Stina','2017-12-31'),
('oj vilka spår','göran p','2016-12-24'),
('jävla kottar och grus i spåren','gunde svan','2017-01-01');
*/

insert into SubPlace (name, placeName, entID, length, height, fakesnow) values 
('1','Delsträckor','1','12','21','23'),
('2','Delsträckor','2','17','476','11'),
('3','Delsträckor','3','9','243','0');


insert into Cannon (subPlaceName, model, status, effect) values
('1','STA1','off','9'),
('2','MOV1','off','5'),
('3','MOV2','off','6');


insert into Report (entID, startDate, workDate, rating, underlay, edges, grip, depth) values
('1','2011-11-11','2011-11-11','1','2','3','4','54'),
('1','2011-11-11','2011-11-11','3','3','2','4','65'),
('1','2011-11-11','2011-11-11','2','2','4','3','43');

/*
insert into Error (entID, sentDate, grade, errorDesc, type) values 
('1',now(),'high','fallna träd','trees'),
('1',now(),'akut','grus','dirt'),
('1',now(),'high','fallna träd','trees');
*/

/*
insert into ReportSubPlace(reportID, name) values
('1','3'),
('2','1'),
('2','2');
*/

insert into SubPlaceWorkOrder(name,orderID) values 
('1','1'),
('1','2'),
('1','3');
/*
insert into ErrorSubPlace(name,errorID) values 
('1','1'),
('1','2'),
('1','3');
*/

/*
insert into CommentSubPlace (CommentID, name) values 
('1','1'),
('3','2'),
('3','3');

