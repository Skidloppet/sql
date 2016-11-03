Drop database b15patkh;
create database b15patkh;
use b15patkh;
 -- hejdå
create table VapenTillverkare( -- codes exempel 4
Tillverkarkod mediumint,
Tillverkatnamn varchar (25),
primary key(Tillverkarkod)
)engine=innodb;
/*
ersatte tillverkarnamnet på vapnet med en kod som representerar det namnet.
*/
create table Vapen(
IDnr tinyint UNIQUE NOT NULL,
Tillverkarkod mediumint,
Farlighet_Vapen varchar (15),
primary key (IDnr),
foreign key (Tillverkarkod) references VapenTillverkare(Tillverkarkod)
)engine=innodb;

create table VapenKommentar( /*EXEMPEL 6 HORIZONTAL: Skapar en ny tabell för "VAPENKommentar", istället för att ha den i i Vapen så bryter jag ut tabellen och har den enskilt för att den är "stor" och tar mycket plats*/
VapenKommentar Varchar(1028)not null,
IDnr tinyint UNIQUE NOT NULL,
primary key (IDnr),
foreign key (IDnr) references Vapen (IDnr)
)engine=innodb;

create table Skepp(
IDskepp tinyint UNIQUE NOT NULL, -- 
Sittplatser tinyint,
Tillverkningsplanet varchar (10),
SkeppKannetecken varchar (50),
primary key (IDskepp)
)engine=innodb;


create table SkeppKanon(
SkeppKanonId smallint not null auto_increment,
SkeppKanonModell varchar (30),
SkeppID tinyint NOT NULL,
primary key (SkeppKanonId),
foreign key (SkeppID) references Skepp (IDskepp)
)engine=innodb;

drop table SkeppKanon;  /*EXEMPEL 3"MERGAR" Skeppkanon med Skepp. Tar bort tabellen "Skeppkanon men lägger till kolumnen SkeppKanonModell i Skepp för att få tillgång till tabellen Skeppkanon*/

alter table Skepp /*Alter innbeär att jag vill tillägga något*/
ADD(
SkeppKanonModell varchar (30) /*Kolumnen jag vill lägga till från tabellen Skeppkanon till Skepp*/
);

/*Skapar en ny tabell "TRASIGASkepp" Denna tabell visar vilka skepp som är trasiga med hjälp utav "ID"*/
create table TRASIGASkepp( /*EXEMPEL 5 VERTICAL, skapar en "ny" tabell "TRASIGASkepp för att urskilja på trasiga och "normala" skepp. Alla trasiga skepp kommer att visas i denna tabell  */
IDskepp tinyint UNIQUE NOT NULL, -- 
Sittplatser tinyint ,
Tillverkningsplanet varchar (10),
SkeppKannetecken varchar (50),
primary key (IDskepp)
)engine=innodb;

create table Ras( 
Namn varchar (20) NOT NULL,
RasKannetecken varchar (50),
primary key (Namn)
)engine=innodb;

Create table Planet( -- EN RAS KAN BARA HA EN PLANET--
PlanetNamn varchar (15)unique NOT NULL,
Storlek tinyint NOT NULL,
RasNamn varchar(20),
primary key (PlanetNamn),
foreign key (RasNamn) references Ras (Namn)
)engine=innodb;

create table Alien(
IDkod varchar(25) UNIQUE NOT NULL,
Farlighet varchar (15)NOT NULL,
Typ varchar (15)NOT NULL,
RasNamn varchar (10)NOT NULL,
AlienKannetecken varchar(50),
primary key (IDkod),
foreign key (RasNamn) references Ras (Namn)
)engine=innodb;

create table AlienRelation(
IDkod1 varchar(25) UNIQUE NOT NULL,
IDkod2 varchar(25) UNIQUE NOT NULL,
foreign key (IDkod1) references Alien (IDkod),
foreign key (IDkod2) references Alien (IDkod)
)engine=innodb;

