<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $TUCOMPIY
 * @property int $TUUSERIY
 * @property string $TUUSER
 * @property string $TUNAME
 * @property string $TUPSWD
 * @property string $TUEMID
 * @property string $TUDEPT
 * @property string $TUMAIL
 * @property string $TUWELC
 * @property boolean $TUEXPP
 * @property string $TUEXPD
 * @property int $TUEXPV
 * @property int $TULGCT
 * @property string $TULSLI
 * @property string $TULSLO
 * @property string $TUFOTO
 * @property string $TUREMK
 * @property string $TURGID
 * @property string $TURGDT
 * @property string $TUCHID
 * @property string $TUCHDT
 * @property int $TUCHNO
 * @property boolean $TUDLFG
 * @property boolean $TUDPFG
 * @property boolean $TUPTFG
 * @property int $TUPTCT
 * @property string $TUPTID
 * @property string $TUPTDT
 * @property string $TUSRCE
 * @property string $TUUSRM
 * @property string $TUITRM
 * @property string $TUCSDT
 * @property string $TUCSID
 * @property string $TUCSNO
 * @property Syscom $syscom
 */
class TBLUSR extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'TBLUSR';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'TUUSERIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['TUCOMPIY', 'TUUSER', 'TUNAME', 'TUPSWD', 'TUEMID', 'TUDEPT', 'TUMAIL', 'TUWELC', 'TUEXPP', 'TUEXPD', 'TUEXPV', 'TULGCT', 'TULSLI', 'TULSLO', 'TUFOTO', 'TUREMK', 'TURGID', 'TURGDT', 'TUCHID', 'TUCHDT', 'TUCHNO', 'TUDLFG', 'TUDPFG', 'TUPTFG', 'TUPTCT', 'TUPTID', 'TUPTDT', 'TUSRCE', 'TUUSRM', 'TUITRM', 'TUCSDT', 'TUCSID', 'TUCSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'TUCOMPIY', 'SCCOMPIY');
    }
}
