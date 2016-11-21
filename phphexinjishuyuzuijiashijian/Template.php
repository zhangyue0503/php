<?php
/**
 * Created by PhpStorm.
 * User: zhangyue
 * Date: 2016/11/21
 * Time: 上午11:17
 */
class Template{
    private $arrayConfig = array(
        'suffix'=>'.m',
        'templateDir'=>'template/',
        'compiledir'=>'cache/',
        'cache_htm'=>false,
        'suffix_cache'=>'.htm',
        'cache_time'=>2000,
        'php_turn'=>true,
        'cache_control'=>'control.dat',
        'debug'=>'false'
    );
    public $file;
    static private $instance = null;
    private $value = array();
    private $comileTool;
    public $debug = array();
    private $controlData = array();

    public function __construct($arrayConfig = array())
    {
        $this->debug['begin'] = microtime(true);
        $this->arrayConfig = $arrayConfig+$this->arrayConfig;
//        $this->getPath();

        if(!is_dir($this->arrayConfig['templateDir'])){
            exit("template dir isn't found");
        }
        if(!is_dir($this->arrayConfig['compiledir'])){
            mkdir($this->arrayConfig['compiledir'],0770,true);
        }
//        $this->comileTool = new CompileClass();
    }

    public function getPath(){
        $this->arrayConfig['templateDir'] = strstr(realpath($this->arrayConfig['templateDir']),"\\",'/').'/';
        $this->arrayConfig['compiledir'] = strstr(realpath($this->arrayConfig['compiledir']),"\\",'/').'/';
    }

    public static function getInstance(){
        if(is_null(self::$instance)){
            self::$instance = new Template();
        }
        return self::$instance;
    }

    public function setConfig($key,$value=null){
        if(is_array($key)){
            $this->arrayConfig = $key+$this->arrayConfig;
        }else{
            $this->arrayConfig[$key] = $value;
        }
    }

    public function getConfig($key = null){
        if($key){
            return $this->arrayConfig[$key];
        }else{
            return $this->arrayConfig;
        }
    }

    public function assign($key,$value){
        $this->value[$key] = $value;
    }

    public function assignArray($key,$array){
        if(is_array($array)){
            foreach ($array as $k=>$v){
                $this->value[$key][$k] = $v;
            }
        }
    }

    public function path(){
        return $this->arrayConfig['templateDir'].$this->file.$this->arrayConfig['suffix'];
    }

    public function needCache(){
        return $this->arrayConfig['cache_htm'];
    }

    public function reCache($file){
        $flag = false;
        $cacheFile = $this->arrayConfig['compiledir'].md5($file).'.htm';
        if($this->arrayConfig['cache_htm'] == true){
            $timeFlag = (time()-@filemtime($cacheFile))<$this->arrayConfig['cache_time']?true:false;
            if(is_file($cacheFile) && filesize($cacheFile) > 1 && $timeFlag){
                $flag = true;
            }else{
                $flag = false;
            }
        }
        return $flag;
    }

    public function show($file){
        $this->file = $file;
        echo $this->path();
        if(!is_file($this->path())){
            exit('找不到对应的模板');
        }
        $compileFile = $this->arrayConfig['compiledir'].'/'.md5($file).'.php';
        $cacheFile = $this->arrayConfig['compiledir'].md5($file).".htm";
        if($this->reCache($file)===false) {
            $this->debug['cached'] = 'false';
            $this->comileTool = new CompileClass($this->path(), $compileFile, $this->arrayConfig);
            if ($this->needCache()) {
                ob_start();
            }
            extract($this->value, EXTR_OVERWRITE);
            if (!is_file($compileFile) || filemtime($compileFile) < filemtime($this->path())) {
                $this->comileTool->value = $this->value;
                $this->comileTool->compile();
                include $compileFile;
            } else {
                include $compileFile;
            }
        }else{
            readfile($cacheFile);
            $this->debug['cached'] = 'true';
        }

        $this->debug['spend'] = microtime(true) - $this->debug['begin'];
        $this->debug['count'] = count($this->value);
        $this->debug_info();
//        var_dump($compileFile);
//        var_dump($this->path());
//        if(!is_file($compileFile)){
//            mkdir($this->arrayConfig['compiledir']);
//            $this->comileTool->compile($this->path(),$compileFile);
//        }else{
//            readfile($compileFile);
//        }
    }

