<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $B1COMPIY
 * @property int $B1B1NOIY
 * @property string $B1B1NO
 * @property string $B1NAME
 * @property string $B1REMK
 * @property string $B1RGID
 * @property string $B1RGDT
 * @property string $B1CHID
 * @property string $B1CHDT
 * @property int $B1CHNO
 * @property boolean $B1DLFG
 * @property boolean $B1DPFG
 * @property boolean $B1PTFG
 * @property int $B1PTCT
 * @property string $B1PTID
 * @property string $B1PTDT
 * @property string $B1SRCE
 * @property string $B1USRM
 * @property string $B1ITRM
 * @property string $B1CSDT
 * @property string $B1CSID
 * @property string $B1CSNO
 * @property Syscom $syscom
 */
class MB1MAS extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'MB1MAS';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'B1B1NOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['B1COMPIY', 'B1B1NO', 'B1NAME', 'B1REMK', 'B1RGID', 'B1RGDT', 'B1CHID', 'B1CHDT', 'B1CHNO', 'B1DLFG', 'B1DPFG', 'B1PTFG', 'B1PTCT', 'B1PTID', 'B1PTDT', 'B1SRCE', 'B1USRM', 'B1ITRM', 'B1CSDT', 'B1CSID', 'B1CSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'B1COMPIY', 'SCCOMPIY');
    }
}
