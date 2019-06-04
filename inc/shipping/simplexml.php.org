<?php

/* SimpleXML Required
 * http://us2.php.net/manual/en/ref.simplexml.php
 */

class XMLToArray {

    public function parse($xml) {
        return $this->convert(simplexml_load_string($xml));
    }

    function convert($xml) {
        if ($xml instanceof SimpleXMLElement) {
            $children = $xml->children();
            $return = null;
        }

        foreach ($children as $element => $value) {
            if ($value instanceof SimpleXMLElement) {
                $values = (array)$value->children();

                if (count($values) > 0) {
                    if (is_array($return[$element])) {
                        //hook
                        foreach ($return[$element] as $k=>$v) {
                            if (!is_int($k)) {
                                $return[$element][0][$k] = $v;
                                unset($return[$element][$k]);
                            }
                        }
                        $return[$element][] = $this->convert($value);
                    } else {
                        $return[$element] = $this->convert($value);
                    }
                } else {
                    if (!isset($return[$element])) {
                        $return[$element] = (string)$value;
                    } else {
                        if (!is_array($return[$element])) {
                            $return[$element] = array($return[$element], (string)$value);
                        } else {
                            $return[$element][] = (string)$value;
                        }
                    }
                }
            }
        }

        if (is_array($return)) {
            return $return;
        } else {
            return false;
        }
    }
}

/*

EXAMPLE:
$xml = new XMLToArray;
$xmlArray = $xml->parse($data);
print_r($xmlArray);

*/

?>