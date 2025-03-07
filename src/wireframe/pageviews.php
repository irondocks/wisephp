<?php

namespace src\wireframe;

require_once(__DIR__."/../../../vendor/autoload.php");

class PageViews
{
    public $path;
    public $partials = array();
    public $token;
    public $injections = array();
    public $selector;
    public $md;
    /**
     * @method __construct
     * @param string, string
     *
     */
    public function __construct(string $token, string $view_name)
    {
        $this->token = $token;
        $this->path = "$this->token\/view";
        $this->md = $_COOKIE['PHPSESSID'];
        if (!is_dir("$this->path/$view_name") && !mkdir("$this->path/$view_name")) {
            echo "Unable to create needed directories";
        }
        $this->copy = $view_name;
        $this->injections = [];
    }
    
    /**
     * @method addPartial
     * @param string, string, string
     *
     */
    public function addPartial(string $filename, string $view_name = "FALSE", string $res_dir = "FALSE"): bool
    {
        if ($view_name == "FALSE") {
            $view_name = $this->copy;
        }
        if ($res_dir == "FALSE") {
            $res_dir = "partials";
        }
        $bool = 0;
        
        $exp_dir = explode('/', $res_dir);
        $kmd = "";
        foreach ($exp_dir as $k) {
            $kmd .= $k . '/';
            if (!is_dir("$this->path/$view_name/$kmd") && !mkdir("$this->path/$view_name/$kmd")) {
                echo "Unable to create directories";
            }
        }
        if (!is_dir("$this->path/$view_name/$res_dir") && !mkdir("$this->path/$view_name/$res_dir")) {
            echo "Unable to create directories needed";
            return false;
        }
        if (!file_exists("$this->path/$view_name/$res_dir/$filename") && !touch("$this->path/$view_name/$res_dir/$filename")) {
            echo "Unable to create files needed";
            return false;
        }
        foreach ($this->injections as $k=>$v) {
            if ($v[0] == $res_dir && $v[1] == $filename) {
                $bool = 1;
            }
        }
        if ($bool == 1) {
            return false;
        } else {
            array_push($this->injections, $res_dir . "/" . $filename);
        }
        return true;
    }
    
    /**
     * @method addShared
     * @param string
     *
     */
    public function addShared(string $filename): bool
    {
        $bool = 0;
        if (!is_dir("$this->path/shared")) {
            mkdir("$this->path/shared");
        }
        if (!is_dir("$this->path/shared")) {
            echo "Unable to create directories needed";
            return false;
        }
        if (!file_exists("$this->path/shared/$filename")) {
            touch("$this->path/shared/$filename");
            if (!file_exists("$this->path/shared/$filename")) {
                echo "Unable to create files needed";
                return false;
            }
        }
        foreach ($this->injections as $k=>$v) {
            if ($v[0] == "shared" && $v[1] == $filename) {
                $bool = 1;
            }
        }
        if ($bool == 1) {
            return false;
        } else {
            array_push($this->injections, array("shared","$filename"));
        }
        return true;
    }

    /**
     * @method save
     * @param none
     *
     */
    public function save(): bool
    {
        $fp = fopen($this->token."/view/".$_COOKIE['PHPSESSID']."/config.json", "w");
        fwrite($fp, serialize($this));
        fclose($fp);
        return true;
    }
    
    /**
     * @method loadJSON
     * @param none
     *
     */
    public function loadThisJSON(): bool
    {
        if (file_exists($this->token."/view/".$_COOKIE['PHPSESSID']."/config.json") && filesize($this->token."/view/".$_COOKIE['PHPSESSID']."/config.json") > 0) {
            $fp = fopen($this->token."/view/".$_COOKIE['PHPSESSID']."/config.json", "r");
        } else {
            return false;
        }
        $json_context = fread($fp, filesize($this->token."/view/".$_COOKIE['PHPSESSID']."/config.json"));
        $old = unserialize($json_context);
        $b = $old->mvc[$old->token];
        foreach ($b as $key => $val) {
            $this->mvc[$this->token]->sid->$key = $b->sid->$key;
        }
        return true;
    }

    /**
     * @method writeIndex
     * @param none
     *
     */
    public function writeThisIndex():void
    {
        $buff = "<?php";
        $fp = fopen($this->token."/view/".$_COOKIE['PHPSESSID']."/index.php", "w");
        foreach ($this->injections as $k) {
            $vk = $k;
            if ($vk == "shared") {
                $buff .= "\r\n\tinclude_once(\"../shared/$vk\");";
            } else {
                $buff .= "\r\n\tinclude_once(\"../index/$vk\");";
            }
        }
        $buff .= "?>\r\n";
        fwrite($fp, $buff);
        fclose($fp);
    }

