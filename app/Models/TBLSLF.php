<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $TQCOMPIY
 * @property int $TQNOMRIY
 * @property string $TQUSER
 * @property string $TQSTMT
 * @property string $TQREMK
 * @property string $TQRGID
 * @property string $TQRGDT
 * @property string $TQCHID
 * @property string $TQCHDT
 * @property int $TQCHNO
 * @property boolean $TQDLFG
 * @property boolean $TQDPFG
 * @property boolean $TQPTFG
 * @property int $TQPTCT
 * @property string $TQPTID
 * @property string $TQPTDT
 * @property string $TQSRCE
 * @property string $TQUSRM
 * @property string $TQITRM
 * @property string $TQCSDT
 * @property string $TQCSID
 * @property string $TQCSNO
 * @property Syscom $syscom
 */
class TBLSLF extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'TBLSLF';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'TQNOMRIY';

    /**
     * @var array
     */
    protected $fillable = ['TQCOMPIY', 'TQUSER', 'TQSTMT', 'TQREMK', 'TQRGID', 'TQRGDT', 'TQCHID', 'TQCHDT', 'TQCHNO', 'TQDLFG', 'TQDPFG', 'TQPTFG', 'TQPTCT', 'TQPTID', 'TQPTDT', 'TQSRCE', 'TQUSRM', 'TQITRM', 'TQCSDT', 'TQCSID', 'TQCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'TQCOMPIY', 'SCCOMPIY');
    }
}