create table RegAlien( 
PNR int (12) UNIQUE NOT NULL,-- alltid 12 därför en int (12)
 /* ENDAST REGGADE HAR ETT PNR SOM MOTSVARAR DET SOM DE MÄNNISKOR SOM BOR I SVERIGE HAR 12 siffror (ANKOMSTDATUM +4 sista siffror)*/
namn varchar (20)NOT NULL,
planet varchar (10),
Alien_IDkod varchar(25) UNIQUE NOT NULL,
primary key (PNR),
foreign key (Alien_IDkod) references Alien (IDkod)
)engine=innodb;

create table OregAlien(
IDkod_OregAlien varchar(25) UNIQUE NOT NULL,
namn varchar (20)NOT NULL,
Alien_IDkod varchar(25) UNIQUE NOT NULL,
primary key (IDkod_OregAlien),
foreign key (Alien_IDkod) references Alien (IDkod)
)engine=innodb;

create table Incident(
NamnIncident varchar(15)NOT NULL,
Nr tinyint NOT NULL,
Grad tinyint ,
Plats tinyint ,
primary key (NamnIncident,Nr)
)engine=innodb;

create table Inkopsplats(
Inkopsplats tinyint NOT NULL,
IDskepp tinyint,
primary key (Inkopsplats,IDskepp),
foreign key (IDskepp) references Skepp (IDskepp)
)engine=innodb;

create table Kannetecken_Skepp(
Kannetecken_Skepp varchar(50),
IDskepp tinyint,
primary key (Kannetecken_Skepp,IDskepp),
foreign key (IDskepp) references Skepp (IDskepp)
)engine=innodb;

create table Kannetecken_Alien(
Kannetecken_Alien varchar(50),
IDkod varchar(25) UNIQUE NOT NULL,
primary key (Kannetecken_Alien,IDkod),
foreign key (IDkod) references Alien (IDkod)
)engine=innodb;

create table Kannetecken_Ras(
Kannetecken_Ras varchar(50),
Namn varchar(20),
primary key (Kannetecken_Ras,Namn),
foreign key (Namn) references Ras (Namn)
)engine=innodb;

create table Vapen_Alien(
IDnr tinyint ,
IDkod varchar(25) UNIQUE NOT NULL,
primary key (IDnr,IDkod),
foreign key (IDkod) references Alien (IDkod)
)engine=innodb;

create table Vapen_Skepp(
IDnr tinyint ,
IDskepp tinyint,
primary key (IDnr,IDskepp),
foreign key (IDskepp) references Skepp (IDskepp)
)engine=innodb;

create table Skepp_Alien(
IDskepp tinyint,
IDkod varchar(25) UNIQUE NOT NULL,
primary key (IDskepp,IDkod),
foreign key (IDkod) references Alien (IDkod)
)engine=innodb;

create table Skepp_Incident(
IDskepp_Incident tinyint,
NamnIncident varchar(15),
NrIncident tinyint,
primary key (IDskepp_Incident),
foreign key (NamnIncident,NrIncident) references Incident (NamnIncident,nr)
)engine=innodb;

create table Alien_Incident(
IDkod_Incident varchar(25) UNIQUE NOT NULL,
NamnIncident varchar(15),
NrIncident tinyint,
primary key (IDkod_Incident,NamnIncident,NrIncident),
foreign key (NamnIncident,NrIncident) references Incident (NamnIncident,nr)
)engine=innodb;

/*Alien som är en tabell där sökningar kommer ske ofta och för att göra det enklare/snabbare skapar jag ett index för tabellen*/
CREATE INDEX ALIENINDEX ON Alien(IDkod ASC) USING BTREE;
/* Skapar ett index för Vapen, sökningen sker på primärnyckeln IDnr. Skapar index för satt snabba upp sökningen på vapen för att det kommer sökas ofta på*/
Create INDEX VAPENINDEX ON Vapen(IDnr ASC) USING BTREE;
/*Skapar ett index för Skepp, sökningen sker på primärnyckeln IDskepp. Skapar index för satt snabba upp sökningen på skepp för att det kommer sökas ofta på*/
Create INDEX SKEPPINDEX ON Skepp(IDskepp ASC) USING BTREE;

