<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/7
 * Time: 上午9:02
 */
//$input = "john@example.com";
//
//try {
//    $isEmail = filter_val($input, FILTER_VALIDATE_EMAIL);
//} catch (Exception $e) {
//    print_r($e->getMessage());
//}
//echo $isEmail;

$output = '<p><script>alert("NSA backdoor installed");</script></p>';
echo htmlentities($output,ENT_QUOTES,'UTF-8');
echo "<br/>";
$pass = password_hash("123456",PASSWORD_DEFAULT,['cost'=>12]);
echo $pass;
echo "<br/>";
echo password_verify("123456",$pass);
echo "<br/>";

$datetime = new DateTime('2016-11-07 10:40:40 AM');
print_r($datetime);
echo "<br/>";
$interval = new DateInterval('P2W');
$datetime->add($interval);
echo $datetime->format('Y-m-d H:i:s');
echo "<br/>";
$dateStart = new DateTime();
$dateInterval = DateInterval::createFromDateString('-1 day');
$datePeriod = new DatePeriod($dateStart,$dateInterval,3);
foreach ($datePeriod as $date){
    echo $date->format('Y-m-d'),PHP_EOL;
}
echo "<br/>";

try {
    $pdo = new \PDO('mysql:host=127.0.0.1;dbname=books;port=3306;charset=utf8', 'root', 'root');
} catch (Exception $e) {
    echo "Database connection failed.";
    print_r($e->getMessage());
}

//流上下文,file_get_contents()发送POST
$requestBody = '{"username":"josh"}';
$context = stream_context_create(array(
    'http'=>array(
        'method'=>'POST',
        'header'=>'Content-type:application/json;charset=utf-8;\r\n'.
            'Content-length:'.mb_strlen($requestBody),
        'content'=>$requestBody
    )
));
$response = file_get_contents('http://newmoumou/',false,$context);

//流过滤器
$handle = fopen('stream.txt','rb');
stream_filter_append($handle,'string.toupper');
while(feof($handle)!==true){
    echo fgets($handle);
}
fclose($handle);

//php://filter方式
$handle2 = fopen('php://filter/read=string.toupper/resource=stream.txt','rb');
while(feof($handle2)!==true){
    echo fgets($handle2);
}
fclose($handle2);


//自定义流过滤器
Class DirtyWordsFilter extends php_user_filter{
    public function filter($in, $out, &$consumed, $closing)
    {
        $words = array('grime','dirt','grease');
        $wordData = array();
        foreach ($words as $word){
            $replacement = array_fill(0,mb_strlen($word),'*');
            $wordData[$word] = implode('',$replacement);
        }
        $bad = array_keys($wordData);
        $good = array_values($wordData);

        while ($bucket = stream_bucket_make_writeable($in)){
            $bucket->data = str_replace($bad,$good,$bucket->data);
            $consumed += $bucket->datalen;
            stream_bucket_append($out,$bucket);
        }
        return PSFS_PASS_ON;
    }

}
stream_filter_register('dirty_words_filter','DirtyWordsFilter');
//php://filter方式
$handle3 = fopen('php://filter/read=dirty_words_filter/resource=stream.txt','rb');
while(feof($handle3)!==true){
    echo fgets($handle3);
}
fclose($handle3);