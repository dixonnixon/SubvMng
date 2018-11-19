CREATE DATABASE SubvMng
ON 
	(NAME = 'SubvMng',
	FILENAME = 'C:\temp\SubvMng.mdf',
	SIZE = 10,
	MAXSIZE = 75,
	FILEGROWTH = 5)
LOG ON
	(NAME = 'SubvMngLog',
	FILENAME = 'C:\temp\SubvMng.ldf',
	SIZE = 5MB,
	MAXSIZE = 25MB,
	FILEGROWTH = 5MB)
GO

CREATE TABLE SubObjs --objects
(
	subObjID	int IDENTITY	NOT NULL,
	objName		varchar(MAX)  	NOT NULL,
	dateSub 	datetime	    NOT NULL
		CONSTRAINT DF_SubObjDt DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	CONSTRAINT 	PK_SubObjs
		PRIMARY KEY (subObjID)
)
GO

CREATE TABLE YearIncomes --objects
(
	incomeId	int IDENTITY	NOT NULL,	
	subObjID	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjID)
		ON UPDATE CASCADE
		ON DELETE CASCADE,	
	dateIn 	datetime	    NOT NULL
		CONSTRAINT DF_YearInc DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	SumBase		money			NOT NULL
		CONSTRAINT DF_SubDt DEFAULT(0.00),
	CONSTRAINT 	PK_YearIncomes
		PRIMARY KEY (incomeId)	
)
GO

CREATE TABLE ProvIncomes
(
	incomeId	int IDENTITY	NOT NULL,	
	subObjID	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjID)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	dateProvInc	datetime	NOT NULL
		CONSTRAINT DF_ProvIncDt DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	sumProv		money		NOT NULL
		CONSTRAINT DF_Prov DEFAULT(0.00),
	feature 	varchar(1) 		NULL,
	CONSTRAINT 	PK_ProvIncomes
		PRIMARY KEY (incomeId)	
)

CREATE TABLE FactIncomes
(
	incomeId int IDENTITY	NOT NULL,	
	subObjID	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjID)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	dateFactInc	datetime	NOT NULL
		CONSTRAINT DF_FactIncDt DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	sumFact		money		NOT NULL
		CONSTRAINT DF_Fact DEFAULT(0.00),
	feature 	varchar(1) 		NULL,
	CONSTRAINT 	PK_FactIncomes
		PRIMARY KEY (incomeId)	
)



CREATE TABLE Outcomes
(
	outcomeId int IDENTITY	NOT NULL,	
	subObjID	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjID)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	dateOut	datetime	NOT NULL
		CONSTRAINT DF_OutDt DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	sumOut		money		NOT NULL
		CONSTRAINT DF_Out DEFAULT(0.00),
)

