<?php
namespace Mime;

/**
 * @class Helper
 *
 * A collection of tools for Mime
 */

class Helper {

    /**
     * @method GrabUserAgents()
     *
     * Grab useragets string from http://useragentstring.com/
     */
    public static function GrabUserAgents() {

        $org_ua_strings = self::__cache_user_agents('/tmp/.ua');
    }

    private static function  __cache_user_agents($cache_path){
        $url = 'http://useragentstring.com/pages/useragentstring.php?name=All';
        $contents = file_get_contents($url);
        if (empty($contents)) {
            throw new \ErrorException('Mime Error: Can\'t get useragent strings from http://useragentstring.com, please check your network and retry!');
        }
        //cache original useragent strings
        $cache_dir = dirname($cache_path);
        if (!file_exists($cache_dir)) {
            throw new \ErrorException('Mime Error: Cache dir('.$cache_dir.') not exists in your disks ! Please check out and retry !');
        } else {
            $fcached = $cache_dir.DIRECTORY_SEPARATOR.base64_encode($cache_path);
            $if_success = file_put_contents($fcached,$contents);
            if ($if_success === false) {
                throw new \ErrorException('Mime Error: You don\'t have the privilege to write on cache dir('.$cache_dir.') ! Please check out and retry !');
            }
        }
        self::__parse_user_agents($contents);
        


    }

    private static function __parse_user_agents($ua_strings) {
        $xpath = '//h3/text()';
        $html = new \DomDocument();
        @$html->loadHTML($ua_strings);
        $dom_xpath = new \DOMXPath($html);
        $browser_nodes = $dom_xpath->query($xpath);
        $browser_types = [];
        foreach($browser_nodes as $node) {
            $browser_types[] = $node->nodeValue;
        }
        var_dump($browser_types);
    }


}
