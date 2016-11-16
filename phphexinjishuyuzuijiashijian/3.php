<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/15
 * Time: 上午9:39
 */
$html = file_get_contents('http://www.baidu.com/');
print_r($http_response_header);
$fp = fopen('http://www.baidu.com/','r');
print(stream_get_meta_data($fp));
fclose($fp);

//$sock = fsockopen("127.0.0.1",12345,$errno,$errstr,1);
//if(!$sock){
//    echo "$errstr($errno)\r\n";
//}else{
////    scoket_set_blocking($sock,false);   //
//    fwrite($sock,"send data....\r\n");
//    fwrite($sock,"end\r\n");
//    while(!feof($sock)){
//        echo fread($sock,128);
//        flush();
//        ob_flush();
//        sleep(1);
//    }
//    fclose($sock);
//}

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,'http://www.php.net');
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);

curl_setopt($ch,CURLOPT_HEADER,1);
$output = curl_exec($ch);
$info = curl_getinfo($ch);
print_r($info);
curl_close($ch);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL,'http://exphp/phphexinjishuyuzuijiashijian/post_output.php');
$post_data = [
    "foo"=>"bar",
    "query"=>"php",
    "action"=>"Submit"
];
curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch,CURLOPT_POST,1);

curl_setopt($ch,CURLOPT_POSTFIELDS,$post_data);
$output = curl_exec($ch);
curl_close($ch);
echo $output;

class smtp_mail{
    private $host;
    private $port = 25;
    private $user;
    private $pass;
    private $debug = false;
    private $sock;
    private $mail_format = 0;

    function smtp_mail($host,$port,$user,$pass,$format=1,$debug=0){
        $this->host = $host;
        $this->port = $port;
        $this->user = base64_encode($user);
        $this->pass = base64_encode($pass);
        $this->mail_format = $format;
        $this->debug = $debug;

        $this->sock = fsockopen($this->host,$this->port,$errno,$errstr,10);
        if(!$this->sock){
            exit("Error number:$errno,Error message:$errstr\n");
        }
        $response = fgets($this->sock);
        if(strstr($response,"220")===false){
            exit("server error:$response\n");
        }
    }
    private function show_debug($message){
        if($this->debug){
            echo "<p>Debug: $message</p>\n";
        }
    }
    private function do_command($cmd,$return_code){
        fwrite($this->sock,$cmd);
        $response = fgets($this->sock);
        if(strstr($response,"$return_code")===false){
            $this->show_debug($response);
            return false;
        }
        return true;
    }
    private function is_email($email){
        $pattren = '/^[^_][\w]* @[\w.]+[\w]*[^_]$/';
        if(preg_match($pattren,$email,$matches)){
            return true;
        }else{
            return false;
        }
    }
    public function send_mail($from,$to,$subject,$body){
        if(!$this->is_email($from) OR !$this->is_email($to)){
            $this->show_debug("Please enter vaild from/to email.");
            return false;
        }
        if(empty($subject) OR empty($body)){
            $this->show_debug("Please enter subject/content");
            return false;
        }
        $detail = "From:".$from."\r\n";
        $detail.="To:".$to."\r\n";
        $detail.="Suject:".$subject."\r\n";

        if($this->mail_format == 1){
            $detail .= "Content-Type:text/html;\r\n";
        }else{
            $detail .= "Content-Type:text/plain;\r\n";
        }
        $detail .= "charset=gb2312\r\n\r\n";
        $detail .= $body;

        $this->do_command("HELO smtp.qq.com\r\n",250);
        $this->do_command("AUTH LOGIN\r\n",334);
        $this->do_command($this->user."\r\n",334);
        $this->do_command($this->pass."\r\n",235);
        $this->do_command("MAIL FROM:<".$from.">\r\n",250);
        $this->do_command("RCPT TO:<".$to.">\r\n",250);
        $this->do_command("DATA\r\n",354);
        $this->do_command($detail."\r\n.\r\n",250);
        $this->do_command("QUIT\r\n",221);
        return true;
    }
}

//$mail = new smtp_mail('smtp.163.com',25,'','');
//$mail->send_mail('s',"",'Hello Body','This is example email for you!');




