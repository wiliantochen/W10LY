<?php

use App\Console\soSeeder;
use App\Models\MI1MAS;
use App\Models\MI2MAS;
use App\Models\MITMAS;
use App\Models\UNTMAS;
use App\Models\SYSNOR;

class OTHERTableSeeder extends soSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        return;
        
        // $this->call(UsersTableSeeder::class);
        $iM1 = 1;
        $iM2 = 1;
        $iMM = 1;
        $iUM = 1;

        $UNTMAS = new UNTMAS();
        $UNTMAS->UMCOMPIY = 1;
        $UNTMAS->UMUNMSIY = $iUM++;
        $UNTMAS->UMUNMS = 'GR';
        $UNTMAS->UMNAME = 'GRAM';
        $this->setDefaultField("UM", $UNTMAS);
        $UNTMAS->save();

        $UNTMAS = new UNTMAS();
        $UNTMAS->UMCOMPIY = 1;
        $UNTMAS->UMUNMSIY = $iUM++;
        $UNTMAS->UMUNMS = 'KG';
        $UNTMAS->UMNAME = 'KILOGRAM';
        $this->setDefaultField("UM", $UNTMAS);
        $UNTMAS->save();

        $UNTMAS = new UNTMAS();
        $UNTMAS->UMCOMPIY = 1;
        $UNTMAS->UMUNMSIY = $iUM++;
        $UNTMAS->UMUNMS = 'ML';
        $UNTMAS->UMNAME = 'MILLILITTRE';
        $this->setDefaultField("UM", $UNTMAS);
        $UNTMAS->save();

        $UNTMAS = new UNTMAS();
        $UNTMAS->UMCOMPIY = 1;
        $UNTMAS->UMUNMSIY = $iUM++;
        $UNTMAS->UMUNMS = 'LTR';
        $UNTMAS->UMNAME = 'LITTER';
        $this->setDefaultField("UM", $UNTMAS);
        $UNTMAS->save();

