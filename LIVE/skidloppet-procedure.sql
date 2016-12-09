/*
-- 1. Procedure för att skapa en Entrepenör
-- 2. Procedure för att skapa en Skidloppet användare
-- 3. procedur för att göra en SKI till arenachef/other
-- 4. Procedur för att logga in.
-- 5. Procedur för att skapa en ny snökanon
-- 6. Procedur för att ändra snökanoner
-- 7. Procedure för nya daglig rapportering
-- 8. Procedure för nya kommentarer
-- 9. Procedure för nya felanmälan
-- 10. Lägg till ny arbetsorder
-- 11. skapa färdig arbetsorder (logg)
-- 12. Procedure för nya cannon arbetsordrar
-- 13. procedur för att ta bort arbetsorder
-- 14. skapa färdig CANNONorder (logg)
-- 15. Byt ent ansvarig för arbetsorder.
-- 16. Byt ent tel-nummber 
-- 17. mottagen akutarbetsorder
-- 18 tar alla gammla kommentarer äldre än 48 h
-- 19 Ändra ansvarande entreprenör över sträcka
-- 20 Ändra ansvarande entreprenör till snökanon
-- 21. procedur för att ta bort kommentar
*/

-- 1. Procedure för att skapa en Entrepenör
-- IF satsen kollar om Ski har tagit email adressen redan
DROP PROCEDURE IF EXISTS CreateEnt;

DELIMITER //
CREATE PROCEDURE CreateEnt(pass varchar(32), firstName varchar(32), lastName varchar(32), email varchar (64), number int(10))
BEGIN
   -- DECLARE encryptedpassword VARCHAR(32);
   -- set encryptedpassword=LEFT(PASSWORD(pass),32); -- krypterar lösenorder
    INSERT INTO Ent(password, firstName, lastName, email, number, regDate) VALUES (pass, firstName, lastName, email, number, NOW());
IF exists(select email from Ski where Ski.email=email)>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This email is already taken by Skidloppet';
        end if;    
END;
// 
DELIMITER ;
-- call CreateEnt ('pass','lasse','berghagen','lasseBH@gmail.com','0704728934');
-- call CreateEnt ('pass','lasse','berghagen','OveSwag@hotmail.com','0704728934');

-- select * from Error;
 -- 2. Procedure för att skapa en Skidloppet användare
 -- IF satsen kollar om Ent har tagit email adressen redan
DROP PROCEDURE IF EXISTS CreateSki;
DELIMITER //
CREATE PROCEDURE CreateSki(pass varchar(32), firstName varchar(32), lastName varchar(32), email varchar (64), number int(10), type enum('arenachef','other'))
BEGIN
   -- DECLARE encryptedpassword VARCHAR(32);
  --  set encryptedpassword=LEFT(PASSWORD(pass),32);
    INSERT INTO Ski(password, firstName, lastName, email, number, type, regDate) VALUES (pass, firstName, lastName, email, number,type, NOW());
    IF exists(select email from Ent where Ent.email=email)>0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'This email is already taken by Entrepenör';
        end if;    
END;
// 
DELIMITER ;
-- call CreateSki ('pass','Stefan','Holm','StaffeOG@hotmail.com','0732728934','other');
-- call CreateSki ('pass','Stefan','Holm','lasseBH@gmail.com','0732738934','other');
-- select * from Ski;
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
-- call CreateSki ('pass','Rune','Lund','Rune.Lund@skidloppet.se','1111111','arenachef');
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
CREATE PROCEDURE NewCannon(subPlaceName varchar(32), model char(3), state enum('På','Av','Urkopplad','Trasig', 'Annat'), effect DECIMAL(4,3), klass varchar(32))

BEGIN
insert into Cannon (subPlaceName, model, state, effect, klass) values (subPlaceName, model, state, effect, klass);
END; //
DELIMITER ;
--
-- call NewCannon('Hedemora 1:1','MO1','På','1,2','asd');
-- select * from Cannon;


-- fungerar ej
-- 6. Procedur för att ändra snökanoner
DROP PROCEDURE IF EXISTS AlterCannon; 
 DELIMITER //
CREATE PROCEDURE AlterCannon (cannonID smallint,subPlaceName varchar(32), state enum('På','Av','Urkopplad','Trasig', 'Annat'))
BEGIN

