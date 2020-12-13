<?php

use App\Console\soMigrations;

class CreateMSTITEMTable extends soMigrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('MI1MAS', function ($table) {

            $table->integer('M1COMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('M1M1NOIY')->nullable(false)->comment('Item Kategori IY');
            $table->char('M1M1NO',20)->nullable(false)->comment('Code');
            $table->char('M1NAME',100)->nullable(false)->comment('Name');
            
            $this->AutoCreateDefaultColumns('M1', $table);

            $table->primary('M1M1NOIY');
            $table->unique(['M1COMPIY','M1M1NO']);    
            $table->foreign('M1COMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
           
        }); 

        Schema::create('MI2MAS', function ($table) {

            $table->integer('M2COMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('M2M2NOIY')->nullable(false)->comment('Item Sub Kategori IY');
            $table->char('M2M2NO',20)->nullable(false)->comment('Code');
            $table->char('M2NAME',100)->nullable(false)->comment('Name');
            $table->integer('M2M1NOIY')->nullable(false)->comment('Item Kategori IY');
            
            $this->AutoCreateDefaultColumns('M2', $table);

            $table->primary('M2M2NOIY');
            $table->unique(['M2COMPIY','M2M2NO']);    
            $table->foreign('M2COMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
            $table->foreign('M2M1NOIY')->references('M1M1NOIY')->on('MI1MAS'); 
           
        }); 

        Schema::create('UNTMAS', function ($table) {

            $table->integer('UMCOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('UMUNMSIY')->nullable(false)->comment('Item Satuan IY');
            $table->char('UMUNMS',20)->nullable(false)->comment('Kode Satuan');
            $table->char('UMNAME',100)->nullable(false)->comment('Nama Satuan');
            
            $this->AutoCreateDefaultColumns('UM', $table);

            $table->primary('UMUNMSIY');
            $table->unique(['UMCOMPIY','UMUNMS']);    
            $table->foreign('UMCOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
           
        }); 

        Schema::create('MITMAS', function ($table) {

            $table->integer('MMCOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('MMITNOIY')->nullable(false)->comment('Item IY');
            $table->char('MMITNO',20)->nullable(false)->comment('Item Code');
            $table->char('MMNAME',100)->nullable(false)->comment('Item Name');
            $table->char('MMDESC',200)->nullable(false)->comment('Item Description');
            $table->integer('MMM2NOIY')->nullable(false)->comment('Item Sub Kategori IY');
            $table->integer('MMUNMSIY')->nullable(false)->comment('Item Satuan IY');
            $table->decimal('MMHARG',24,10)->nullable(false)->comment('Default Price');
            $table->decimal('MMQTYS',24,10)->nullable(false)->comment('Stock Qty');
            
            $this->AutoCreateDefaultColumns('MM', $table);

            $table->primary('MMITNOIY');
            $table->unique(['MMCOMPIY','MMITNO']);    
            $table->foreign('MMCOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
            $table->foreign('MMM2NOIY')->references('M2M2NOIY')->on('MI2MAS'); 
            $table->foreign('MMUNMSIY')->references('UMUNMSIY')->on('UNTMAS'); 
           
        }); 


        Schema::create('MITTRA', function ($table) {

            $table->integer('MTCOMPIY')->nullable(false)->comment('System Company IY');
            $table->increments('MTNOMRIY')->nullable(false)->comment('System Running No IY');
            $table->integer('MTITNOIY')->nullable(false)->comment('Item IY');
            $table->char('MTTRDT',8)->nullable(true)->comment('Transaction Date');
            $table->decimal('MTTMSX',11,0)->nullable(true)->comment('Time Suffix');
            $table->char('MTMODL',5)->nullable(false)->comment('Module');

            $table->integer('MTTRNOIY')->nullable(false)->comment('Transaction IY');
            $table->char('MTTRNO',50)->nullable(false)->comment('Transaction No');
            $table->integer('MTLNNOIY')->nullable(false)->comment('Transaction Line No IY');
            $table->integer('MTLNNO')->nullable(false)->comment('Transaction Line No');

            $table->decimal('MTQTYS',24,10)->nullable(false)->comment('Qty');
            $table->decimal('MTHARG',24,10)->nullable(false)->comment('Harga');
            $table->decimal('MTTOTL',24,10)->nullable(false)->comment('Total');

            $table->decimal('MTBEFQ',24,10)->nullable(true)->comment('Qty Sebelumnya');
            $table->decimal('MTAFTQ',24,10)->nullable(false)->comment('Qty Sesudahnya');

            $table->decimal('MTAVGO',24,10)->nullable(true)->comment('Harga Lama (AVG)');
            $table->decimal('MTAVGN',24,10)->nullable(false)->comment('Harga Baru (AVG)');
            
            $this->AutoCreateDefaultColumns('MT', $table);

            $table->unique(['MTCOMPIY','MTITNOIY','MTTMSX']);    
            $table->foreign('MTITNOIY')->references('MMITNOIY')->on('MITMAS'); 
           
        }); 

        DB::unprepared("
            DROP PROCEDURE IF EXISTS StpProsesMittra;
        ");

        DB::unprepared("


CREATE PROCEDURE `StpProsesMittra`(
            IN pUSERNAME VARCHAR(50) ,
            IN pCompIY Int,
            IN pTglTrs Char(8),
            IN pITNOIY Int  
            )
BEGIN
    DECLARE vSqlStm Text ;
    DECLARE vPesan Text ;


    Set vSqlStm = '';
    Set vSqlStm = ConCat(vSqlStm,' ');
    Set vSqlStm = ConCat(vSqlStm,' Delete From MITTRA');
    Set vSqlStm = ConCat(vSqlStm,' Where MTCOMPIY = ', pCompIY );
    Set vSqlStm = ConCat(vSqlStm,'   And MTTRDT >= ', '''', pTglTrs, '''');
    IF pITNOIY <> 0 THEN
    Set vSqlStm = ConCat(vSqlStm,'   And MTITNOIY = ', pITNOIY );
    END IF;  

    SET @Sql = ConCat(vSqlStm);
    PREPARE Q_Sql FROM @Sql;
    EXECUTE Q_Sql;
    DEALLOCATE PREPARE Q_Sql;
        
          
        
    Set vSqlStm = '';
    Set vSqlStm = ConCat(vSqlStm,' ');


    Set vSqlStm = ConCat(vSqlStm,' Insert Into MITTRA (');
    Set vSqlStm = ConCat(vSqlStm,' MTCOMPIY, MTITNOIY, MTTRDT, MTTMSX, MTMODL, MTQTYS, MTHARG, MTTOTL, ');
    Set vSqlStm = ConCat(vSqlStm,' MTTRNOIY, MTTRNO, MTLNNOIY, MTLNNO,');
    Set vSqlStm = ConCat(vSqlStm,' MTBEFQ, MTAFTQ, MTAVGO, MTAVGN, MTREMK,MTITRM,');
    Set vSqlStm = ConCat(vSqlStm,' MTDPFG, MTDLFG, MTRGDT, MTRGID, MTCHDT, MTCHID, MTCHNO, MTSRCE, MTCSDT, MTCSID');
    Set vSqlStm = ConCat(vSqlStm,' )');


    Set vSqlStm = ConCat(vSqlStm,' Select ');
    Set vSqlStm = ConCat(vSqlStm,'   ''', pCompIY, ''' As MTCOMPIY');
    Set vSqlStm = ConCat(vSqlStm,' , SLITNOIY As MTITNOIY');
    Set vSqlStm = ConCat(vSqlStm,' , SHDATE As MTTRDT');
#    Set vSqlStm = ConCat(vSqlStm,' , (@row_num:=@row_num + 1) As MTTMSX');
    Set vSqlStm = ConCat(vSqlStm,' , @row_num := IF(  @key_val = ConCat(SLITNOIY,SHDATE) ,  @row_num + 1 ,(Right(SHDATE,6) * 10000) + 1) As MTTMSX');
#    Set vSqlStm = ConCat(vSqlStm,' , @row_num := IF(  @key_val = ConCat(SLITNOIY,SHDATE) ,  @row_num + 1 , 1) As MTTMSX');
#    Set vSqlStm = ConCat(vSqlStm,' , @row_num := @row_num + ((Right(SHDATE,6) * 10000) + 1) As MTTMSX');
    Set vSqlStm = ConCat(vSqlStm,' , MODL As MTMODL ');
    Set vSqlStm = ConCat(vSqlStm,' , SLQTYS As MTQTYS');
    Set vSqlStm = ConCat(vSqlStm,' , SLHARG As MTHARG');
    Set vSqlStm = ConCat(vSqlStm,' , SLTOTL As MTTOTL');

    Set vSqlStm = ConCat(vSqlStm,' , SLSHNOIY As MTTRNOIY');
    Set vSqlStm = ConCat(vSqlStm,' , SHSHNO As MTTRNO');
    Set vSqlStm = ConCat(vSqlStm,' , SLSLNOIY As MTLNNOIY');
    Set vSqlStm = ConCat(vSqlStm,' , SLSLNO As MTLNNO');

    Set vSqlStm = ConCat(vSqlStm,' , 0 As MTBEFQ');
    Set vSqlStm = ConCat(vSqlStm,' , SLQTYS As MTAFTQ');
    Set vSqlStm = ConCat(vSqlStm,' , 0 As MTAVGO');
    Set vSqlStm = ConCat(vSqlStm,' , 0 As MTAVGN');
    Set vSqlStm = ConCat(vSqlStm,' , '''' As MTREMK');
    Set vSqlStm = ConCat(vSqlStm,' , @key_val := ConCat(SLITNOIY,SHDATE) As MTITRM');
    Set vSqlStm = ConCat(vSqlStm,' , ''0'' As MTDPFG');
    Set vSqlStm = ConCat(vSqlStm,' , ''0'' As MTDLFG');
    Set vSqlStm = ConCat(vSqlStm,' , SLRGDT As MTRGDT');
    Set vSqlStm = ConCat(vSqlStm,' , SLRGID As MTRGID');
    Set vSqlStm = ConCat(vSqlStm,' , SLCHDT As MTCHDT');
    Set vSqlStm = ConCat(vSqlStm,' , SLCHID As MTCHID');
    Set vSqlStm = ConCat(vSqlStm,' , SLCHNO As MTCHNO');
    Set vSqlStm = ConCat(vSqlStm,' , ''StpProsesMITTRA'' As MTSRCE');
    Set vSqlStm = ConCat(vSqlStm,' , Now() As MTCSDT');
    Set vSqlStm = ConCat(vSqlStm,' , ''', pUSERNAME, ''' As MTCSID');
    Set vSqlStm = ConCat(vSqlStm,' From (');
    Set vSqlStm = ConCat(vSqlStm,' Select SLSLNOIY, SHDATE, SLITNOIY, -1*SLQTYS SLQTYS, SLHARG, SLTOTL ');
    Set vSqlStm = ConCat(vSqlStm,' , SLSHNOIY, SHSHNO, SLSLNO');
    Set vSqlStm = ConCat(vSqlStm,' , ''SLS'' As MODL, SLRGID, SLRGDT, SLCHID, SLCHDT, SLCHNO From SHLINE ');
    Set vSqlStm = ConCat(vSqlStm,' Left Join SHHEAD On SHSHNOIY = SLSHNOIY ');
    Set vSqlStm = ConCat(vSqlStm,' Where SHCOMPIY = ', pCompIY );
    Set vSqlStm = ConCat(vSqlStm,'   And SHDLFG = ''0'' And SLDLFG = ''0'' ');
    Set vSqlStm = ConCat(vSqlStm,'   And SHDATE >= ', '''', pTglTrs, '''');
    IF pITNOIY <> 0 THEN
    Set vSqlStm = ConCat(vSqlStm,'   And SLITNOIY = ', pITNOIY );
    END IF;  
    Set vSqlStm = ConCat(vSqlStm,' Union All ');
    Set vSqlStm = ConCat(vSqlStm,' Select PLPLNOIY, PHDATE, PLITNOIY, PLQTYS, PLHARG, PLTOTL ');
    Set vSqlStm = ConCat(vSqlStm,' , PLPHNOIY, PHPHNO, PLPLNO');
    Set vSqlStm = ConCat(vSqlStm,' , ''PCH'' As MODL, PLRGID, PLRGDT, PLCHID, PLCHDT, PLCHNO From PHLINE ');
    Set vSqlStm = ConCat(vSqlStm,' Left Join PHHEAD On PHPHNOIY = PLPHNOIY ');
    Set vSqlStm = ConCat(vSqlStm,' Where PHCOMPIY = ', pCompIY );
    Set vSqlStm = ConCat(vSqlStm,'   And PHDLFG = ''0'' And PLDLFG = ''0'' ');
    Set vSqlStm = ConCat(vSqlStm,'   And PHDATE >= ', '''', pTglTrs, '''');
    IF pITNOIY <> 0 THEN
    Set vSqlStm = ConCat(vSqlStm,'   And PLITNOIY = ', pITNOIY );
    END IF;  
    Set vSqlStm = ConCat(vSqlStm,' ) As A ');
    Set vSqlStm = ConCat(vSqlStm,' , (SELECT @row_num := 0) As R ');
    Set vSqlStm = ConCat(vSqlStm,' , (SELECT @key_val := '''') As K ');
    Set vSqlStm = ConCat(vSqlStm,' Order By SLITNOIY, SHDATE, SLRGDT ');


    SET @Sql = ConCat(vSqlStm);
    PREPARE Q_Sql FROM @Sql;
    EXECUTE Q_Sql;
    DEALLOCATE PREPARE Q_Sql;

#    Select * From MITTRA
#    Where MTDPFG = 0
#
#    Select 
#      @row_num := IF(  @key_val =ConCat(MTITNOIY,MTTRDT) ,  @row_num + 1 ,(Right(MTTRDT,6) * 10000) + 1) 
#    ,   @key_val := ConCat(MTITNOIY,MTTRDT) 
#        ,MTITNOIY, MTTRDT 
#        From MITTRA
#        , (SELECT @row_num := 0) R 
#    , (SELECT @key_val := 0) K
#    Where MTDPFG = 0
#        Order By MTITNOIY, MTTRDT, MTRGDT
        
UpDate MITTRA, (
Select 
MTNOMRIY NOMRIY
#, MTMODL, MTTRDT, MTITNOIY, MTQTYS, MTHARG, MTTOTL
, @BEQ := IF(@KEY = MTITNOIY, @AFQ, ifNull((Select B.MTAFTQ From MITTRA B Where B.MTCOMPIY = A.MTCOMPIY ANd B.MTITNOIY = A.MTITNOIY And B.MTTMSX < A.MTTMSX Order By B.MTITNOIY, B.MTTMSX Desc limit 0,1),0) ) BEFQ
#, @AFQ := IF(@KEY = MTITNOIY, @AFQ+MTQTYS, MTBEFQ+MTQTYS) AFTQ
, @AFQ := IF(@KEY = MTITNOIY, @AFQ+MTQTYS, @BEQ+MTQTYS) AFTQ
, @AVO := IF(@KEY = MTITNOIY, @AVN, ifNull((Select B.MTAVGN From MITTRA B Where B.MTCOMPIY = A.MTCOMPIY ANd B.MTITNOIY = A.MTITNOIY And B.MTTMSX < A.MTTMSX Order By B.MTITNOIY, B.MTTMSX Desc limit 0,1),0) ) AVGO
, @AVN := IF(MTMODL='SLS',@AVO,IF(@BEQ+MTQTYS = 0 , 0, ((@BEQ*@AVO)+(MTTOTL)) / (@BEQ+MTQTYS)) ) AVGN
, @KEY := MTITNOIY ITNOIY
From MITTRA A
, (Select @BEQ := 0 ) BE
, (Select @AFQ := 0 ) AF
, (Select @KEY := 0 ) K
, (Select @AVO := 0 ) O
, (Select @AVN := 0 ) N
Where  MTCOMPIY = pCompIY
#And MTITNOIY = 354
And MTDPFG = '0'
) Semua
Set MTBEFQ = BEFQ, MTAFTQ = AFTQ
, MTAVGO = AVGO, MTAVGN = AVGN
Where  MTCOMPIY = pCompIY
And MTNOMRIY = NOMRIY And MTDPFG = '0';

UpDate MITMAS
Inner Join MITTRA On MTCOMPIY = MMCOMPIY And MTNOMRIY = (
Select MTNOMRIY From MITTRA Where MTCOMPIY = pCompIY And MTDPFG = '0' And MTITNOIY = MMITNOIY Order By MTITNOIY, MTTMSX Desc Limit 0, 1
)
Set MMQTYS = ifNull(MTAFTQ,0);


Select IfNull(MTAFTQ,0), MMITNO, MTTRDT 
Into @C_QTYS, @C_BANO, @C_DATE
From MITTRA 
Left Join MITMAS On MMITNOIY = MTITNOIY 
Where  MTCOMPIY = pCompIY
And MTDPFG = '0'
And MTAFTQ < 0
limit 0,1;

if @C_QTYS < 0 then
    #Set vPesan = ConCat('Kode Barang : ', @C_BANO, '<br>', 'Pada Tanggal : ', @C_DATE, '<br>Pergerakan Stock Qty MINUS');
    Set vPesan = ConCat('Kode Barang : ', @C_BANO, ' ', 'Stock Qty MINUS Pada Tanggal : ', DATE_FORMAT(STR_TO_DATE(@C_DATE,'%Y%m%d'),'%d %M %Y'), ' ');
    SIGNAL SQLSTATE '45000'
    SET MYSQL_ERRNO = 9970, MESSAGE_TEXT = vPesan;        
end if;

UpDate MITTRA Set MTDPFG = '1'
Where  MTCOMPIY = pCompIY
And MTDPFG = '0';


/*
DROP PROCEDURE `StpProsesMittra`
Call StpProcesMittra('SysAdmin','1','20181101','0')
Select * From MITTRA

Call StpProcesMittra('SysAdmin','1','20181201','0')
Select * From MITTRA
Order By MTITNOIY, MTTMSX

Call StpProcesMittra('SysAdmin','1','20180101','0')
Select * From MITTRA
Order By MTITNOIY, MTTMSX

    Set vSqlStm = ConCat(vSqlStm,' Select ');
    Set vSqlStm = ConCat(vSqlStm,' MTCOMPIY, MTITNOIY, MTTRDT, MTTMSX, MTMODL, MTQTYS, MTHARG, MTTOTL, ');
    Set vSqlStm = ConCat(vSqlStm,' MTBEFQ, MTAFTQ, MTAVGO, MTAVGN, MTREMK,');
    Set vSqlStm = ConCat(vSqlStm,' MTDPFG, MTDLFG, MTRGDT, MTRGID, MTCHDT, MTCHID, MTCHNO, MTSRCE, MTCSDT, MTCSID');
    Set vSqlStm = ConCat(vSqlStm,' From ( ');
    Set vSqlStm = ConCat(vSqlStm,' ) A ');

ALTER TABLE SHLINE CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; 
ALTER TABLE SHHEAD CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE PHLINE CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE PHHEAD CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
ALTER TABLE MITTRA CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

ALTER TABLE SHLINE CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;   
ALTER TABLE SHHEAD CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;   
ALTER TABLE PHLINE CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;   
ALTER TABLE PHHEAD CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;   
ALTER TABLE MITTRA CONVERT TO CHARACTER SET utf8 COLLATE utf8_unicode_ci;   

*/

END



        ");


        DB::unprepared("
            DROP PROCEDURE IF EXISTS StpProsesMittraByTransaksi;
        ");

        DB::unprepared("

CREATE PROCEDURE `StpProsesMittraByTransaksi`( 
    IN pUserName VARCHAR( 50 ) ,
    IN pCompIY bigint ,
  IN pMODL varChar (10) ,
    IN pTRNOIY VarChar(10) ,
    IN pREMK Text
)
BEGIN

    /* Declare '_val' variables to read in each record from the cursor */
    Declare T_COMPIY bigint;
    Declare T_ITNOIY bigint;
    Declare T_TRDT Char(8);

    /*
    All 'DECLARE' statements must come first
    */

    /* Declare variables used just for cursor and loop control */
    DECLARE B_no_more_rows BOOLEAN;
    DECLARE no_more_rows BOOLEAN;
    DECLARE loop_cntr INT DEFAULT 0;
    DECLARE num_rows INT DEFAULT 0;

    IF pMODL = 'SLS' Then
        BLOCK1: BEGIN
        /* Declare the cursor */
        DECLARE Transasctions_Cur CURSOR FOR
            Select
            SHCOMPIY T_COMPIY, SHDATE T_TRDT, SLITNOIY T_ITNOIY
            From SHHEAD 
            Left Join SHLINE On SLSHNOIY = SHSHNOIY
            Where SHCOMPIY = pCompIY And SHSHNOIY = pTRNOIY ;
            #And SHDLFG = 0 And SLDLFG = 0 

        /* Declare 'handlers' for exceptions */
        DECLARE CONTINUE HANDLER FOR NOT FOUND
        SET no_more_rows = TRUE;

        OPEN Transasctions_Cur;
        select FOUND_ROWS() into num_rows;

        the_loop_MITTRA: LOOP

            FETCH  Transasctions_Cur
            INTO   T_COMPIY, T_TRDT, T_ITNOIY ;

            IF no_more_rows THEN
                CLOSE Transasctions_Cur;
                LEAVE the_loop_MITTRA;
            END IF;
            
            Call StpProsesMittra(pUserName, T_COMPIY, T_TRDT, T_ITNOIY);    

        END LOOP the_loop_MITTRA;
        END BLOCK1;
    elseif pMODL = 'PCH' Then
        BLOCK2: BEGIN
        /* Declare the cursor */
        DECLARE Transasctions_Cur CURSOR FOR
            Select
            PHCOMPIY T_COMPIY, PHDATE T_TRDT, PLITNOIY T_ITNOIY
            From PHHEAD 
            Left Join PHLINE On PLPHNOIY = PHPHNOIY
            Where PHCOMPIY = pCompIY And PHPHNOIY = pTRNOIY ;
            #And PHDLFG = 0 And PLDLFG = 0 
        /* Declare 'handlers' for exceptions */
        DECLARE CONTINUE HANDLER FOR NOT FOUND
        SET no_more_rows = TRUE;

        OPEN Transasctions_Cur;
        select FOUND_ROWS() into num_rows;

        the_loop_MITTRA: LOOP

            FETCH  Transasctions_Cur
            INTO   T_COMPIY, T_TRDT, T_ITNOIY ;

            IF no_more_rows THEN
                CLOSE Transasctions_Cur;
                LEAVE the_loop_MITTRA;
            END IF;
            
            Call StpProsesMittra(pUserName, T_COMPIY, T_TRDT, T_ITNOIY);          

        END LOOP the_loop_MITTRA;
        END BLOCK2;
    end if;


END;

        ");


    } 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    { 
        Schema::dropIfExists('MI1MAS'); 
        Schema::dropIfExists('MI2MAS'); 
        Schema::dropIfExists('UNTMAS'); 
        Schema::dropIfExists('MITMAS'); 
    } 
} 
?> 

