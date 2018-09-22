<?php
class Youtube {
    
    var $conn = false;
	//gmail username
    var $username = "ujicobasnmptn@gmail.com";
	//gmail password
    var $password = "HarusKuliah**//";
    var $error = false;
          
    function get($url)
    {
        $this->conn = new Curl('youtube');
        
        $html = $this->conn->get($url);

        if(strstr($html,'verify-age-thumb'))
        {
            $this->error = "Adult Video Detected";
            return false;
        }

        if(strstr($html,'das_captcha'))
        {
            $this->error = "Captcah Found please run on diffrent server";
            return false;
        }

        if(!preg_match('/stream_map=(.[^&]*?)&/i',$html,$match))
        {
            $this->error = "Error Locating Downlod URL's";
            return false;
        }

        if(!preg_match('/stream_map=(.[^&]*?)(?:\\\\|&)/i',$html,$match))
        {
            return false;
        }

        $fmt_url =  urldecode($match[1]);
   
        $urls = explode(',',$fmt_url);
                
        $foundArray = array();

        foreach($urls as $url)
        {            
            if(preg_match('/itag=([0-9]+)/',$url,$tm) && preg_match('/sig=(.*?)&/', $url , $si) && preg_match('/url=(.*?)&/', $url , $um))
            {
                $u = urldecode($um[1]);
                $foundArray[$tm[1]] = $u.'&signature='.$si[1];
            }
        }
                        
        $typeMap = array();

        $typeMap[13] = array("13", "3GP", "Low Quality - 176x144");
        $typeMap[17] = array("17", "3GP", "Medium Quality - 176x144");
        $typeMap[36] = array("36", "3GP", "High Quality - 320x240");
        $typeMap[5]  = array("5", "FLV", "Low Quality - 400x226");
        $typeMap[6]  = array("6", "FLV", "Medium Quality - 640x360");
        $typeMap[34] = array("34", "FLV", "Medium Quality - 640x360");
        $typeMap[35] = array("35", "FLV", "High Quality - 854x480");
        $typeMap[43] = array("43", "WEBM", "Low Quality - 640x360");
        $typeMap[44] = array("44", "WEBM", "Medium Quality - 854x480");
        $typeMap[45] = array("45", "WEBM", "High Quality - 1280x720");
        $typeMap[18] = array("18", "MP4", "Medium Quality - 480x360");
        $typeMap[22] = array("22", "MP4", "High Quality - 1280x720");
        $typeMap[37] = array("37", "MP4", "High Quality - 1920x1080");
        $typeMap[33] = array("38", "MP4", "High Quality - 4096x230");

        
        $videos = array();
        
        foreach($typeMap as $format => $meta) {
            if (isset($foundArray[$format])) {
                $videos[] = array('ext' => strtolower($meta[1]) , 'type' => $meta[2], 'url' => $foundArray[$format]);
            } 
        }

        return $videos;

        
    }
    
}