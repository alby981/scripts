<?php

include_once "grab.php";

class AssetsAggregator {

    private $html = "";
    private $website = '';
    private $dir = "finalCss";
    private $type = "css";

    function __construct($websiteAddress, $folder, $type) {
        $this->website = $websiteAddress;
        $this->dir = $folder;
        $this->type = $type;
    }
    
    /**
     * 
     * @return type
     */
    public function process() {
        return $this->checkPermissions()->getWebsiteContent()->parseContent();
    }
    
    /**
     * Check folder permissions
     * @return $this
     */
    private function checkPermissions() {
        $dir = $this->dir;
        if (!file_exists($dir)) {
            if (!mkdir($dir, 0777, true)) {
                die("Warning! You don't have permission to create the $dir folder");
            }
        }
        if (!file_put_contents("$dir/test.save", "saved")) {
            die("Warning! You can't save the final css to the folder {$dir}. Check folder permission");
        } else {
            unlink("$dir/test.save");
        }
        return $this;
    }

    /**
     * Get website html
     * @return $this
     */
    private function getWebsiteContent() {
        $html = file_get_contents($this->website);
        $this->html = $html;
        return $this;
    }
    
    /**
     * Parse content of the html website
     * @return $this
     */
    private function parseContent() {
        
        switch($this->type) {
            case 'css':
                $startString = "<link rel='stylesheet'";
                $finalName = 'final_'.time().'.css';
                $urlT = 'href';
                break;
            case 'js':
                $startString = "<script type='text/javascript'";
                $finalName = 'final_'.time().'.js';
                $urlT = 'src';
                break;
        }
        $contents = getContents($this->html, $startString , ">");
        if (empty($contents)) {
            $contents = getContents($this->html, $startString, ">");
        }
        $save = false;
        $final = '';
        foreach ($contents as $css) {
            $filename = getContent($css, "{$urlT}='", "'");
            if (!empty($filename)) {
                if (substr($filename, 0, 5) == 'http:' || substr($filename, 0, 6) == 'https:') {
                    $filename = str_replace("{$urlT}='", "", $filename);
                    $final .= "\n/* File $filename */\n";
                    $final .= file_get_contents($filename);
                    $final .= "\n\n";
                    $save = true;
                }
            }
        }
        if ($save) {
            if (!file_put_contents("{$this->dir}/{$finalName}", $final)) {
                die("Warning! You can't save the final css to the folder {$dir}. Check folder permission");
            }
        }
        return $this;
    }
    private function minify() {
        //TODO
    }
}

$css = new AssetsAggregator("https://ziobelo.com", "finalCss","js");
$css->process();