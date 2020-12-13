<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $PHCOMPIY
 * @property int $PHPHNOIY
 * @property string $PHPHNO
 * @property string $PHDATE
 * @property string $PHTYPE
 * @property int $PHBPNOIY
 * @property string $PHADDR
 * @property string $PHCITY
 * @property string $PHTELP
 * @property string $PHCPER
 * @property float $PHSUBT
 * @property float $PHEXCT
 * @property float $PHTOTL
 * @property string $PHREMK
 * @property string $PHRGID
 * @property string $PHRGDT
 * @property string $PHCHID
 * @property string $PHCHDT
 * @property int $PHCHNO
 * @property boolean $PHDLFG
 * @property boolean $PHDPFG
 * @property boolean $PHPTFG
 * @property int $PHPTCT
 * @property string $PHPTID
 * @property string $PHPTDT
 * @property string $PHSRCE
 * @property string $PHUSRM
 * @property string $PHITRM
 * @property string $PHCSDT
 * @property string $PHCSID
 * @property string $PHCSNO
 * @property Mbpma $mbpma
 * @property Syscom $syscom
 */
class PHHEAD extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'PHHEAD';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'PHPHNOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['PHCOMPIY', 'PHPHNO', 'PHDATE', 'PHTYPE', 'PHBPNOIY', 'PHADDR', 'PHCITY', 'PHTELP', 'PHCPER', 'PHSUBT', 'PHEXCT', 'PHTOTL', 'PHREMK', 'PHRGID', 'PHRGDT', 'PHCHID', 'PHCHDT', 'PHCHNO', 'PHDLFG', 'PHDPFG', 'PHPTFG', 'PHPTCT', 'PHPTID', 'PHPTDT', 'PHSRCE', 'PHUSRM', 'PHITRM', 'PHCSDT', 'PHCSID', 'PHCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mbpma()
    {
        return $this->belongsTo('App\Models\Mbpma', 'PHBPNOIY', 'BPBPNOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'PHCOMPIY', 'SCCOMPIY');
    }
}
