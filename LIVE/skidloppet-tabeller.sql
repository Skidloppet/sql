drop database SlitABSkidloppet;
create database SlitABSkidloppet CHARACTER SET utf8 COLLATE utf8_unicode_ci;
use SlitABSkidloppet;


-- Tabell för Skidloppet anställda
create table Ski(
skiID smallint not null auto_increment unique,
password varchar(32) not null,
firstName varchar(32) not null,
lastName varchar(32) not null,
email varchar(64) unique,
number varchar(13) not null unique,
type ENUM('arenachef','other'),
regDate datetime,
primary key (skiID)
)engine=innodb;


-- Tabell för Entrepenörer 
create table Ent (
entID smallint not null auto_increment unique, 
password varchar(32)not null,
firstName varchar(32)not null,
lastName varchar(32) not null,
email varchar (64) unique,
number varchar(13) not null unique,
regDate datetime,
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
priority enum('Låg','Medium','Hög','Akut'),
type enum('Ljus','Bana','Skräp','Träd','Annat') null,
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
priority enum('Låg','Medium','Hög','Akut'),
type enum('Ljus','Bana','Skräp','Träd','Annat') null,
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
del tinyint(1)default'0',
primary key (commentID)
)engine=innodb;


-- tabell för kundkommentarer
create table OldCommenta(
commentID int auto_increment,
kommentar varchar(1024) not null,
alias varchar(32) not null,
grade tinyint,
date timestamp,
del tinyint(1)default'0',
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
primary key (name),
foreign key (placeName) references Place(name),
foreign key (entID) references Ent(entID)
)engine=innodb;


