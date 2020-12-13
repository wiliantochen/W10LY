<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $B2COMPIY
 * @property int $B2B2NOIY
 * @property string $B2B2NO
 * @property string $B2NAME
 * @property int $B2B1NOIY
 * @property string $B2REMK
 * @property string $B2RGID
 * @property string $B2RGDT
 * @property string $B2CHID
 * @property string $B2CHDT
 * @property int $B2CHNO
 * @property boolean $B2DLFG
 * @property boolean $B2DPFG
 * @property boolean $B2PTFG
 * @property int $B2PTCT
 * @property string $B2PTID
 * @property string $B2PTDT
 * @property string $B2SRCE
 * @property string $B2USRM
 * @property string $B2ITRM
 * @property string $B2CSDT
 * @property string $B2CSID
 * @property string $B2CSNO
 * @property Mb1ma $mb1ma
 * @property Syscom $syscom
 */
class MB2MAS extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'MB2MAS';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'B2B2NOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['B2COMPIY', 'B2B2NO', 'B2NAME', 'B2B1NOIY', 'B2REMK', 'B2RGID', 'B2RGDT', 'B2CHID', 'B2CHDT', 'B2CHNO', 'B2DLFG', 'B2DPFG', 'B2PTFG', 'B2PTCT', 'B2PTID', 'B2PTDT', 'B2SRCE', 'B2USRM', 'B2ITRM', 'B2CSDT', 'B2CSID', 'B2CSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mb1ma()
    {
        return $this->belongsTo('App\Models\Mb1ma', 'B2B1NOIY', 'B1B1NOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'B2COMPIY', 'SCCOMPIY');
    }
}
