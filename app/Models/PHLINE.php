<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $PLPLNOIY
 * @property int $PLPLNO
 * @property int $PLPHNOIY
 * @property int $PLITNOIY
 * @property string $PLDESC
 * @property float $PLQTYS
 * @property float $PLHARG
 * @property float $PLTOTL
 * @property string $PLREMK
 * @property string $PLRGID
 * @property string $PLRGDT
 * @property string $PLCHID
 * @property string $PLCHDT
 * @property int $PLCHNO
 * @property boolean $PLDLFG
 * @property boolean $PLDPFG
 * @property boolean $PLPTFG
 * @property int $PLPTCT
 * @property string $PLPTID
 * @property string $PLPTDT
 * @property string $PLSRCE
 * @property string $PLUSRM
 * @property string $PLITRM
 * @property string $PLCSDT
 * @property string $PLCSID
 * @property string $PLCSNO
 * @property Mitma $mitma
 * @property Phhead $phhead
 */
class PHLINE extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'PHLINE';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'PLPLNOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['PLPLNO', 'PLPHNOIY', 'PLITNOIY', 'PLDESC', 'PLQTYS', 'PLHARG', 'PLTOTL', 'PLREMK', 'PLRGID', 'PLRGDT', 'PLCHID', 'PLCHDT', 'PLCHNO', 'PLDLFG', 'PLDPFG', 'PLPTFG', 'PLPTCT', 'PLPTID', 'PLPTDT', 'PLSRCE', 'PLUSRM', 'PLITRM', 'PLCSDT', 'PLCSID', 'PLCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mitma()
    {
        return $this->belongsTo('App\Models\Mitma', 'PLITNOIY', 'MMITNOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function phhead()
    {
        return $this->belongsTo('App\Models\Phhead', 'PLPHNOIY', 'PHPHNOIY');
    }
}
