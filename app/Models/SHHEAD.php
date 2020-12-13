<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $SHCOMPIY
 * @property int $SHSHNOIY
 * @property string $SHSHNO
 * @property string $SHDATE
 * @property string $SHTYPE
 * @property int $SHBPNOIY
 * @property string $SHADDR
 * @property string $SHCITY
 * @property string $SHTELP
 * @property string $SHCPER
 * @property float $SHSUBT
 * @property float $SHEXCT
 * @property float $SHTOTL
 * @property string $SHREMK
 * @property string $SHRGID
 * @property string $SHRGDT
 * @property string $SHCHID
 * @property string $SHCHDT
 * @property int $SHCHNO
 * @property boolean $SHDLFG
 * @property boolean $SHDPFG
 * @property boolean $SHPTFG
 * @property int $SHPTCT
 * @property string $SHPTID
 * @property string $SHPTDT
 * @property string $SHSRCE
 * @property string $SHUSRM
 * @property string $SHITRM
 * @property string $SHCSDT
 * @property string $SHCSID
 * @property string $SHCSNO
 * @property Mbpma $mbpma
 * @property Syscom $syscom
 */
class SHHEAD extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'SHHEAD';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'SHSHNOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['SHCOMPIY', 'SHSHNO', 'SHDATE', 'SHTYPE', 'SHBPNOIY', 'SHADDR', 'SHCITY', 'SHTELP', 'SHCPER', 'SHSUBT', 'SHEXCT', 'SHTOTL', 'SHREMK', 'SHRGID', 'SHRGDT', 'SHCHID', 'SHCHDT', 'SHCHNO', 'SHDLFG', 'SHDPFG', 'SHPTFG', 'SHPTCT', 'SHPTID', 'SHPTDT', 'SHSRCE', 'SHUSRM', 'SHITRM', 'SHCSDT', 'SHCSID', 'SHCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mbpma()
    {
        return $this->belongsTo('App\Models\Mbpma', 'SHBPNOIY', 'BPBPNOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'SHCOMPIY', 'SCCOMPIY');
    }
}
