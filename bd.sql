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

USE SubvMng
GO
CREATE TABLE Tobo
(
	tobo		int 		 		NOT NULL UNIQUE,
	toboName	varchar(300)		NOT NULL,
	CONSTRAINT PK_Tobo
		PRIMARY KEY (tobo)
)


GO
USE SubvMng
CREATE TABLE Budgets
(
	budgCode		bigint 		 	NOT NULL UNIQUE,
	tobo			int				NOT NULL
		FOREIGN KEY REFERENCES Tobo(tobo)
		ON UPDATE CASCADE
		ON DELETE NO ACTION,	
	budgName	varchar(300)		NOT NULL,
	CONSTRAINT PK_Budgets
		PRIMARY KEY (budgCode)
)

--при вставці об`єкту ід об`єкту повинен
--вставлятися в таблицю ObjViewPerm
--і тобо користувача який вводить об`єкт

GO
USE SubvMng
CREATE TABLE SubObjs --objects
(
	subObjId	int IDENTITY	NOT NULL,
	objName		varchar(MAX)  	NOT NULL,
	tobo		int				NOT NULL
	FOREIGN KEY REFERENCES Tobo(tobo)
			ON UPDATE NO ACTION
			ON DELETE NO ACTION,	
	budgCode 	bigint				NOT NULL
	FOREIGN KEY REFERENCES Budgets(budgCode)
		ON UPDATE NO ACTION
		ON DELETE NO ACTION,
	dateSub 	datetime	    NOT NULL
		CONSTRAINT DF_SubObjDt DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	CONSTRAINT 	PK_SubObjs
		PRIMARY KEY (subObjId)
)


--таблиця зберігає інформацію які тобо
--можуть мати до об`єкту доступ 
--До таблиці доступ повинен мати тільки 1800

GO
USE SubvMng
CREATE TABLE ObjViewPerm
(
	subObjId 	int 	NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjId)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	tobo		int				NOT NULL
	FOREIGN KEY REFERENCES Tobo(tobo)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	CONSTRAINT 	PK_ObjViewPerm
		PRIMARY KEY (subObjId, tobo)	
)

USE SubvMng
GO
IF NOT EXISTS (
	SELECT  * FROM    sys.objects
	WHERE   type = 'TR'
	and name = 'tr_insert_ob_perm'
) BEGIN
	EXEC ('
		CREATE TRIGGER [dbo].[tr_insert_ob_perm] 
			on [dbo].[SubObjs]
			   INSTEAD OF INSERT AS 
			BEGIN 
				SET NOCOUNT ON;
				
				INSERT INTO SubObjs 
				SELECT	i.objName, i.tobo, 
				i.budgCode, i.dateSub
				FROM INSERTED i
				
				DECLARE @ID int
				DECLARE @tobo int
				
				SET @tobo = (SELECT i.tobo FROM INSERTED i)
				
				SELECT @ID = @@IDENTITY
					
				INSERT INTO ObjViewPerm (subObjId, tobo)
				SELECT @ID, i.tobo FROM
				INSERTED i
				
				--PRINT @tobo
				if(@tobo <> 1800)
					BEGIN
						INSERT INTO ObjViewPerm (subObjId, tobo)
						SELECT @ID, 1800 FROM
						INSERTED i
					END
				
			END
	');
END


GO
USE SubvMng
CREATE TABLE YearIncomes --objects
(
	incomeId	int IDENTITY	NOT NULL,	
	subObjId	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjId)
		ON UPDATE CASCADE
		ON DELETE CASCADE,	
	dateIn 	datetime	    NOT NULL
		CONSTRAINT DF_YearInc DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	SumBase		money			NOT NULL
		CONSTRAINT DF_SubDt DEFAULT(0.00),
	feature 	varchar(1) 		NULL,
	CONSTRAINT 	PK_YearIncomes
		PRIMARY KEY (incomeId)	
)

GO
USE SubvMng
CREATE TABLE ProvIncomes
(
	incomeId	int IDENTITY	NOT NULL,	
	subObjId	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjId)
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

GO
USE SubvMng
CREATE TABLE FactIncomes
(
	incomeId int IDENTITY	NOT NULL,	
	subObjId	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjId)
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

