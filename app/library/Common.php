<?php
use Phalcon\Mvc\User\Component as Component;
use Phalcon\Logger\Adapter\File as FileAdapter;

class Common extends Component
{
    //返回错误结果
    public function _printError($code)
    {
        $out = $this->errmsg->getErrMsg($code);

        return json_encode($out,JSON_UNESCAPED_UNICODE);
    }

    public function _printSuccess($value=array(),$isobj=0)
    {
        $out = array("status" => 1,"data" => $value);

        if($isobj){
            $out = array("status" => 1,"data" => (object)$value );
        }

        return json_encode($out);
    }


    /**
     * 读结果缓存文件
     *
     * @params  string  $cache_name
     * @return  array   $data
     */
    function readStaticCache($cacheName)
    {
        static $result = array();
        if (!empty($result[$cacheName])){
            return $result[$cacheName];
        }

        $data = array();
        $staticCachesDir = ROOT_PATH . '/temp/static_caches/';
        if(!is_dir($staticCachesDir)){

        }

        $cacheFilePath = $staticCachesDir. $cacheName . '.php';

        if (file_exists($cacheFilePath)){
            include_once($cacheFilePath);
            $result[$cacheName] = $data;
            return $result[$cacheName];
        }else{
            return false;
        }
    }

    /**
     * 写结果缓存文件
     *
     * @params  string  $cache_name
     * @params  string  $caches
     *
     * @return
     */
    function writeStaticCache($cacheName, $caches)
    {
        $cacheFilePath = ROOT_PATH . '/temp/static_caches/' . $cacheName . '.php';
        $content = "<?php\r\n";
        $content .= "\$data = " . var_export($caches, true) . ";\r\n";
        $content .= "?>";
        file_put_contents($cacheFilePath, $content, LOCK_EX);
    }

    public function _logger($abbr, $type, $message)
    {
        $filePath = ERRLOG_PATH."$abbr.log";
        if(defined('DEBUG') || defined('TRACE')){
            //判断日志文件是否存在，不存在则创建
            if(!is_dir(ERRLOG_PATH)){
                mkdir(ERRLOG_PATH,0777,true);
            }elseif(!file_exists($filePath)){
                touch($filePath);
            }

            $logger = new FileAdapter($filePath);
            switch($type){
                case 'D':  # Debug
                    $logger->debug($message . ".");
                    break;

                case 'I':  # Info
                    $logger->info($message . ".");
                    break;

                case 'N':  # Notice
                    $logger->notice($message . ".");
                    break;

                case 'W':  # Warning
                    $logger->warning($message . ".");
                    break;

                case 'E':  # Error
                    $logger->error($message . ".");
                    break;

                case 'C':  # Critical
                    $logger->critical($message . ".");
                    break;

                case 'A':  # Alert
                    $logger->alert($message . ".");
                    break;

                case 'M':  # Emergency
                    $logger->emergency($message . ".");
                    break;
            }
            return;
        }

        $ctname = "timer4$abbr";  # commit timer name
        $lgname = "logger$abbr";  # logger name
        $coname = "reopen$abbr";  # close-open timer name

        $cts = time(); # current timestatmp

        if(!$this->persistent->has($ctname))
        {
            # Open+a log file
            $logger = new FileAdapter($filePath);

            # Put handler into bag
            $this->persistent->set($lgname, $logger);

            # Start log transaction
            $this->persistent->get($lgname)->begin();

            # Put next-reopen-logfile timestamp into bag
            $this->persistent->set($coname, mktime(3, 0, 0, (int)date('m', strtotime("+1 day")),
                (int)date('d', strtotime("+1 day")),
                (int)date('Y', strtotime("+1 day"))));

            # Put commit timestamp into bag - here first time
            $this->persistent->set($ctname, $cts);
        }

        switch($type){
            case 'D':  # Debug
                $this->persistent->get($lgname)->debug($message);
                break;

            case 'I':  # Info
                $this->persistent->get($lgname)->info($message);
                break;

            case 'N':  # Notice
                $this->persistent->get($lgname)->notice($message);
                break;

            case 'W':  # Warning
                $this->persistent->get($lgname)->warning($message);
                break;

            case 'E':  # Error
                $this->persistent->get($lgname)->error($message);
                break;

            case 'C':  # Critical
                $this->persistent->get($lgname)->critical($message);
                break;

            case 'A':  # Alert
                $this->persistent->get($lgname)->alert($message);
                break;

            case 'M':  # Emergency
                $this->persistent->get($lgname)->emergency($message);
                break;
        }

#       echo "last commit time = " . $this->persistent->get($ctname) . "</br>";
#       echo "next reopen time = " . $this->persistent->get($coname) . "</br>";
#       echo "current time     = " . $cts . "</br>";

        if($cts - $this->persistent->get($ctname) >= 5){
            # Commit
            $this->persistent->get($lgname)->commit();

            # Refresh the commit timestamp in bag
            $this->persistent->set($ctname, $cts);

            # Whether it is time to close-open
            if($cts >= $this->persistent->get($coname)){
                # Close and rename
                $this->persistent->get($lgname)->close();
                rename($filePath,
                    ERRLOG_PATH . "$abbr" . date('Ymd') . ".log");

                # Open and put handler into bag
                $logger = new FileAdapter($filePath);
                $this->persistent->set($lgname, $logger);

                # Put next-reopen-logfile timestamp into bag
                $this->persistent->set($coname, mktime(3, 0, 0, (int)date('m', strtotime("+1 day")),
                    (int)date('d', strtotime("+1 day")),
                    (int)date('Y', strtotime("+1 day"))));
            }

            $this->persistent->get($lgname)->begin();
        }

        return;
    }

