<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $SCCOMPIY
 * @property string $SCCOMP
 * @property string $SCNAME
 * @property string $SCDESC
 * @property string $SCREMK
 * @property string $SCRGID
 * @property string $SCRGDT
 * @property string $SCCHID
 * @property string $SCCHDT
 * @property int $SCCHNO
 * @property boolean $SCDLFG
 * @property boolean $SCDPFG
 * @property boolean $SCPTFG
 * @property int $SCPTCT
 * @property string $SCPTID
 * @property string $SCPTDT
 * @property string $SCSRCE
 * @property string $SCUSRM
 * @property string $SCITRM
 * @property string $SCCSDT
 * @property string $SCCSID
 * @property string $SCCSNO
 */
class SYSCOM extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'SYSCOM';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'SCCOMPIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['SCCOMP', 'SCNAME', 'SCDESC', 'SCREMK', 'SCRGID', 'SCRGDT', 'SCCHID', 'SCCHDT', 'SCCHNO', 'SCDLFG', 'SCDPFG', 'SCPTFG', 'SCPTCT', 'SCPTID', 'SCPTDT', 'SCSRCE', 'SCUSRM', 'SCITRM', 'SCCSDT', 'SCCSID', 'SCCSNO'];

}
