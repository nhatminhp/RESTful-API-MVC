<?php
/**
 * Created by PhpStorm.
 * User: minhpn
 * Date: 17/07/2017
 * Time: 14:19
 */

namespace View;


class StaffView
{
    public function displayJson($array) {
        header('Content-type: application/json; charset=uft-8');
        echo json_encode($array);
    }

    public function displayXML($array) {
        header('Content-type: application/xml; charset=uft-8');
        $xml = $this->arrayToXML($array, $level = 1);
        echo $xml;
    }

    function arrayToXML($array, $level=1) {
        $xml = '';
        if ($level==1) {
            $xml .= '<?xml version="1.0" encoding="ISO-8859-1"?>'.
                "\n<staff>\n";
        }
        foreach ($array as $key=>$value) {
            $key = strtolower($key);
            if (is_array($value)) {
                $multi_tags = false;
                foreach($value as $key2=>$value2) {
                    if (is_array($value2)) {
                        $xml .= str_repeat("\t",$level)."<$key>\n";
                        $xml .= $this->arrayToXML($value2, $level+1);
                        $xml .= str_repeat("\t",$level)."</$key>\n";
                        $multi_tags = true;
                    } else {
                        if (trim($value2)!='') {
                            if (htmlspecialchars($value2)!=$value2) {
                                $xml .= str_repeat("\t",$level).
                                    "<$key><![CDATA[$value2]]>".
                                    "</$key>\n";
                            } else {
                                $xml .= str_repeat("\t",$level).
                                    "<$key>$value2</$key>\n";
                            }
                        }
                        $multi_tags = true;
                    }
                }
                if (!$multi_tags and count($value)>0) {
                    $xml .= str_repeat("\t",$level)."<$key>\n";
                    $xml .= $this->arrayToXML($value, $level+1);
                    $xml .= str_repeat("\t",$level)."</$key>\n";
                }
            } else {
                if (trim($value)!='') {
                    if (htmlspecialchars($value)!=$value) {
                        $xml .= str_repeat("\t",$level)."<$key>".
                            "<![CDATA[$value]]></$key>\n";
                    } else {
                        $xml .= str_repeat("\t",$level).
                            "<$key>$value</$key>\n";
                    }
                }
            }
        }
        if ($level==1) {
            $xml .= "</staff>\n";
        }
        return $xml;
    }
}