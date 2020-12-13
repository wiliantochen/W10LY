<?php
    $weLicence = true;

    if (!$weLicence) {
        die('abc');
    }

	function Test123($str) {
		return "ABCDEF".$str;
	}

    function fnProtectHack() {
        // $computerId = $_SERVER['HTTP_USER_AGENT']." - ".$_SERVER['REMOTE_PORT']." - ".$_SERVER['REMOTE_ADDR'];
        $Data = ["Your IP"=>$_SERVER['REMOTE_ADDR'],
                 "Your Device Name"=>gethostbyaddr($_SERVER['REMOTE_ADDR']),
                 "Recorded"=>true,
                 "Warning"=>"Dont try to do some stupid thing!"
                    ];    
        return $Data;
    }

    function fnEnCrypt($a) {
    	$flag = false;
									    	if ($flag) echo "<hr>";
											if ($flag) echo "<br>Original : ".$a."<br>";
        $a = base64_encode("Lilyana").$a;
        $a = base64_encode($a); 			if ($flag) echo "<br>Base64_Encode : ".$a."<br>";
        $a = strrev($a); 					if ($flag) echo "<br>Reverse : ".$a."<br>";
        $b = str_split($a,strlen($a)/2); 	if ($flag) echo "<br>Split String (Dibagi 2)<br>Menjadi 1 : $b[0]<br>Menjadi 2 : $b[1] <br>";
        $c = str_split($b[0]);
        $d = str_split($b[1]);

        $e = []; 
        foreach($c as $key=>$value) {
            array_push($e, $c[$key].$d[$key]);
        }

        $f = implode("",$e); 				if ($flag) echo "<br>".$f."<br>";
        // $f = base64_decode($f); 			if ($flag) echo "<br>".$f."<br>";
        
    										if ($flag) echo "<hr>";
    	return $f;

    }


    function fnDeCrypt($a) {
    	$flag = false;
									    	if ($flag) echo "<hr>";
											if ($flag) echo "<br>Original : ".$a."<br>";

        $b = str_split($a);
        $c = []; $d = []; $ab = "a";
        foreach($b as $key=>$value) {
        	if ($ab == "a") {
            	array_push($c, $b[$key]);
        		$ab = "b";
        	} else {
            	array_push($d, $b[$key]);
        		$ab = "a";
        	}
        }
        									if ($flag) echo "<br>Split String (Dibagi 2)<br>Menjadi 1 : ".implode("",$c)."<br>Menjadi 2 : ".implode("",$d)." <br>";
        $e = implode("",$c).implode("",$d);	if ($flag) echo "<br>Digabung menjadi 1 : ".implode("",$c).implode("",$d)." <br>";
        $e = strrev($e);					if ($flag) echo "<br>DiReverse : ".$e." <br>";
        $e = base64_decode($e); 			if ($flag) echo "<br>Base64_Decode : ".$e." <br>";
        $keys = base64_encode("Aliang");
        $e = preg_replace("/".$keys."/", "", $e,1);
        $e = json_decode($e);  
    										if ($flag) echo "<hr>";
    	return $e;

    }

    function fnEncryptPassword($Password) {
        $JumlahSQL = 0;
        for ($i = 1; $i <= strlen($Password); $i++) {
            $HurufSQL = substr($Password, $i - 1, 1);
            $HurufSQL = ord($HurufSQL);
            $HurufSQL*=$i;
            $JumlahSQL+=$HurufSQL;
        }
        return md5($JumlahSQL);
    }


