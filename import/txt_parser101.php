<!DOCTYPE html>
<html>
  <head>
    <title>Parse Result</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8" />
    </head>
  <body>
  <?php

    // File Path
    // /Users/jeremyyen/Dropbox/Document/archive
    
    include('LIB_parse.php');
    
    if ($handle = opendir('txt101/')) 
    {
        $c = 1;
        while (false !== ($entry = readdir($handle))) {
            if( $entry != ".." && $entry != "." && $entry != '.DS_Store')
            {
                echo "$c - $entry : ";
                $c++;
            
                // DEBUG
                //if( $c >= 5 ) break;
                                
                $data = array();
                $raw = read_file("txt101/$entry");
                
                // 處理班級與年份
                // $raw_temp = return_between( $raw, '班級', '姓名：', EXCL);
                // $data['year'] = 100;
                //str_replace('級','',rmbr( return_between( $raw_temp, '（', '）', EXCL) ));
                
                // $raw_temp_2 = np(return_between( $raw_temp, '：', '年', EXCL ));
                // $data['studentClass'] = $raw_temp_2 . 
                                        //fill_zero(np(return_between( $raw_temp, '年', '班', EXCL )));
                
                // 處理手機
                $no_phone = true;
                if( !(strpos($raw, '手機：') === false ) ) {              
                    $no_phone = false;
                    $data['studentPhone'] = rmbr(np(return_between( $raw, '手機：', '報考科系：', EXCL)));      
                }    
                
                // 處理姓名
                //if($no_phone)
                //    $data['studentName'] = rmbr(np(return_between( $raw, '姓名：', '報考科系', EXCL)));
                //else
                //    $data['studentName'] = np(return_between( $raw, '姓名：', '手機：', EXCL));
                
                // 利用檔名處理 班級 姓名 年份
                //$arr = explode('-',$entry);
                //$data['studentName'] = ltrim($arr[1], ' 0123456789');
                $data['year'] = substr( $entry, 0 , 3 );
                //$data['studentClass'] = 
                
                $arr = explode('3', $entry);
                $class = substr( $arr[1], 0 , 2);
                $data['studentClass'] = '3'. $class;
                $data['studentName'] = str_replace($class,'',str_replace('.txt', '', $arr[1]));
                
                // 處理學校系所
                $raw_temp_2 = np(rmbr(return_between( $raw, '報考科系：', '學測分數：', EXCL)));
                $arr = explode('大學',$raw_temp_2);
                                
                $data['schoolName'] = $arr[0]."大學";
                
                //if( strpos($arr[1],'（個人申請）') !== false )
                //$data['schoolDepart'] = $arr[1];
                
                $ret = str_replace( substr( $arr[1], 0, -6 ), '' , $arr[1] );
                //echo $ret;
                if( cont($ret, "正取") || cont($ret, "備取") || cont($ret, "就讀") ) {
                    $data['schoolResult'] = $ret;   
                    $data['schoolDepart'] = substr( $arr[1], 0, -4 ); 
                }
                else {
                    $data['schoolDepart'] = $arr[1];
                }
                
                $data['schoolResult'] = $ret;
                //else if( strpos($arr[1],'（個人申請，現就讀）') !== false ) {
               //     $data['schoolDepart'] = str_replace('（個人申請，現就讀）','',$arr[1]);
                //    $data['schoolResult'] = '就讀';
                //}
                               
                
                // 處理學測成績
                $str = return_between( $raw, '學測分數：', '級分', EXCL);
                $data['studentGradeChinese'] = intval(np(return_between($str, '國文','英文',EXCL)));
                $data['studentGradeEnglish'] = intval(np(return_between($str, '英文','數學',EXCL)));
                $data['studentGradeMath'] = intval(np(return_between($str, '數學','社會',EXCL)));
                $data['studentGradeSocial'] = intval(np(return_between($str, '社會','自然',EXCL)));
                $data['studentGradeScience'] = intval(np(return_between($str, '自然','總',EXCL)));
                $data['studentGradeTotal'] = $data['studentGradeChinese'] + 
                                             $data['studentGradeEnglish'] + 
                                             $data['studentGradeMath'] +  
                                             $data['studentGradeSocial'] + 
                                             $data['studentGradeScience']; 
                
                $data['interviewMethod'] = noul(trim(rmbr(return_between( $raw, '指定項目甄試方式：', '二、備審資料項目：', EXCL))));
                
                $data['interviewApplying'] = noul(trim(rmbr(return_between( $raw, '備審資料項目：', '三、指定項', EXCL))));
                                        
                $data['interviewDetail'] = str_replace('（流程、時間、型式、口試、筆試題目…等）','',return_between($raw,'指定項目甄試過程及內容：','四、個人心得',EXCL));
                
                if( strpos($raw,'分享，讓世界更美好') === false )
                    $data['interviewOpinion'] = str_replace('：（學測篩選成績、第二階段注意事項、個人觀察…）','',rmaddi(trim(split_string($raw, '個人心得及建議', AFTER, EXCL))));   
                else
                    $data['interviewOpinion'] = str_replace('：（學測篩選成績、第二階段注意事項、個人觀察…）','',rmaddi(trim(return_between($raw,'個人心得及建議','分享，讓世界更美好',EXCL))));
            
                $data['schoolClass'] = 0;
                $data['createUser'] = 'admin(管理員)';
                
                
                
                //echo "<pre>";
                //echo var_dump($data);
                //echo "</pre>";
               
                $connection = curl_init();
                $toURL = "http://localhost/clone/uid/import/import.php";
                $result = send_request($connection, $data, $toURL);
                curl_close($connection);
                
                //$result = "false";
                echo "$result\n";
            }
        }
        
        closedir($handle);
    }
    
    
    
    
    
    
        
    function send_request( $handle, $arr, $url)
    {
        $options = array(
            CURLOPT_URL=>$url,
            CURLOPT_HEADER=>0,
            CURLOPT_VERBOSE=>0,
            CURLOPT_RETURNTRANSFER=>true,
            CURLOPT_USERAGENT=>"Mozilla/4.0 (compatible;)",
            CURLOPT_POST=>true,
            CURLOPT_POSTFIELDS=>http_build_query($arr),
        );
        curl_setopt_array($handle, $options);
        return curl_exec( $handle ); 
    }
    
    function read_file($filename)
    {
        $handle = fopen($filename, "rb");
        $contents = fread($handle, filesize($filename));
        fclose($handle);
        return $contents;
    }
    
    function fill_zero( $str )
    {
        $num = intval($str);
        if( $num < 10 )
            return "0".$num;
        else
            return $num;
    }
    
    function np( $str )
    {
        return noul(str_replace('　','', preg_replace('/\s+/', '', $str)));   
    }
    
    function noul($str)
    {
        return str_replace('_','',$str);
    }
    
    function cont($str, $search)
    {
        if( strpos($str, $search) === false )
            return false;
        else
            return true;
    }
    
    function rmbr( $str )
    {
        return str_replace (array("\r\n", "\n", "\r"), ' ', $str);
    }
     
    function rmaddi( $str )
    {
        return str_replace('：（學測篩選成績、第二階段注意事項、個人觀察）','',$str);
    } 
        
  ?>      
  </body>
</html>