CREATE TRIGGER [dbo].[tr_insert_fact_date_less_date_year] 
on [dbo].[FactIncomes]
   FOR INSERT, UPDATE AS 
BEGIN 
	SET NOCOUNT ON;
	DECLARE @tempy varchar(100)
	DECLARE @temp varchar(100)
	DECLARE @tempID varchar(100)
	
	SELECT @tempy = y.date
	FROM YearProvs y
	JOIN Inserted i
	ON i.incId = y.incId
	
	SELECT @tempID = i.incID
	FROM Inserted i
	
	
	SELECT @temp = i.date
	FROM YearProvs y
	JOIN Inserted i
	ON i.incId = y.incId
	
	SELECT @temp = i.date, @tempy = y.date
	 FROM Inserted i
		JOIN YearProvs y
		ON i.incID = y.incID
		WHERE (i.date <= y.date)
END

CREATE TRIGGER [dbo].[tr_insert_fact_date_less_year_sum] 
on [dbo].[FactIncomes]
   FOR INSERT, UPDATE AS 
BEGIN 
	SET NOCOUNT ON;
	DECLARE @sumUntil	money
	DECLARE @inDate		datetime
	DECLARE @sumYear	money
	
	SELECT @inDate = date From Inserted
	
	SELECT @sumYear = y.sum 
	FROM YearProvs y
	JOIN Inserted i
	ON i.incId = y.incId
	WHERE YEAR(y.date) = YEAR(i.date)
		
	;WITH cte as (SELECT TOP 1 t.sum, 
			( 
				SELECT SUM(sum) 
				FROM (
					SELECT sum
					FROM FactIncomes f
					WHERE t.incId = f.incId
					AND f.date <= t.date
				) AS q
			) as AllSum
			FROM FactIncomes t
			JOIN YearProvs y
			ON y.incId = t.incId
			WHERE t.date <= @inDate AND YEAR(t.date) = YEAR(y.date)
			 AND YEAR(t.date) >= YEAR(@inDate)
			ORDER BY t.date desc 
	)
	SELECT @sumUntil = AllSum FROM cte
	PRINT @sumUntil
	
	IF @sumUntil > @sumYear
	BEGIN
		PRINT 'Сума на рік '+ CAST(@sumUntil as varchar) 
		+ ' більша ніж річна ' +  CAST(@sumYear as varchar) 
		ROLLBACK TRAN
	END
	
END


GO
USE SubvMng
CREATE TABLE Outcomes
(
	outcomeId int IDENTITY	NOT NULL,	
	subObjID	int 			NOT NULL
	FOREIGN KEY REFERENCES SubObjs(subObjId)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	dateOut	datetime	NOT NULL
		CONSTRAINT DF_OutDt DEFAULT(
			CONVERT(varchar, YEAR(GETDATE()))
		),
	sumOut		money		NOT NULL
		CONSTRAINT DF_Out DEFAULT(0.00),
	feature 	varchar(1) 		NULL
)

ALTER TRIGGER [dbo].[tr_FillDeletedOutcomes] 
   ON  [dbo].[Outcomes]
   INSTEAD OF DELETE AS
BEGIN
	-- SET NOCOUNT ON added to prevent extra result sets from
	-- interfering with SELECT statements.
	SET NOCOUNT ON;
	
	DECLARE @incId int
	DECLARE @date datetime
	
	SELECT 
		@incId = o.incId, 
		@date = d.date
	From Outcomes o
	JOIN DELETED d
	ON d.incId = o.incId

	
	DELETE FROM Outcomes 
	WHERE incId = @incId
	AND date = @date
	
	DECLARE @Count int
	SELECT @Count =  COUNT(*) FROM Outcomes
		WHERE incId = @incId
	
	
	IF @Count = 0 
	BEGIN
		
		DECLARE @fond int
		
		SELECT @date = date From DELETED
		
		
		INSERT INTO Outcomes
		VALUES(@incId, @date, 0.00)
	END
    -- Insert statements for trigger here
	
END



