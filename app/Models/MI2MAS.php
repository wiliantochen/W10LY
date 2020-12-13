<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $M2COMPIY
 * @property int $M2M2NOIY
 * @property string $M2M2NO
 * @property string $M2NAME
 * @property int $M2M1NOIY
 * @property string $M2REMK
 * @property string $M2RGID
 * @property string $M2RGDT
 * @property string $M2CHID
 * @property string $M2CHDT
 * @property int $M2CHNO
 * @property boolean $M2DLFG
 * @property boolean $M2DPFG
 * @property boolean $M2PTFG
 * @property int $M2PTCT
 * @property string $M2PTID
 * @property string $M2PTDT
 * @property string $M2SRCE
 * @property string $M2USRM
 * @property string $M2ITRM
 * @property string $M2CSDT
 * @property string $M2CSID
 * @property string $M2CSNO
 * @property Mi1ma $mi1ma
 * @property Syscom $syscom
 */
class MI2MAS extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'MI2MAS';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'M2M2NOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['M2COMPIY', 'M2M2NO', 'M2NAME', 'M2M1NOIY', 'M2REMK', 'M2RGID', 'M2RGDT', 'M2CHID', 'M2CHDT', 'M2CHNO', 'M2DLFG', 'M2DPFG', 'M2PTFG', 'M2PTCT', 'M2PTID', 'M2PTDT', 'M2SRCE', 'M2USRM', 'M2ITRM', 'M2CSDT', 'M2CSID', 'M2CSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mi1ma()
    {
        return $this->belongsTo('App\Models\Mi1ma', 'M2M1NOIY', 'M1M1NOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'M2COMPIY', 'SCCOMPIY');
    }
}