/*--------------------------------------------------------------*/

        $MI1MAS = new MI1MAS();
        $MI1MAS->M1COMPIY = 1;
        $MI1MAS->M1M1NOIY = $iM1++;
        $MI1MAS->M1M1NO = 'MAK001';
        $MI1MAS->M1NAME = 'MAKANAN';
        $this->setDefaultField("M1", $MI1MAS);
        $MI1MAS->save();

            $MI2MAS = new MI2MAS();
            $MI2MAS->M2COMPIY = 1;
            $MI2MAS->M2M1NOIY = ($iM1-1);
            $MI2MAS->M2M2NOIY = $iM2++;
            $MI2MAS->M2M2NO = 'TAR001';
            $MI2MAS->M2NAME = 'TARO';
            $this->setDefaultField("M2", $MI2MAS);
            $MI2MAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 1;
                $MITMAS->MMITNO = 'TAR001';
                $MITMAS->MMNAME = 'TARO 250 GRM';
                $MITMAS->MMDESC = 'TARO 250 Gram';
                $MITMAS->MMHARG = '2000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 1;
                $MITMAS->MMITNO = 'TAR002';
                $MITMAS->MMNAME = 'TARO 500 GRM';
                $MITMAS->MMDESC = 'TARO 500 Gram';
                $MITMAS->MMHARG = '5000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 2;
                $MITMAS->MMITNO = 'TAR003';
                $MITMAS->MMNAME = 'TARO 1 Kg';
                $MITMAS->MMDESC = 'TARO 1 KiloGram';
                $MITMAS->MMHARG = '8000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();


            $MI2MAS = new MI2MAS();
            $MI2MAS->M2COMPIY = 1;
            $MI2MAS->M2M1NOIY = ($iM1-1);
            $MI2MAS->M2M2NOIY = $iM2++;
            $MI2MAS->M2M2NO = 'LAY001';
            $MI2MAS->M2NAME = 'LAYS';
            $this->setDefaultField("M2", $MI2MAS);
            $MI2MAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 1;
                $MITMAS->MMITNO = 'LAY001';
                $MITMAS->MMNAME = 'LAYS 250 GRM';
                $MITMAS->MMDESC = 'LAYS 250 Gram';
                $MITMAS->MMHARG = '3000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 1;                
                $MITMAS->MMITNO = 'LAY002';
                $MITMAS->MMNAME = 'LAYS 500 GRM';
                $MITMAS->MMDESC = 'LAYS 500 Gram';
                $MITMAS->MMHARG = '7000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 2;                
                $MITMAS->MMITNO = 'LAY003';
                $MITMAS->MMNAME = 'LAYS 1 Kg';
                $MITMAS->MMDESC = 'LAYS 1 KiloGram';
                $MITMAS->MMHARG = '12000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();


        $MI1MAS = new MI1MAS();
        $MI1MAS->M1M1NOIY = $iM1++;
        $MI1MAS->M1COMPIY = 1;
        $MI1MAS->M1M1NO = 'MIN001';
        $MI1MAS->M1NAME = 'MINUMAN';
        $this->setDefaultField("M1", $MI1MAS);
        $MI1MAS->save();



            $MI2MAS = new MI2MAS();
            $MI2MAS->M2COMPIY = 1;
            $MI2MAS->M2M1NOIY = ($iM1-1);
            $MI2MAS->M2M2NOIY = $iM2++;
            $MI2MAS->M2M2NO = 'AQU001';
            $MI2MAS->M2NAME = 'AQUA';
            $this->setDefaultField("M2", $MI2MAS);
            $MI2MAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 3;
                $MITMAS->MMITNO = 'AQU001';
                $MITMAS->MMNAME = 'AQUA 200 ML';
                $MITMAS->MMDESC = 'AQUA 200 Millilitre';
                $MITMAS->MMHARG = '1500';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 3;
                $MITMAS->MMITNO = 'AQU002';
                $MITMAS->MMNAME = 'AQUA 600 ML';
                $MITMAS->MMDESC = 'AQUA 600 Millilitre';
                $MITMAS->MMHARG = '4000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 4;
                $MITMAS->MMITNO = 'AQU003';
                $MITMAS->MMNAME = 'AQUA 1.5 Ltr';
                $MITMAS->MMDESC = 'AQUA 1.5 Litter';
                $MITMAS->MMHARG = '6000';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();


            $MI2MAS = new MI2MAS();
            $MI2MAS->M2COMPIY = 1;
            $MI2MAS->M2M1NOIY = ($iM1-1);
            $MI2MAS->M2M2NOIY = $iM2++;
            $MI2MAS->M2M2NO = 'ULT001';
            $MI2MAS->M2NAME = 'ULTRA MILK';
            $this->setDefaultField("M2", $MI2MAS);
            $MI2MAS->save();

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 3;
                $MITMAS->MMITNO = 'ULT101';
                $MITMAS->MMNAME = 'ULTRA MILK COKLAT 250 ML';
                $MITMAS->MMDESC = 'ULTRA MILK COKLAT 250 Millilitre';
                $MITMAS->MMHARG = '3500';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();               

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 3;
                $MITMAS->MMITNO = 'ULT102';
                $MITMAS->MMNAME = 'ULTRA MILK STRAWBERRY 250 ML';
                $MITMAS->MMDESC = 'ULTRA MILK STRAWBERRY 250 Millilitre';
                $MITMAS->MMHARG = '3600';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();        

                $MITMAS = new MITMAS();
                $MITMAS->MMCOMPIY = 1;
                $MITMAS->MMM2NOIY = ($iM2-1);
                $MITMAS->MMITNOIY = $iMM++;
                $MITMAS->MMUNMSIY = 3;
                $MITMAS->MMITNO = 'ULT103';
                $MITMAS->MMNAME = 'ULTRA MILK VANILLA 250 ML';
                $MITMAS->MMDESC = 'ULTRA MILK VANILLA 250 Millilitre';
                $MITMAS->MMHARG = '3400';
                $MITMAS->MMQTYS = '0';
                $this->setDefaultField("MM", $MITMAS);
                $MITMAS->save();                                         
/*--------------------------------------------------------------*/


/*--------------------------------------------------------------*/

        $RunNoSYS = new SYSNOR();
        $RunNoSYS->SNTABL = 'MI1MAS';
        $RunNoSYS->SNNOUR = $iM1;
        $this->setDefaultField("SN", $RunNoSYS);
        $RunNoSYS->save();

        $RunNoSYS = new SYSNOR();
        $RunNoSYS->SNTABL = 'MI2MAS';
        $RunNoSYS->SNNOUR = $iM2;
        $this->setDefaultField("SN", $RunNoSYS);
        $RunNoSYS->save();

        $RunNoSYS = new SYSNOR();
        $RunNoSYS->SNTABL = 'MITMAS';
        $RunNoSYS->SNNOUR = $iMM;
        $this->setDefaultField("SN", $RunNoSYS);
        $RunNoSYS->save();

        $RunNoSYS = new SYSNOR();
        $RunNoSYS->SNTABL = 'UNTMAS';
        $RunNoSYS->SNNOUR = $iUM;
        $this->setDefaultField("SN", $RunNoSYS);
        $RunNoSYS->save();        
/*--------------------------------------------------------------*/


    }
}