update Cannon
set Cannon.subPlaceName = subPlaceName
where Cannon.cannonID = cannonID;
update Cannon
set Cannon.state = state
where Cannon.cannonID = cannonID;

END; //
DELIMITER ;
-- Call AlterCannon ('5',"Hedemora 1:3",'Av');
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




/*
call _newReport (3, now(), '2016-10-13', '5', '5', '5', '5', 30.1, 'Perfekt',1,3);
call _newReport (4, now(), '2016-10-13', '5', '4', '5', '4', 20.0, 'Superbra dag för skidåkning',4,7);
call _newReport (5, now(), '2016-10-13', '2', '2', '2', '2', 8.6, 'Dålig sträcka',8,10);
call _newReport (6, now(), '2016-10-13', '3', '3', '2', '4', 13.5, 'Funkar, borde bli bättre när snön kommer!',11,12);
call _newReport (7, now(), '2016-10-13', '4', '4', '4', '4', 20.9, 'Fin sträcka!',13,15);
call _newReport (8, now(), '2016-10-13', '5', '4', '4', '4', 23.4, 'Jag har inget speciellt att rapportera. Bra sträcka.',16,17);
call _newReport (9, now(), '2016-10-13', '1', '1', '2', '1', 0.2, 'Finns ingen snö...',18,19);
call _newReport (10, now(), '2016-10-13', '2', '2', '1', '2', 5.7, 'Dåligt med snö.',20,21);

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

INSERT INTO Commenta (Kommentar, grade, alias, date) values (newComment, newGrade, newAlias, newDate);
INSERT INTO OldCommenta (Kommentar, grade, alias, date) values (newComment, newGrade, newAlias, newDate);

set LastInsert = last_insert_id();

SET nameCounter = startName;
-- gör en if sats som kollar om det första värdet är större, därefter gör 2 whileloopar där ena adderar och andra subtraherar
WHILE nameCounter<=endName DO

	insert into CommentSubPlace(name, commentID) values (nameCounter, LastInsert);
	insert into OldCommentSubPlace(name, commentID) values (nameCounter, LastInsert);
	set nameCounter = nameCounter + 1;

	END WHILE;
COMMIT ;
END //
DELIMITER ;
/*
call _NewComment ('Härlig Upplevelse','Connor McGregor','2',now(),'2','5');
call _NewComment ('Hej','Lars','2',now(),'6','1');
call _NewComment ('en kommentar på några spår','Klas','2',now(),'1','6');
call _NewComment ('korar','Kalle','2',now(),'2','5');
call _NewComment ('sånt kul','Olof','2',now(),'6','1');
call _NewComment ('kottarkottarkottarkottar','Jon Jones','2',now(),'1','6');
-- 
-- select * from CommentSubPlace;
-- select * from Commenta;
*/
-- delete from Ent where entID='6';

-- 9. Procedure för nya felanmälan

DROP PROCEDURE IF EXISTS _NewError;

DELIMITER //
CREATE PROCEDURE _NewError (
newErrorDesc varchar(1024),
newEntID smallint,
newSentDate timestamp,
-- newGrade enum('low','medium','high','akut'),
newType enum('Ljus','Spår','Skräp','Träd','Annat'),
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

-- call _NewError ('mörkt överallt','1',now(),'Ljus','1','3');
-- call _NewError ('träd över spåret','2',now(),'Träd','3','1');
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
newPriority enum('Hög','Medium','Låg','Akut'),
newType enum('Ljus','Spår','Skräp','Träd','Annat'),
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
		values (newSkiID, newEntID, now(), newPriority,newType, newInfo, "not finnished/accepted(emergency) yet");
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
		WHILE nameCounter<=endName DO
			insert into SubPlaceWorkOrder(name, orderID) values (nameCounter, LastInsert);
			set nameCounter = nameCounter + 1;
			END WHILE;
		end if;
COMMIT ;
END //
DELIMITER ;
/*
call _newSplitWorkOrder ('1','1',now(),'Hög','Spår','spåra spåren','1','1','6');
call _newSplitWorkOrder ('1','1',now(),'Akut','Träd','träda träden','0','1','6');
select * from SubPlaceWorkOrder;
select * from WorkOrder;
*/



-- 11. skapa färdig arbetsorder (logg)

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
skiID smallint,
entID smallint,
startStamp datetime,
priority enum('Låg','Medium','Hög','Akut'),
state enum('På','Av','Urkopplad','Trasig', 'Annat'),
info varchar (1024))
BEGIN


