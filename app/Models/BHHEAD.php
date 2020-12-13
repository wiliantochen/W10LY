<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $BHCOMPIY
 * @property int $BHBHNOIY
 * @property string $BHBHNO
 * @property string $BHDATE
 * @property float $BHTOTL
 * @property string $BHREMK
 * @property string $BHRGID
 * @property string $BHRGDT
 * @property string $BHCHID
 * @property string $BHCHDT
 * @property int $BHCHNO
 * @property boolean $BHDLFG
 * @property boolean $BHDPFG
 * @property boolean $BHPTFG
 * @property int $BHPTCT
 * @property string $BHPTID
 * @property string $BHPTDT
 * @property string $BHSRCE
 * @property string $BHUSRM
 * @property string $BHITRM
 * @property string $BHCSDT
 * @property string $BHCSID
 * @property string $BHCSNO
 * @property Syscom $syscom
 */
class BHHEAD extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'BHHEAD';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'BHBHNOIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['BHCOMPIY', 'BHBHNO', 'BHDATE', 'BHTOTL', 'BHREMK', 'BHRGID', 'BHRGDT', 'BHCHID', 'BHCHDT', 'BHCHNO', 'BHDLFG', 'BHDPFG', 'BHPTFG', 'BHPTCT', 'BHPTID', 'BHPTDT', 'BHSRCE', 'BHUSRM', 'BHITRM', 'BHCSDT', 'BHCSID', 'BHCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'BHCOMPIY', 'SCCOMPIY');
    }
}
