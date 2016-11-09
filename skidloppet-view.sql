-- Vyer till Skidloppet AB

-- Vy för att skapa en entreprenör
DROP VIEW IF EXISTS AllUsers;
CREATE VIEW AllUsers AS
    SELECT 
        email, password
    FROM
        Ski 
    UNION SELECT 
        email, password
    FROM
        Ent;
-- select * from AllUsers;




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

Select * From WorkOrdersAndPlaces;

-- Bör skapa så man kan se snittet på den specifika delsträckan, SubPlace.name!Med (avg)? (count)?

-- SELECT * FROM Report;