INSERT INTO CannonSubPlace (cannonID, name, skiID,entID, startStamp, priority,newStatus, info) values (cannonID, name, skiID,entID, startStamp, priority,state, info);
COMMIT ;
END //
DELIMITER ;

-- call _newCannonOrder ('1','7','1','1',NOW(),'Låg','Av','fdgfhfgdsfad');
-- 
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

-- CALL _newWorkOrder (1, 2, now(), 'Låg', 'KOTTAR ÖVERALLT RÄDDA MIG', 1, 3);

-- CALL _deleteWorkOrder(5);

-- SELECT * FROM WorkOrder;


    -- 14. skapa färdig CANNONorder (logg)

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
-- call _finnishedCannonOrder('31','1',now(),'texttesttets');
-- SELECT * FROM CannonSubPlace;
-- select * from FinnishedCannonSubPlace;


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

-- call _newResponsability ('3','1');
-- select * from WorkOrder;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');




    -- 16. Byt ent tel-nummber 
DROP PROCEDURE IF EXISTS _newNumber;
DELIMITER //
CREATE PROCEDURE _newNumber (
_number varchar(13),
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

-- call _newNumber ('1487654321','1');
-- select * from Ent;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');




    -- 17. mottagen akutarbetsorder
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

 -- call _akut ('1','asd@hotmail.com');
-- select * from WorkOrder;
-- select * from Ent;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');
-- select * from WorkOrder where priority="akut" and entID != '1';
-- SELECT * FROM WorkOrder where priority="akut";


-- 18 tar alla gammla kommentarer äldre än 48 h

DROP PROCEDURE IF EXISTS _removeComment;
DELIMITER //
CREATE PROCEDURE _removeComment()
begin
delete
from Commenta
where date < DATE_SUB(CURDATE(), interval 48 hour);
END //
DELIMITER ;

-- call _removeComment();


-- 19 Ändra ansvarande entreprenör över sträcka
  
DROP PROCEDURE IF EXISTS _newResponsabilitySubPlace;
DELIMITER //
CREATE PROCEDURE _newResponsabilitySubPlace (
_entID smallint,
_name int)
begin

	update SubPlace
    set
    entID = _entID
    where
    name = _name;

   COMMIT ;
END //
DELIMITER ;

-- call _newResponsabilitySubPlace ('3','1');
-- select * from WorkOrder;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');


-- select * from SubPlaceWorkOrder;
-- select realName from SubPlace, SubPlaceWorkOrder where SubPlace.name = SubPlaceWorkOrder.name and SubPlaceWorkOrder.orderID = 12;


-- 20 Ändra ansvarande entreprenör till snökanon

DROP PROCEDURE IF EXISTS _newResponsabilityC;
DELIMITER //
CREATE PROCEDURE _newResponsabilityC (
_entID smallint,
_orderID int)
begin

	update CannonSubPlace
    set
    entID = _entID
    where
    orderID = _orderID;

   COMMIT ;
END //
DELIMITER ;

-- call _newResponsabilityC ('3','30');
-- select * from CannonSubPlace;
-- call _finnishedCannonOrder('2','1',now(),'texttesttets');
-- SELECT * FROM Commenta order by commentID desc;


-- 21. procedur för att ta bort kommentar
DROP PROCEDURE IF EXISTS _deleteCOM;
DELIMITER //
CREATE PROCEDURE _deleteCOM (delCommentID INT)
BEGIN
	DELETE FROM Commenta WHERE commentID=delCommentID;
update OldCommenta set del = "1"  where commentID=delCommentID;
END //
DELIMITER ;
-- 
-- call _deleteCOM ('1');
-- select count(*)as b from OldCommenta where del="1";
-- select * from Commenta;
-- select * from OldCommenta;
-- select realName from SubPlace, OldCommentSubPlace where SubPlace.name = OldCommentSubPlace.name and OldCommentSubPlace.commentID = '9'; 
-- select count(*) from OldCommentSubPlace where OldCommentSubPlace.orderID ='1' ;
-- select count(*)as b from OldCommenta where del="1";
-- call _deleteCOM (:commentID)
-- 13. procedur för att ta bort arbetsorder








