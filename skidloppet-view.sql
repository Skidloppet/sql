/*
-- Vyer till Skidloppet AB
1. Vy för alla användare
2. Vy för allt dagligt arbete & delsträckor
3. Vy för arbetsorder och delsträckor
4.

KVAR ATT GÖRA!

Vy för inskickade felanälningar (Error från kund & ent)ink. procedure för borttagning
Vy för avklarade arbesordrar (finnishedWorkOrder)
Vy för skick per sträcka(inte del-sträcka)
Vy för detaljerat skick på delsträcka (ink Ent report & kund kommentar & snitt av båda)
VY för samma som ovan men ink. vem som ansvarar över sträckan och ev. extra info
Vy för entrepenörer samt senaste genomförd arbetsorder, arbete & nästa planerade
Vy för kundkommentarer

Vy för inkommande arbetsordrar
Vy för snökanoner
Vy för snö och konstsnö
*/




-- 1. Vy för alla användare
-- Vy för att skapa en entreprenör
DROP VIEW IF EXISTS AllUsers;
CREATE VIEW AllUsers AS
    SELECT 
        skiID as id, email, password
    FROM
        Ski 
    UNION SELECT 
        entID as id, email, password
    FROM
        Ent;
-- select * from AllUsers;



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

-- denna vyn hämtar den senaste rapportID för en del-sträcka
DROP VIEW IF EXISTS overview;

create view overview as
SELECT ReportSubPlace.name as rspName, max(ReportSubPlace.reportID) as rspID
from ReportSubPlace
group by ReportSubPlace.name;

-- denna vyn hämtar rating från senaste rapporten på en viss del-sträcka.
-- select * from ReportSubPlace;
DROP VIEW IF EXISTS overview2;

create view overview2 as
select rspName,rating from overview, Report where reportID = rspID;

select * from overview2;



-- denna vyn hämtar detaljerad information om del-sträckan (KUNDVY)
DROP VIEW IF EXISTS overview3;

create view overview3 as
select rspName, startDate, rating, underlay, edges, grip, depth, length, height, realname 
from overview, Report, SubPlace
where reportID = rspID and rspName = SubPlace.name;

select * from overview3;

-- denna vyn hämtar detaljerad information om rapport på vald del-sträcka (SKI-VY)
DROP VIEW IF EXISTS overview3;

create view overview3 as
select rspName, Report.entID as ReportEnt, workDate, startDate, rating, underlay, edges, grip, depth, realName, SubPlace.entID as SubPlaceEnt, length, height, fakesnow
from overview, Report, SubPlace
where reportID = rspID and rspName = SubPlace.name;

select * from overview3;


-- denna vyn hämtar detaljerad information om snökanonerna på vald del-sträcka (SKI-VY)
DROP VIEW IF EXISTS overview4;

create view overview4 as
select realName, fakesnow, cannonID, model, status, effect
from overview, SubPlace, Cannon
where Cannon.subPlaceName = SubPlace.name and rspName = SubPlace.name;

select * from overview4;

