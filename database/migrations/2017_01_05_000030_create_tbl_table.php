<?php

use App\Console\soMigrations;

class CreateTBLTable extends soMigrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('TBLSLF', function ($table) {
            $table->integer('TQCOMPIY')->nullable(false)->comment('System Company IY');
            $table->increments('TQNOMRIY')->nullable(false)->comment('NoUrut IY');
            $table->char('TQUSER',50)->nullable(false)->comment('User');
            $table->longText('TQSTMT')->nullable(false)->comment('Sql Statement');
            $this->AutoCreateDefaultColumns('TQ', $table);
            $table->foreign('TQCOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
        }); 

        Schema::create('TBLELF', function ($table) {
            $table->integer('TECOMPIY')->nullable(false)->comment('System Company IY');
            $table->increments('TENOMRIY')->nullable(false)->comment('NoUrut IY');
            $table->char('TEUSER',50)->nullable(false)->comment('User');
            $table->char('TEERNO',50)->nullable(false)->comment('Error No');
            $table->char('TEERST',50)->nullable(false)->comment('Error State');
            $table->longText('TEERMS')->nullable(false)->comment('Error Message');
            $table->char('TESPTR',100)->nullable(false)->comment('Stored Procedure Type');
            $table->longText('TESTMT')->nullable(false)->comment('Sql Statement');
            $this->AutoCreateDefaultColumns('TE', $table);
            $table->foreign('TECOMPIY')->references('SCCOMPIY')->on('SYSCOM');             
        }); 

        Schema::create('TBLUSR', function ($table) {

            $table->integer('TUCOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('TUUSERIY')->nullable(false)->comment('User IY');
            // $table->integer('TUUSERIY')->primary()->nullable(false)->comment('User IY');
            $table->char('TUUSER',50)->nullable(false)->comment('User Login');
            $table->char('TUNAME',100)->nullable(true)->comment('User Name');
            $table->char('TUPSWD',100)->nullable(true)->comment('Password');
            $table->char('TUEMID',20)->nullable(true)->comment('Employee ID');
            $table->char('TUDEPT',100)->nullable(true)->comment('Department');
            $table->char('TUMAIL',100)->nullable(true)->comment('Mail');
            $table->longText('TUWELC')->nullable(true)->comment('Welcome Text');
            $table->boolean('TUEXPP')->nullable(true)->comment('Expired');
            $table->char('TUEXPD',8)->nullable(true)->comment('Expired Date');
            $table->integer('TUEXPV')->nullable(true)->default(((3)))->comment('Expired Value');
            $table->integer('TULGCT')->nullable(true)->default(((0)))->comment('Login Counter');
            $table->datetime('TULSLI')->nullable(true)->comment('Last Login');
            $table->datetime('TULSLO')->nullable(true)->comment('Last Logoff');
            $table->binary('TUFOTO')->nullable(true)->comment('Avatar');

            $this->AutoCreateDefaultColumns('TU', $table);

            $table->primary('TUUSERIY');  
            $table->unique(['TUCOMPIY','TUUSER']);          
            $table->foreign('TUCOMPIY')->references('SCCOMPIY')->on('SYSCOM');             

        }); 

        Schema::create('TBLUAM', function ($table) {

            $table->increments('TANOMRIY')->nullable(false)->comment('IY'); // ini sudah primary karena increments
            $table->integer('TAUSERIY')->nullable(false)->comment('TBLUSR IY');
            $table->integer('TAMENUIY')->nullable(false)->comment('TBLMNU IY');
            $table->char('TAACES',20)->nullable(true)->comment('Access Menu');
            $table->datetime('TALSDT')->nullable(true)->comment('Last Date Use');
            $table->integer('TAUSCT')->nullable(true)->comment('Use Count');

            $this->AutoCreateDefaultColumns('TA', $table);

            // $table->primary(['TACOMSIY','TAUSERIY','TAMENUIY']);  
            $table->unique(array('TAUSERIY', 'TAMENUIY'));
            $table->foreign('TAUSERIY')->references('TUUSERIY')->on('TBLUSR');
            $table->foreign('TAMENUIY')->references('SMMENUIY')->on('SYSMNU');    
            // $table->foreign('TACOMSIY')->references('SCCOMSIY')->on('SYSCOM');
            // $table->foreign(array('TACOMSIY','TAUSERIY'))->references(array('TUCOMSIY','TUUSERIY'))->on('TBLUSR');  
            // $table->foreign(array('TACOMSIY','TAMENUIY'))->references(array('TMCOMSIY','TMMENUIY'))->on('TBLMNU');  
        }); 

        Schema::create('TBLTRN', function ($table) {
            $table->integer('TRCOMPIY')->nullable(false)->comment('System Company IY');
            $table->increments('TRNOMRIY')->nullable(false)->comment('NoUrut IY');
            $table->char('TRDCNO',50)->nullable(true)->comment('Document No');
            $table->char('TRSWNO',50)->nullable(true)->comment('Show No');
            $table->integer('TRRNNO')->nullable(false)->comment('Running No');
            
            $this->AutoCreateDefaultColumns('TR', $table);

            $table->foreign('TRCOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
            $table->unique(array('TRCOMPIY', 'TRDCNO'));
        });


    } 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    {  
        Schema::dropIfExists('TBLSLF'); 
        Schema::dropIfExists('TBLELF'); 
        Schema::dropIfExists('TBLUSR'); 
        Schema::dropIfExists('TBLUAM'); 
    } 
} 
?> 

