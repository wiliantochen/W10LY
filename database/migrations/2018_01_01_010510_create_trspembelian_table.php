<?php

use App\Console\soMigrations;

class CreateTRSPEMBELIANTable extends soMigrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('PHHEAD', function ($table) {

            $table->integer('PHCOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('PHPHNOIY')->nullable(false)->comment('Purchase HEAD IY');
            $table->char('PHPHNO',20)->nullable(false)->comment('Transaction No');
            $table->char('PHNOTA',50)->nullable(true)->comment('Nota No');
            $table->char('PHDATE',8)->nullable(true)->comment('Transaction Date');
            $table->char('PHTYPE',20)->nullable(true)->comment('Transaction Type');
            $table->integer('PHBPNOIY')->nullable(false)->comment('Bisnis Partner IY');
            $table->longText('PHADDR')->nullable(false)->comment('Address');
            $table->char('PHCITY',50)->nullable(false)->comment('City');
            $table->char('PHTELP',50)->nullable(false)->comment('Telephone');
            $table->char('PHCPER',50)->nullable(false)->comment('Contact Person');
            $table->decimal('PHSUBT',24,10)->nullable(false)->comment('Sub Total');
            $table->decimal('PHEXCT',24,10)->nullable(false)->comment('Extra Cost');
            $table->decimal('PHTOTL',24,10)->nullable(false)->comment('Total Amount');
            
            $this->AutoCreateDefaultColumns('PH', $table);

            $table->primary('PHPHNOIY');
            $table->unique(['PHCOMPIY','PHPHNO']);    
            $table->foreign('PHCOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
            $table->foreign('PHBPNOIY')->references('BPBPNOIY')->on('MBPMAS');   
           
        }); 

        Schema::create('PHLINE', function ($table) {

            $table->integer('PLPLNOIY')->nullable(false)->comment('Purchase LINE  IY');
            $table->integer('PLPLNO')->nullable(false)->comment('Nomor Urut');
            $table->integer('PLPHNOIY')->nullable(false)->comment('Purchase HEAD IY');
            $table->integer('PLITNOIY')->nullable(false)->comment('Item IY');
            $table->char('PLDESC',50)->nullable(false)->comment('Item Description');
            $table->decimal('PLQTYS',24,10)->nullable(false)->comment('Qty');
            $table->decimal('PLHARG',24,10)->nullable(false)->comment('Harga');
            $table->decimal('PLTOTL',24,10)->nullable(false)->comment('Total Line Amount');
            
            $this->AutoCreateDefaultColumns('PL', $table);

            $table->primary('PLPLNOIY');
            $table->unique(['PLPHNOIY','PLPLNO']);    
            $table->foreign('PLPHNOIY')->references('PHPHNOIY')->on('PHHEAD');   
            $table->foreign('PLITNOIY')->references('MMITNOIY')->on('MITMAS');   
           
        }); 


    } 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    { 
        Schema::dropIfExists('PHHEAD'); 
        Schema::dropIfExists('PHLINE'); 
    } 
} 
?> 

