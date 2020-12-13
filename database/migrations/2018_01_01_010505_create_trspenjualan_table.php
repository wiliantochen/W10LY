<?php

use App\Console\soMigrations;

class CreateTRSPENJUALANTable extends soMigrations
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('SHHEAD', function ($table) {

            $table->integer('SHCOMPIY')->nullable(false)->comment('System Company IY');
            $table->integer('SHSHNOIY')->nullable(false)->comment('Sales HEAD IY');
            $table->char('SHSHNO',20)->nullable(false)->comment('Transaction No');
            $table->char('SHNOTA',50)->nullable(true)->comment('Nota No');
            $table->char('SHDATE',8)->nullable(true)->comment('Transaction Date');
            $table->char('SHTYPE',20)->nullable(true)->comment('Transaction Type');
            $table->integer('SHBPNOIY')->nullable(false)->comment('Bisnis Partner IY');
            $table->longText('SHADDR')->nullable(false)->comment('Address');
            $table->char('SHCITY',50)->nullable(false)->comment('City');
            $table->char('SHTELP',50)->nullable(false)->comment('Telephone');
            $table->char('SHCPER',50)->nullable(false)->comment('Contact Person');
            $table->decimal('SHSUBT',24,10)->nullable(false)->comment('Sub Total');
            $table->decimal('SHEXCT',24,10)->nullable(false)->comment('Extra Cost');
            $table->decimal('SHTOTL',24,10)->nullable(false)->comment('Total Amount');
            
            $this->AutoCreateDefaultColumns('SH', $table);

            $table->primary('SHSHNOIY');
            $table->unique(['SHCOMPIY','SHSHNO']);    
            $table->foreign('SHCOMPIY')->references('SCCOMPIY')->on('SYSCOM'); 
            $table->foreign('SHBPNOIY')->references('BPBPNOIY')->on('MBPMAS');   
           
        }); 

        Schema::create('SHLINE', function ($table) {

            $table->integer('SLSLNOIY')->nullable(false)->comment('Sales LINE  IY');
            $table->integer('SLSLNO')->nullable(false)->comment('Nomor Urut');
            $table->integer('SLSHNOIY')->nullable(false)->comment('Sales HEAD IY');
            $table->integer('SLITNOIY')->nullable(false)->comment('Item IY');
            $table->char('SLDESC',50)->nullable(false)->comment('Item Description');
            $table->decimal('SLQTYS',24,10)->nullable(false)->comment('Qty');
            $table->decimal('SLHARG',24,10)->nullable(false)->comment('Harga');
            $table->decimal('SLTOTL',24,10)->nullable(false)->comment('Total Line Amount');
            
            $this->AutoCreateDefaultColumns('SL', $table);

            $table->primary('SLSLNOIY');
            $table->unique(['SLSHNOIY','SLSLNO']);    
            $table->foreign('SLSHNOIY')->references('SHSHNOIY')->on('SHHEAD');   
            $table->foreign('SLITNOIY')->references('MMITNOIY')->on('MITMAS');   
           
        }); 


    } 
    /** 
     * Reverse the migrations. 
     * 
     * @return void 
     */ 
    public function down() 
    { 
        Schema::dropIfExists('SHHEAD'); 
        Schema::dropIfExists('SHLINE'); 
    } 
} 
?> 

