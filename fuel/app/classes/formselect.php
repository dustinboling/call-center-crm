<?php

    class FormSelect{
        
        static function states(){
            return array("" => "", "AL"=>"Alabama", "AK"=>"Alaska", "AZ"=>"Arizona", "AR"=>"Arkansas", "CA"=>"California", "CO"=>"Colorado", "CT"=>"Connecticut", "DE"=>"Delaware", "DC"=>"District Of Columbia", "FL"=>"Florida", "GA"=>"Georgia", "HI"=>"Hawaii", "ID"=>"Idaho", "IL"=>"Illinois", "IN"=>"Indiana", "IA"=>"Iowa", "KS"=>"Kansas", "KY"=>"Kentucky", "LA"=>"Louisiana", "ME"=>"Maine", "MD"=>"Maryland", "MA"=>"Massachusetts", "MI"=>"Michigan", "MN"=>"Minnesota", "MS"=>"Mississippi", "MO"=>"Missouri", "MT"=>"Montana", "NE"=>"Nebraska", "NV"=>"Nevada", "NH"=>"New Hampshire", "NJ"=>"New Jersey", "NM"=>"New Mexico", "NY"=>"New York", "NC"=>"North Carolina", "ND"=>"North Dakota", "OH"=>"Ohio", "OK"=>"Oklahoma", "OR"=>"Oregon", "PA"=>"Pennsylvania", "RI"=>"Rhode Island", "SC"=>"South Carolina", "SD"=>"South Dakota", "TN"=>"Tennessee", "TX"=>"Texas", "UT"=>"Utah", "VT"=>"Vermont", "VA"=>"Virginia", "WA"=>"Washington", "WV"=>"West Virginia", "WI"=>"Wisconsin", "WY"=>"Wyoming"); 
        }
        
        static function range_leading($start, $end, $digits, $selected=''){
            $options = "";
            for($i=$start;$i<=$end;$i++)
            {
                ($selected == $i ? $select = "selected" : $select = "");
                $value = '';
                $len = strlen($i);
                if ($len < $digits)
                {
                    $loop = $digits - $len;
                    for ($x=0; $x<$loop; $x++)
                    {
                        $value = $value.'0';
                    }
                    $value = $value.$i;
                }
                else
                {
                    $value=$i;
                }
                $options .= "<option value=\"$value\" $select>$value</option>"."\r\n";
            }
            return $options;
        }

        static function states_option($val=null) {
            $options = '';
            foreach (self::states() as $k => $v) {
                $options .= "<option value=\"$k\"";
                if (!is_null($val) && $val == $k) {
                    $options .= " selected=\"selected\"";
                }
                $options .= ">$v</option>";
            }
            return $options;
        }
        
    }