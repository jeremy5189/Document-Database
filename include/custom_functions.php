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
                18 => '醫藥衛生學群', 
                0 => '未分類');  

function echoActiveClass($requestUri)
{
    $serv = $_SERVER['REQUEST_URI'];
    if( strpos($serv,'?') === false )
        $current_file_name = basename($serv, ".php");
    else {
        $str = explode('?',$serv);
        $current_file_name = basename($str[0], ".php");
    }

    if ($current_file_name == $requestUri)
        return 'class="active"';
    else
        return '';
}                
         
function printTextbox( $title, $name, $type = "input-xlarge", $ph = "", $required = "", $disable = "" )
{
    echo "<div class=\"control-group\">          
            <label class=\"control-label\" for=\"$name\">$title</label>
            <div class=\"controls\">
              <input type=\"text\" placeholder=\"$ph\" class=\"$type\" name=\"$name\" id=\"$name\" $required $disable>
            </div>
          </div>";
}

function printTextArea( $title, $name, $type = "input-xlarge", $required = "" )
{
    echo '<div class="control-group">
            <label class="control-label" for="'.$name.'">'.$title.'</label>
            <div class="controls">
              <textarea class="'.$type.' textarea" name="'.$name.'" id="'.$name.'" rows="3" '.$required.'></textarea>
            </div>
          </div>';
}

function time2str($ts)
{
    if(!ctype_digit($ts))
        $ts = strtotime($ts);

    $diff = time() - $ts;
    if($diff == 0)
        return 'now';
    elseif($diff > 0)
    {
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 60) return 'just now';
            if($diff < 120) return '1 minute ago';
            if($diff < 3600) return floor($diff / 60) . ' minutes ago';
            if($diff < 7200) return '1 hour ago';
            if($diff < 86400) return floor($diff / 3600) . ' hours ago';
        }
        if($day_diff == 1) return 'Yesterday';
        if($day_diff < 7) return $day_diff . ' days ago';
        if($day_diff < 31) return ceil($day_diff / 7) . ' weeks ago';
        if($day_diff < 60) return 'last month';
        return date('F Y', $ts);
    }
    else
    {
        $diff = abs($diff);
        $day_diff = floor($diff / 86400);
        if($day_diff == 0)
        {
            if($diff < 120) return 'in a minute';
            if($diff < 3600) return 'in ' . floor($diff / 60) . ' minutes';
            if($diff < 7200) return 'in an hour';
            if($diff < 86400) return 'in ' . floor($diff / 3600) . ' hours';
        }
        if($day_diff == 1) return 'Tomorrow';
        if($day_diff < 4) return date('l', $ts);
        if($day_diff < 7 + (7 - date('w'))) return 'next week';
        if(ceil($day_diff / 7) < 4) return 'in ' . ceil($day_diff / 7) . ' weeks';
        if(date('n', $ts) == date('n') + 1) return 'next month';
        return date('F Y', $ts);
    }
}

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
    return "<html><head><title>Error</title></head>
            <body><center><h1>Page Not Found or Access Denied</h1></center>
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