ALTER TRIGGER [dbo].[tr_insert_inc_each_factProv_zero] 
on [dbo].[YearProvs]
INSTEAD OF INSERT, UPDATE AS 
BEGIN 
	SET NOCOUNT ON;
	DECLARE @incID int
	
	INSERT INTO YearProvs (date, subObjId, sum)
		SELECT date, subObjId, sum FROM Inserted
	SELECT @incID = @@IDENTITY
	
	
	
	DECLARE @months TABLE ( mn int )
	DECLARE @inps TABLE (id int, dt datetime, sum money)
	
	DECLARE @year int
	DECLARE @yearN int
	

	SELECT @year = YEAR(i.date) FROM Inserted i
	

	
	SET @yearN = @year+1

insert INTO @months
	SELECT MONTH(DATEADD(
		MONTH, 
		n, 
		DATEADD(
			MONTH,
			DATEDIFF(MONTH, 0, CAST(@year as varchar) + '-01-01'),
			0
		)
	)) month 
	FROM (
		SELECT TOP (
			SELECT DATEDIFF(
				MONTH, 
				CAST(@year as varchar) + '-01-01',
				CAST(@yearN as varchar) + '-01-01')
		)
		ROW_NUMBER() OVER (ORDER BY object_id)-1 n
		FROM sys.all_objects  ORDER BY object_id
	) n

	--search abscent month from FactIncomes
	DECLARE @inc int, @missedDate datetime, @nulSum money,
	@STR varchar(MAX);
	
	;WITH CTE AS (SELECT * FROM @months m
			EXCEPT (SELECT DISTINCT MONTH(fi.date)
			FROM FactIncomes fi
			LEFT JOIN FactIncomes f
			ON MONTH(fi.date) = MONTH(f.date)
			WHERE fi.incId = @incID AND YEAR(fi.date) = @year
		)
	) 
	INSERT INTO @inps 
		SELECT @incID, CONVERT(datetime, CAST(@year as varchar) + '-' + cast(mn as varchar) + '-01'), 0.00 FROM CTE
	--SELECT * FROM @inps
	
	DECLARE curs  CURSOR SCROLL FOR
		SELECT id, dt, sum FROM @inps 
		
	OPEN curs
	FETCH NEXT FROM curs
	INTO @inc, @missedDate, @nulSum 
	
	WHILE @@FETCH_STATUS = 0
		BEGIN
			SELECT @STR = CAST(@inc as varchar) 
			+ CAST(@missedDate as varchar) 
			+ CAST(@nulSum  as varchar) 
			
			--PRINT @STR
			INSERT INTO 
			FactIncomes VALUES(@inc, @missedDate, @nulSum)
			FETCH NEXT FROM curs
			INTO @inc, @missedDate, @nulSum 
		END
	CLOSE curs
	DEALLOCATE curs
	
	DELETE FROM @inps
	
	;WITH CTE AS (SELECT * FROM @months m
			EXCEPT (SELECT DISTINCT MONTH(piN.date)
			FROM ProvIncomes piN
			LEFT JOIN ProvIncomes p
			ON MONTH(piN.date) = MONTH(p.date)
			WHERE piN.incId = @incID AND YEAR(piN.date) = @year
		)
	) 
	INSERT INTO @inps 
		SELECT @incID, CONVERT(datetime, CAST(@year as varchar) + '-' + cast(mn as varchar) + '-01'), 0.00 FROM CTE
	

	DECLARE curs  CURSOR SCROLL FOR
		SELECT id, dt, sum FROM @inps 
	OPEN curs
	FETCH NEXT FROM curs
	INTO @inc, @missedDate, @nulSum 
	WHILE @@FETCH_STATUS = 0
		BEGIN
			SELECT @STR = CAST(@inc as varchar) 
			+ CAST(@missedDate as varchar) 
			+ CAST(@nulSum  as varchar) + 'STR PROV'
			
			PRINT @STR
			INSERT INTO 
			ProvIncomes VALUES(@inc, @missedDate, @nulSum)
			FETCH NEXT FROM curs
			INTO @inc, @missedDate, @nulSum 
		END
	CLOSE curs
	DEALLOCATE curs
	DELETE FROM @inps
	
	;WITH CTE AS (SELECT * FROM @months m
			EXCEPT (SELECT DISTINCT MONTH(oc.date)
			FROM Outcomes oc
			LEFT JOIN Outcomes o
			ON MONTH(oc.date) = MONTH(o.date)
			WHERE oc.incId = @incID AND YEAR(oc.date) = @year
		)
	) 
	INSERT INTO @inps 
		SELECT @incID, CONVERT(datetime, CAST(@year as varchar) + '-' + cast(mn as varchar) + '-01'), 0.00 FROM CTE
	
	DECLARE curs  CURSOR SCROLL FOR
		SELECT id, dt, sum FROM @inps 
	OPEN curs
	FETCH NEXT FROM curs
	INTO @inc, @missedDate, @nulSum 
	
	WHILE @@FETCH_STATUS = 0
		BEGIN
			SELECT @STR = CAST(@inc as varchar) 
			+ CAST(@missedDate as varchar) 
			+ CAST(@nulSum  as varchar) 
			
			--PRINT @STR
			INSERT INTO 
			Outcomes VALUES(@inc, @missedDate, @nulSum)
			FETCH NEXT FROM curs
			INTO @inc, @missedDate, @nulSum 
		END
	CLOSE curs
	DEALLOCATE curs
	--COMMIT TRANSACTION;
