<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $SDDATAIY
 * @property int $SDTABLIY
 * @property string $SDDATA
 * @property string $SDNAME
 * @property string $SDREMK
 * @property string $SDRGID
 * @property string $SDRGDT
 * @property string $SDCHID
 * @property string $SDCHDT
 * @property int $SDCHNO
 * @property boolean $SDDLFG
 * @property boolean $SDDPFG
 * @property boolean $SDPTFG
 * @property int $SDPTCT
 * @property string $SDPTID
 * @property string $SDPTDT
 * @property string $SDSRCE
 * @property string $SDUSRM
 * @property string $SDITRM
 * @property string $SDCSDT
 * @property string $SDCSID
 * @property string $SDCSNO
 * @property Systbl $systbl
 */
class SYSDAT extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'SYSDAT';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'SDDATAIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['SDTABLIY', 'SDDATA', 'SDNAME', 'SDREMK', 'SDRGID', 'SDRGDT', 'SDCHID', 'SDCHDT', 'SDCHNO', 'SDDLFG', 'SDDPFG', 'SDPTFG', 'SDPTCT', 'SDPTID', 'SDPTDT', 'SDSRCE', 'SDUSRM', 'SDITRM', 'SDCSDT', 'SDCSID', 'SDCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function systbl()
    {
        return $this->belongsTo('App\Models\Systbl', 'SDTABLIY', 'STTABLIY');
    }
}