/*CREATE VIEW STATISTIC, jag vill få ut medelstatistik på farlighet på aliens. EXEMPEL 9*/
Create VIEW ALIENFARLIGHET AS
SELECT AVG (Farlighet) AS AVGFarlighet
From Alien
Group by Alien.IDkod;

drop user 'admin'@'localhost';

Create USER 'admin'@'localhost' IDENTIFIED BY 'mypass';

GRANT SELECT ON b15patkh.Alien TO admin;
GRANT SELECT ON b15patkh.Skepp TO admin;
GRANT SELECT ON b15patkh.Vapen TO admin;

/*CREATE VIEW CHECKCUSTOMER AS SELECT * FROM CUSTOMER WHERE (SSN LIKE '[0-9][0-9][0-9][0-9][0-9][0-9]-[0-9][0-9][0-9][0-9]') WITH CHECK OPTION;
      
GRANT INSERT ON a00leifo.COMPANY TO economysystem;*/


/*-- Create a user for the economy system application
CREATE USER 'economysystem'@'localhost' IDENTIFIED BY 'mypass';
 
-- Gives select access to COMPANY table to the economysystem
GRANT SELECT ON a00leifo.COMPANY TO economysystem;
 
-- Create a view that excludes the password from the result
CREATE VIEW ECONOMYCUSTOMERS AS SELECT CUSTNO,SSN,NAME,REGDATE FROM CUSTOMER;
 
-- Gives select on all parts of customer except for password to economysystem
GRANT SELECT ON a00leifo.ECONOMYCUSTOMERS to economysystem;
 */

Create View CHECKALIEN AS SELECT * FROM Alien WHERE (IDkod LIKE char_length(IDkod)=25) WITH CHECK OPTION; /* CHECK FÖR ATT KOLLA SÅ ATT DET ALLTID ÄR 25 TECKEN*/
Create View CHECKALIENID AS SELECT * FROM Alien Where (IDkod LIKE '[A-Z] [A-Z] [A-Z] [A-Z][A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z] [A-Z]') WITH CHECK OPTION;
/*EN CHECK SKAPAS FÖR IDKOD, 25 BOXAR SOM REPRESENTERAR VARJE TECKEN I ID-KODEN*/
 
insert into Ras(Namn,RasKannetecken) values ('svart','socker');
insert into Ras(Namn,RasKannetecken) values ('rosa','salt');
insert into Ras(Namn,RasKannetecken) values ('brun','tranar');
insert into Ras(Namn,RasKannetecken) values ('grön',NULL);
insert into Ras(Namn,RasKannetecken) values ('gul',NULL);



/*create table Ras( 
Namn varchar (20) NOT NULL,
RasKannetecken varchar (50),
primary key (Namn)
)engine=innodb;*/

Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAANABBBBBTTTTTRRRRRWWWWW",'Harmlös','ful','svart','socker');
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("BAAVABBBBBTTTTTRRRRRWWWWW",'Ofarlig','gullig','rosa','salt');
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAACABBBBBTTTTTRRRRRWWWVW",'Neutral','snygg','brun','tranar');
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAABABBBBBTTTTTRRRRRTWWWW",'Ofarlig','ful','grön',NULL);
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAAVABBBBBTTTTTRRRRRWWWWT",'','ultraful','svart',NULL);
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAAEABBBBBTTTTTRTCRRWWWWT",'','ultraful','svart',NULL);
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAAWABBBBBTTTTTRRTRRWWWWT",'','ultraful','svart',NULL);
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAARABBBBBTTTTTRRPRRWWWWT",'','ultraful','svart',NULL);
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAAGABBBBBTTTTTRRQRRWWWWT",'','ultraful','svart',NULL);
Insert into Alien(IDkod,Farlighet,Typ,Rasnamn,AlienKannetecken) values ("AAAHABBBBBTTTTTRRYRRWWWWT",'','ultraful','svart',NULL);




/*create table Alien(
IDkod tinyint (10) UNIQUE NOT NULL,
Farlighet varchar (15)NOT NULL,
Typ varchar (15)NOT NULL,
RasNamn varchar (10)NOT NULL,
AlienKannetecken varchar(50),
primary key (IDkod),
foreign key (RasNamn) references Ras (Namn)
)engine=innodb;*/