END



ALTER TRIGGER [dbo].[tr_insert_inc_each_outc_zero] 
on [dbo].[YearRems]
INSTEAD OF INSERT, UPDATE AS 
BEGIN 
	SET NOCOUNT ON;
	--SET IDENTITY_INSERT YearProvs ON;
	DECLARE @incID int
	
	INSERT INTO YearRems (date, subObjId, sum, fond)
		SELECT date, subObjId, sum, fond FROM Inserted
	SELECT @incID = @@IDENTITY
	--IF(@incID IS NOT NULL) COMMIT TRANSACTION;
	
	--PRINT @incID
	
	DECLARE @months TABLE ( mn int )
	DECLARE @inps TABLE (id int, dt datetime, sum money)
	
	DECLARE @year int
	DECLARE @yearN int
	

	SELECT @year = YEAR(i.date) FROM Inserted i
	

	
	SET @yearN = @year+1

insert INTO @months
	SELECT MONTH(DATEADD(
		MONTH, 
		n, 
		DATEADD(
			MONTH,
			DATEDIFF(MONTH, 0, CAST(@year as varchar) + '-01-01'),
			0
		)
	)) month 
	FROM (
		SELECT TOP (
			SELECT DATEDIFF(
				MONTH, 
				CAST(@year as varchar) + '-01-01',
				CAST(@yearN as varchar) + '-01-01')
		)
		ROW_NUMBER() OVER (ORDER BY object_id)-1 n
		FROM sys.all_objects  ORDER BY object_id
	) n

	--search abscent month from FactIncomes
	DECLARE @inc int, @missedDate datetime, @nulSum money,
	@STR varchar(MAX);
	
	;WITH CTE AS (SELECT * FROM @months m
			EXCEPT (SELECT DISTINCT MONTH(fi.date)
			FROM FactIncomes fi
			LEFT JOIN FactIncomes f
			ON MONTH(fi.date) = MONTH(f.date)
			WHERE fi.incId = @incID AND YEAR(fi.date) = @year
		)
	) 
	INSERT INTO @inps 
		SELECT @incID, CONVERT(datetime, CAST(@year as varchar) + '-' + cast(mn as varchar) + '-01'), 0.00 FROM CTE
	--SELECT * FROM @inps
	
	DECLARE curs  CURSOR SCROLL FOR
		SELECT id, dt, sum FROM @inps 
		
	OPEN curs
	FETCH NEXT FROM curs
	INTO @inc, @missedDate, @nulSum 
	
	WHILE @@FETCH_STATUS = 0
		BEGIN
			SELECT @STR = CAST(@inc as varchar) 
			+ CAST(@missedDate as varchar) 
			+ CAST(@nulSum  as varchar) 
			
			--PRINT @STR
			INSERT INTO 
			Outcomes VALUES(@inc, @missedDate, @nulSum)
			FETCH NEXT FROM curs
			INTO @inc, @missedDate, @nulSum 
		END
	CLOSE curs
	DEALLOCATE curs
	
	DELETE FROM @inps
	
	
