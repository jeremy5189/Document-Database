<?php

$map = array(   1 => '大眾傳播學群',
                2 => '工程學群',
                3 => '文史哲學群',
                4 => '不分系學群',
                5 => '外語學群',
                6 => '生命科學學群',
                7 => '地球環境學群',
                8 => '社會與心理學群',
                9 => '建築與設計學群',
                10 => '財經學群',
                11 => '教育學群',
                12 => '遊憩與運動學群',
                13 => '資訊學群',
                14 => '農林漁牧學群',
                15 => '管理學群',
                16 => '數理化學群',
                17 => '藝術學群',
                18 => '醫藥衛生學群' );  

function schoollink( $text )
{
    return "<a href=\"search.php?type=school&schoolSelect%5B%5D=0-".urlencode($text)."\">$text</a>";
}

function classlink( $num, $text )
{
    
    return "<a href=\"search.php?type=class&schoolSelect%5B%5D=$num\">$text</a>";
}

function fill_zero( $num, $level2 = true )
{
    $num = intval($num);
    if( $num < 100 && $num >= 10 )
        return "0".$num;
    else if( $num < 10 && $level2 )
        return "00".$num;
    else if( $num < 10 && !$level2 )
        return "0".$num;
    else
        return $num;
}

function printNavbar($text)
{
    return '
            <div class="navbar">
            <div class="navbar-inner">
              <a class="brand" href="#">'.$text.'</a>
            </div>
            </div>';
}

function escape_str($str)
{
    return mysql_real_escape_string($str);
}

function NotFoundPage()
{
    return "<html><head><title>404 Not Found</title></head>
            <body><center><h1>404 Not Found</h1></center>
            <hr><center>".SYSTEM_NAME." / ".SYSTEM_VERSION."</center></body></html>";
}

function ErrorAlert( $msg )
{
    return "<div class=\"alert alert-error\">
              <a class=\"close\">×</a>
              <strong>Error</strong>：$msg
            </div>";
}

function SuccessAlert( $msg )
{
    return "<div class=\"alert alert-success\">
              <a class=\"close\">×</a>
              <strong>Success</strong>：$msg
            </div>";
}

function replaceURLToLink( $str )
{
    return preg_replace_callback(
           "/(?<![\>https?:\/\/|href=\"'])(?<http>(https?:[\/][\/]|www\.)([a-z]|[A-Z]|[0-9]|[\/.&?= ]|[~])*)/",
           create_function(
                '$matches',
                'return \'<a href="\'.trim($matches[0]).\'">\'.trim($matches[0]).\'</a>\';'
            ),
            $str);
}

?>