-- cannon är snökanon, model namn avgör om den är stationär
create table Cannon (
cannonID smallint not null auto_increment unique,
subPlaceName varchar(32) null,
model char (3) not null, 
state enum('På','Av','Urkopplad','Trasig', 'Annat') null,
effect DECIMAL(4,3), -- producerar ca: 1.226 m3/minut ()(fasta), flyttbara producerar ca: 0.5 m3 /mint
klass varchar(32) not null, 
-- effect och status tillsammans med N:M tabellens timestamp skall visa antal m2 snö tillverkat.
primary key (cannonID)
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
-- grade enum('Låg','Medium','Hög','Akut'),
errorDesc varchar(1024),
type enum('Ljus','Bana','Skräp','Träd','Annat') null,
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

-- N:M arbetsorder - delsträckor
create table SubPlaceWorkOrder(
name smallint not null,
orderID int not null,
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
primary key (commentID, name),
foreign key (commentID) references Commenta(commentID)ON UPDATE CASCADE ON DELETE CASCADE,
foreign key (name) references SubPlace(name)
)engine=innodb;

create table OldCommentSubPlace(
CommentID int not null,
name smallint not null,
primary key (commentID, name),
foreign key (commentID) references OldCommenta(commentID)ON UPDATE CASCADE ON DELETE CASCADE,
foreign key (name) references SubPlace(name)
)engine=innodb;

-- N:M tabell för N:M förhållande mellan cannon och sträckor så en arbetsorder kan flytta en eller flera snökanoner.


create table CannonSubPlace (
orderID int not null auto_increment unique,
cannonID smallint,
name smallint,
skiID smallint,
entID smallint,
startStamp datetime,
endStamp datetime,
priority enum('Låg','Medium','Hög','Akut'),
newStatus enum('På','Av','Urkopplad','Trasig', 'Annat'),
info varchar(1024),
comment varchar(1024),
primary key (orderID),
foreign key (cannonID) references Cannon(cannonID)on delete cascade,
foreign key (name) references SubPlace(name)on delete cascade,
foreign key (skiID) references Ski(SkiID),
foreign key (entID) references Ent(entID)
)engine=innodb;


create table FinnishedCannonSubPlace (
orderID int not null auto_increment unique,
cannonID smallint,
name smallint,
skiID smallint,
entID smallint,
startStamp datetime,
endStamp datetime,
priority enum('Låg','Medium','Hög','Akut'),
newStatus enum('På','Av','Urkopplad','Trasig', 'Annat'),
info varchar(1024),
comment varchar(1024),
primary key (orderID),
foreign key (cannonID) references Cannon(cannonID),
foreign key (name) references SubPlace(name),
foreign key (entID) references Ent(entID)
)engine=innodb;

create table StoredReports(
storedReportID int not null auto_increment unique,
reportID int not null,
entID smallint not null,
startDate timestamp,
workDate datetime,
rating enum('1','2','3','4','5'),
underlay enum('1','2','3','4','5'),
edges enum('1','2','3','4','5'),
grip enum('1','2','3','4','5'),
depth DECIMAL(4,1),
comment varchar(1024),
name smallint,
primary key (storedReportID)
)engine=innodb;

insert into Ski (password, firstName, lastName, email, number, type, regDate) values
('pass','Tomas','Karlsson','Tomas.Karlsson@skidloppet.se','1234567891','arenachef','2016-11-01'),
('pass','Peo','Swahn','Peo.Swahn@skidloppet.se','1234567892','other','2016-11-01'),
('pass','Agne','Bowall','Agne.Bowall@skidloppet.se','1234562293','other','2016-11-01'),
('pass','Anna','Holm','Anna.Holm@skidloppet.se','1234522293','other','2016-11-01'),
('pass','Rune','Lund','Rune.Lund@skidloppet.se','04040404','arenachef','2016-11-01');

insert into Ent (password, firstName, lastName, email, number, regDate) values 
('pass','Global Användare','','ent','0205624321','2016-11-05'),
('sture','Sture','Ekman','Sture.Ekman@skidloppet.se','0046704719082','2016-11-01'),
('andersson','Bröderna','Andersson','Bröderna.Andersson@skidloppet.se','0046707966871','2016-11-01'),
('persson','Siv-Jan','Persson','SoJ.Persson@skidloppet.se','0046733504750','2016-11-01'),
('jonas','Jonas','Hed','Jonas.Hed@skidloppet.se','0046709960720','2016-11-01'),
('oswald','Oswald','Ek','Oswald.Ek@skidloppet.se','0046738733122','2016-11-01'),
('rune','Rune','Kvarn','Rune.Kvarn@skidloppet.se','0046703713943','2016-11-01'),
('iris','Iris','Sax','Iris.Sax@skidloppet.se','00545454','2016-11-01'),
('vidar','Vidar','Ytter','Vidar.Ytter@skidloppet.se','00551232','2016-11-01'),
('urban','Urban','Garv','Urban.Garv@skidloppet.se','0057131323','2016-11-01');


/* Sture Ekman, delsträckor 1, 2
Bröderna Andersson delsträckor 3, 4
Siv och Jan Persson delsträckor 5, 6, 7
Jonas Hed delsträckor 8, 9, 10
Oswald Ek delsträckor 11, 12
Rune Kvarn delsträckor 13, 14, 15
Iris Sax delsträckor 16, 17
Vidar Ytter delsträckor 18, 19
Urban Garv delsträckor 20, 21 */

insert into Place (name, info) values 
('Vattendrag','Vattendrag som är tillängliga för snötillverkning'),
('Delstrackor','Delsträckor som kan användas under vinterhalvåret'),
('Garage','Garage för pistmaskiner');



insert into WorkOrder (skiID, entID, sentDate, endDate, priority, info, EntComment,type) values 
('1','1',now(),'','Akut','ligger en död kanin på spåret', 'text1','dirt'),
('1','2',now(),'','Hög','träd som ligger över spåren','text2','dirt'),
('1','3',now(),'','Medium','grus vid lerdalen','text3','dirt'),
('1','2',now(),'','Låg','sten','text4','dirt'); 
/*
insert into FinnishedWorkOrder (OrderID, entID, sentDate, endDate, priority, info, EntComment) values
('1','1','2016-01-15','','akut','död snubbe på spåret','text1'),
('3','1','2016-01-17','','low','sten','text2');

insert into Commenta (Kommentar,grade, alias, date) values 
('Arenan bjöd på en mycket bra upplevelse med bra spår','5','Alexander Gustafsson','2016-11-11'),
('Delsträckorna 2:1 och 2:2 i Norrhyttan var väldigt dåligt spårad','1','Khabib Nurmanogedov','2016-01-24'),
('Bra spårade sträckor i Hedemora','4','Jon Jones','2017-03-01'),
('Trevlig upplevelse och bra spårning','5','Nate Diaz','2017-02-01'),
('Det ligger mycket skräp på delsträckan 3.1 i Bondhyttan','2','Connor McGregor','2017-01-01');
*/
-- select avg(grade) from Comment;
-- select grade from Comment;
-- select * from Ent;
insert into SubPlace (name, placeName, realName, entID, length, height, fakesnow) values 
('1','Delstrackor','Hedemora 1:1','1','12','21','23'),
('2','Delstrackor','Hedemora 1:2','1','17','476','11'),
('3','Delstrackor','Hedemora 1:3','1','29','376','3'),
('4','Delstrackor','Norrhyttan 2:1','2','12','198','5'),
('5','Delstrackor','Norrhyttan 2:2','2','6','264','1'),
('6','Delstrackor','Norrhyttan 2:3','2','22','333','31'),
('7','Delstrackor','Norrhyttan 2:4','2','22','333','31'),
('8','Delstrackor','Bondhyttan 3:1','3','22','333','31'),
('9','Delstrackor','Bondhyttan 3:2','3','22','333','31'),
('10','Delstrackor','Bondhyttan 3:3','3','22','333','31'),
('11','Delstrackor','Bommansbo 4:1','1','22','333','31'),
('12','Delstrackor','Bommansbo 4:2','1','22','333','31'),
('13','Delstrackor','Bommansbo 4:3','1','22','333','31'),
('14','Delstrackor','Bommansbo 4:4','1','22','333','31'),
('15','Delstrackor','Smedjebacken 5:1','2','22','333','31'),
('16','Delstrackor','Smedjebacken 5:2','2','22','333','31'),
('17','Delstrackor','Smedjebacken 5:3','2','22','333','31'),
('18','Delstrackor','Björsjö 6:1','3','22','333','31'),
('19','Delstrackor','Björsjö 6:2','3','22','333','31'),
('20','Delstrackor','Björsjö 6:3','3','22','333','31'),
('21','Delstrackor','Björsjö 6:4','3','22','333','31'),
('55','Garage','HUVUDGARAGET','1','6','264','1');

-- select * from Cannon;
insert into Cannon (subPlaceName, model, state, effect,klass) values
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'), 
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','STA','Av','1.226','SMI Super PoleCat'),
('HUVUDGARAGET','MOV','Av','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Av','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Av','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7'),
('HUVUDGARAGET','MOV','Urkopplad','0.5','Top Gun 7');


insert into Report (entID, startDate, workDate, rating, underlay, edges, grip, depth) values
('1','2011-11-11','2011-09-11','1','2','3','4','54'),
('1','2011-11-11','2011-10-11','3','3','2','4','65'),
('1','2011-11-11','2011-12-11','2','2','4','3','43');

insert into CannonSubPlace (CannonID, name, entID, startStamp, endStamp, newStatus, info, comment) values
('1','1','2',now(),now(),'Urkopplad','text från ski','not finnished'),
('2','1','1',now(),now(),'Urkopplad','text från ski1','not finnished'),
('3','1','3',now(),now(),'På','text från ski2','not finnished');


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