END


ALTER proc [dbo].[groupMonthO](@tblNm sysname, @idObj INT, @idInc INT, @year varchar(4))
AS
BEGIN

SET NOCOUNT ON;

declare @SQLString nvarchar(4000)

Set @SQLString = N'

		SELECT yp.subObjId, SUM(o.sum) as sum, MONTH(o.date) month 
		FROM Outcomes o
		JOIN '+ @tblNm+' yp
			ON o.incId = yp.incId
		WHERE subObjId = @id AND YEAR(o.date)= @year AND o.incId = @idInc
		GROUP BY yp.subObjId, MONTH(o.date)'

exec sp_executesql @SQLString, N'@id INT, @year varchar(4), @idInc INT', 
       @idObj, @year, @idInc


--SELECT * FROM @value   
RETURN @@ROWCOUNT
end 


ALTER proc [dbo].[sp_checkIdInTable](@tblNm sysname, @id INT)
AS
BEGIN

SET NOCOUNT ON;
declare @SQLString nvarchar(4000)
DECLARE @identitiCol varchar(20)


SELECT @identitiCol = name 
FROM syscolumns
WHERE OBJECT_NAME(id) = @tblNm
AND COLUMNPROPERTY(id, name, 'IsIdentity') = 1

Set @SQLString = N'

		SELECT ' + @identitiCol + ' 
		FROM '+ @tblNm+' 
		WHERE ' + @identitiCol + ' = @id';

exec sp_executesql @SQLString, N'@id INT, @identitiCol varchar', 
       @id, @identitiCol
RETURN @@ROWCOUNT
END



ALTER FUNCTION [dbo].[fn_ProvsByObj](@objId int)
RETURNS @incomes TABLE
(
	subObjId	INT				NOT NULL,
	incId		INT				NOT NULL,
	date		datetime		NULL,
	sum			decimal(18,2)	NULL
)

AS BEGIN
	;WITH CTE AS (
		SELECT subObjId FROM subObjs
	), rems as (
		SELECT yp.subObjId, yp.incId, yp.date, yp.sum FROM CTE c 
		JOIN YearProvs yp
		ON yp.subObjId = c.subObjId
	)
	INSERT INTO @incomes
		SELECT * FROM rems
		WHERE subObjId = @objId
		ORDER BY date
		RETURN
END


ALTER FUNCTION [dbo].[fn_RemsByObj](@objId int)
RETURNS @incomes TABLE
(
	subObjId	INT				NOT NULL,
	incId		INT				NOT NULL,
	date		datetime		NULL,
	sum			decimal(18,2)	NULL,
	fond		char(1)			NULL
)

AS BEGIN
	;WITH CTE AS (
		SELECT subObjId FROM subObjs
	), rems as (
		SELECT yr.subObjId, yr.incId, yr.date, yr.sum, yr.fond FROM CTE c 
		JOIN YearRems yr
		ON yr.subObjId = c.subObjId
		
	)
	INSERT INTO @incomes
		SELECT * FROM rems
		WHERE subObjId = @objId
		ORDER BY date, fond 
		RETURN
END
-----------------------------------------------------------------------------------------------

