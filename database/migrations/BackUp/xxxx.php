<?php

use App\Console\soMigrations;

class CreateSYSTable extends soMigrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('SYSCOM', function ($table) { // System Company

            $table->integer('SCCOMPIY')->nullable(false)->comment('System Company IY');
            $table->char('SCCOMP',50)->nullable(false)->comment('System Company Code');
            $table->char('SCNAME',100)->nullable(true)->comment('System Company Name');
            $table->longText('SCDESC')->nullable(true)->comment('System Company Description');

            $this->CreateDefaultColumns('SC', $table);

            $table->primary('SCCOMPIY');  
            $table->unique('SCCOMP');     

        }); 


        Schema::create('SYSNOR', function ($table) { // System No Running

            $table->increments('SNNOMRIY')->nullable(false)->comment('System Running No IY');
            $table->char('SNTABL',50)->nullable(false)->comment('Table Name');
            $table->integer('SNNOUR')->nullable(true)->comment('No Urut Terakhir');

            $this->CreateDefaultColumns('SN', $table);

            // $table->primary('SNNOMRIY');  // Karena Increments, Jadi sudah otomatis set Primary
            $table->unique('SNTABL');

        }); 

        Schema::create('SYSTBL', function ($table) { // System Table

            $table->integer('STTABLIY')->nullable(false)->comment('System Table IY');
            $table->char('STTABL',50)->nullable(false)->comment('Table Code');
            $table->char('STNAME',100)->nullable(true)->comment('Table Name');

            $this->CreateDefaultColumns('ST', $table);

            $table->primary('STTABLIY');  
            $table->unique('STTABL');          
             
        }); 

        Schema::create('SYSDAT', function ($table) { // System Data

            $table->integer('SDDATAIY')->nullable(false)->comment('System Running No IY');
            $table->integer('SDTABLIY')->nullable(false)->comment('System Table IY');
            $table->char('SDDATA',50)->nullable(false)->comment('Code');
            $table->char('SDNAME',100)->nullable(true)->comment('Name');

            $this->CreateDefaultColumns('SD', $table);

            $table->primary('SDDATAIY');  
            $table->unique(['SDTABLIY','SDDATA']);    
            $table->foreign('SDTABLIY')->references('STTABLIY')->on('SYSTBL');   

        }); 


        Schema::create('SYSMNU', function ($table) { // System Menu

            $table->integer('SMMENUIY')->nullable(false)->comment('System Menu IY');
            // $table->integer('SMMENUIY')->primary()->nullable(false)->comment('Menu IY');
            $table->char('SMNOMR',20)->nullable(false)->comment('Nomor Urut');
            $table->char('SMGRUP',250)->nullable(true)->comment('Kelompok Menu');
            $table->char('SMMENU',200)->nullable(false)->comment('Menu');
            $table->longText('SMDESC')->nullable(true)->comment('Menu Deskirpsi');
            $table->char('SMSCUT',20)->nullable(true)->comment('Short Cut');
            $table->char('SMACES',20)->nullable(true)->comment('Menu Akses');
            $table->integer('SMBCDT')->nullable(true)->comment('BackDate');
            $table->integer('SMFWDT')->nullable(true)->comment('ForwardDate');
            $table->char('SMURLW',200)->nullable(true)->comment('URL');
            $table->char('SMSYFG',10)->nullable(true)->comment('System Flag');
            $table->integer('SMUSCT')->nullable(true)->comment('User Hit Count');
            $table->datetime('SMLSDT')->nullable(true)->comment('User Hit Last Date');
            $table->char('SMLSBY',50)->nullable(true)->comment('User Hit Last By');
            $table->char('SMRLDT',8)->nullable(true)->comment('Release Date');
            $table->longText('SMGRID')->nullable(true)->comment('Grid Syntax');

            $this->CreateDefaultColumns('SM', $table);

            $table->primary('SMMENUIY');  
            $table->unique('SMNOMR');           

        }); 


    } 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    {  
        Schema::dropIfExists('SYSCOM'); 
        Schema::dropIfExists('SYSNOR'); 
        Schema::dropIfExists('SYSTBL'); 
        Schema::dropIfExists('SYSDAT'); 
        Schema::dropIfExists('SYSMNU'); 
    } 
} 
?> 