/*=================================================================================================================================*/
/*=======BEGIN GRID================================================================================================================*/
/*=================================================================================================================================*/

    function fnCrtColGridDefault(&$Column, $Prefix) {   

        fnCrtColGrid($Column, "txt", 0, 1, '', $Prefix.'RGID', 'Entry By', 100, 'left');
        fnCrtColGrid($Column, "txt", 0, 1, '', $Prefix.'RGDT', 'Entry Date', 100, 'center');
        fnCrtColGrid($Column, "txt", 0, 1, '', $Prefix.'CHID', 'Change By', 100, 'left');
        fnCrtColGrid($Column, "txt", 0, 1, '', $Prefix.'CHDT', 'Change Date', 100, 'center');
        fnCrtColGrid($Column, "num", 0, 1, '', $Prefix.'CHNO', 'Change Num', 100, 'right');
        fnCrtColGrid($Column, "txt", 0, 1, '', $Prefix.'CSID', 'Change System By', 100, 'left');
        fnCrtColGrid($Column, "txt", 0, 1, '', $Prefix.'CSDT', 'Change System Date', 100, 'center');

    }   

    function fnCrtColGrid(&$Column, $Tipe, $Required, $Tampil, $TipeGrid, $Field, $Label, $Width, 
                                  $Align = "", $PanjangKalimat = 0) {   


        $c = [];
        switch (strtoupper($Tipe)) {
            case "RNO":
                $Align ="left";
                $c["xtype"] = "rownumberer";
                $c["autoSizeColumn"] = false;      
                break;
            case "ACT":
                $Align ="left";
                $c["autoSizeColumn"] = false;      
                break;
            case "DTP":
                $Align ="center";
                $c["xtype"] = "datecolumn";
                $c["autoSizeColumn"] = true;                
                $c["filter"] = true;
                break;
            case "NUM":
                $Align ="right";
                $c["filter"] = "number";
                $c["autoSizeColumn"] = true;                
                break;
            case "TXT":
                $Align="left";
                $c["autoSizeColumn"] = true;                
                // $c["filter"] = true;       
                $c["filter"] = array(
                                    "type" => 'string',
                                );
             
                // $c["filter"] = array(
                //                     "type" => 'string',
                //                     "itemDefaults" =>  array(
                //                         "emptyText" =>  'Search for...'
                //                     )
                //                 );

                break;
        }


        $c["dataIndex"] = $Field;
        $c["text"] = $Label;
        $c["field"] = $Field;
        $c["tipe"] = strtolower($Tipe);
        $c["width"] = $Width;
        $c["hidden"] = !$Tampil;
        $c["lockable"] = true;
        $c["value"] = $Field;
        $c["xxxxx"] = "xxxx";
        
        $Column[] = $c;


        // if (strtoupper($Tipe)=="RNO") {
        //     $Column[] = array ("xtype" => "rownumberer",
        //                        "tipe" => strtolower($Tipe),
        //                        "text" => $Label,
        //                        "field" => $Field,
        //                        "width" => $Width,
        //                        "xxxxx" => "xxxx"
        //                 );
        // } else {
        //     $Column[] = array ("dataIndex" => $Field,
        //                        "text" => $Label,
        //                        "field" => $Field,
        //                        "tipe" => strtolower($Tipe),
        //                        // "tipeGrid" => strtolower($Tipe.$TipeGrid),
        //                        "width" => $Width,
        //                        "filter" => $filter,
        //                        // "required" => $Required === 1 ? true : false,
        //                        "hidden" => !$Tampil,
        //                        // "align" => $Align,
        //                        "lockable" => true,
        //                        // "sortable" => false,
        //                        // "FilterOperator" => "",
        //                        // "FilterValue" => "",
        //                        // "panjangKalimat" => $PanjangKalimat,
        //                        "value" => $Field,
        //                        // "urut" =>isset($SortArray[$Field]) ? $SortArray[$Field] : '',                           
        //                        "xxxxx" => "xxxx");
        // }




    }         


    function fnQuerySearchAndPaginate($Request, $TableModel, $Obj, &$Sort, &$Filter, &$ColumnGrid) {   

        $Filter = [];
        if (!is_null($Request->filter)) {
            // $Filter = $Request->filter;
            $Filter = json_decode($Request->filter);
        }
        if (!is_null($Request->sort)) {
            $Sort = [];
            $Sort = json_decode($Request->sort);
        } else {          
            $Sort = json_decode(json_encode($Sort));
        }

        // $b = array_filter($Obj, function ($a) { return $a['tipe'] != 'hdn'; } );
        // $a = array_splice($b,0,100);
        // dd($a);

        $driver = DB::connection()->getConfig("driver");
        if ($driver=="sqlsrv") {
            $B1 = "["; $B2 = "]";
        } else if ($driver=="mysql") { 
            $B1 = ""; $B2 = "";
        } 

        $Col = []; $ColumnGrid = [];
        foreach($Obj as $k => $f) {
            if (($f['tipe'] != 'act') && ($f['tipe'] != 'rno')) { $Col[] = $f['field']; }
            if ($f['tipe'] != 'hdn') { $ColumnGrid[] = $f; }
            // echo ($v[$k]);
        }

        $TableModel->select($Col);

        foreach ($Sort as $s) {
            $TableModel->orderBy($s->property,$s->direction);
        }


        $condition = "";
        if (!is_null($Request->AllColumns)) {
        //   $TableModel->where(function ($query) use($Col, $Request) {
        //       foreach ($Col as $c) {
        //         // echo "or ".$c." like '%master%'";
        //         $query->orwhere($c, 'LIKE', '%'.$Request->AllColumns.'%');
        //       }            
        //   });
            $or = "";
            foreach ($Col as $c) {
                $nilai = str_replace("'","''",$Request->AllColumns);
                
                $condition = $condition.$or." ".$B1.$c.$B2."  like '%".$nilai."%'";
                $or = " or ";
            }
            $condition = " (".$condition.") ";
        }

        foreach ($Filter as $f) {

            if($condition != "") {
                $condition = $condition."And";
            }

            $nilai = str_replace("'","''",$f->value);

            if($f->operator == 'in') {
                // $TableModel->whereIn($f->property, explode(',', $f->filterValue));
                $condition = $condition." ".$B1.$f->property.$B2." "." in (".explode(',', $nilai).")";
            } else if($f->operator == 'like') {
                // $TableModel->where($f->property, 'LIKE', '%'.$f->filterValue.'%');
                $condition = $condition." ".$B1.$f->property.$B2." "." like '%".$nilai."%'";
            } else if($f->operator == 'likeRight') {
                // $TableModel->where($f->property, 'LIKE', $f->filterValue.'%');
                $condition = $condition." ".$B1.$f->property.$B2." "." like '".$nilai."%'";
            } else {
                // $TableModel->where($f->property, $f->operator, $f->filterValue);
                $condition = $condition." ".$B1.$f->property.$B2." "." ".$f->operator." '".$nilai."'";
            }
        }  

        if (!is_null($Request->SubMethod)) {
            if (rtrim($Request->SubMethod) != "") {
                if($condition != "") {
                    $condition = $condition."And";
                }
                if(substr($Request->Method,0,6) === "SYSDAT"){
                    $condition = $condition." STTABL = '".$Request->SubMethod."' ";
                }
            }
        }

        if (!is_null($Request->Condition)) {
            if (rtrim($Request->Condition) != "") {
                if($condition != "") {
                    $condition = $condition."And";
                }
                $condition = $condition." ".$Request->Condition." ";
            }
        }

        if($condition != ""){
            $TableModel->whereRaw($condition);
        }

        // Sintax Check SQL
        // $sql = $TableModel->toSql();
        // dd($sql);
        // dd($TableModel);

        // dd($Request->limit);
        // dd($TableModel->count());
        if (!is_null($Request->limit)) {
            if($Request->limit != "0") {
                // $page = $Request->page;
                // $perPage = $Request->perPage;
                // $offset = ($page * $perPage) - $perPage;
                // return $TableModel->offset($offset)->limit($perPage)->get();
                return $TableModel->paginate($Request->limit);
            }
        }       


        // if (!is_null($Request->perPage)) {
        //     if($Request->perPage != "0") {
        //         return $TableModel->paginate($Request->perPage);
        //     }
        // }                 
        return $TableModel->paginate($TableModel->count());
        

    }     
