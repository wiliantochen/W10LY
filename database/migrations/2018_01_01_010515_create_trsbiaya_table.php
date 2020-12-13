<?php

use App\Console\soMigrations;

class CreateTRSBIAYATable extends soMigrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('BHHEAD', function ($table) {

            $table->integer('BHCOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('BHBHNOIY')->nullable(false)->comment('Biaya HEAD IY');
            $table->char('BHBHNO',20)->nullable(false)->comment('Transaction No');
            $table->char('BHNOTA',50)->nullable(true)->comment('Nota No');
            $table->longText('BHDESC')->nullable(true)->comment('Deksripsi Biaya');
            $table->char('BHDATE',8)->nullable(true)->comment('Transaction Date');
            $table->decimal('BHTOTL',24,10)->nullable(false)->comment('Total Amount');
            
            $this->AutoCreateDefaultColumns('BH', $table);

            $table->primary('BHBHNOIY');
            $table->unique(['BHCOMPIY','BHBHNO']);    
            $table->foreign('BHCOMPIY')->references('SCCOMPIY')->on('SYSCOM');   
           
        }); 

        Schema::create('BHLINE', function ($table) {

            $table->integer('BLBLNOIY')->nullable(false)->comment('Biaya LINE  IY');
            $table->integer('BLBLNO')->nullable(false)->comment('Nomor Urut');
            $table->integer('BLBHNOIY')->nullable(false)->comment('Biaya HEAD IY');
            $table->integer('BLB2NOIY')->nullable(false)->comment('Item IY');
            $table->char('BLDESC',50)->nullable(false)->comment('Item Description');
            $table->decimal('BLTOTL',24,10)->nullable(false)->comment('Total Line Amount');
            
            $this->AutoCreateDefaultColumns('BL', $table);

            $table->primary('BLBLNOIY');
            $table->unique(['BLBHNOIY','BLBLNO']);    
            $table->foreign('BLBHNOIY')->references('BHBHNOIY')->on('BHHEAD');   
            $table->foreign('BLB2NOIY')->references('B2B2NOIY')->on('MB2MAS');   
           
        }); 


    } 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    { 
        Schema::dropIfExists('BHHEAD'); 
        Schema::dropIfExists('BHLINE'); 
    } 
} 
?> 

