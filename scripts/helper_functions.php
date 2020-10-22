<?php
function phpObjectToArray($data)
{
    if (is_array($data) || is_object($data)) {
        $result = array();

        foreach ($data as $key => $value) {
            $result[$key] = phpObjectToArray($value);
        }

        return $result;
    }

    return $data;
}