/*=================================================================================================================================*/
/*=====END GRID====================================================================================================================*/
/*=================================================================================================================================*/





/*=================================================================================================================================*/
/*======BEGIN STANDARD OBJECT======================================================================================================*/
/*=================================================================================================================================*/
    function fnCrtObj(&$Obj, $cm, $Show, $Required, $FFTipe, $Mode, $Tipe, $Code, $Name, $Description) {   
        // if ($Description == "") { $Description = $Name; }
        $Obj[$Code] = array(
// classic
                       "name" => $Code,
                       "fieldLabel" => $Name, 
                       "emptyText" => $Description, 
                       "reference" => $Code,
                       "labelAlign" => $cm === "classic" ? "right" : "top", //placeholder (saat view, gak ada label) , top
                       "Tipe" => strtolower($Tipe), 
                       "TObj" => "so",
                       "Mode" => $Mode, 
                       "hidden" => $Show === 1 ? false : true,
                       "FFTipe" => $FFTipe,  // FillForm Type Untuk Query Field Fill Form
                       "allowBlank" => $Required === 0 ? true : false,
// modern
                       "label" => $Name, 
                       "clearIcon" => false, 
                       "placeHolder" => $Description, 
                       "required" => $Required === 0 ? true : false,
                       );
    }        

    function fnUpdObj(&$Obj, $Code, $LainLain) {   
        $Obj[$Code] = array_merge($Obj[$Code], $LainLain);
    }   
/*=================================================================================================================================*/
/*======End STANDARD OBJECT========================================================================================================*/
/*=================================================================================================================================*/




