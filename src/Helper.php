<?php
namespace Mime;

/**
 * @class Helper
 *
 * A collection of tools for Mime
 */

class Helper {
    private static $__debug = false;
    private static $__cached_ua = '/tmp/.ua';
    private static $__cached_html = '/tmp/.ua-string-html';
    
    /**
     * @method GrabUserAgents()
     *
     * @param $debug whether to switch on debug mode
     * Grab useragents string from http://useragentstring.com/
     */
    public static function GrabUserAgents(bool $debug = false) {
        self::$__debug = $debug;
        $org_ua_strings = self::__cache_user_agents();
        return $org_ua_strings;
    }

    /**
     * @method Forge()
     * Forge ua strings and extract a specified set of ua from ua strings by mode
     * @param  array $ua ua strings mappings 
     * @param  string $mode ALL,PC,MOBILE
     * @return array  a specified set of  ua
     *
     */
    public static function Forge(array $ua, $mode = 'ALL') {
        $allow_modes = [
            'ALL',
            'PC',
            'MOBILE',
            'BROWSER'
        ];
        $specified_ua = [];
        if (!in_array($mode,$allow_modes)) {
            throw ErrorException('HelperError: Invalid forge mode!');
            exit(0);
        }
        $filter_ua = [];
        if ($mode == 'ALL') {
            $filter_ua = $ua;
       } else if ($mode == 'PC') {
            foreach($ua as $tua) {
                if(array_keys($tua)[0] == 'BROWSERS') {
                    $filter_ua= $tua;
                }
            }
        } else if ($mode == 'MOBILE') {
            foreach($ua as $tua) {
                if(array_keys($tua)[0] == 'MOBILE BROWSERS') {
                    $filter_ua= $tua;
                }
            }
        } else if ($mode == 'BROWSER') {
            foreach($ua as $tua) {
                if(array_keys($tua)[0] == 'MOBILE BROWSERS' || array_keys($tua)[0] == 'BROWSERS') {
                    $filter_ua[] = $tua;
                }
            }
        }
        array_walk_recursive($filter_ua,function(&$value,$key) use(&$specified_ua) {
            $specified_ua[] = $value;
        });
        return $specified_ua;

    }

    private static function Dive(array $array) {
        foreach($array as $sub) {
            if (is_array($sub)) {
                self::Dive($sub);
            } else {
                yield $sub;
            }
        }
    }


