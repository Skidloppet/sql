/*
-- Vyer till Skidloppet AB
1. Vy för alla användare
	2. Vy för allt dagligt arbete & delsträckor
	3. Vy för arbetsorder och delsträckor
4. Vy för snökannoner
5. Vy för akuta arbetsordrar
6. Vy för kundkommentar
7. Vy för senaste rapporten på en delsträcka
8. Vy för senaste statusen på del-sträcka (överblicks-kartan)
9. Vy för status på del-sträcka (KUND-VY)
10. Vy för status på del-sträcka (SKI-VY)
11. Vy för snökanoner och konstsnöstatus på del-sträcka
12. Vy för avklarade arbetsordrar
KVAR ATT GÖRA!

Vy för där alla arbetsordar och snökanonsordrar som är tilldelade en visas skiID 
Vy för inskickade felanälningar (Error från kund & ent)ink. procedure för borttagning
Vy för inkommande arbetsordrar
*/
 

-- 1. Vy för alla användare
-- Vy för att skapa en entreprenör
DROP VIEW IF EXISTS AllUsers;
CREATE VIEW AllUsers AS
    SELECT 
        skiID as id, email, password, type
    FROM
        Ski 
    UNION SELECT 
        entID as id, email, password, number as type
    FROM
        Ent;
-- select * from AllUsers;
-- select * from AllUsers WHERE password='pass' and email='stefan';


-- 2. Vy för allt dagligt arbete & delsträckor
DROP VIEW IF EXISTS Reporting;
CREATE VIEW Reporting AS
SELECT 
Report.reportID, Report.entID, Report.startDate, 
Report.workDate, Report.rating, Report.underlay, 
Report.edges, Report.grip, Report.depth,
ReportSubPlace.name
FROM 	Report, ReportSubPlace
WHERE	Report.reportID = ReportSubPlace.reportID;

-- Select * From Reporting;



-- 3. Vy för arbetsorder och delsträckor
DROP VIEW IF EXISTS WorkOrdersAndPlaces;
-- skiID, entID, sentDate, startDate, priority, info, startName, endName
CREATE VIEW WorkOrdersAndPlaces AS
SELECT 
WorkOrder.orderID, WorkOrder.skiID, WorkOrder.entID, 
WorkOrder.sentDate, WorkOrder.endDate, WorkOrder.priority, 
WorkOrder.info,
SubPlaceWorkOrder.name
FROM 	WorkOrder, SubPlaceWorkOrder
WHERE	WorkOrder.orderID = SubPlaceWorkOrder.orderID;

-- Select * From WorkOrdersAndPlaces;



-- 4. Vy för snökannoner
DROP VIEW IF EXISTS SnowCannons;
CREATE VIEW SnowCannons AS
SELECT
Cannon.cannonID, Cannon.subPlaceName,Cannon.model,Cannon.effect
FROM Cannon
WHERE Cannon.CannonID >0; 
-- SELECT * FROM SnowCannons;



-- 5. Vy för akuta arbetsordrar
DROP VIEW IF EXISTS UrgentWorkOrder;
CREATE VIEW UrgentWorkOrder AS
SELECT
WorkOrder.orderID,WorkOrder.skiID,WorkOrder.entID,WorkOrder.sentDate,
WorkOrder.endDate,WorkOrder.priority,WorkOrder.info,WorkOrder.EntComment
FROM WorkOrder
WHERE WorkOrder.priority='akut';
-- SELECT * FROM UrgentWorkOrder;



-- 6. Vy för kund kommentar
DROP VIEW IF EXISTS CustommerComment;
CREATE VIEW CustommerComment AS
SELECT * FROM Commenta
WHERE CommentID >0;
-- SELECT * FROM  Comment;



/*
------------------------------- ALTERNATIVT MÖJLIG LÖSNING GENOM TIMESTAMP I N:M TABELLEN
DROP VIEW IF EXISTS newview;
create view newview as
SELECT ReportSubPlace.name as rspName, reportID -- rating 
from ReportSubPlace
  join Report on ReportSubPlace.reportID = Report.reportID
order by rspName, abs(stamp - now());

select * from newview;
*/


-- 7. Vy för senaste rapporten på en delsträcka
-- denna vyn hämtar den senaste rapportID för en del-sträcka
DROP VIEW IF EXISTS overview;
create view overview as
SELECT ReportSubPlace.name as rspName, max(ReportSubPlace.reportID) as rspID
from ReportSubPlace
group by ReportSubPlace.name;

-- denna vyn hämtar rating från senaste rapporten på en viss del-sträcka.
-- select * from ReportSubPlace;




-- 8. Vy för senaste statusen på del-sträcka (överblicks-kartan)
DROP VIEW IF EXISTS karta;

create view karta as
select rspName,rating from overview, Report where reportID = rspID;

-- call _newReport (1, now(), '2016-10-14', '1', '4', '4', '4', 23.1, 1,6);
-- i skidloppet-procedurer.sql finns fler exempel för rapporter för test av N:M (rad 179-183)
-- select * from karta order by rspName;




-- 9. Vy för status på sträcka (överblicks-kartan)
-- denna vyn hämtar detaljerad information om del-sträckan (KUNDVY)
DROP VIEW IF EXISTS KundDetaljer;

create view KundDetaljer as
select rspName, startDate, rating, underlay, edges, grip, depth, length, height, realname 
from overview, Report, SubPlace
where reportID = rspID and rspName = SubPlace.name;

-- select * from KundDetaljer;



-- 10. Vy för detaljerad spårningsinformation på del-sträcka
-- denna vyn hämtar detaljerad information om rapport på vald del-sträcka (SKI-VY)
DROP VIEW IF EXISTS SkiDetaljer;

create view SkiDetaljer as
select rspName, Report.entID as ReportEnt, workDate, startDate, rating, underlay, edges, grip, depth, realName, SubPlace.entID as SubPlaceEnt, length, height, fakesnow
from overview, Report, SubPlace
where reportID = rspID and rspName = SubPlace.name;

-- select * from SkiDetaljer;




-- 11. Vy för snökanoner och konstsnöstatus på del-sträcka
-- denna vyn hämtar detaljerad information om snökanonerna på vald del-sträcka (SKI-VY)
DROP VIEW IF EXISTS overview4;

create view overview4 as
select realName, fakesnow, cannonID, model, status, effect
from overview, SubPlace, Cannon
where Cannon.subPlaceName = SubPlace.name and rspName = SubPlace.name;

-- select * from overview4;

-- 12. Vy för avklarade arbesordrar 

DROP VIEW IF EXISTS finnishedWorkOrder;
CREATE VIEW finnishedWorkOrder AS
	SELECT FinnishedWorkOrder.orderID,FinnishedWorkOrder.entID,FinnishedWorkOrder.sentDate,FinnishedWorkOrder.endDate,
    FinnishedWorkOrder.priority,FinnishedWorkOrder.info,FinnishedWorkOrder.EntComment
	FROM FinnishedWorkOrder,WorkOrder
	WHERE WorkOrder.orderID=FinnishedWorkOrder.orderID;

-- select * from finnishedWorkOrder;

-- Vy för entrepenörer samt senaste genomförd arbetsorder, arbete & nästa planerade
DROP VIEW IF EXISTS lastWorkOrderEnt;
CREATE VIEW lastWorkOrderEnt AS
	SELECT max(FinnishedWorkOrder.OrderID),max(Report.workDate) 
    FROM FinnishedWorkOrder,Report;
-- select * from lastWorkOrderEnt