/*=================================================================================================================================*/
/*======BEGIN OBJECT===============================================================================================================*/
/*=================================================================================================================================*/

    function fnCrtObjDefault(&$Obj, $cm, $Prefix) {   
        fnCrtObjTxt($Obj, $cm, 0, 0, "FF", "3", $Prefix."RGID", "Register ID", "", 200, 200);
        fnCrtObjTxt($Obj, $cm, 0, 0, "FF", "3", $Prefix."RGDT", "Register Date", "", 200, 200);
        fnCrtObjTxt($Obj, $cm, 0, 0, "FF", "3", $Prefix."CHID", "Change ID", "", 200, 200);
        fnCrtObjTxt($Obj, $cm, 0, 0, "FF", "3", $Prefix."CHDT", "Change Date", "", 200, 200);
        fnCrtObjNum($Obj, $cm, 0, 0, "FF", "3", $Prefix."CHNO", "Change Num", "", 200, 200);
        fnCrtObjTxt($Obj, $cm, 0, 0, "FF", "3", $Prefix."CSID", "Change System ID", "", 200, 200);
        fnCrtObjTxt($Obj, $cm, 0, 0, "FF", "3", $Prefix."CSDT", "Change System Date", "", 200, 200);
    }  

    function fnCrtObjTxt(&$Obj, $cm, $Show, $Required, $FFTipe, $Mode, $Code, $Name, $Description = "", 
                                $LabelWidth = 0, $Width = 0,
                                $Min = 0, $Max = 0, $Capital = "", $Prefix = "", $Suffix = "") {   
        /* 
            $Capital = ['Normal','Big','Small'] 
         */        

        if ($Capital == "") { $Capital = "Normal"; }
        fnCrtObj($Obj, $cm, $Show, $Required, $FFTipe, $Mode, "txt", $Code, $Name, $Description);
        fnUpdObj($Obj, $Code, array("xtype" => "textfield",
                                    "labelWidth" => $LabelWidth,  
                                    "width" => $cm === "classic" ? $LabelWidth+$Width : $Width,
                                    // "Prefix" => $Prefix,  
                                    // "Suffix" => $Suffix,
                                    "Capital" => strtoupper($Capital)) );
        if ( ($Min+$Max) > 0) {
            fnUpdObj($Obj, $Code, array("minLength" => $Min, 
                                        "maxLength" => $Max,
                                        "enforceMaxLength" => true));
        }

    } 



    function fnCrtObjRmk(&$Obj, $cm, $Show, $Required, $FFTipe, $Mode, $Code, $Name, $Description = "", 
                                $LabelWidth = 0, $Width = 0,
                                $Height = 100) {   
        fnCrtObj($Obj, $cm, $Show, $Required, $FFTipe, $Mode, "rmk", $Code, $Name, $Description );
        if ($cm === "classic") {
            fnUpdObj($Obj, $Code, array("xtype" => "textareafield",
                                        "labelWidth" => $LabelWidth,  
                                        "width" => $cm === "classic" ? $LabelWidth+$Width : $Width,
                                        // "fieldStyle" => "min-height: 200px", 
                                        "height" => $Height) );
        } else {
            fnUpdObj($Obj, $Code, array("xtype" => "textareafield",
                                        "labelWidth" => $LabelWidth,  
                                        "width" => $cm === "classic" ? $LabelWidth+$Width : $Width,
                                        // "fieldStyle" => "min-height: 200px", 
                                        ));
        }

    } 


    function fnCrtObjNum(&$Obj, $cm, $Show, $Required, $FFTipe, $Mode, $Code, $Name, $Description = "",  
                                $LabelWidth = 0, $Width = 0,
                                $Decimal = 0, $Prefix = "", $trigger = true, $Step = 1, $MinValue = 0, $MaxValue = 0) { 

        fnCrtObj($Obj, $cm, $Show, $Required, $FFTipe, $Mode, "num", $Code, $Name, $Description);
        fnUpdObj($Obj, $Code, array("xtype" => "numberfield",
                                    "labelWidth" => $LabelWidth,  
                                    "width" => $cm === "classic" ? $LabelWidth+$Width : $Width,
                                    "Step" => $Step,
                                    "fieldStyle" => "text-align: right",  
                                    "Prefix" => $Prefix,  
                                    "hideTrigger" => $trigger,
                                    "ValueNum" => 0,) );
        if ( $MinValue <> 0) {
            fnUpdObj($Obj, $Code, array("minValue" => $MinValue,) );
        }
        if ( $MaxValue <> 0) {
            fnUpdObj($Obj, $Code, array("maxValue" => $MaxValue,) );
        }
        if ( $Decimal > 0) {
            fnUpdObj($Obj, $Code, array("allowDecimals" => true,
                                        "decimalPrecision" => $Decimal,) );
        }

    } 

    function fnCrtObjDtp(&$Obj, $cm, $Show, $Required, $FFTipe, $Mode, $Code, $Name, $Description = "", 
                                $LabelWidth = 0, $Width = 180, 
                                $FormatDisplay="d-F-Y", $Min = "", $Max = "") {
        fnCrtObj($Obj, $cm, $Show, $Required, $FFTipe, $Mode, "dtp", $Code, $Name, $Description);
        fnUpdObj($Obj, $Code, array("xtype" => $cm === "classic" ? "datefield" : "datepickerfield", 
                                    "labelWidth" => $LabelWidth,  
                                    "width" => $cm === "classic" ? $LabelWidth+$Width : $Width,
                                    "format" => $FormatDisplay, // date("m/d/Y")
                                    "destroyPickerOnHide" => true, 
                                    "Min" => $Min, 
                                    "Max" => $Max) );
    } 

    function fnCrtObjRad(&$Obj, $cm, $Show, $Required = true, $FFTipe, $Mode, $Code, $Name, $Description = "", 
                                $LabelWidth = 0, $Width = "0", $DefaultValue, 
                                $TableCode, $Condition = "", $Table="SYSDAT") {   

        $ListData = fnGetComboData( ($cm === "classic" ? $cm : $cm."Rad"), $Code, $Table, $TableCode, $DefaultValue, $Condition = "");
        // dd($ListData);
        fnCrtObj($Obj, $cm, $Show, $Required, $FFTipe, $Mode, "rad", $Code, $Name, $Description);
        if ($cm === "classic") {
            fnUpdObj($Obj, $Code, array("xtype" => "radiogroup",
                                        "labelWidth" => $LabelWidth,  
                                        // "width" => $LabelWidth+$Width,
                                        "columns" => explode(',', $Width),
                                        "vertical" => true,  
                                        "items" => $ListData,) );
        } else {
            fnUpdObj($Obj, $Code, array("xtype" => "fieldset",
                                        "title" => $Name,  
                                        "labelWidth" => ($LabelWidth/2),   
                                        "items" => $ListData,) );
        }

    } 


    function fnCrtObjChk(&$Obj, $cm, $Show, $Required = true, $FFTipe, $Mode, $Code, $Name, $Description = "", 
                                $LabelWidth = 0, $Width = "0", $DefaultValue, 
                                $TableCode, $Condition = "", $Table="SYSDAT") {   

        $ListData = fnGetComboData( ($cm === "classic" ? $cm : $cm."Chk"), $Code, $Table, $TableCode, $DefaultValue, $Condition = "");
        // dd($ListData);
        fnCrtObj($Obj, $cm, $Show, $Required, $FFTipe, $Mode, "chk", $Code, $Name, $Description);
        if ($cm === "classic") {
            fnUpdObj($Obj, $Code, array("xtype" => "checkboxgroup",
                                        "labelWidth" => $LabelWidth,  
                                        // "width" => $LabelWidth+$Width,
                                        "columns" => explode(',', $Width),
                                        "vertical" => true,  
                                        "items" => $ListData,) );
        } else {
            fnUpdObj($Obj, $Code, array("xtype" => "fieldset",
                                        "title" => $Name, 
                                        "labelWidth" => ($LabelWidth/2),   
                                        "items" => $ListData,) );
        }


    } 


    function fnCrtObjGrd($cm, $Reference, $Controller, $Method, $Columns = "", $PageSize = 15) {        
        $Grid  = "";
        $Grid .= "{";  
        $Grid .= "    xtype: 'xtGrid',";
        $Grid .= "    reference: '".$Reference."',";
        if ($cm==="modern") {
        $Grid .= "    columns: ".json_encode($Columns).",";
        }
        $Grid .= "    store: {";
        $Grid .= "        type: 'stGrid',";
        $Grid .= "        reference: '".$Reference."Store',";
        $Grid .= "        pageSize: ".(strtoupper($PageSize) === 'ALL' ? 99999999999999 : $PageSize).",";
        $Grid .= "        gridParams: {";
        $Grid .= "            c: '".$Controller."', ";
        $Grid .= "            m: '".$Method."', ";
        $Grid .= "            g: '".$Reference."', ";
        $Grid .= "        }";
        $Grid .= "    },";
        $Grid .= "}";
        return $Grid;
    } 

