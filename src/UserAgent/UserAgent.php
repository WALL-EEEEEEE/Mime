<?php
namespace Mime\UserAgent;
use Mime\Helper;

class UserAgent {

    private $ua;

    public final function __construct() {
        $this->ua = Helper::GrabUserAgents(true);
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
     * Pick up an user-agent of pc randomly.
     */
    public  function pc() {
        $samples = Helper::Forge($this->ua,'PC');
        return $samples[array_rand($samples)];
    }

    /**
     * @method mobile
     *
     * Pick up an user-agent of mobile phone randomly.
     */
    public function mobile() {
        $samples = Helper::Forge($this->ua,'MOBILE');
        return $samples[array_rand($samples)];
    }
}

