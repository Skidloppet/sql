/*
PROCEDURER FÖR SKIDLOPPET AB -Innehållsförteckning
1. procedur CreateEnt
2. procedur CreateSki
3. procedur för att göra en SKI till arenachef/other
4. procedur för kontroll av inlogg
5. procedur för ny snökanon
6. procedur för att flytta/status snökanon
7. procedure för Rapportering
8. procedure för nya kommentarer
9. procedur för nya felanmälan
10. procedur för att lägg till ny arbetsorder
11. procedur för avklarad arbetsorder


Kvar att göra:
- implementera SMS för akut arbetsorder (10._newWorkOrder & NyArbetsOrder.php).
-  redigera 7. _NewReport så den fungerar för kund
- ändra .11 _finnishedWorkOrder så man även kan automatiskt flytta/ändra sttus på snkökanoner (om det var arbetsordern)
- ny procedur för att acceptera skut order (ändra ansvar till den entID som accepterar)
- procedurer för notiser till ENT & SKI
- procedur för att ta bort arbetsorder
- procedur för att ta bort arbetsorder(val för borttagning eller loggning(genomförd))
- procedur för automatiskt borttagning av kommentarer 48h
- procedur för att beställa snö (ex. flytta kanon & ha den igång x timmar?)
- procedur för att sätta en tävlingsarbetsorder (arbetsorder som berör allt?!) LÅG PRIO

ändra procedure N:M så den räknar ner vid baklänges åkning

*/



-- 1. Procedure för att skapa en Entrepenör
-- IF satsen kollar om Ski har tagit email adressen redan
DROP PROCEDURE IF EXISTS CreateEnt;
DELIMITER //
CREATE PROCEDURE CreateEnt(pass varchar(32), firstName varchar(32), lastName varchar(32), email varchar (64), number int(10))
BEGIN
    DECLARE encryptedpassword VARCHAR(32);
    set encryptedpassword=LEFT(PASSWORD(pass),32); -- krypterar lösenorder
    INSERT INTO Ent(password, firstName, lastName, email, number, regDate) VALUES (encryptedpassword, firstName, lastName, email, number, NOW());
IF exists(select email from Ski where Ski.email=email)>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This email is already taken by Skidloppet';
        end if;    
END;
// 
DELIMITER ;
-- call CreateEnt ('pass','lasse','berghagen','lasseBH@gmail.com','0704728934');
-- call CreateEnt ('pass','lasse','berghagen','OveSwag@hotmail.com','0704728934');

 
 -- 2. Procedure för att skapa en Skidloppet användare
 -- IF satsen kollar om Ent har tagit email adressen redan
DROP PROCEDURE IF EXISTS CreateSki;
DELIMITER //
CREATE PROCEDURE CreateSki(pass varchar(32), firstName varchar(32), lastName varchar(32), email varchar (64), number int(10), type enum('arenachef','other'))
BEGIN
    DECLARE encryptedpassword VARCHAR(32);
    set encryptedpassword=LEFT(PASSWORD(pass),32);
    INSERT INTO Ski(password, firstName, lastName, email, number, type, regDate) VALUES (encryptedpassword, firstName, lastName, email, number,type, NOW());
    IF exists(select email from Ent where Ent.email=email)>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This email is already taken by Entrepenör';
        end if;    
END;
// 
DELIMITER ;
-- call CreateSki ('pass','Stefan','Holm','StaffeOG@hotmail.com','0732728934','other');
-- call CreateSki ('pass','Stefan','Holm','lasseBH@gmail.com','0732738934','other');


-- 3. procedur för att göra en SKI till arenachef/other
 -- IF satsen kollar om Ent har tagit email adressen redan
DROP PROCEDURE IF EXISTS EditSki;
DELIMITER //
CREATE PROCEDURE EditSki(editSkiID smallint , newType enum('arenachef','other'))
BEGIN
  UPDATE Ski SET type=newType WHERE skiID=editSkiID;
END;
// 
DELIMITER ;
-- call CreateSki ('pass','Stefan','Holm','StaffeOG@hotmail.com','0732728934','other');
-- call EditSki ('4','arenachef');
-- select * from Ski;

-- 4. Procedur för att logga in.
DROP PROCEDURE IF EXISTS CheckLogin; 
 DELIMITER //
CREATE PROCEDURE CheckLogin(CheckEmail varchar(32),CheckPass VARCHAR(32))
BEGIN
    DECLARE encryptedpassword VARCHAR(32);
    set encryptedpassword=LEFT(PASSWORD(CheckPass),32);
    IF((SELECT COUNT(*) FROM AllUsers WHERE email=CheckEmail and password=encryptedpassword)>0) THEN
        SELECT 'OK' as RESULT;
    END IF;
END; //
DELIMITER ;
-- Call CheckLogin ('lasseBH@gmail.com','pass');


-- 5. Procedur för att skapa en ny snökanon
DROP PROCEDURE IF EXISTS NewCannon; 
 DELIMITER //
