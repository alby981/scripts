<?php

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
        $this->checkPermissions()->getWebsiteContent()->parseContent();
        die("assets aggregator execution finished.");
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

        switch ($this->type) {
            case 'css':
                $startString = "<link rel='stylesheet'";
                $finalName = 'final_' . time() . '.css';
                $urlT = 'href';
                break;
            case 'js':
                $startString = "<script type='text/javascript'";
                $finalName = 'final_' . time() . '.js';
                $urlT = 'src';
                break;
        }
        $contents = $this->getContents($this->html, $startString, ">");
        if (empty($contents)) {
            $contents = $this->getContents($this->html, $startString, ">");
        }
        $save = false;
        $final = '';
        foreach ($contents as $asset) {
            $filename = $this->getContent($asset, "{$urlT}='", "'");
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
    
    /**
     * 
     * @param type $str
     * @param type $startDelimiter
     * @param type $endDelimiter
     * @return type
     */
    private static function getContents($str, $startDelimiter, $endDelimiter) {
        $contents = array();
        $startDelimiterLength = strlen($startDelimiter);
        $endDelimiterLength = strlen($endDelimiter);
        $startFrom = $contentStart = $contentEnd = 0;
        while (false !== ($contentStart = strpos($str, $startDelimiter, $startFrom))) {
            $contentStart += $startDelimiterLength;
            $contentEnd = strpos($str, $endDelimiter, $contentStart);
            if (false === $contentEnd) {
                break;
            }
            $contents[] = substr($str, $contentStart, $contentEnd - $contentStart);
            $startFrom = $contentEnd + $endDelimiterLength;
        }

        return $contents;
    }
    
    /**
     * @param type $str
     * @param type $first
     * @param type $second
     * @return type
     */
    private static function getContent($str, $first, $second) {
        $startsAt = strpos($str, $first) + strlen($first);
        $endsAt = strpos($str, $second, $startsAt);
        $result = substr($str, $startsAt, $endsAt - $startsAt);
        return $result;
    }

    private function minify() {
        //TODO
    }

}

$assets = new AssetsAggregator("https://ziobelo.com", "assets", "css");
$assets->process();