ALTER FUNCTION [dbo].[fn_report_curAllPrevRem](@year varchar(4), 
@month varchar(2), @current BIT, @prevAll BIT)
RETURNS @Objs TABLE
(
	fond		char(1)			NULL,
	budgCode	varchar(30)		NOT NULL, 
	subObjId	varchar(30)		NOT NULL,
	
	--name 	varchar(MAX)	NOT NULL, 
	SumYear 	decimal(18,2)	NOT NULL,
	OutSum		decimal(18,2)	NOT NULL,
	RemYear		decimal(18,2)	NOT NULL
)
AS BEGIN
	DECLARE @prevYear datetime
	SET @prevYear = DATEADD(YEAR, -1, @year+ '-12-31')

	;WITH CTE AS (SELECT DISTINCT 
		yr.incId,
		sum(yr.sum) yearSum,
		sum(ISNULL(o.outSum, 0.00)) outSum,
		sum(yr.sum - ISNULL(o.outSum, 0.00)) as RemObj
		FROM YearRems yr
	 JOIN( 
	SELECT 
		incId, 
		SUM(sum) as outSum 
		FROM  Outcomes 
		WHERE (
		(date <= @year and YEAR(date) = CAST(@year as INT) AND (@prevAll = 1))
			OR
		(date < @year+'-' + @month + '-01' and YEAR(date) = CAST(@year as INT) and @current = 1) 
		)
		GROUP BY incId
	) o
	On yr.incId = o.incId
	GROUP BY 
		yr.incId
), objs as (
	SELECT yr.fond, so.subObjId, yr.incId, so.budgCode
	FROM subObjs so
	JOIN YearRems yr
	ON so.subObjId = yr.subObjId
)
	INSERT INTO @Objs
	SELECT  o.fond, COALESCE(o.budgCode,0) as budgCode,
		CASE
		WHEN (CAST(o.budgCode AS varchar) IS NULL 
			AND CAST(o.subObjId AS varchar) IS NULL)
			 THEN 'Total'	
		WHEN CAST(o.subObjId AS varchar) IS NULL  THEN 'TotalBudg'
		
		ELSE CAST(o.subObjId AS varchar)
	END as subObjId,
	 (c.yearSum) as SumYear, (c.outSum) as OutSum, (c.RemObj) as RemYear
	FROM CTE c
	LEFT JOIN objs o
	ON c.incId = o.incId
	WHERE 
		((@current = 1) OR (c.RemObj > 0 and @prevAll = 1))
	--GROUP BY   
	--GROUPING SETS(ROLLUP(o.budgCode, o.subObjId))
	ORDER BY budgCode
	RETURN
END

--------------------------------------------------------____

use SubvMng
INSERT INTO Tobo VALUES
 ('1800', 'ГУ ДКCУ  у Сумськiй області'),
 ('1801', 'УДКCУ у Бiлопiльському районі'),
 ('1802', 'УДКCУ  у Буринському районі'),
 ('1803', 'УДКCУ у Великописарiвському районі'),
 ('1804', 'Глухiвське УДКCУ'),
 ('1805', 'Конотопське УДКCУ'),
 ('1806', 'УДКCУ  у Краснопiльському районі'),
 ('1807', 'УДКCУ у Кролевецькому районі'),
 ('1808', 'Лебединське УДКCУ'),
 ('1809', 'УДКCУ  у Липоводолинському районі'),
 ('1810', 'УДКCУ  у Недригайлiвському районі'),
 ('1812', 'УДКCУ у Путивльському районі'),
 ('1813', 'Роменське УДКCУ'),
 ('1814', 'УДКCУ у Середино-Будському районі'),
 ('1815', 'УДКCУ  у Сумському районі'),
 ('1816', 'УДКCУ у Тростянецькому районі'),
 ('1817', 'Шосткинське УДКCУ'),
 ('1818', 'УДКCУ  в Ямпiльському районі'),
 ('1854', 'Охтирське УДКCУ'),
 ('1856', 'УДКCУ  у м.Сумах')
 GO
 
