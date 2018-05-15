<?php
namespace Mime\UserAgent;
use Mime\Helper;

class UserAgent {

    private $ua;
    private $__debug;

    public final function __construct(bool $debug = false) {
        $this->__debug = $debug;
        $this->ua = Helper::GrabUserAgents($debug);
    }
    /**
     * @method random
     *
     * Pick up an user-agent randomly.
     */
    public  function random() {
        $samples = Helper::Forge($this->ua,'ALL');
        return $samples[array_rand($samples)];
    }

    /**
     * @method pc
     *
     * Pick up an user-agent of pc browser randomly.
     */
    public  function pc() {
        $samples = Helper::Forge($this->ua,'PC');
        return $samples[array_rand($samples)];
    }

    /**
     * @method mobile
     *
     * Pick up an user-agent of mobile browser randomly.
     */
    public function mobile() {
        $samples = Helper::Forge($this->ua,'MOBILE');
        return $samples[array_rand($samples)];
    }

    /**
     * @method browser()
     * Pick up an user-agent of 
     *
     * Pick up an user-agent of mobile browser or pc browser randomly.
     */
    public function browser() {
        $samples = Helper::Forge($this->ua,'BROWSER');
        return $samples[array_rand($samples)];
    }
}