    /**
     * @method writeIndex
     * @param none
     *
     */
    public function writeIndex(): void
    {
        $buff = "<?php";
        $fp = fopen("$this->token/index.php", "w");
        foreach ($this->injections as $k) {
            $vk = $k;
            $vv = '';
            if (is_array($vk) && $vk[0] == "shared") {
                $buff .= "\r\n\tinclude_once(__DIR__ . '/view/shared/$vk[1]');";
            } else {
                $buff .= "\r\n\tinclude_once(__DIR__ . \"/view/$this->copy/$vk\");";
            }
        }
        $buff .= "\r\n?>\r\n";
        fwrite($fp, $buff);
        fclose($fp);
    }

    /**
     * @method is_session_started
     * @return bool
     */
    public function is_session_started(): bool
    {
        if (php_sapi_name() !== 'cli') {
            if (version_compare(phpversion(), '5.4.0', '>=')) {
                return session_status() === PHP_SESSION_ACTIVE ? true : false;
            } else {
                return session_id() === '' ? false : true;
            }
        }
        return false;
    }

    /**
     * @method configJSON
     * @param string
     *
     */
    public function configPageWrite(string $view_name = "index"): bool
    {
        $fp = null;

        if (!is_dir($this->token."/view/".$_COOKIE['PHPSESSID']) && !mkdir($this->token."/view/".$_COOKIE['PHPSESSID'])) {
            echo "Unable to create directories";
        }
        if ($view_name == "index") {
            touch($this->token."/view/".$_COOKIE['PHPSESSID']."/index.php");
            $this->writeIndex($this->md);
            return true;
        } elseif (!file_exists($this->token."/view/".$_COOKIE['PHPSESSID']."/config.json")) {
            echo "Unable to find files needed: ".$this->token."/view/".$_COOKIE['PHPSESSID']."/config.json";
        } elseif ($view_name != "index") {
            $fp = fopen($this->token."/view/".$_COOKIE['PHPSESSID']."/index.php", "a");
        }
        $dis = $this->loadThisJSON();
        $buff = "<?php\r\n";
        foreach ($this->injections as $k) {
            $vk = $k;
            if ($vk == "shared") {
                $buff .= "include_once(\"../shared/$vk\");\r\n";
            } elseif ($vk == "partials") {
                $buff .= "include_once(\"../$view_name/$vk\");\r\n";
            } else {
                $buff .= "include_once(\"../view/".$_COOKIE['PHPSESSID']."/$vk\");\r\n";
            }
        }
        $buff .= "?>\r\n";
        fwrite($fp, $buff);
        fclose($fp);
        return true;
    }


    /**
     * @method writePage
     * @param string
     *
     */
    public function writePage(string $view_name = "index"): bool
    {
        $fp = null;
        try {
            if ($view_name == "index") {
                \touch("$this->token/index.php");
                $this->writeIndex();
                return true;
            }
            if (!\is_dir("$this->token/view/$this->md") && !\mkdir("$this->token/view/$this->md")) {
                echo "Unable to create directory needed";
            }
            if (!\file_exists("$this->token/view/$this->md/index.php") && !\file_put_contents("$this->token/view/$this->md/index.php", "")) {
                echo "Unable to create files needed";
            }
            if ($view_name != "index") {
                $fp = \fopen("$this->token/view/$this->md/index.php", "w");
            }
            $buff = "<?php\r\n";
            foreach ($this->injections as $k) {
                $vk = $k;
                if ($vk == "shared") {
                    $buff .= "include_once(\"../shared/$vk\");\r\n";
                } elseif ($vk == "partials") {
                    $buff .= "include_once(\"../$view_name/$vk\");\r\n";
                } else {
                    $buff .= "include_once(\"../$view_name/$vk\");\r\n";
                }
            }
            \fwrite($fp, $buff);
            \fclose($fp);
        } catch (\Exception $e) {
            return true;
        }
    }
    
    /**
     * @method removeDependency
     * @param string, string
     *
     */
    public function removeDependency(string $folder, string $partial): bool
    {
        $bool = 0;
        $k = [];
        foreach ($this->injections as $v) {
            if ($v != array($folder,$partial)) {
                $k = array_merge($k, array($v));
            } else {
                $bool = 1;
            }
        }
        if ($bool == 1) {
            $this->injections = $k;
            return true;
        }
        return false;
    }

    /**
     * @method createAction
     * @param string
     *
     */
    public function createAction(string $action_name): bool
    {
        $this->actions[$this->copy] = new PageViews($this->token, $this->copy);
        $this->actions[$this->copy]->addPartial("index.php", $this->copy, $action_name);
        echo "<br><br><br>" . json_encode($this->actions);
        return true;
    }
}
