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
     * Grab useragents string from http://useragentstring.com/
     */
    public static function GrabUserAgents() {

        $org_ua_strings = self::__cache_user_agents('/tmp/.ua');
    }

    /**
     * @method __cache_user_agents()
     *
     * Cache original useragents strings from http://useragentstring.com
     *
     * @param string $cache_path Path stored the cached useragents
     */
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

    /**
     * @method __parse_user_agents()
     *
     * Parse user-agent headers from original ua strings
     *
     * @param string $ua_string original content grabed from http://useragentstring.com
     *
     */
    private static function __parse_user_agents($ua_strings) {
        $browser_typs = [
            'browsers',
            'cloud_platforms',
        ];
        $xpath = '//h3[preceding::h3[text()="BROWSERS"] and following::h3[text()="CLOUD PLATFORMS"]]';
        $browser_types = self::__xpath($xpath,$ua_strings);
        var_dump($browser_types);
    }

    /**
     * @method __xpath()
     * 
     * Simple tool to extract html by xpath
     *
     * @param string $xpath xpath string
     */
    private static function __xpath($xpath, $html) {
        $document = new \DomDocument();
        @$document->loadHTML($html);
        $dom_xpath = new \DOMXPath($document);
        $nodelists = $dom_xpath->query($xpath);
        $contents = [];
        foreach($nodelists as $node) {
            $contents[] = $node->nodeValue;
        }
        return $contents;
 
    }


}
