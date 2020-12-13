<?php

use App\Console\soMigrations;

class CreateMSTBISNISPARTNERTable extends soMigrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('MBPMAS', function ($table) {

            $table->integer('BPCOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('BPBPNOIY')->nullable(false)->comment('Bisnis Partner IY');
            $table->char('BPBPNO',20)->nullable(false)->comment('Code');
            $table->char('BPNAME',100)->nullable(false)->comment('Name');
            $table->char('BPSUPF',1)->nullable(false)->comment('Supplier Flag');
            $table->char('BPCUSF',1)->nullable(false)->comment('Customer Flag');
            $table->char('BPMAIL',100)->nullable(false)->comment('EMail');
            $table->char('BPCPER',100)->nullable(false)->comment('Contac Person');
            
            $this->AutoCreateDefaultColumns('BP', $table);

            $table->primary('BPBPNOIY');
            $table->unique(['BPCOMPIY','BPBPNO']);    
            $table->foreign('BPCOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
           
        }); 

        Schema::create('MBPADR', function ($table) {

            $table->integer('BACOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('BANOMRIY')->nullable(false)->comment('Nomor IY');
            $table->integer('BABPNOIY')->nullable(false)->comment('Bisnis Partner IY');
            $table->char('BACODE',20)->nullable(false)->comment('Code');
            $table->longText('BAADDR')->nullable(false)->comment('Address');
            $table->char('BACITY',50)->nullable(false)->comment('City');
            $table->char('BATELP',50)->nullable(false)->comment('Telephone');
            $table->char('BACPER',50)->nullable(false)->comment('Contact Person');
            
            $this->AutoCreateDefaultColumns('BA', $table);

            $table->primary('BANOMRIY');
            $table->unique(['BABPNOIY','BACODE']);    
            $table->foreign('BACOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
            $table->foreign('BABPNOIY')->references('BPBPNOIY')->on('MBPMAS');
           
        }); 


    } 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    { 
        Schema::dropIfExists('MBPMAS'); 
        Schema::dropIfExists('MBPADR'); 
    } 
} 
?> 

