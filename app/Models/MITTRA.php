<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $MTCOMPIY
 * @property int $MTNOMRIY
 * @property int $MTITNOIY
 * @property string $MTTRDT
 * @property float $MTTMSX
 * @property string $MTMODL
 * @property float $MTQTYS
 * @property float $MTHARG
 * @property float $MTTOTL
 * @property float $MTBEFQ
 * @property float $MTAFTQ
 * @property float $MTAVGO
 * @property float $MTAVGN
 * @property string $MTREMK
 * @property string $MTRGID
 * @property string $MTRGDT
 * @property string $MTCHID
 * @property string $MTCHDT
 * @property int $MTCHNO
 * @property boolean $MTDLFG
 * @property boolean $MTDPFG
 * @property boolean $MTPTFG
 * @property int $MTPTCT
 * @property string $MTPTID
 * @property string $MTPTDT
 * @property string $MTSRCE
 * @property string $MTUSRM
 * @property string $MTITRM
 * @property string $MTCSDT
 * @property string $MTCSID
 * @property string $MTCSNO
 * @property Mitma $mitma
 */
class MITTRA extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'MITTRA';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'MTNOMRIY';

    /**
     * @var array
     */
    protected $fillable = ['MTCOMPIY', 'MTITNOIY', 'MTTRDT', 'MTTMSX', 'MTMODL', 'MTQTYS', 'MTHARG', 'MTTOTL', 'MTBEFQ', 'MTAFTQ', 'MTAVGO', 'MTAVGN', 'MTREMK', 'MTRGID', 'MTRGDT', 'MTCHID', 'MTCHDT', 'MTCHNO', 'MTDLFG', 'MTDPFG', 'MTPTFG', 'MTPTCT', 'MTPTID', 'MTPTDT', 'MTSRCE', 'MTUSRM', 'MTITRM', 'MTCSDT', 'MTCSID', 'MTCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mitma()
    {
        return $this->belongsTo('App\Models\Mitma', 'MTITNOIY', 'MMITNOIY');
    }
}
