<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $UMCOMPIY
 * @property int $UMUNMSIY
 * @property string $UMUNMS
 * @property string $UMNAME
 * @property string $UMREMK
 * @property string $UMRGID
 * @property string $UMRGDT
 * @property string $UMCHID
 * @property string $UMCHDT
 * @property int $UMCHNO
 * @property boolean $UMDLFG
 * @property boolean $UMDPFG
 * @property boolean $UMPTFG
 * @property int $UMPTCT
 * @property string $UMPTID
 * @property string $UMPTDT
 * @property string $UMSRCE
 * @property string $UMUSRM
 * @property string $UMITRM
 * @property string $UMCSDT
 * @property string $UMCSID
 * @property string $UMCSNO
 * @property Syscom $syscom
 */
class UNTMAS extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'UNTMAS';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'UMUNMSIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['UMCOMPIY', 'UMUNMS', 'UMNAME', 'UMREMK', 'UMRGID', 'UMRGDT', 'UMCHID', 'UMCHDT', 'UMCHNO', 'UMDLFG', 'UMDPFG', 'UMPTFG', 'UMPTCT', 'UMPTID', 'UMPTDT', 'UMSRCE', 'UMUSRM', 'UMITRM', 'UMCSDT', 'UMCSID', 'UMCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'UMCOMPIY', 'SCCOMPIY');
    }
}
