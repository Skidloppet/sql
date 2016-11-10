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

-- Bör skapa så man kan se snittet på den specifika delsträckan, SubPlace.name!Med (avg)? (count)?

-- SELECT * FROM Report;