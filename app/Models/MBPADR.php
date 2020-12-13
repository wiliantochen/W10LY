<?php

namespace App\Models;

use App\Models\soModel;

/**
 * @property int $BACOMPIY
 * @property int $BANOMRIY
 * @property int $BABPNOIY
 * @property string $BACODE
 * @property string $BAADDR
 * @property string $BACITY
 * @property string $BATELP
 * @property string $BACPER
 * @property string $BAREMK
 * @property string $BARGID
 * @property string $BARGDT
 * @property string $BACHID
 * @property string $BACHDT
 * @property int $BACHNO
 * @property boolean $BADLFG
 * @property boolean $BADPFG
 * @property boolean $BAPTFG
 * @property int $BAPTCT
 * @property string $BAPTID
 * @property string $BAPTDT
 * @property string $BASRCE
 * @property string $BAUSRM
 * @property string $BAITRM
 * @property string $BACSDT
 * @property string $BACSID
 * @property string $BACSNO
 * @property Mbpma $mbpma
 * @property Syscom $syscom
 */
class MBPADR extends soModel
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'MBPADR';

    /**
     * The primary key for the model.
     * 
     * @var string
     */
    protected $primaryKey = 'BANOMRIY';

    /**
     * Indicates if the IDs are auto-incrementing.
     * 
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = ['BACOMPIY', 'BABPNOIY', 'BACODE', 'BAADDR', 'BACITY', 'BATELP', 'BACPER', 'BAREMK', 'BARGID', 'BARGDT', 'BACHID', 'BACHDT', 'BACHNO', 'BADLFG', 'BADPFG', 'BAPTFG', 'BAPTCT', 'BAPTID', 'BAPTDT', 'BASRCE', 'BAUSRM', 'BAITRM', 'BACSDT', 'BACSID', 'BACSNO'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mbpma()
    {
        return $this->belongsTo('App\Models\Mbpma', 'BABPNOIY', 'BPBPNOIY');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function syscom()
    {
        return $this->belongsTo('App\Models\Syscom', 'BACOMPIY', 'SCCOMPIY');
    }
}