GO
USE SubvMng
INSERT INTO dbo.Budgets VALUES
(5900000000, 1800,	'СУМСЬКА ОБЛАСТЬ/М.СУМИ	ГУК Сумській обл/Сумська обл/'),
(5920600000, 1801,	'БIЛОПIЛЬСЬКИЙ РАЙОН/М.БIЛОПIЛЛЯ	УК Бiлопільск.р./Бiлопільск.р/'),
(5920655300,	1801,	'МИКОЛАЇВКА	УК Бiлопіл.р./отг Миколаївка/'),
(5920900000,	1802,	'БУРИНСЬКИЙ РАЙОН/М.БУРИНЬ	УК Буринському р/Буринський p/'),
(5920910100,	1802,	'отг м. Буринь	УК Буринськ.р/отг м. Буринь'),
(5921200000,	1803,	'ВЕЛИКОПИСАРIВСЬКИЙ РАЙОН/СМТ ВЕЛИКА ПИСАРIВКА	УК Великопис.р/В-Писарiвськ.р/'),
(5921255400,	1803,	'КИРИКIВКА	УК Великописа.р/отг Кириківка/'),
(5910300000,	1804,	'ГЛУХIВ	Глухiвське УК/м.Глухiв/'),
(5921500000,	1804,	'ГЛУХIВСЬКИЙ РАЙОН/М.ГЛУХIВ	Глухiвське УК/Глухiв.р-н/'),
(5921555800,	1804,	'ШАЛИГИНЕ	Глухiвське УК/отг Шалигине/'),
(5921581100,	1804,	'БЕРЕЗIВСЬКА/С.БЕРЕЗА	Глухiвське УК/отг с.Береза/'),
(5910400000,	1805,	'КОНОТОП	Конотопське УК/м.Конотоп/'),
(5922000000,	1805,	'КОНОТОПСЬКИЙ РАЙОН/М.КОНОТОП	Конотопське УК/Конот.р-н/'),
(5922055300,	1805,	'отг смт Дубов’язівка	Конотоп.УК/отг смтДубов’язівка'),
(5922080400,	1805,	'отг с. Бочечки	Конотопське УК/отг с. Бочечки'),
(5922300000,	1806,	'КРАСНОПIЛЬСЬКИЙ РАЙОН/СМТ КРАСНОПIЛЛЯ	УК Краснопiль.р/Красноп.р-н/'),
(5922355100,	1806,	'отг смт Краснопілля	УК Красн.р/отг смт Краснопілля'),
(5922383300,	1806,	'МИРОПIЛЬСЬКА/С.МИРОПIЛЛЯ	УК Краснопiл.р/отг Миропілля/'),
(5922600000,	1807,	'КРОЛЕВЕЦЬКИЙ РАЙОН/М.КРОЛЕВЕЦЬ	УК Кролевець.р/Кролевецький р/'),
(5922610100,	1807,	'отг м. Кролевець	УК Кролев.р./отг м. Кролевець'),
(5910500000,	1808,	'ЛЕБЕДИН	Лебединське УК/м.Лебедин/'),
(5922900000,	1808,	'ЛЕБЕДИНСЬКИЙ РАЙОН/М.ЛЕБЕДИН	Лебединське УК/Лебедин.р-н/'),
(5923200000,	1809,	'ЛИПОВОДОЛИНСЬКИЙ РАЙОН/СМТ ЛИПОВА ДОЛИНА	УК Л-Долинськ.р/Л. Долинск.р/'),
(5923500000,	1810,	'НЕДРИГАЙЛIВСЬКИЙ РАЙОН/СМТ НЕДРИГАЙЛIВ	УК Недригайл.р/Недригайлiв.р./'),
(5923555100,	1810,	'НЕДРИГАЙЛIВ	УК Недригайл.р/отг Недр-йлів/'),
(5923583400,	1810,	'отг с. Коровинці	УК Недригайл.р/отг с.Коровинці'),
(5923584400,	1810,	'отг с. Вільшана	УК Недригайл.р/отг с. Вільшана'),
(5923800000,	1812,	'ПУТИВЛЬСЬКИЙ РАЙОН/М.ПУТИВЛЬ	УК Путивльсь.р/Путивльський р/'),
(5923886300,	1812,	'отг с. Нова Слобода	УК Пут-му.р/отг с.Н.Слобода'),
(5910700000,	1813,	'РОМНИ	Роменське УК/м.Ромни/'),
(5924100000,	1813,	'РОМЕНСЬКИЙ РАЙОН/М.РОМНИ	Роменське УК/Роменський р-н/'),
(5924400000,	1814,	'СЕРЕДИНО-БУДСЬКИЙ РАЙОН/М.СЕРЕДИНО-БУДА	УК С-Будсько.р/С-Будський.р-н/'),
(5924455300,	1814,	'ЗНОБ-НОВГОРОДСЬКЕ	УК С-Будс.р/отг Зноб-Новг-ке/'),
(5924700000,	1815,	'СУМСЬКИЙ РАЙОН/М.СУМИ	УК Сумському р/Сумський р/'),
(5924755800,	1815,	'отг смт Степанівка	УК Сумськ.р./отг смт Степ-ка'),
(5924756200,	1815,	'ХОТIНЬ	УК Сумському р/отг Хотінь/'),
(5924780900,	1815,	'БЕЗДРИЦЬКА/С.БЕЗДРИК	УК Сумському р/отг с.Бездрик/'),
(5924782900,	1815,	'отг с. Верхня Сироватка	УК Сумськ. р./отг с. В. Сир-ка'),
(5924785000,	1815,	'НИЖНЬОСИРОВАТСЬКА/С.НИЖНЯ СИРОВАТКА	УК Сумськом.р/отг Н. Сир-тка/'),
(5924785400,	1815,	'МИКОЛАЇВКА	УК Сумському р/отг с.Мик-ївка/'),
(5925000000,	1816,	'ТРОСТЯНЕЦЬКИЙ РАЙОН/М.ТРОСТЯНЕЦЬ	УК Тростянецьк.р/Тростянецьки/'),
(5925010100,	1816,	'отг м. Тростянець	УК Трост.р./отг м. Тростянець'),
(5925080800,	1816,	'БОРОМЛЯНСЬКА/С.БОРОМЛЯ	УК Тростянецьк.р/отг Боромля/'),
(5911000000,	1817,	'ШОСТКА	Шосткинське УК/м.Шостка/'),
(5925300000,	1817,	'ШОСТКИНСЬКИЙ РАЙОН/М.ШОСТКА	Шосткинське УК/Шосткинський р/'),
(5925600000,	1818,	'ЯМПIЛЬСЬКИЙ РАЙОН/СМТ ЯМПIЛЬ	УК Ямпiльському р/Ямпiльський/'),
(5925610300,	1818,	'ДРУЖБА	УК Ямпiльському р/отг Дружба/'),
(5910200000,	1854,	'ОХТИРКА	Охтирське УК/м.Охтирка/'),
(5920300000,	1854,	'ОХТИРСЬКИЙ РАЙОН/М.ОХТИРКА	Охтирське УК/Охтирський р-н/'),
(5920355500,	1854,	'отг смт Чупахівка	Охтирське УК/отг смт Чупахівка'),
(5920382400,	1854,	'ГРУНСЬКА/С.ГРУНЬ	Охтирське УК/отг с.Грунь/'),
(5920383600,	1854,	'отг с. Комиші	Охтирське УК/отг с. Комиші'),
(5920389200,	1854,	'отг с. Чернеччина	Охтирське УК/отг с. Чернеччина'),
(5910100000,	1856,	'СУМИ	УК у м.Сумах/м.Суми/')
GO


