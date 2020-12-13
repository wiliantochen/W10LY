<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $MMCOMPIY
 * @property int $MMITNOIY
 * @property string $MMITNO
 * @property string $MMNAME
 * @property string $MMDESC
 * @property int $MMM2NOIY
 * @property int $MMUNMSIY
 * @property float $MMHARG
 * @property float $MMQTYS
 * @property string $MMREMK
 * @property string $MMRGID
 * @property string $MMRGDT
 * @property string $MMCHID
 * @property string $MMCHDT
 * @property int $MMCHNO
 * @property boolean $MMDLFG
 * @property boolean $MMDPFG
 * @property boolean $MMPTFG
 * @property int $MMPTCT
 * @property string $MMPTID
 * @property string $MMPTDT
 * @property string $MMSRCE
 * @property string $MMUSRM
 * @property string $MMITRM
 * @property string $MMCSDT
 * @property string $MMCSID
 * @property string $MMCSNO
 * @property Untma $untma
 * @property Syscom $syscom
 * @property Mi2ma $mi2ma
 */
class MITMAS extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'MITMAS';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'MMITNOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['MMCOMPIY', 'MMITNO', 'MMNAME', 'MMDESC', 'MMM2NOIY', 'MMUNMSIY', 'MMHARG', 'MMQTYS', 'MMREMK', 'MMRGID', 'MMRGDT', 'MMCHID', 'MMCHDT', 'MMCHNO', 'MMDLFG', 'MMDPFG', 'MMPTFG', 'MMPTCT', 'MMPTID', 'MMPTDT', 'MMSRCE', 'MMUSRM', 'MMITRM', 'MMCSDT', 'MMCSID', 'MMCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function untma()
    {
        return $this->belongsTo('App\Models\Untma', 'MMUNMSIY', 'UMUNMSIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'MMCOMPIY', 'SCCOMPIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mi2ma()
    {
        return $this->belongsTo('App\Models\Mi2ma', 'MMM2NOIY', 'M2M2NOIY');
    }
}
