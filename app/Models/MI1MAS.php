<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $M1COMPIY
 * @property int $M1M1NOIY
 * @property string $M1M1NO
 * @property string $M1NAME
 * @property string $M1REMK
 * @property string $M1RGID
 * @property string $M1RGDT
 * @property string $M1CHID
 * @property string $M1CHDT
 * @property int $M1CHNO
 * @property boolean $M1DLFG
 * @property boolean $M1DPFG
 * @property boolean $M1PTFG
 * @property int $M1PTCT
 * @property string $M1PTID
 * @property string $M1PTDT
 * @property string $M1SRCE
 * @property string $M1USRM
 * @property string $M1ITRM
 * @property string $M1CSDT
 * @property string $M1CSID
 * @property string $M1CSNO
 * @property Syscom $syscom
 */
class MI1MAS extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'MI1MAS';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'M1M1NOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['M1COMPIY', 'M1M1NO', 'M1NAME', 'M1REMK', 'M1RGID', 'M1RGDT', 'M1CHID', 'M1CHDT', 'M1CHNO', 'M1DLFG', 'M1DPFG', 'M1PTFG', 'M1PTCT', 'M1PTID', 'M1PTDT', 'M1SRCE', 'M1USRM', 'M1ITRM', 'M1CSDT', 'M1CSID', 'M1CSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'M1COMPIY', 'SCCOMPIY');
    }
}
