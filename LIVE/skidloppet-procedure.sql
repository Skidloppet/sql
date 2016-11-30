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
12. Procedure för nya cannon arbetsordrar
13. procedur för att ta bort arbetsorder
14. skapa färdig CANNONorder (logg)
15. Ta bort gammla kund kommentarer
16. för att ändra tel-nummer för en ent.
Kvar att göra:
 
procedur & php för avklarade workorder
procedur & php för avklarade snökanon-workorder


- implementera SMS för akut arbetsorder (10._newWorkOrder & NyArbetsOrder.php).
- bilder för Report(daligt underhåll samt alternativt kundkommentar, ent, ski bilder?)
- ny procedur för att acceptera akut order (ändra ansvar till den entID som accepterar)
- procedur för att ta bort arbetsorder(val för borttagning eller loggning(genomförd))
- procedur för automatiskt borttagning av kommentarer 48h
- procedur för att beställa snö (ex. flytta kanon & ha den igång x timmar?)
- procedur för att sätta en tävlingsarbetsorder (arbetsorder som berör allt?!) LÅG PRIO
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
CREATE PROCEDURE NewCannon(subPlaceName varchar(32), model char(3), state enum('on','off','unplugged','broken'),effect smallint)
BEGIN
insert into Cannon (subPlaceName, model, state, effect) values (subPlaceName, model, state, effect);
END; //
DELIMITER ;
-- call NewCannon('11','MO11','off','12');
-- select * from Cannon;


-- fungerar ej
-- 6. Procedur för att ändra snökanoner
DROP PROCEDURE IF EXISTS AlterCannon; 
 DELIMITER //
CREATE PROCEDURE AlterCannon (cannonID smallint,subPlaceName smallint, state enum('on','off','unplugged','broken'))
BEGIN
-- insert into Cannon(cannonID,subPlaceName, status) values (cannonID, subPlaceName, status);

update Cannon
set Cannon.subPlaceName = subPlaceName 
where Cannon.cannonID = cannonID;
update Cannon
set Cannon.state = state 
where Cannon.cannonID = cannonID;
END; //
DELIMITER ;
Call AlterCannon ('1','2','off');
-- select * from Cannon;
-- select * from SubPlace;
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
newComment varchar (1024),
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

INSERT INTO Report (entID, startDate, workDate, rating, underlay, edges, grip, depth, comment)
values (newEntID, newStartDate, newWorkDate, newRating, newUnderlay, newEdges, newGrip, newDepth, newComment);
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

-- call _newReport (3, now(), '2016-11-12', '5', '5', '5', '5', 23.1, 'lade till kommentar bild snart?', 1, 6);
-- call _newReport (3, now(), '2016-10-13', '2', '4', '4', '4', 23.1, 5,5);
call _newReport (3, now(), '2016-10-13', '3', '4', '4', '4', 23.1, 'beep',1,21);
call _newReport (3, now(), '2016-11-12', '5', '5', '5', '5', 23.1, 'lade till kommentar bild snart?', 1, 6);

-- select * from ReportSubPlace;


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

INSERT INTO Commenta (Kommentar, grade, alias, date) values (newComment, newGrade, newAlias, newDate);

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

call _NewComment ('Härlig Upplevelse','Connor McGregor','2',now(),'2','5');
call _NewComment ('Hej','Lars','2',now(),'6','1');
call _NewComment ('en kommentar på några spår','Klas','2',now(),'1','6');
call _NewComment ('korar','Kalle','2',now(),'2','5');
call _NewComment ('sånt kul','Olof','2',now(),'6','1');
call _NewComment ('kottar','Jon Jones','2',now(),'1','6');
-- select * from CommentSubPlace;
-- select * from Commenta;



-- 9. Procedure för nya felanmälan

DROP PROCEDURE IF EXISTS _NewError;

