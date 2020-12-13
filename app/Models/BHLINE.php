<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $BLBLNOIY
 * @property int $BLBLNO
 * @property int $BLBHNOIY
 * @property int $BLB2NOIY
 * @property string $BLDESC
 * @property float $BLTOTL
 * @property string $BLREMK
 * @property string $BLRGID
 * @property string $BLRGDT
 * @property string $BLCHID
 * @property string $BLCHDT
 * @property int $BLCHNO
 * @property boolean $BLDLFG
 * @property boolean $BLDPFG
 * @property boolean $BLPTFG
 * @property int $BLPTCT
 * @property string $BLPTID
 * @property string $BLPTDT
 * @property string $BLSRCE
 * @property string $BLUSRM
 * @property string $BLITRM
 * @property string $BLCSDT
 * @property string $BLCSID
 * @property string $BLCSNO
 * @property Mb2ma $mb2ma
 * @property Bhhead $bhhead
 */
class BHLINE extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'BHLINE';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'BLBLNOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['BLBLNO', 'BLBHNOIY', 'BLB2NOIY', 'BLDESC', 'BLTOTL', 'BLREMK', 'BLRGID', 'BLRGDT', 'BLCHID', 'BLCHDT', 'BLCHNO', 'BLDLFG', 'BLDPFG', 'BLPTFG', 'BLPTCT', 'BLPTID', 'BLPTDT', 'BLSRCE', 'BLUSRM', 'BLITRM', 'BLCSDT', 'BLCSID', 'BLCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mb2ma()
    {
        return $this->belongsTo('App\Models\Mb2ma', 'BLB2NOIY', 'B2B2NOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bhhead()
    {
        return $this->belongsTo('App\Models\Bhhead', 'BLBHNOIY', 'BHBHNOIY');
    }
}
