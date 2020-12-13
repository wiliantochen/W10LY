<?php

use App\Console\soSeeder;
use App\Models\SYSCOM;
use App\Models\SYSTBL;
use App\Models\SYSDAT;
use App\Models\SYSNOR;

class SYSTableSeeder extends soSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);


/*--------------------------------------------------------------*/
        $SYSCOM = new SYSCOM();
        $SYSCOM->SCCOMPIY = '1';
        $SYSCOM->SCCOMP = 'DEMO';
        $SYSCOM->SCNAME = 'DEMO NAME';
        $SYSCOM->SCDESC = 'DEMO DESCRIPTION';
        $this->setDefaultField("SC", $SYSCOM);
        $SYSCOM->save();

        $SYSCOM = new SYSCOM();
        $SYSCOM->SCCOMPIY = '2';
        $SYSCOM->SCCOMP = 'WEXITS';
        $SYSCOM->SCNAME = 'WEXITS NAME';
        $SYSCOM->SCDESC = 'WEXITS DESCRIPTION';
        $this->setDefaultField("SC", $SYSCOM);
        $SYSCOM->save();
/*--------------------------------------------------------------*/


        $iTBL = 1;
        $iDAT = 1;

/*--------------------------------------------------------------*/
        $SYSTBL = new SYSTBL();
        $SYSTBL->STTABLIY = $iTBL++;
        $SYSTBL->STTABL = 'YN';
        $SYSTBL->STNAME = 'YESNO';
        $this->setDefaultField("ST", $SYSTBL);
        $SYSTBL->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = '1';
        $SYSDAT->SDNAME = 'YES';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = '0';
        $SYSDAT->SDNAME = 'NO';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();
/*--------------------------------------------------------------*/

        $SYSTBL = new SYSTBL();
        $SYSTBL->STTABLIY = $iTBL++;
        $SYSTBL->STTABL = 'DSPLY';
        $SYSTBL->STNAME = 'DISPLAY';
        $this->setDefaultField("ST", $SYSTBL);
        $SYSTBL->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = '0';
        $SYSDAT->SDNAME = 'Not Display';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = '1';
        $SYSDAT->SDNAME = 'Display';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();
/*--------------------------------------------------------------*/

        $SYSTBL = new SYSTBL();
        $SYSTBL->STTABLIY = $iTBL++;
        $SYSTBL->STTABL = 'CC';
        $SYSTBL->STNAME = 'CASH CREDIT';
        $this->setDefaultField("ST", $SYSTBL);
        $SYSTBL->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'T';
        $SYSDAT->SDNAME = 'TUNAI';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'K';
        $SYSDAT->SDNAME = 'KREDIT';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();
/*--------------------------------------------------------------*/

        $SYSTBL = new SYSTBL();
        $SYSTBL->STTABLIY = $iTBL++;
        $SYSTBL->STTABL = 'MODE';
        $SYSTBL->STNAME = 'Mode Access';
        $this->setDefaultField("ST", $SYSTBL);
        $SYSTBL->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'V';
        $SYSDAT->SDNAME = 'View';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'A';
        $SYSDAT->SDNAME = 'Add';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'E';
        $SYSDAT->SDNAME = 'Edit';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'D';
        $SYSDAT->SDNAME = 'Delete';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'L';
        $SYSDAT->SDNAME = 'View List';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'X';
        $SYSDAT->SDNAME = 'Export To Excel';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();

        $SYSDAT = new SYSDAT();
        $SYSDAT->SDTABLIY = ($iTBL-1);
        $SYSDAT->SDDATAIY = $iDAT++;
        $SYSDAT->SDDATA = 'R';
        $SYSDAT->SDNAME = 'Confirm / Approved';
        $this->setDefaultField("SD", $SYSDAT);
        $SYSDAT->save();
/*--------------------------------------------------------------*/

        $RunNoDSC = new SYSNOR();
        $RunNoDSC->SNTABL = 'SYSTBL';
        $RunNoDSC->SNNOUR = $iTBL;
        $this->setDefaultField("SN", $RunNoDSC);       
        $RunNoDSC->save();

        $RunNoSYS = new SYSNOR();
        $RunNoSYS->SNTABL = 'SYSDAT';
        $RunNoSYS->SNNOUR = $iDAT;
        $this->setDefaultField("SN", $RunNoSYS);      
        $RunNoSYS->save();
/*--------------------------------------------------------------*/

    }
}