    /**
     * 通过新浪API将长URL转换成短URL
     * @param    $longUrl
     * @return   mixed
     */
    public  function sinaLongUrlToShortUrl($longUrl)
    {
        $this->config = new ConfigIni(CONFIG_PATH . 'config-msg.ini');
        $apiKey = $this->config->app->SinaAppKey ? $this->config->app->SinaAppKey:'1462195281';
        $apiUrl='http://api.t.sina.com.cn/short_url/shorten.json?source='.$apiKey.'&url_long='.urlencode($longUrl);
        //初始化一个curl对象
        $curlObj = curl_init();
        curl_setopt($curlObj, CURLOPT_URL, $apiUrl);
        curl_setopt($curlObj, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlObj, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curlObj, CURLOPT_HEADER, 0);
        curl_setopt($curlObj, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        $response = curl_exec($curlObj);
        curl_close($curlObj);
        $json = json_decode($response);

        return($json[0]->url_short);
    }

    public function uploadImgs($files)
    {
        $rep = array();
        foreach($files as $file){
            $fileError = $file->getError();//文件是否错误
            $fileName  = $file->getName();//文件名
            $fileExt   = $file->getExtension();//文件后缀名
            $fileKey   = $file->getKey();//文件的key
            $fileSize  = $file->getSize();//文件大小

            if($fileSize > 1024*1024){
                $rep['fail'][] = array("name"=>$fileKey,"url"=>$fileName);
                continue;
            }

            $filePath = $this->common->getImgSavePath($fileExt);
            if(!$filePath){
                $rep['fail'][] = array("name"=>$fileKey,"url"=>$filePath);
                continue;
            }

            $file->moveTo(PUBLIC_PATH.$filePath);
            $rep['success'][] = array("name"=>$fileKey,"url"=>$filePath);
        }

        return $rep;
    }

    public function getImgSavePath($fileExt)
    {
        $vedioExtArr = array('amr','wav','mp3','mp4','acc','ape','rm','ogg','avi','wma');
        $imgExtArr = array('jpg','jpeg','png','gif');

        $curDirName = $this->getDateByCurrentWeek();

        if(in_array(strtolower($fileExt),$imgExtArr)){
            $relativeDirPath = 'media/images/'.$curDirName;
        }elseif(in_array(strtolower($fileExt),$vedioExtArr)){
            $relativeDirPath = 'media/vedio/'.$curDirName;
        }else{
            return false;
        }

        $dirPath = PUBLIC_PATH.$relativeDirPath;
        if(!is_dir($dirPath)){
            $rusult = mkdir($dirPath,0777,true);
            if(!$rusult){
                return false;
            }
        }
        $fileName =  date("dHis", time()).rand(1000,10000).".".$fileExt;
        $relativeFilePath = $relativeDirPath.DS.$fileName;

        return $relativeFilePath;
    }


    /**
     * 获取当前星期某一天的日期
     * @param int $specifyWeek
     * @return mixed
     */
    public function getDateByCurrentWeek($specifyWeek = 0)
    {
        $curWeek = date('w');
        if($curWeek == $specifyWeek){
            $curDirName = date("Ymd");
        }else{
            $curDirName = date("Ymd",strtotime("-$curWeek days"));
        }

        return $curDirName;
    }


    /**
     * 返回指定日期当天起始时间戳
     * @param $date 20160102
     * @return int
     */
    public function dayStampStart($date)
    {
        $pattern = "/[^0-9]/";
        $date = trim(preg_replace($pattern,'',$date));
        $stampStart = strtotime($date."000000");
        return $stampStart;
    }


    /**
     * 返回指定日期当天结束时间戳
     * @param $date 20160102
     * @return int
     */
    public function dayStampEnd($date)
    {
        $pattern = "/[^0-9]/";
        $date = trim(preg_replace($pattern,'',$date));
        $stampEnd = mktime(23,59,59,substr($date,4,2),substr($date,6,2),substr($date,0,4));
        return $stampEnd;
    }

    /**
     * 加密密码字符串
     * @param $password
     * @return string
     */
    public function passwordEncryption($password)
    {
        return  md5(md5('qj_'.$password));
    }


    /**
     * 获取服务端IP
     * @return mixed
     */
    public function getServerIp()
    {
        $serverIp = $_SERVER['SERVER_ADDR'];
        return $serverIp;
    }


    /**
     * 从数组中取指定长度的值
     * @param array $data
     * @param $pgNum
     * @param $pgSize
     * @return array
     */
    public function pagination(array $data,$pgNum,$pgSize)
    {
        if(empty($data)){return array();}

        $start = ($pgNum-1)*$pgSize;
        $sliceArr = array_slice($data,$start,$pgSize,true);

        return $sliceArr;
    }
}