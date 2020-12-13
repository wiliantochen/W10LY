<?php

use App\Console\soSeeder;
use App\Models\SYSMNU;
use App\Models\SYSNOR;

class SYSMNUTableSeeder extends soSeeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $i = 1;

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '01'; $SYSMNU->SMSCUT = ''; $SYSMNU->SMACES = '';
        $SYSMNU->SMURLW = ''; $SYSMNU->SMMENU = 'FILE'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0105'; $SYSMNU->SMSCUT = 'FIL005'; $SYSMNU->SMACES = 'VXL';
        $SYSMNU->SMURLW = 'TBLSLF'; $SYSMNU->SMMENU = 'LOG FILE'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();        

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0110'; $SYSMNU->SMSCUT = 'FIL010'; $SYSMNU->SMACES = 'VXL';
        $SYSMNU->SMURLW = 'TBLELF'; $SYSMNU->SMMENU = 'ERROR LOG FILE'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();    

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0115'; $SYSMNU->SMSCUT = 'FIL015'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'SYSMNU'; $SYSMNU->SMMENU = 'MENU'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();    

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0120'; $SYSMNU->SMSCUT = 'FIL020'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'TBLUSR'; $SYSMNU->SMMENU = 'USER'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();    

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '02'; $SYSMNU->SMSCUT = ''; $SYSMNU->SMACES = '';
        $SYSMNU->SMURLW = ''; $SYSMNU->SMMENU = 'MASTER'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0205'; $SYSMNU->SMSCUT = 'MAS005'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'MI1MAS'; $SYSMNU->SMMENU = 'ITEM KATEGORI'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();        

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0210'; $SYSMNU->SMSCUT = 'MAS010'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'MI2MAS'; $SYSMNU->SMMENU = 'ITEM SUB KATEGORI'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();     

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0215'; $SYSMNU->SMSCUT = 'MAS015'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'UNTMAS'; $SYSMNU->SMMENU = 'SATUAN'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0220'; $SYSMNU->SMSCUT = 'MAS020'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'MITMAS'; $SYSMNU->SMMENU = 'ITEM'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();     

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0225'; $SYSMNU->SMSCUT = 'MAS025'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'MBPMAS'; $SYSMNU->SMMENU = 'BISNIS PARTNER'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0230'; $SYSMNU->SMSCUT = 'MAS030'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'MB1MAS'; $SYSMNU->SMMENU = 'KATEGORI BIAYA'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();        

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '0235'; $SYSMNU->SMSCUT = 'MAS035'; $SYSMNU->SMACES = 'VAEDXL';
        $SYSMNU->SMURLW = 'MB2MAS'; $SYSMNU->SMMENU = 'SUB KATEGORI BIAYA'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '11'; $SYSMNU->SMSCUT = ''; $SYSMNU->SMACES = '';
        $SYSMNU->SMURLW = ''; $SYSMNU->SMMENU = 'TRANSACTION'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '1110'; $SYSMNU->SMSCUT = 'CST010'; $SYSMNU->SMACES = 'VAEDXLP';
        $SYSMNU->SMURLW = 'BHHEAD'; $SYSMNU->SMMENU = 'BIAYA'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();    

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '1120'; $SYSMNU->SMSCUT = 'PCH010'; $SYSMNU->SMACES = 'VAEDXLP';
        $SYSMNU->SMURLW = 'PHHEAD'; $SYSMNU->SMMENU = 'PEMBELIAN'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '1130'; $SYSMNU->SMSCUT = 'SLS010'; $SYSMNU->SMACES = 'VAEDXLP';
        $SYSMNU->SMURLW = 'SHHEAD'; $SYSMNU->SMMENU = 'PENJUALAN'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '70'; $SYSMNU->SMSCUT = ''; $SYSMNU->SMACES = '';
        $SYSMNU->SMURLW = ''; $SYSMNU->SMMENU = 'INFORMASI'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '7005'; $SYSMNU->SMSCUT = 'INF010'; $SYSMNU->SMACES = 'VX';
        $SYSMNU->SMURLW = 'INF_PHHEAD'; $SYSMNU->SMMENU = 'DETAIL PEMBELIAN'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '7010'; $SYSMNU->SMSCUT = 'INF020'; $SYSMNU->SMACES = 'VX';
        $SYSMNU->SMURLW = 'INF_SHHEAD'; $SYSMNU->SMMENU = 'DETAIL PENJUALAN'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '7015'; $SYSMNU->SMSCUT = 'INF030'; $SYSMNU->SMACES = 'VX';
        $SYSMNU->SMURLW = 'INF_MITTRA'; $SYSMNU->SMMENU = 'COGS'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '7020'; $SYSMNU->SMSCUT = 'INF030'; $SYSMNU->SMACES = 'VX';
        $SYSMNU->SMURLW = 'INF_BHHEAD'; $SYSMNU->SMMENU = 'DETAIL BIAYA'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '90'; $SYSMNU->SMSCUT = ''; $SYSMNU->SMACES = '';
        $SYSMNU->SMURLW = ''; $SYSMNU->SMMENU = 'UTILITY'; $SYSMNU->SMGRUP = ''; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();

        $SYSMNU = new SYSMNU();
        $SYSMNU->SMMENUIY = $i++; $SYSMNU->SMNOMR = '9005'; $SYSMNU->SMSCUT = 'INF010'; $SYSMNU->SMACES = 'VXR';
        $SYSMNU->SMURLW = 'MITTRA'; $SYSMNU->SMMENU = 'PROSES STOCK'; $SYSMNU->SMGRUP = 'FORM01'; $SYSMNU->SMDESC = ''; $SYSMNU->SMREMK = '';
        $this->setDefaultField("SM", $SYSMNU);
        $SYSMNU->save();  
// ================================================================================================================
        $RunNo = new SYSNOR();
        $RunNo->SNTABL = 'SYSMNU';
        $RunNo->SNNOUR = $i;
        $this->setDefaultField("SN", $RunNo);       
        $RunNo->save();


    }
}
