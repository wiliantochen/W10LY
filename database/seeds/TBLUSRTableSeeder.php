<?php

use App\Console\soSeeder;
use App\Models\SYSNOR;
use App\Models\SYSMNU;
use App\Models\TBLUSR;
use App\Models\TBLUAM;

class TBLUSRTableSeeder extends soSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $iUSER = 1;


/*--------------------------------------------------------------*/
        $Admin = new TBLUSR();
        $Admin->TUUSERIY = $iUSER++;
        $Admin->TUCOMPIY = '1';
        $Admin->TUUSER = 'ADMIN';
        $Admin->TUNAME = 'ADMINISTRATOR';
        $Admin->TUPSWD = '0ebcc77dc72360d0eb8e9504c78d38bd';
        $Admin->TURGID = 'Default';
        $Admin->TURGDT = Date("Y-m-d H:i:s");
        $Admin->TUCHID = 'Default';
        $Admin->TUCHDT = Date("Y-m-d H:i:s");
        $Admin->TUCHNO = '0';
        $Admin->TUDPFG = '1';
        $Admin->TUDLFG = '0';
        $Admin->TUCSID = 'Default';
        $Admin->TUCSDT = Date("Y-m-d H:i:s");
        $Admin->TUSRCE = 'FirstSetup';
        $Admin->save();

        $DemoUser = new TBLUSR();
        $DemoUser->TUUSERIY = $iUSER++;
        $DemoUser->TUCOMPIY = '1';
        $DemoUser->TUUSER = 'DEMO';
        $DemoUser->TUNAME = 'USER DEMO';
        $DemoUser->TUPSWD = '0ebcc77dc72360d0eb8e9504c78d38bd';
        $DemoUser->TURGID = 'Default';
        $DemoUser->TURGDT = Date("Y-m-d H:i:s");
        $DemoUser->TUCHID = 'Default';
        $DemoUser->TUCHDT = Date("Y-m-d H:i:s");
        $DemoUser->TUCHNO = '0';
        $DemoUser->TUDPFG = '1';
        $DemoUser->TUDLFG = '0';
        $DemoUser->TUCSID = 'Default';
        $DemoUser->TUCSDT = Date("Y-m-d H:i:s");
        $DemoUser->TUSRCE = 'FirstSetup';
        $DemoUser->save();

/*--------------------------------------------------------------*/
        $Admin = new TBLUSR();
        $Admin->TUUSERIY = $iUSER++;
        $Admin->TUCOMPIY = '2';
        $Admin->TUUSER = 'ADMIN';
        $Admin->TUNAME = 'ADMINISTRATOR';
        $Admin->TUPSWD = '0ebcc77dc72360d0eb8e9504c78d38bd';
        $Admin->TURGID = 'Default';
        $Admin->TURGDT = Date("Y-m-d H:i:s");
        $Admin->TUCHID = 'Default';
        $Admin->TUCHDT = Date("Y-m-d H:i:s");
        $Admin->TUCHNO = '0';
        $Admin->TUDPFG = '1';
        $Admin->TUDLFG = '0';
        $Admin->TUCSID = 'Default';
        $Admin->TUCSDT = Date("Y-m-d H:i:s");
        $Admin->TUSRCE = 'FirstSetup';
        $Admin->save();


/*--------------------------------------------------------------*/
        $RunNo = new SYSNOR();
        $RunNo->SNTABL = 'TBLUSR';
        $RunNo->SNNOUR = $iUSER;
        $RunNo->SNRGID = 'Default';
        $RunNo->SNRGDT = Date("Y-m-d H:i:s");
        $RunNo->SNCHID = 'Default';
        $RunNo->SNCHDT = Date("Y-m-d H:i:s");
        $RunNo->SNCHNO = '0';
        $RunNo->SNDPFG = '1';
        $RunNo->SNDLFG = '0';
        $RunNo->SNCSID = 'Default';
        $RunNo->SNCSDT = Date("Y-m-d H:i:s");
        $RunNo->SNSRCE = 'FirstSetup';        
        $RunNo->save();
/*--------------------------------------------------------------*/


        $u = TBLUSR::all()->toArray();
        $m = SYSMNU::all()->toArray();
        $um = [];
        foreach ($u as $uKey => $uValue) {
            $dd = $u[$uKey];
            foreach ($m as $mKey => $mValue) {
                array_push($um, $u[$uKey]+$m[$mKey]);
            }
        }

        foreach ($um as $umKey => $umValue) {
            $TBLUAM = new TBLUAM();
            // $TBLUAM->TANOMRIY = '';
            $TBLUAM->TAUSERIY = $um[$umKey]['TUUSERIY'];
            $TBLUAM->TAMENUIY = $um[$umKey]['SMMENUIY'];
            $TBLUAM->TAACES = $um[$umKey]['SMACES'];
            $this->setDefaultField("TA", $TBLUAM);
            $TBLUAM->save();
        }


    }
}