CREATE PROCEDURE NewCannon(subPlaceName varchar(32), model char(4), status enum('on','off','unplugged','broken'),effect smallint)
BEGIN
insert into Cannon (subPlaceName, model, status, effect) values (subPlaceName, model, status, effect);
END; //
DELIMITER ;
-- call NewCannon('11','MO11','off','12');
-- select * from Cannon;


-- fungerar ej
-- 6. Procedur för att flytta snökanoner
DROP PROCEDURE IF EXISTS AlterCannon; 
 DELIMITER //
CREATE PROCEDURE AlterCannon (CannonID smallint,subPlaceName varchar(32), status enum('on','off','unplugged','broken'))
BEGIN
update Cannon
set Cannon.subPlaceName = subPlaceName and Cannon.status = status
where Cannon.CannonID = CannonID;
END; //
DELIMITER ;

-- Call AlterCannon ('1','11','on');
-- select * from Cannon;

-- 7. Procedure för nya daglig rapportering
DROP PROCEDURE IF EXISTS _newReport;

DELIMITER //
CREATE PROCEDURE _newReport (
newEntID smallint,
newStartDate timestamp,
newWorkDate datetime,
newRating enum('1','2','3','4','5'),
newUnderlay enum('1','2','3','4','5'),
newEdges enum('1','2','3','4','5'),
newGrip enum('1','2','3','4','5'),
newDepth DECIMAL(4,1),
startName tinyint,
endName tinyint
)
BEGIN
DECLARE LastInsert int;
DECLARE nameCounter tinyint;
DECLARE switch tinyint;
DECLARE switch2 tinyint;


START TRANSACTION;

-- kontrollerar om startName har det lägre värdet 
if startName>endName then
set switch = startName;
set switch2 = endName;
set endName = switch;
set startName = switch2;
end if;

INSERT INTO Report (entID, startDate, workDate, rating, underlay, edges, grip, depth)
values (newEntID, newStartDate, newWorkDate, newRating, newUnderlay, newEdges, newGrip, newDepth);
-- tilldelar LastInsert reportID's auto_increment värde för kopplingen i N:M tabellen
SET LastInsert = last_insert_id();

SET nameCounter = startName;

