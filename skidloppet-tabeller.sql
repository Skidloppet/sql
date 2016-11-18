drop database SlitABSkidloppet;
create database SlitABSkidloppet;
use SlitABSkidloppet;


-- Tabell för inloggningsförsök (anti brute-force)
-- 
create table login_attempts(
userID int(11) not null,
time varchar (30) not null
)engine=innodb;

create table img (
	img_id		int 	not null auto_increment,
    name	varchar (50),
    path	varchar(100),
    -- img			blob	,
    -- img_size 	varchar (25) not null default '',
    primary key (img_id)
)engine=innodb;


-- Tabell för Skidloppet anställda
create table Ski(
skiID smallint not null auto_increment unique,
password varchar(32) not null,
firstName varchar(32) not null,
lastName varchar(32) not null,
email varchar(64) unique,
number int(10) not null unique,
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
email varchar (64) unique,
number int(10) not null unique,
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
sentDate datetime,
-- ändrade från timestamp till datetime pga att det blev fel datum i finnishedworkorder när man flyttade över
endDate timestamp,
priority enum('high','medium','low','akut'),
info varchar(1024),
EntComment varchar(1024),
primary key (orderID),
foreign key (skiID) references Ski(skiID),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- tabell för arbetsorder
create table FinnishedWorkOrder (
orderID int not null unique,
skiID smallint not null,
entID smallint not null,
-- not null här pga den som genomförde arbetet
sentDate datetime,
endDate timestamp,
priority enum('high','medium','low','akut'),
info varchar(1024),
EntComment varchar(1024),
primary key (orderID),
-- foreign key (skiID) references Ski(skiID),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- tabell för kundkommentarer
create table Commenta(
commentID int auto_increment unique,
kommentar varchar(1024) not null,
alias varchar(32) not null,
grade tinyint,
date timestamp,
primary key (commentID)
)engine=innodb;


-- tabell för specifika platser
create table SubPlace (
name smallint not null,
placeName varchar(32) not null,
realName varchar (32) not null,
entID smallint null,
length mediumint,
height smallint,
fakesnow smallint,
-- fakesnow kommer nollställas när en arbetsorder hämtar snö, kommer öka när kanoner har status on * tid * effekt (m2)
primary key (name),
foreign key (placeName) references Place(name),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- cannon är snökanon, model namn avgör om den är stationär
create table Cannon (
cannonID smallint not null auto_increment unique,
subPlaceName smallint,
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
depth DECIMAL(4,1),
comment varchar(1024),
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
stamp timestamp,
name smallint not null,
-- Kanske lägga till datum för pågående arbete eller annat?
primary key (reportID, name),
foreign key (reportID) references Report(reportID),
foreign key (name) references SubPlace(name)
)engine=innodb;
-- SHOW engine innodb STATUS;


create table SubPlaceWorkOrder(
name smallint not null,
orderID int not null,
cannonID smallint,
-- Kanske lägga till datum för pågående arbete eller annat?
primary key (orderID, name),
foreign key (orderID) references WorkOrder(orderID)ON DELETE CASCADE,
foreign key (name) references SubPlace(name)
)engine=innodb;

create table ErrorSubPlace(
name smallint not null,
errorID int not null,
-- Kanske lägga till datum för pågående arbete eller annat?
primary key (errorID, name),
foreign key (errorID) references Error(errorID),
foreign key (name) references SubPlace(name)
)engine=innodb;

create table CommentSubPlace(
CommentID int not null,
name smallint not null,
-- Kanske lägga till datum för att ta bort gamla kommentarer?
primary key (commentID, name),
foreign key (commentID) references Commenta(commentID),
foreign key (name) references SubPlace(name)
)engine=innodb;

-- N:M tabell för N:M förhållande mellan cannon och sträckor så en arbetsorder kan flytta en eller flera snökanoner.
-- TRANSAKTION
create table CannonSubPlace (
orderID int not null auto_increment unique,
cannonID smallint,
name smallint,
entID smallint,
startStamp timestamp,
endStamp timestamp,
newStatus enum('on','off','unplugged','broken'),
info varchar(1024),
comment varchar(1024),
primary key (orderID),
foreign key (cannonID) references Cannon(cannonID),
foreign key (name) references SubPlace(name),
foreign key (entID) references Ent(entID)
)engine=innodb;


create table FinnishedCannonSubPlace (
orderID int not null unique,
cannonID smallint,
name smallint,
entID smallint,
startStamp timestamp,
endStamp timestamp,
newStatus enum('on','off','unplugged','broken'),
info varchar(1024),
comment varchar(1024),
primary key (orderID),
foreign key (cannonID) references Cannon(cannonID),
foreign key (name) references SubPlace(name),
foreign key (entID) references Ent(entID)
)engine=innodb;

insert into Ski (skiID, password, firstName, lastName, email, number, type, regDate) values
('1','pass','Tomas','Stormhagen','tomas','1234567891','arenachef','2016-11-01'),
('2','pass','Göran','Smith','g_smith@gmail.com','1234567892','other','2016-11-01'),
('3','pass','Ove','Svensson','OveSwag@hotmail.com','1234567893','other','2016-11-01');


insert into Ent (entID, password, firstName, lastName, email, number, regDate) values 
('1','pass','Stefan','Fridström','stefan','1234567891','2016-11-01'),
('2','pass','Adrian','Abrahamsson','rotfs@hotmail.com','1234567892','2016-11-01'),
('3','pass','Philip','Svensson','asd@gmail.com','1234567893','2016-11-01');


insert into Place (name, info) values 
('Vattendrag','Vattendrag som är tillängliga för snötillverkning'),
('Delstrackor','Delsträckor som kan användas under vinterhalvåret'),
('Garage','Garage för pistmaskiner');


insert into WorkOrder (skiID, entID, sentDate, endDate, priority, info, EntComment) values 
('1','1',now(),'','akut','ligger en död uteliggare på spåret', 'text1'),
('1','2',now(),'','high','träd som ligger över spåren','text2'),
('1','3',now(),'','medium','grus vid lerdalen','text3'),
('1','2',now(),'','low','sten','text4');

insert into FinnishedWorkOrder (OrderID, entID, sentDate, endDate, priority, info, EntComment) values
('1','1','2016-01-15','','akut','död snubbe på spåret','text1'),
('3','1','2016-01-17','','low','sten','text2');


<<<<<<< HEAD
insert into Commenta (Kommentar,grade, alias, date) values 
('blabla','2','Stina','2017-12-31'),
('oj vilka spår','4','göran p','2016-12-24'),
('jävla kottar och grus i spåren','1','gunde svan','2017-01-01');
=======
insert into Commenta (comment,grade, alias, date) values 
('blabla','4','Stina','2015-12-31'),
('blabla','2','Stina','2016-11-15 14:00:11'),
('blabla','3','Stina','2016-11-15 17:00:11'),
('jävla kottar och grus i spåren','1','gunde svan','2015-01-01');
>>>>>>> e2c67f746b99e5af437152e2f0aa4735f9699d4e

-- select avg(grade) from Comment;
-- select grade from Comment;
insert into SubPlace (name, placeName, realName, entID, length, height, fakesnow) values 
('1','Delstrackor','Hedemora 3:1','1','12','21','23'),
('2','Delstrackor','Hedemora 3:2','2','17','476','11'),
('3','Delstrackor','Hedemora 3:3','3','29','376','3'),
('4','Delstrackor','Hedemora2 3:1','3','12','198','5'),
('5','Delstrackor','Hedemora2 3:2','3','6','264','1'),
('55','Garage','HUVUDGARAGET','1','6','264','1'),
('6','Delstrackor','Hedemora2 3:3','3','22','333','31');


insert into Cannon (subPlaceName, model, status, effect) values
('1','STA1','off','9'),
('2','MOV1','off','5'),
('3','MOV2','off','6');


insert into Report (entID, startDate, workDate, rating, underlay, edges, grip, depth) values
('1','2011-11-11','2011-09-11','1','2','3','4','54'),
('1','2011-11-11','2011-10-11','3','3','2','4','65'),
('1','2011-11-11','2011-12-11','2','2','4','3','43');

insert into CannonSubPlace (CannonID, name, entID, startStamp, endStamp, newStatus, info, comment) values
('1','1','2',now(),now(),'off','text från ski','not finnished'),
('2','1','1',now(),now(),'off','text från ski1','not finnished'),
('3','1','3',now(),now(),'on','text från ski2','not finnished');

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
*/