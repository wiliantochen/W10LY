<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $TANOMRIY
 * @property int $TAUSERIY
 * @property int $TAMENUIY
 * @property string $TAACES
 * @property string $TALSDT
 * @property int $TAUSCT
 * @property string $TAREMK
 * @property string $TARGID
 * @property string $TARGDT
 * @property string $TACHID
 * @property string $TACHDT
 * @property int $TACHNO
 * @property boolean $TADLFG
 * @property boolean $TADPFG
 * @property boolean $TAPTFG
 * @property int $TAPTCT
 * @property string $TAPTID
 * @property string $TAPTDT
 * @property string $TASRCE
 * @property string $TAUSRM
 * @property string $TAITRM
 * @property string $TACSDT
 * @property string $TACSID
 * @property string $TACSNO
 * @property Sysmnu $sysmnu
 * @property Tblusr $tblusr
 */
class TBLUAM extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'TBLUAM';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'TANOMRIY';

    /**
     * @var array
     */
    protected $fillable = ['TAUSERIY', 'TAMENUIY', 'TAACES', 'TALSDT', 'TAUSCT', 'TAREMK', 'TARGID', 'TARGDT', 'TACHID', 'TACHDT', 'TACHNO', 'TADLFG', 'TADPFG', 'TAPTFG', 'TAPTCT', 'TAPTID', 'TAPTDT', 'TASRCE', 'TAUSRM', 'TAITRM', 'TACSDT', 'TACSID', 'TACSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sysmnu()
    {
        return $this->belongsTo('App\Models\Sysmnu', 'TAMENUIY', 'SMMENUIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tblusr()
    {
        return $this->belongsTo('App\Models\Tblusr', 'TAUSERIY', 'TUUSERIY');
    }
}
