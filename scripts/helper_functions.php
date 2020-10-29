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

function getAllDatesBetween($start, $end, $format = 'Y-m-d')
{
    return array_map(
        function ($timestamp) use ($format) {
            return date($format, $timestamp);
        },
        range(strtotime($start) + ($start < $end ? 4000 : 8000), strtotime($end) + ($start < $end ? 8000 : 4000), 86400)
    );
}

function calculateTime($starttime, $duration)
{
    return date('H:i:s', strtotime('+' . $duration . " minutes", strtotime($starttime)));
}

function checkFormEmpty($formarray, $filePoster, $fileBackground)
{
    $isEmpty = false;

    foreach ($formarray as $formfield) {
        if (empty($_POST[$formfield])) {
            $isEmpty = true;
        }
    }

    if (($filePoster["size"] == 0 && $filePoster["error"] != 0) && ($fileBackground["size"] == 0 && $fileBackground["error"] != 0)) {
        $isEmpty = true;
    }

    return $isEmpty;
}

function checkTranslationFormEmpty($formarray)
{
    $isEmpty = false;

    foreach ($formarray as $formfield) {
        if (empty($_POST[$formfield])) {
            $isEmpty = true;
        }
    }

    return $isEmpty;
}