/*=================================================================================================================================*/
/*======END OBJECT===============================================================================================================*/
/*=================================================================================================================================*/



    function fnGetRec($Table, $Field, $FieldKey, $FieldKeyValue, $Condition) {

        $Rec = DB::table($Table)
                        ->Select(explode(',',$Field))
                        ->where($FieldKey,'=',$FieldKeyValue)
                        ->where(function ($query) use($Condition) {
                              if ( is_array($Condition) ) {
                                $query->where($Condition);
                              }
                          })
                        ->get();
        
        if ($Rec->isEmpty()) {
            return [];
        }
        return $Rec[0];
    
    }
    
    function fnGetComboData($cm, $ObjCode, $Table, $TableCode, $DefaultValue, $Condition = "") {

        $ListData = [];
        switch (strtoupper($Table)) {
            case "SYSDAT":
                $Model = "SYSDAT";        

                $Condition = [];
                array_push($Condition, ['STTABL','=',$TableCode]);
                array_push($Condition, ['SDDLFG','=','0']);
                array_push($Condition, ['SDDPFG','=','1']);
                // dd($Condition);

                $NamespacedModel = 'App\\Models\\' . $Model;
                $Table = $NamespacedModel::select('SDDATA','SDNAME')
                                            ->leftJoin('SYSTBL', 'STTABLIY', 'SDTABLIY')
                                            ->where($Condition)
                                            ->get();
                // dd($Table);

                foreach($Table as $row) {  // Begin Looping Record ListData  
                    if ($cm === "classic") {
                        $ListData[] = array("boxLabel"=> rtrim($row->SDNAME),
                                            "checked"=> strtoupper(rtrim($row->SDDATA)) == strtoupper(rtrim($DefaultValue)) ? true : false,  
                                            // "icon"=> 'home', 
                                            "name"=> $ObjCode,  
                                            "inputValue"=>rtrim($row->SDDATA)) ; 
                    } else if ($cm === "modernRad") {
                        $ListData[] = array("xtype"=> "radiofield",
                                            "label"=> rtrim($row->SDNAME), 
                                            "value"=>rtrim($row->SDDATA), 
                                            "checked"=> strtoupper(rtrim($row->SDDATA)) == strtoupper(rtrim($DefaultValue)) ? true : false,  
                                            "name"=> $ObjCode) ; 
                    } else if ($cm === "modernChk") {
                        $ListData[] = array("xtype"=> "checkboxfield",
                                            "label"=> rtrim($row->SDNAME), 
                                            "value"=>rtrim($row->SDDATA), 
                                            "checked"=> strtoupper(rtrim($row->SDDATA)) == strtoupper(rtrim($DefaultValue)) ? true : false,  
                                            "name"=> $ObjCode) ; 
                    }

                } // End Looping Record ListData
                // dd($ListData);

                break;
            default:
                break;
        }
        return $ListData;

    }





