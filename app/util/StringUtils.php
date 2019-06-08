<?php


class StringUtils
{
    //Para evitar en cierta medida que se JSinjection
    public static function strip_html_script($str)
    {
        $tags = ["<script>", "<script type=\"text/javascript\">"];
        $str = str_replace($tags, "<noscript>", $str);
        $str = str_replace("</script>", "</snoscript>", $str);

        return $str;
    }

    //Dni Validator
    function dni_validator($dni)
    {
        $letra = substr($dni, -1);
        $numeros = substr($dni, 0, -1);

        if (substr("TRWAGMYFPDXBNJZSQVHLCKE", $numeros % 23, 1) == $letra && strlen($letra) == 1 && strlen($numeros) == 8) {
            return true;
        }

        return false;
    }
}