DELIMITER //
CREATE PROCEDURE _NewError (
newErrorDesc varchar(1024),
newEntID smallint,
newSentDate timestamp,
-- newGrade enum('low','medium','high','akut'),
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

INSERT INTO Error (entID, sentDate , errorDesc , type) values (newEntID, newSentDate, newErrorDesc, newType);

SET LastInsert = last_insert_id();
SET nameCounter = startName;

WHILE nameCounter<=endName DO

	insert into ErrorSubPlace(name, errorID) values (nameCounter, LastInsert);
	set nameCounter = nameCounter + 1;

	END WHILE;
    
COMMIT ;
END //
DELIMITER ;

call _NewError ('mörkt överallt','1',now(),'lights','1','3');
call _NewError ('träd över spåret','2',now(),'trees','3','1');
-- select * from ErrorSubPlace;



-- 10. Lägg till ny arbetsorder

DROP PROCEDURE IF EXISTS _newSplitWorkOrder;
DELIMITER //
CREATE PROCEDURE _newSplitWorkOrder ( -- skiID, entID, sentDate, startDate, priority, info, startName, endName
-- newSkiID och newEntID skall vara user() sedan.
newSkiID smallint,
newEntID smallint,
-- (entID) Kan inte tilldelas till en specifik entreprenör vid akut prio.
newSentDate timestamp,
-- newStartDate timestamp,
newPriority enum('high','medium','low','akut'),
newType enum('lights','tracks','dirt','trees','other'),
newInfo varchar(1024),
newSplit bool,
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

-- sätter nameCounter som den första sträckan 
SET nameCounter = startName;
-- kollar om arbetsordern skall uppdelas för de som har ansvarsområde för del-sträckorna
if newSplit = 1 then

-- while loop eftersom det blir flera arbetsordrar.. (delar upp arbetsordern på delsträckornas ansvarsområde)
	WHILE nameCounter<=endName DO
-- eid är entrepenörens id från delsträckan som = nameCounter
        -- skapar en arbetsorder för varje delsträcka
		INSERT INTO WorkOrder (skiID, entID, sentDate, priority,type, info, EntComment)
		values (newSkiID, newEntID, now(), newPriority,newType, newInfo, "BAJS finnished/accepted(emergency) yet");
        		SET LastInsert = last_insert_id();

        		update WorkOrder
			set entID = (select entID from SubPlace where name = nameCounter) 
            where WorkOrder.orderID = LastInsert;
-- tilldelar LastInsert reportID's auto_increment värde för kopplingen i N:M tabellen
		insert into SubPlaceWorkOrder(name, orderID) values (nameCounter, LastInsert);
		set nameCounter = nameCounter + 1;
		END WHILE;
	else
    
-- skapar bara en arbetsorder för alla delsträckor. (INGEN SPLIT!)
		INSERT INTO WorkOrder (skiID, entID, sentDate, priority, type, info, EntComment)
		values (newSkiID, newEntID, now(), newPriority,newType, newInfo, "not finnished/accepted(emergency) yet");
-- tilldelar LastInsert reportID's auto_increment värde för kopplingen i N:M tabellen
		SET LastInsert = last_insert_id();
--     for ($i=0;$i<$numRecs;$i++) {       <-- alternativ lösning (ev. bättre & snyggare)
		WHILE nameCounter<=endName DO
			insert into SubPlaceWorkOrder(name, orderID) values (nameCounter, LastInsert);
			set nameCounter = nameCounter + 1;
			END WHILE;
		end if;
COMMIT ;
END //
DELIMITER ;
/*
call _newSplitWorkOrder ('1','1',now(),'high','tracks','spåra spåren','1','1','6');
call _newSplitWorkOrder ('1','1',now(),'high','trees','träda träden','0','1','6');
select * from SubPlaceWorkOrder;
select * from WorkOrder;
*/



-- 11. skapa färdig arbetsorder (logg)

-- problem med att få proceduren nedan att fungera, prövat flera lösningsalternativ utan resultat. hjälp sökes
DROP PROCEDURE IF EXISTS _finnishedWorkOrder;
DELIMITER //
CREATE PROCEDURE _finnishedWorkOrder (
finnishedOrderID int,
finnishedEntID smallint, 
finnishedDate timestamp, 
finnishedComment varchar(1024))

begin

  INSERT INTO FinnishedWorkOrder
  SELECT * FROM WorkOrder where WorkOrder.orderID = finnishedOrderID;
   
   update FinnishedWorkOrder
    set 
     entID = finnishedEntID,
     endDate = finnishedDate,
     EntComment = finnishedComment
      where
       orderID = finnishedOrderID;
     

   DELETE FROM WorkOrder where orderID=finnishedOrderID;
   COMMIT ;
END //
DELIMITER ;
-- call _finnishedWorkOrder('2','3',now(),'text');
-- select * from WorkOrder;
-- select * from FinnishedWorkOrder;


-- 12. Procedure för nya cannon arbetsordrar
DROP PROCEDURE IF EXISTS _newCannonOrder;

DELIMITER //
CREATE PROCEDURE _newCannonOrder (
cannonID smallint,
name smallint,
entID smallint,
info varchar (1024),
newStatus enum('on','off','unplugged','broken'))
BEGIN

INSERT INTO CannonSubPlace (cannonID, name, entID, newStatus, info, comment) values (cannonID, name, entID, newStatus, info,"not finnished/accepted(emergency) yet");

COMMIT ;
END //
DELIMITER ;
-- call _newCannonOrder ('1','2','1','tecxt example','on');

-- select * from CannonSubPlace;



-- 13. procedur för att ta bort arbetsorder
DROP PROCEDURE IF EXISTS _deleteWorkOrder;
DELIMITER //
CREATE PROCEDURE _deleteWorkOrder (delWorkOrderID INT)
BEGIN
IF (delWorkOrderID IS NOT NULL) THEN
	DELETE FROM WorkOrder WHERE delWorkOrderID=orderID;
ELSE
	SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This orderID does not exist!';
END IF;
END //
DELIMITER ;

-- CALL _newWorkOrder (1, 2, now(), 'low', 'KOTTAR ÖVERALLT RÄDDA MIG', 1, 3);

-- CALL _deleteWorkOrder(5);

-- SELECT * FROM WorkOrder;



    -- 14. skapa färdig CANNONorder (logg)

-- problem med att få proceduren nedan att fungera, prövat flera lösningsalternativ utan resultat. hjälp sökes
DROP PROCEDURE IF EXISTS _finnishedCannonOrder;
DELIMITER //
CREATE PROCEDURE _finnishedCannonOrder (
finnishedOrderID int,
finnishedEntID smallint, 
finnishedEnd timestamp, 
finnishedComment varchar(1024))
begin
  INSERT INTO FinnishedCannonSubPlace
  SELECT * FROM CannonSubPlace where CannonSubPlace.orderID = finnishedOrderID;
   
   update FinnishedCannonSubPlace
    set 
     entID = finnishedEntID,
     endStamp = finnishedEnd,
     comment = finnishedComment
      where
       orderID = finnishedOrderID;
       
   DELETE FROM CannonSubPlace where orderID=finnishedOrderID;
   COMMIT ;
END //
DELIMITER ;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');


    -- 15. Byt ent ansvarig för arbetsorder.
    
DROP PROCEDURE IF EXISTS _newResponsability;
DELIMITER //
CREATE PROCEDURE _newResponsability (
_entID smallint,
_orderID int)
begin

	update WorkOrder
    set
    entID = _entID
    where
    orderID = _orderID;

   COMMIT ;
END //
DELIMITER ;

call _newResponsability ('3','1');
-- select * from WorkOrder;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');




    -- 15. Byt ent tel-nummber 
DROP PROCEDURE IF EXISTS _newNumber;
DELIMITER //
CREATE PROCEDURE _newNumber (
_number int(10),
_entID smallint)
begin

	update Ent
    set
    number = _number
    where
    entID = _entID;

   COMMIT ;
END //
DELIMITER ;

call _newNumber ('1487654321','1');
-- select * from Ent;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');




    -- 16. mottagen akutarbetsorder
DROP PROCEDURE IF EXISTS _akut;
DELIMITER //
CREATE PROCEDURE _akut (
_orderID int,
_EM varchar(64))
begin
	update WorkOrder
    set
    entID = (select entID from Ent where email = _EM)
    where
    orderID = _orderID;

   COMMIT ;
END //
DELIMITER ;

 call _akut ('1','asd@hotmail.com');
-- select * from WorkOrder;
-- select * from Ent;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');
-- select * from WorkOrder where priority="akut" and entID != '1';
-- SELECT * FROM WorkOrder where priority="akut";


-- 15 tar alla gammla kommentarer äldre än 48 h

DROP PROCEDURE IF EXISTS _removeComment();
DELIMITER //
CREATE PROCEDURE _removeComment()
begin
delete
from Commenta
where date < DATE_SUB(CURDATE(), interval 48 hour);
END //
DELIMITER ;

call _removeComment();

/*
DELETE FROM Commenta 
WHERE
    date < NOW() - INTERVAL 48 HOUR;
    */
select * from Commenta;



