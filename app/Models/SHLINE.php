<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $SLSLNOIY
 * @property int $SLSLNO
 * @property int $SLSHNOIY
 * @property int $SLITNOIY
 * @property string $SLDESC
 * @property float $SLQTYS
 * @property float $SLHARG
 * @property float $SLTOTL
 * @property string $SLREMK
 * @property string $SLRGID
 * @property string $SLRGDT
 * @property string $SLCHID
 * @property string $SLCHDT
 * @property int $SLCHNO
 * @property boolean $SLDLFG
 * @property boolean $SLDPFG
 * @property boolean $SLPTFG
 * @property int $SLPTCT
 * @property string $SLPTID
 * @property string $SLPTDT
 * @property string $SLSRCE
 * @property string $SLUSRM
 * @property string $SLITRM
 * @property string $SLCSDT
 * @property string $SLCSID
 * @property string $SLCSNO
 * @property Mitma $mitma
 * @property Shhead $shhead
 */
class SHLINE extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'SHLINE';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'SLSLNOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['SLSLNO', 'SLSHNOIY', 'SLITNOIY', 'SLDESC', 'SLQTYS', 'SLHARG', 'SLTOTL', 'SLREMK', 'SLRGID', 'SLRGDT', 'SLCHID', 'SLCHDT', 'SLCHNO', 'SLDLFG', 'SLDPFG', 'SLPTFG', 'SLPTCT', 'SLPTID', 'SLPTDT', 'SLSRCE', 'SLUSRM', 'SLITRM', 'SLCSDT', 'SLCSID', 'SLCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mitma()
    {
        return $this->belongsTo('App\Models\Mitma', 'SLITNOIY', 'MMITNOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function shhead()
    {
        return $this->belongsTo('App\Models\Shhead', 'SLSHNOIY', 'SHSHNOIY');
    }
}