---------------------------------------------------------

;WITH CTE AS (
SELECT yr.incId, yr.subObjId,
SUM(yr.sum) as SumYear,
ISNULL(SUM(oc.OutSum), 0.00) as OutSum,
SUM(yr.sum - ISNULL(oc.OutSum, 0.00)) as RemYear
FROM YearRems yr
RIGHT OUTER JOIN (
	select  incId, SUM(SUM) as OutSum from Outcomes
	WHERE (MONTH(date) < 12) and YEAR(date) = 2017
	GROUP BY incId
) as oc
ON yr.incId = oc.incId
WHERE yr.fond = 0 AND YEAR(yr.date) = 2017
GROUP BY yr.incId, yr.subObjId
), objs AS (
	SELECT * FROM subObjs
), budgs as (
	SELECT * FROM Budgets
)
SELECT 
	DISTINCT o.budgCode, 
	CASE
		
		--WHEN CAST(BudgetCode as varchar) IS NULL  THEN 'Total'
		WHEN (CAST(o.budgCode AS varchar) IS NULL 
			AND CAST(o.subObjId AS varchar) IS NULL)
			 THEN 'Total'	
		WHEN CAST(o.subObjId AS varchar) IS NULL  THEN 'TotalBudg'
		ELSE CAST(o.subObjId AS varchar)
	END as subObjId,
	SUM(c.SumYear)	as SumYear,
	SUM(c.OutSum)	as OutSum,
	SUM(c.RemYear)	as RemYear
FROM CTE c
JOIN objs o
ON c.subObjId = o.subObjId
JOIN budgs b
ON b.budgCode = o.budgCode

GROUP BY   
	GROUPING SETS(ROLLUP(o.budgCode, o.subObjId))