--     for ($i=0;$i<$numRecs;$i++) {       <-- alternativ lösning (ev. bättre & snyggare)
WHILE nameCounter<=endName DO

	insert into ReportSubPlace(name, reportID) values (nameCounter, LastInsert);
	set nameCounter = nameCounter + 1;

	END WHILE;
COMMIT ;
END //
DELIMITER ;
/*
call _newReport (2, now(), '2016-10-12', '3', '2', '1', '1', 23.1, 1,3);
call _newReport (1, now(), '2016-10-12', '2', '4', '4', '4', 23.1, 5,5);
call _newReport (2, now(), '2016-10-13', '3', '2', '1', '1', 23.1, 1,1);
-- select * from ReportSubPlace;
call _newReport (1, now(), '2016-10-14', '1', '4', '4', '4', 23.1, 4,6);
call _newReport (1, now(), '2016-10-14', '4', '4', '4', '4', 23.1, 2,1);
*/

-- 8. Procedure för nya kommentarer
DROP PROCEDURE IF EXISTS _NewComment;

DELIMITER //
CREATE PROCEDURE _NewComment (
newComment varchar(1024),
newAlias varchar (32),
newGrade tinyint,
newDate timestamp,
startName tinyint,
endName tinyint
)
BEGIN

DECLARE LastInsert int;
DECLARE nameCounter tinyint;
DECLARE switch tinyint;
DECLARE switch2 tinyint;

START TRANSACTION;

if startName>endName then
set switch = startName;
set switch2 = endName;
set endName = switch;
set startName = switch2;
end if;

INSERT INTO Comment (comment, grade, alias, date) values (newComment, newGrade, newAlias, newDate);

set LastInsert = last_insert_id();

SET nameCounter = startName;
-- gör en if sats som kollar om det första värdet är större, därefter gör 2 whileloopar där ena adderar och andra subtraherar
WHILE nameCounter<=endName DO

	insert into CommentSubPlace(name, commentID) values (nameCounter, LastInsert);
	set nameCounter = nameCounter + 1;

	END WHILE;
COMMIT ;
END //
DELIMITER ;

-- call _NewComment ('en kommentar på några spår','kalle','2',now(),'3','1');
-- call _NewComment ('NY comment, bögjävel!','rasselasse',now(),'1','2');
-- select * from CommentSubPlace;



-- 9. Procedure för nya felanmälan
DROP PROCEDURE IF EXISTS _NewError;

DELIMITER //
CREATE PROCEDURE _NewError (
newErrorDesc varchar(1024),
newEntID smallint,
newSentDate timestamp,
newGrade enum('low','medium','high','akut'),
newType enum('lights','tracks','dirt','trees','other'),
startName tinyint,
endName tinyint
)
BEGIN

DECLARE LastInsert int;
DECLARE nameCounter tinyint;
DECLARE switch tinyint;
DECLARE switch2 tinyint;

START TRANSACTION;

if startName>endName then
set switch = startName;
set switch2 = endName;
set endName = switch;
set startName = switch2;
end if;

INSERT INTO Error (entID, sentDate , grade, errorDesc , type) values (newEntID, newSentDate, newGrade, newErrorDesc, newType);

SET LastInsert = last_insert_id();
SET nameCounter = startName;

WHILE nameCounter<=endName DO

	insert into ErrorSubPlace(name, errorID) values (nameCounter, LastInsert);
	set nameCounter = nameCounter + 1;

	END WHILE;
COMMIT ;
END //
DELIMITER ;

-- call _NewError ('mörkt överallt','1',now(),'low','lights','1','3');
-- call _NewError ('träd över spåret','2',now(),'low','trees','3','1');
-- select * from ErrorSubPlace;





-- 10. Lägg till ny arbetsorder

DROP PROCEDURE IF EXISTS _newWorkOrder;
DELIMITER //
CREATE PROCEDURE _newWorkOrder ( -- skiID, entID, sentDate, startDate, priority, info, startName, endName
-- newSkiID och newEntID skall vara user() sedan.
newSkiID smallint,
newEntID smallint,
-- (entID) Kan inte tilldelas till en specifik entreprenör vid akut prio.
newSentDate timestamp,
-- newStartDate timestamp,
newPriority enum('high','medium','low','akut'),
newInfo varchar(1024),
startName tinyint,
endName tinyint
-- lägga till cannon...?!
)
BEGIN
DECLARE LastInsert int;
DECLARE nameCounter tinyint;
DECLARE switch tinyint;
DECLARE switch2 tinyint;


START TRANSACTION;

-- kontrollerar om startName har det lägre värdet 
if startName>endName then
set switch = startName;
set switch2 = endName;
set endName = switch;
set startName = switch2;
end if;

INSERT INTO WorkOrder (skiID, entID, sentDate, priority, info)
values (newSkiID, newEntID, newSentDate, newPriority, newInfo);
-- tilldelar LastInsert reportID's auto_increment värde för kopplingen i N:M tabellen
SET LastInsert = last_insert_id();

SET nameCounter = startName;

--     for ($i=0;$i<$numRecs;$i++) {       <-- alternativ lösning (ev. bättre & snyggare)
WHILE nameCounter<=endName DO

	insert into SubPlaceWorkOrder(name, orderID) values (nameCounter, LastInsert);
	set nameCounter = nameCounter + 1;

	END WHILE;
COMMIT ;
END //
DELIMITER ;

-- skiID, entID, sentDate, startDate, priority, info, startName, endName
-- CALL _newWorkOrder (1, 2, now(), 'low', 'KOTTAR ÖVERALLT RÄDDA MIG', 1, 3);
-- select * from WorkOrdersAndPlaces;
-- Select * From Reporting;
-- SELECT * FROM SubPlace where name<"21" ORDER BY name;
-- SELECT * FROM Comment;


-- 11. skapa färdig arbetsorder (logg)

-- problem med att få proceduren nedan att fungera, prövat flera lösningsalternativ utan resultat. hjälp sökes
DROP PROCEDURE IF EXISTS _finnishedWorkOrder;
DELIMITER //
CREATE PROCEDURE _finnishedWorkOrder (finnishedOrderID int,finnishedEntID smallint, finnishedDate timestamp, finnishedComment varchar(1024))

begin
   insert into FinnishedWorkOrder (orderID, entID, endDate, EntComment) values (finnishedOrderID, finnishedEntID, finnishedDate, finnishedComment);
   /*update FinnishedWorkOrder 
   set skiID = WorkOrder.skiID, sentDate = WorkOrder.sentDate, prio = WorkOrder.priority, info = WorkOrder.info
   from WorkDate
   where FinnishedWorkOrder.orderID = WorkOrder.orderID;
   */DELETE FROM WorkOrder where orderID=finnishedOrderID;
   COMMIT ;
END //
DELIMITER ;

-- call _finnishedWorkOrder('1','1',now(),'text');
-- select * from WorkOrder;
-- select * from FinnishedWorkOrder;



-- 12. Procedure för nya felanmälan
DROP PROCEDURE IF EXISTS _newCannonOrder;

DELIMITER //
CREATE PROCEDURE _newCannonOrder (
cannonID smallint,
name smallint,
entID smallint,
newStatus enum('on','off','unplugged','broken'))
BEGIN

INSERT INTO CannonSubPlace (cannonID, name, entID, newStatus) values (cannonID, name, entID, newStatus);

COMMIT ;
END //
DELIMITER ;

-- call _newCannonOrder ('1','2','1','on');
-- select * from CannonSubPlace;


-- call _NewError ('mörkt överallt','1',now(),'low','lights','1','3');
-- call _NewError ('träd över spåret','2',now(),'low','trees','3','1');
-- select * from ErrorSubPlace;





