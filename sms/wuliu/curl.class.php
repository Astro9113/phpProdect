<?php 
class curl{
    /*
     * post 请求数据
     * 
     * @param string  $url            请求地址
     * @param mix     $data           请求的数据
     * @param int     $withhead       是否返回请求头信息
     * @param string  $cookie         请求时附加的cookie信息
     * @param string  $reffer         请求来路
     * @param boolean $ssl            加密请求
     * @param boolean $followlocation 是否跟随跳转
     */
    
    static function post($url,$data,$withhead=0,$cookie='',$reffer='',$ssl=false,$followLocation=0,$custom_head = array()){
       $ch = curl_init($url);
       //ssl
       if($ssl){
           curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
           curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
       }
       
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt($ch, CURLOPT_HEADER, $withhead);
       
       //cookie 
       if($cookie){
           curl_setopt($ch, CURLOPT_COOKIE, $cookie);     
       }
       
       //ua
       $ua = get_ua();
       curl_setopt($ch, CURLOPT_USERAGENT, $ua);
       
       //followLocation
       if($followLocation){
       		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followLocation);	       	
       }
       
       //custom_head
       if($custom_head){
           curl_setopt($ch, CURLOPT_HTTPHEADER , $custom_head);
       }
       
       $ret = curl_exec($ch);
       curl_close($ch);
       return $ret;  
    }
    
    /*
     * get 请求数据
     * 
     * @param string  $url            请求地址
     * @param int     $withhead       是否返回请求头信息
     * @param string  $cookie         请求时附加的cookie信息
     * @param string  $reffer         请求来路
     * @param boolean $followlocation 是否跟随跳转
     * @param boolean $ssl            加密请求
     */
    static function get($url,$withhead=0,$cookie='',$reffer='',$followLocation=0,$ssl=false){
        $ch = curl_init($url);
        if($ssl){
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);
        }
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_HEADER, $withhead);
        if($cookie){
            curl_setopt($ch, CURLOPT_COOKIE, $cookie);
        }
        
        //follow location
        if($followLocation){
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $followLocation);
        }
        
        $ua = curl::get_ua();
        curl_setopt($ch, CURLOPT_USERAGENT, $ua);
        $ret = curl_exec($ch);
        
        curl_close($ch);
        return $ret;
    }
    
    static function get_ua(){
        return 'Mozilla/5.0 (X11; U; Linux i686; en-GB; rv:1.8.1.6) Gecko/20070914 Firefox/2.0.0.7';
    }
}