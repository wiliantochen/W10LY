<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $SNNOMRIY
 * @property string $SNTABL
 * @property int $SNNOUR
 * @property string $SNREMK
 * @property string $SNRGID
 * @property string $SNRGDT
 * @property string $SNCHID
 * @property string $SNCHDT
 * @property int $SNCHNO
 * @property boolean $SNDLFG
 * @property boolean $SNDPFG
 * @property boolean $SNPTFG
 * @property int $SNPTCT
 * @property string $SNPTID
 * @property string $SNPTDT
 * @property string $SNSRCE
 * @property string $SNUSRM
 * @property string $SNITRM
 * @property string $SNCSDT
 * @property string $SNCSID
 * @property string $SNCSNO
 */
class SYSNOR extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'SYSNOR';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'SNNOMRIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['SNTABL', 'SNNOUR', 'SNREMK', 'SNRGID', 'SNRGDT', 'SNCHID', 'SNCHDT', 'SNCHNO', 'SNDLFG', 'SNDPFG', 'SNPTFG', 'SNPTCT', 'SNPTID', 'SNPTDT', 'SNSRCE', 'SNUSRM', 'SNITRM', 'SNCSDT', 'SNCSID', 'SNCSNO'];

}
