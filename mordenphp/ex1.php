<?php
/*使用接口*/
class DocumentStore{
    protected $data = [];
    public function addDocument(Documentable $document){
        $key = $document->getId();
        $value = $document->getContent();
        $this->data[$key] = $value;
    }
    public function getDocuments(){
        return $this->data;
    }
}

interface Documentable{
    public function getId();
    public function getContent();
}

class HtmlDocument implements Documentable {
    protected $url;
    public function __construct($url)
    {
        $this->url = $url;
    }
    public function getId(){
        return $this->url;
    }
    public function getContent()
    {
        // TODO: Implement getContent() method.
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,3);
        curl_setopt($ch,CURLOPT_FOLLOWLOCATION,1);
        curl_setopt($ch,CURLOPT_MAXREDIRS,3);
        $html = curl_exec($ch);
        curl_close($ch);

        return $html;
    }
}

class StreamDocument implements Documentable {
    protected $resource;
    protected $buffer;

    public function __construct($resource,$buffer=4096)
    {
        $this->resource = $resource;
        $this->buffer = $buffer;
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return 'resource - '.(int)$this->resource;
    }

    public function getContent()
    {
        // TODO: Implement getContent() method.
        $streamContent = '';
        rewind($this->resource);
        while(feof($this->resource)===false){
            $streamContent.=fread($this->resource,$this->buffer);

        }
        return $streamContent;
    }
}

class CommandOutputDocument implements Documentable {
    protected $command;

    public function __construct($command)
    {
        $this->command = $command;
    }

    public function getId()
    {
        // TODO: Implement getId() method.
        return $this->command;
    }

    public function getContent()
    {
        // TODO: Implement getContent() method.
        return shell_exec($this->command);
    }
}

$documentStore = new DocumentStore();

$htmlDoc = new HtmlDocument("http://www.jianshenchao.com");
$documentStore->addDocument($htmlDoc);

$streamDoc = new StreamDocument(fopen("stream.txt",'rb'));
$documentStore->addDocument($streamDoc);

$cmdDoc = new CommandOutputDocument("cat /etc/hosts");
$documentStore->addDocument($cmdDoc);

print_r($documentStore->getDocuments());