    /**
     * @method __cache_user_agents()
     *
     * Cache original useragents strings from http://useragentstring.com
     *
     */
    private static function  __cache_user_agents(){
        $cached_ua = dirname(self::$__cached_ua).DIRECTORY_SEPARATOR.base64_encode(self::$__cached_ua);
        $ua = NULL;
        self::__debug('If cached ua ... ');
        if (file_exists($cached_ua)) {
            self::__debug('Have cached ua ...  yes ');
            $ua = file_get_contents($cached_ua);
            $ua = json_decode($ua,true);
        } else {
            self::__debug('Have cached ua ...  no');
            self::__debug("Caching UserAgent from http://useragentstring.com ...");
            $contents = self::__cache_html();
            if (empty($contents)) {
                throw new \ErrorException('Mime Error: Can\'t get useragent strings from http://useragentstring.com, please check your network and retry!');
            }
            $ua = self::__parse_user_agents($contents);
            self::__debug("Caching UserAgent from http://useragentstring.com ... done");
        }
        return $ua;
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
        $browser_types = [
            'BROWSERS',
            'CLOUD PLATFORMS',
            'CONSOLES',
            'CRAWLERS',
            'E-MAIL CLIENTS',
            'E-MAIL COLLECTORS',
            'FEED READERS',
            'LIBRARIES',
            'LINK CHECKERS',
            'MOBILE BROWSERS',
            'OFFLINE BROWSERS',
            'OTHERS',
            'VALIDATORS'
        ];
        $browsers = [];
        $cached_snippets = [];
        $cached_subsnippets = [];

        self::__debug("Parsing UserAgent from html ... ");
        //retrieve browser names
        for ( $i = 0; $i < count($browser_types); $i++) {
            self::__debug("Parsing UserAgent of ".$browser_types[$i]." ... ");
            if ($i != count($browser_types) -1 ) {
                $xpath = '//h3[preceding::h3[text()="'.$browser_types[$i].'"] and following::h3[text()="'.$browser_types[$i+1].'"]]';
                $snippets_regex = '/<h3[^>]*>'.$browser_types[$i].'<\/h3>.*<h3[^>]*>'.$browser_types[$i+1].'<\/h3>/ms';
            } else {

                $xpath = '//h3[preceding::h3[text()="'.$browser_types[$i].'"]]';
                $snippets_regex = '/<h3[^>]*>'.$browser_types[$i].'<\/h3>.*<\/ul>/ms';
            }
            $subtypes = self::__xpath($xpath,$ua_strings);
            $browsers[] =  [$browser_types[$i]=>$subtypes];
            preg_match($snippets_regex,$ua_strings,$matches);
            $cached_snippets[$browser_types[$i]]  = @$matches[0];
            self::__debug("Parsing UserAgent of ".$browser_types[$i]." ... done ");
        }
    
        //retrieve browser versions and user-agent headers
        foreach($browsers as $key=>$browser) {
            $type = array_keys($browser)[0];
            $browser = array_values($browser)[0];
            for ($i = 0; $i < count($browser); $i++) {

                self::__debug("Parsing versions of ".$browser[$i]." ...");
                if ( $i != count($browser) - 1 ) {

                    $xpath = '//h4[preceding::h3[text()="'.$browser[$i].'"] and following::h3[text()="'.$browser[$i+1].'"]]';
                    $subsnippets_regex = '/<h3[^>]*>(?:<img[^>]*>)?'.addcslashes($browser[$i],'+').'<\/h3>.*<h3[^>]*>(?:<img[^>]*>)?'.addcslashes($browser[$i+1],'+').'<\/h3>/mUs';
                } else {
                    if ( $key != count($browsers) -1 ) {
                        $xpath = '//h4[preceding::h3[text()="'.$browser[$i].'"] and following::h3[text()="'.array_keys($browsers[$key+1])[0].'"]]';
                        $subsnippets_regex = '/<h3[^>]*>(?:<img[^>]*>)?'.$browser[$i].'<\/h3>.*<h3[^>]*>(?:<img[^>]*)?'.array_keys($browsers[$key+1])[0].'<\/h3>/mUs';
 
                    } else {
                        $xpath = '//h4[preceding::h3[text()="'.$browser[$i].'"]]';
                        $subsnippets_regex = '/<h3[^>]*>(?:<img[^>]*>)?'.$browser[$i].'<\/h3>.*<\/ul>/mUs';
                    }
                }
                $versions = self::__xpath($xpath,$cached_snippets[$type]);
                $browsers[$key][$type][$i] =  [$browser[$i] => $versions];
                preg_match($subsnippets_regex,$cached_snippets[$type],$matches);
                $cached_subsnippets[$browser[$i]] = @$matches[0];
                self::__debug("Parsing versions of ".$browser[$i]." ... done ");
            }  
        }
        self::__debug("Parsing UserAgent headers ...");
        foreach($browsers as $bkey=> $browser) {
            $type = array_keys($browser)[0];
            $browser = array_values($browser)[0];
            foreach ($browser as $name => $versions) {
                $versions_name = array_keys($versions)[0];
                $versions = array_values($versions)[0];
                foreach($versions as $vkey => $version) {
                    self::__debug("Parsing headers of ".$version.' ...');
                    if($vkey != count($versions)-1) {

                        $xpath = '//ul[preceding::h4[text()="'.$versions[$vkey].'"] and following::h4[text()="'.$versions[$vkey+1].'"]]/li/a/text()';
                    } else {
                        if ($key != count($browsers) -1) {

                            $xpath = '//ul[preceding::h4[text()="'.$versions[$vkey].'"] and following::h4[text()="'.$versions_name.'"]]/li/a/text()';
                        } else {
                            $xpath = '//ul[preceding::h4[text()="'.$versions[$vkey].'"]]/li/a/text()';
                        }
                    }
                    $links = self::__xpath($xpath,$cached_subsnippets[$versions_name]);
                    $browsers[$bkey][$type][$name][$versions_name][$vkey] = [$version=>$links];
                    self::__debug("Parsing headers of ".$version.'... done');
                }
            } 
        }
        //cached all of headers
        $header_cached = dirname(self::$__cached_ua).DIRECTORY_SEPARATOR.base64_encode(self::$__cached_ua);
        if (!file_exists(dirname($header_cached))) {
              throw new ErrorException('Cache directory '.dirname($html_cached).' not exists ! ');
        } else {
              $serialize_json = json_encode($browsers);
              file_put_contents($header_cached,$serialize_json);
        }
        self::__debug("Parsing UserAgent headers ... done ");
        //retrieve user-agent strings
        self::__debug("Parsing UserAgent from html ... done ");
        return $browsers;
    }

    public static function debug(bool $debug) {
        self::$__debug = $debug;
        return self;
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


    private static function __debug($log) {
        if (self::$__debug === true) {
            echo $log.PHP_EOL;
        }
    }

    private static function __cache_html() {
        $url = 'http://useragentstring.com/pages/useragentstring.php?name=All';
        $html_cached = dirname(self::$__cached_html).DIRECTORY_SEPARATOR.base64_encode(self::$__cached_html);
        $html = '';
        self::__debug('If has cache ...');
        if (file_exists($html_cached)) {
            self::__debug('Html cached found ... yes ');
            self::__debug('Load cached ...');
            $html = file_get_contents($html_cached);
            self::__debug('Load cached ...');
        } else {
            self::__debug('Html cached found ... no');
            self::__debug('Downloading html from http://useragentstring.com ...');
            $html = file_get_contents($url);
            if (!file_exists(dirname($html_cached))) {
                throw new ErrorException('Cache directory '.dirname($html_cached).' not exists ! ');
                exit(0);
            } else {
                file_put_contents($html_cached,$html);
            }
            self::__debug('Downloading html from http://useragentstring.com ... done ');
        }
        return $html;
    }


}
