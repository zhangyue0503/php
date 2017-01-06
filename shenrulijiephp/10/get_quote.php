<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2017/1/6
 * Time: 上午10:30
 */

if(isset($_GET['symbol'])&&!empty($_GET['symbol'])){
    $url = sprintf('http://quote.yahoo.com/d/quotes.csv?s=%s&f=nl1',$_GET['symbol']);
    $fp = fopen($url,'r');
    $read = fgetcsv($fp);

    fclose($fp);
    if(strcasecmp($read[0],$_GET['symbol'])!== 0){
        echo '<div>The latest value for <span class="quote">'.$read[0].'</span>(<span class="quote">)'.$_GET['symbol'].'</span> is $<span class="quote"'.$read[1].'</span></div>';
    }else{
        echo '<div class="error">Invalid symbol!</div>';
    }
}
?>
<form action="get_quote.php" method="get">
    <fieldset>
        <legend>Enter a NYSE stock symbol to get the latest price</legend>
        <p><label for="symbol">Symbol</label>：<input type="text" name="symbol" size="5" maxlength="5"> </p>
        <p><input type="submit" name="submit" value="Fetch the Quote!"/> </p>
    </fieldset>
</form>
