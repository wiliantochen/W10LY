<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $STTABLIY
 * @property string $STTABL
 * @property string $STNAME
 * @property string $STREMK
 * @property string $STRGID
 * @property string $STRGDT
 * @property string $STCHID
 * @property string $STCHDT
 * @property int $STCHNO
 * @property boolean $STDLFG
 * @property boolean $STDPFG
 * @property boolean $STPTFG
 * @property int $STPTCT
 * @property string $STPTID
 * @property string $STPTDT
 * @property string $STSRCE
 * @property string $STUSRM
 * @property string $STITRM
 * @property string $STCSDT
 * @property string $STCSID
 * @property string $STCSNO
 */
class SYSTBL extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'SYSTBL';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'STTABLIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['STTABL', 'STNAME', 'STREMK', 'STRGID', 'STRGDT', 'STCHID', 'STCHDT', 'STCHNO', 'STDLFG', 'STDPFG', 'STPTFG', 'STPTCT', 'STPTID', 'STPTDT', 'STSRCE', 'STUSRM', 'STITRM', 'STCSDT', 'STCSID', 'STCSNO'];

}