/*======================================================================================================================*/
/*======BEGIN CRUD======================================================================================================*/
/*======================================================================================================================*/


    // function fnFillGrid($Data) {
    //     $Hasil = $Data;
    //     $Hasil = json_encode($Hasil);
    //     $Hasil = json_decode($Hasil, true);
    //     return $Hasil['original'];
    // }


    function fnGenDelimiter($length = 10) {
        //$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $characters = '~`!@$^*()_-{}[]:;<>?|0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function fnGenUnikNo(&$Delimiter) {
        $Delimiter = fnGenDelimiter();
        // dd(date('Ymd_H:i:s:u _')); 
        return date('Ymd_His_').strrev($Delimiter);
    }

    function fnGetSintaxCRUD ($UserName, $AllField, $Mode, $Prefix, $Fields, $UnikNo) {

        $FinalField = array_filter( $AllField,
                            function ($key) use ($Fields) {
                                return in_array($key, $Fields);
                            },
                            ARRAY_FILTER_USE_KEY
                        );



        switch ($Mode) {
            case "1":
                $FinalField = array_merge($FinalField, array(
                                            $Prefix."DLFG"=>"0",
                                            $Prefix."RGID"=>$UserName,
                                            $Prefix."RGDT"=>Date("Y-m-d H:i:s"),
                                            $Prefix."CHID"=>$UserName,
                                            $Prefix."CHDT"=>Date("Y-m-d H:i:s"),
                                            $Prefix."CHNO"=>"0",
                                            $Prefix."CSID"=>$UserName,
                                            $Prefix."CSDT"=>Date("Y-m-d H:i:s"),
                                            $Prefix."CSNO"=>$UnikNo
                                        ));
                break;
            case "2": 
                $FinalField = array_merge($FinalField, array(
                                            $Prefix."DLFG"=>"0",
                                            $Prefix."CHID"=>$UserName,
                                            $Prefix."CHDT"=>Date("Y-m-d H:i:s"),
                                            // $Prefix."CHNO"=>$AllField[$Prefix."CHNO"]+1,
                                            $Prefix."CHNO"=>DB::raw($Prefix.'CHNO+1'),
                                            $Prefix."CSID"=>$UserName,
                                            $Prefix."CSDT"=>Date("Y-m-d H:i:s")
                                        ));            
                break;
            case "3":
                $FinalField = array_merge($FinalField, array(
                                            $Prefix."CHID"=>$UserName,
                                            $Prefix."CHDT"=>Date("Y-m-d H:i:s"),
                                            $Prefix."CHNO"=>DB::raw($Prefix.'CHNO+1'),
                                            $Prefix."CSID"=>$UserName,
                                            $Prefix."CSDT"=>Date("Y-m-d H:i:s")
                                        ));           
                break;
            default:
                $FinalField = array_merge($FinalField, array(
                                            $Prefix."CSID"=>$UserName,
                                            $Prefix."CSDT"=>Date("Y-m-d H:i:s")
                                        ));                       
                break;
        }

        return $FinalField;
    }



    function fnCheckBFCS ($Obj) {

        // if ($Obj["Mode"]!="1") { // Begin Check Change System Date
        /*  By Wilianto 2019 06 07
            Hanya Edit saja yang di Check BFCS
            Karena ke bentur dengan GRID value kirim
        */
        if ($Obj["Mode"]=="2") { // Begin Check Change System Date
            if (is_array($Obj["Key"])) {
                $Prefix = SubStr($Obj["Key"][0],0,2);
                $Key = $Obj["Key"][0];
                $arrCondition = [];
                for ($i=1; $i < count($Obj["Key"]); $i++) {
                    array_push($arrCondition,array($Obj["Key"][$i],
                                                   '=',
                                                   $Obj["Data"][$Obj["Key"][$i]]
                                                   ));
                }
            } else {
                $Prefix = SubStr($Obj["Key"],0,2);
                $Key = $Obj["Key"];
                $arrCondition = "";
            }

            $arrCSDT = fnGetRec($Obj["Table"], 
                                $Prefix.'CSDT'.",".$Prefix.'CSID', 
                                $Key, $Obj["Data"][$Key], $arrCondition) ;
            // var_dump($arrCSDT);

            // Begin By Wili n Edison 2019 06 07
            if (empty($arrCSDT)) {
                return array("success"=>false, "message"=>"Record not found, Please refresh your data!!!");            
            }
            // End By Wili n Edison 2019 06 07

            $CSDT = $Prefix.'CSDT';
            $CSID = $Prefix.'CSID';

            if ($arrCSDT->$CSDT != $Obj["Data"][$Prefix.'CSDT']) {
                return array("success"=>false, "message"=>"This Record already change by '".$arrCSDT->$CSID. "', Please refresh your data!!!");            
            }

        }  // End Check Change System Date


        if ($Obj["Menu"]!="") {  // Begin Check BackDate 
            $arrMENU = fnGetRec("TBLMNU","TMMENU,TMBFDT,TMFWDT", "TMURLW", $Obj["Menu"], "") ;


            $TGL = date('Ymd');
            $TGL_TRANS = $Obj["Data"][$Obj["FieldTransDate"]]; //"20181120";
            $diff1 = date_diff(date_create($TGL),date_create($TGL_TRANS));
            $daysdiff = $diff1->format("%R%a");
            $daysdiff = abs($daysdiff);
            if ($TGL < $TGL_TRANS) {
                if ($arrMENU->TMFWDT > $daysdiff) {
                  return array("success"=>false, "message"=>"Forward Date only ".$arrMENU->TMFWDT." days");
                } 
            } else if ($TGL > $TGL_TRANS) {
                if ($arrMENU->TMBCDT > $daysdiff) {
                  return array("success"=>false, "message"=>"Bac kDate only ".$arrMENU->TMBCDT." days");
                } 
            } 

        } // End Check BackDate

        return array("success"=>true, "message"=>"");            
    }

    function fnTBLNOR($Table, $UserName) {
        $NoIY = 1;
        $TBLNOUR = DB::table("TBLNOR")
                        ->Select(['TNTABL' , 'TNNOUR'])
                        ->where('TNTABL','=',$Table)
                        // ->where('TNTABL','=','TBLMNU')
                        ->get();
        if (count($TBLNOUR)) {
            // var_dump($TBLNOUR[0]);
            $NoIY = ($TBLNOUR[0]->TNNOUR+1);
            $TBLNOR = array("TNTABL"=>$Table,"TNNOUR"=>$NoIY);
            $FinalTBLNOR = fnGetSintaxCRUD ($UserName, $TBLNOR, '1', "TN", ['TNTABL','TNNOUR'], "" );
            DB::table('TBLNOR')
                ->where('TNTABL','=',$Table)
                ->update($FinalTBLNOR);   
        } else {
            $TBLNOR = array("TNTABL"=>$Table,"TNNOUR"=>"1");
            $FinalTBLNOR = fnGetSintaxCRUD ($UserName, $TBLNOR, '1', "TN", ['TNTABL','TNNOUR'], "" );
            DB::table('TBLNOR')
                ->insert($FinalTBLNOR);   
        }
        return $NoIY;    
    }

    function fnSYSNOR($Table, $UserName) {
        $NoIY = 1;
        $TBLNOUR = DB::table("SYSNOR")
                        ->Select(['SNTABL' , 'SNNOUR'])
                        ->where('SNTABL','=',$Table)
                        // ->where('SNTABL','=','TBLMNU')
                        ->get();
        if (count($TBLNOUR)) {
            // var_dump($TBLNOUR[0]);
            $NoIY = ($TBLNOUR[0]->SNNOUR+1);
            $SYSNOR = array("SNTABL"=>$Table,"SNNOUR"=>$NoIY);
            $FinalSYSNOR = fnGetSintaxCRUD ($UserName, $SYSNOR, '1', "SN", ['SNTABL','SNNOUR'], "" );
            DB::table('SYSNOR')
                ->where('SNTABL','=',$Table)
                ->update($FinalSYSNOR);   
        } else {
            $SYSNOR = array("SNTABL"=>$Table,"SNNOUR"=>"1");
            $FinalSYSNOR = fnGetSintaxCRUD ($UserName, $SYSNOR, '1', "SN", ['SNTABL','SNNOUR'], "" );
            DB::table('SYSNOR')
                ->insert($FinalSYSNOR);   
        }
        return $NoIY;    
    }

    function fnTBLTRN($CompIY, $UserName, $DCNO, $SWNO, $Lgth) {
        $NoIY = 1;
        $NoTRS = "";
        $TBLNOUR = DB::table("TBLTRN")
                        ->Select(['TRDCNO' , 'TRRNNO'])
                        ->where('TRDCNO','=',$DCNO)
                        // ->where('TRDCNO','=','TBLMNU')
                        ->get();
        if (count($TBLNOUR)) {
            // var_dump($TBLNOUR[0]);
            $NoIY = ($TBLNOUR[0]->TRRNNO+1);
            $NoTRS = $SWNO.substr(str_repeat("0",$Lgth).$NoIY,-1*$Lgth);
            $TBLTRN = array("TRCOMPIY"=>$CompIY,"TRDCNO"=>$DCNO,"TRRNNO"=>$NoIY,"TRSWNO"=>$NoTRS);
            $FinalTBLTRN = fnGetSintaxCRUD ($UserName, $TBLTRN, '1', "TR", ['TRSWNO','TRRNNO'], "" );
            DB::table('TBLTRN')
                ->where('TRCOMPIY','=',$CompIY)
                ->where('TRDCNO','=',$DCNO)
                ->update($FinalTBLTRN);   
        } else {
            $NoTRS = $SWNO.substr(str_repeat("0",$Lgth)."1",-1*$Lgth);
            $TBLTRN = array("TRCOMPIY"=>$CompIY,"TRDCNO"=>$DCNO,"TRRNNO"=>"1","TRSWNO"=>$NoTRS);
            $FinalTBLTRN = fnGetSintaxCRUD ($UserName, $TBLTRN, '1', "TR", ['TRCOMPIY','TRDCNO','TRSWNO','TRRNNO'], "" );
            DB::table('TBLTRN')
                ->insert($FinalTBLTRN);   
        }
        return $NoTRS;    
    }

    function fnSetExecuteQuery ($user, $cm, $Params = "") {
        $UserName = $user->TUUSER;
        $CompIY = $user->TUCOMPIY;
        $HasilExec = null;
        try{
            DB::enableQueryLog();            
            $HasilExec = DB::transaction(function () use($cm) {
                return App::call('\App\Http\Controllers\Forms\\'.$cm);
            });

            $QueryLog = DB::getQueryLog();
            fnSaveSqlSintax($QueryLog, $UserName, $CompIY );
            $BerHasil = true;
        } catch (\Exception $e){ 

            $message = "";
            $message = $e->errorInfo[2];
            // $eCode = $e;
            $eCode = fnSaveSqlError($e, $UserName, $CompIY );
            // $message = $a->sql;
            $BerHasil = false;
        }        
        /*
            Jika StpXXXXX tidak Response apa apa
            maka akan masuk is_null($hasilExec)

            Jika StpXXXXX ada Responses apa apa
            maka akan pake response StpXXXXX
        */
        if (is_null($HasilExec)) {
            if ($BerHasil) {
                $Hasil = array("success"=> true, "message"=> "*** Success ***", "eCode"=>"");
                // $Hasil = array("success"=> true, "message"=> "*** Success ***");
            } else {
                $Hasil = array("success"=> false, "message"=> $message, "eCode"=>$eCode);
                // $Hasil = array("success"=> false, "message"=> $message);
            }
        } else {
            $Hasil = json_encode($HasilExec);
            $Hasil = json_decode($Hasil, true);
            $Hasil = $Hasil['original'];
        }

        return $Hasil;
    }

    function fnGetSqlSintax($QueryLog) {
        $STMT = "";
        foreach ($QueryLog as $k => $Q) {
            $sql = $Q['query'];
            $bindings = $Q['bindings'];
            // Process the query's SQL and parameters and create the exact query
            foreach ($bindings as $i => $binding) {
                if ($binding instanceof \DateTime) {
                    $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                } else {
                    if (is_string($binding)) {
                        $bindings[$i] = "'$binding'";
                    }
                }
            }
            $query = str_replace(array('%', '?'), array('%%', '%s'), $sql);
            $query = vsprintf($query, $bindings);
            $STMT .= $query.";
"; // Harus begini supaya didatabasenya ada enternya

        }        
        return $STMT;

    }

    function fnSaveSqlSintax($QueryLog, $UserName, $CompIY) {

        $TQSTMT = fnGetSqlSintax($QueryLog);

        $TABLE = 'App\\Models\\TBLSLF';
        $TBLSLF = new $TABLE;
        if ($CompIY!="") {
            $TBLSLF->TQCOMPIY = $CompIY;
        }        
        $TBLSLF->TQUSER = $UserName;
        $TBLSLF->TQSTMT = $TQSTMT;
        $TBLSLF->TQREMK = json_encode($QueryLog);
        $TBLSLF->TQRGID = 'Default';
        $TBLSLF->TQRGDT = Date("Y-m-d H:i:s");
        $TBLSLF->TQCHID = 'Default';
        $TBLSLF->TQCHDT = Date("Y-m-d H:i:s");
        $TBLSLF->TQCHNO = '0';
        $TBLSLF->TQDPFG = '1';
        $TBLSLF->TQDLFG = '0';
        $TBLSLF->TQCSID = 'Default';
        $TBLSLF->TQCSDT = Date("Y-m-d H:i:s");
        $TBLSLF->TQSRCE = 'FirstSetup';
        $TBLSLF->save();        

    }

    function fnSaveSqlError($exception, $UserName, $CompIY) {
        $sql = $exception->getSql();
        $bindings = $exception->getBindings();

        // Process the query's SQL and parameters and create the exact query
        foreach ($bindings as $i => $binding) {
            if ($binding instanceof \DateTime) {
                $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
            } else {
                if (is_string($binding)) {
                    $bindings[$i] = "'$binding'";
                }
            }
        }
        $query = str_replace(array('%', '?'), array('%%', '%s'), $sql);
        $query = vsprintf($query, $bindings);

        // Here's the part you need
        $errorInfo = $exception->errorInfo;

        $data = [
            'sql'        => $query,
            'message'    => isset($errorInfo[2]) ? $errorInfo[2] : '',
            'sql_state'  => $errorInfo[0],
            'error_code' => $errorInfo[1]
        ];

        $TEREMK = fnGetSqlSintax(DB::getQueryLog());
        $TEREMK .= $query;

        $TABLE = 'App\\Models\\TBLELF';
        $TBLELF = new $TABLE;
        if ($CompIY!="") {
            $TBLELF->TECOMPIY = $CompIY;
        }
        $TBLELF->TEUSER = $UserName;
        $TBLELF->TEERNO = $errorInfo[1];
        $TBLELF->TEERST = $errorInfo[0];
        $TBLELF->TEERMS = isset($errorInfo[2]) ? $errorInfo[2] : '';
        $TBLELF->TESPTR = '';
        $TBLELF->TESTMT = $query;
        $TBLELF->TEREMK = $TEREMK;
        $TBLELF->TERGID = 'Default';
        $TBLELF->TERGDT = Date("Y-m-d H:i:s");
        $TBLELF->TECHID = 'Default';
        $TBLELF->TECHDT = Date("Y-m-d H:i:s");
        $TBLELF->TECHNO = '0';
        $TBLELF->TEDPFG = '1';
        $TBLELF->TEDLFG = '0';
        $TBLELF->TECSID = 'Default';
        $TBLELF->TECSDT = Date("Y-m-d H:i:s");
        $TBLELF->TESRCE = 'FirstSetup';
        $TBLELF->save();

        return $data;
        // Now store the error into database, if you want..
        // ....
    }



/*======================================================================================================================*/
/*======END CRUD========================================================================================================*/
/*======================================================================================================================*/




?>
