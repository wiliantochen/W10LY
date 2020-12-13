<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $SMMENUIY
 * @property string $SMNOMR
 * @property string $SMGRUP
 * @property string $SMMENU
 * @property string $SMDESC
 * @property string $SMSCUT
 * @property string $SMACES
 * @property int $SMBCDT
 * @property int $SMFWDT
 * @property string $SMURLW
 * @property string $SMSYFG
 * @property int $SMUSCT
 * @property string $SMLSDT
 * @property string $SMLSBY
 * @property string $SMRLDT
 * @property string $SMGRID
 * @property string $SMREMK
 * @property string $SMRGID
 * @property string $SMRGDT
 * @property string $SMCHID
 * @property string $SMCHDT
 * @property int $SMCHNO
 * @property boolean $SMDLFG
 * @property boolean $SMDPFG
 * @property boolean $SMPTFG
 * @property int $SMPTCT
 * @property string $SMPTID
 * @property string $SMPTDT
 * @property string $SMSRCE
 * @property string $SMUSRM
 * @property string $SMITRM
 * @property string $SMCSDT
 * @property string $SMCSID
 * @property string $SMCSNO
 */
class SYSMNU extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'SYSMNU';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'SMMENUIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['SMNOMR', 'SMGRUP', 'SMMENU', 'SMDESC', 'SMSCUT', 'SMACES', 'SMBCDT', 'SMFWDT', 'SMURLW', 'SMSYFG', 'SMUSCT', 'SMLSDT', 'SMLSBY', 'SMRLDT', 'SMGRID', 'SMREMK', 'SMRGID', 'SMRGDT', 'SMCHID', 'SMCHDT', 'SMCHNO', 'SMDLFG', 'SMDPFG', 'SMPTFG', 'SMPTCT', 'SMPTID', 'SMPTDT', 'SMSRCE', 'SMUSRM', 'SMITRM', 'SMCSDT', 'SMCSID', 'SMCSNO'];

}