    public function debug_info(){
        if($this->arrayConfig['debug'] === true){
            echo PHP_EOL,'---------debug info---------',PHP_EOL;
            echo '程序运行日期：',date("Y-m-d H:i:s"),PHP_EOL;
            echo '模板解析耗时：',$this->debug['spend']."秒",PHP_EOL;
            echo '模板包含标签数目：',$this->debug['count'],PHP_EOL;
            echo '是否使用表态缓存：',$this->debug['cached'],PHP_EOL;
            echo '模板引擎实例参数：',var_dump($this->getConfig());
        }
    }
    public function clean($path=null){
        if($path == null){
            $path = $this->arrayConfig['compiledir'];
            $path = glob($path.'*'.$this->arrayConfig['suffix_cache']);
        }else{
            $path = $this->arrayConfig['compiledir'].md5($path).'.htm';
        }
        foreach((array)$path as $v){
            unlink($v);
        }
    }


}

class CompileClass{
    private $template;
    private $content;
    private $comfile;
    private $left = '{';
    private $right = '}';
    private $value = array();
    private $phpTurn;
    public function __construct($template,$compileFile,$config)
    {
        $this->template = $template;
        $this->comfile = $compileFile;
        $this->content = file_get_contents($template);

        if($config['php_turn']){
            $this->T_P[] = "#\{<\?(=|php)(.+?)\?>#is";
            $this->T_R[] = "&lt;? \\1\\2? &gt;";
        }

        $this->T_P[] = "#\{\\$([a-zA-Z_-ÿ][a-zA-Z_-ÿ]* )\}#";
        $this->T_P[] = "#\{(loop|foreach) \\$([a-zA-Z_-ÿ][a-zA-Z_-ÿ]* )\}#";
        $this->T_P[] = "#\{\/(loop|foreach|if)\}#";
        $this->T_P[] = "#\{([K|V])\}#";

        $this->T_P[] = "#\{if (.*?)\}#";
        $this->T_P[] = "#\{(else if|elseif) (.*?)\}#";
        $this->T_P[] = "#\{else\}#";


        $this->T_R[] = "<?php echo \$this->value['\\1']?>";
        $this->T_R[] = "<?php foreach((array)\$this->value['\\2'] as \$K=>\$V){?>";
        $this->T_R[] = "<?php }?>";
        $this->T_R[] = "<?php echo \$\\1;";

        $this->T_R[] = "<?php if(\\1){?>";
        $this->T_R[] = "<?php }else if(\\2){?>";
        $this->T_R[] = "<?php }else{?>";

    }

    private $T_P = array();
    private $T_R = array();

    public function compile($source,$destFile){
//        $this->content = preg_replace($this->T_P,$this->T_R,$this->content);
//        file_put_contents($destFile,file_get_contents($source));
        $this->c_var2();
        $this->c_staticFile();
        file_put_contents($this->comfile,$this->content);
    }

    public function c_var2(){
        $this->content = preg_replace($this->T_P,$this->T_R,$this->content);
    }

    public function c_staticFile(){
        $this->content = preg_replace("#\{\!(.*?)\!\}#","<script src=\\1".'?t='.time()."></script>",$this->content);
    }

    public function __set($name,$value){
        $this->$name = $value;
    }
    public function __get($name){
        return $this->$name;
    }



    public function c_var(){
        $patten = "";
        if(strpos($this->content,'{$')!==false){
            $this->content = preg_replace($patten,"<?php echo \$this->value['\\1'];?>",$this->content);
        }
    }


    public function c_foreach(){

    }


}