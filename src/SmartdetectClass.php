<?php

namespace Lotfixyz\Smartdetect;

use Assert\Assert;
use Assert\AssertionFailedException;
use Request;

/**
 * Class SmartdetectClass
 * @package Lotfixyz\Smartdetect
 */
class SmartdetectClass
{
    /**
     *
     */
    public const DOMAIN_TYPE_ENTIRE = 0;

    /**
     *
     */
    public const DOMAIN_TYPE_EXTENSION = 1;

    /**
     *
     */
    public const DOMAIN_TYPE_NAME = 2;

    /**
     *
     */
    public const USER_TYPE_EMAIL = 0;

    /**
     *
     */
    public const USER_TYPE_ID = 1;

    /**
     *
     */
    public const INVOLVE_AUTO = false;

    /**
     *
     */
    public const INVOLVE_NO = false;

    /**
     *
     */
    public const INVOLVE_YES = true;

    /**
     * @var \stdClass
     */
    public $result;

    /**
     * @var \stdClass
     */
    protected $config;

    /**
     * @var array
     */
    protected $is_off = true;

    /**
     * @var array
     */
    protected $is_on = false;

    /**
     * @var
     */
    protected $factors;

    /**
     * @var
     */
    protected $results;

    /**
     * @var array
     */
    public $result_types = ['factor_based', 'flatten_factors', 'flatten', 'at_least_one', 'exact_all'];

    /**
     * @param $user
     */
    private function initial_involve_user($user)
    {
        Assert::lazy()
            ->that($user, "user.email")->keyExists('email')
            ->that($user, "user.id")->keyExists('id')
            ->verifyNow();
        Assert::lazy()
            ->that($user['email'], "user.email")->isArray()
            ->that($user['id'], "user.id")->isArray()
            ->verifyNow();
        foreach ($user['email'] as $v) {
            Assert::that($v)->string();
        }
        foreach ($user['id'] as $v) {
            Assert::that($v)->integer();
        }
        $this->factors['user'] = array_merge($this->factors['user'], $user);
    }

    /**
     * @param $request
     */
    private function initial_involve_request($request)
    {
        foreach ($request as $v) {
            Assert::that($v)->string();
        }
        $this->factors['request'] = array_merge($this->factors['request'], $request);
    }

    /**
     * @param $ip
     */
    private function initial_involve_ip($ip)
    {
        foreach ($ip as $v) {
            Assert::that($v)->ip();
        }
        $this->factors['ip'] = array_merge($this->factors['ip'], $ip);
    }

    /**
     * @param $domain
     */
    private function initial_involve_domain($domain)
    {
        Assert::lazy()
            ->that($domain, "domain.entire")->keyExists('entire')
            ->that($domain, "domain.extension")->keyExists('extension')
            ->that($domain, "domain.name")->keyExists('name')
            ->verifyNow();
        Assert::lazy()
            ->that($domain['entire'], "domain.entire")->isArray()
            ->that($domain['extension'], "domain.extension")->isArray()
            ->that($domain['name'], "domain.name")->isArray()
            ->verifyNow();
        foreach (['entire', 'extension', 'name'] as $k) {
            foreach ($domain[$k] as $v) {
                Assert::that($v)->string();
            }
        }
        $this->factors['domain'] = array_merge($this->factors['domain'], $domain);
    }

    /**
     *
     */
    protected function initial_involve_config()
    {
        $factors = config('smartdetect.factors', []);
        if ($this->config->involve_domain) {
            $this->initial_involve_domain($factors['domain']);
        }
        if ($this->config->involve_ip) {
            $this->initial_involve_ip($factors['ip']);
        }
        if ($this->config->involve_request) {
            $this->initial_involve_request($factors['request']);
        }
        if ($this->config->involve_user) {
            $this->initial_involve_user($factors['user']);
        }
    }

    /**
     *
     */
    private function initial_involve()
    {
        if ($this->config->involve_config) {
            $this->initial_involve_config();
        }
    }

    /**
     *
     */
    private function initial_results()
    {
        $this->results = $this->factors;
    }

    /**
     *
     */
    private function initial_factors()
    {
        $this->factors =
            [
                'domain' =>
                    [
                        'entire' => [],
                        'extension' => [],
                        'name' => [],
                    ],
                'ip' => [],
                'request' => [],
                'user' =>
                    [
                        'email' => [],
                        'id' => [],
                    ],
            ];
    }

    /**
     *
     */
    private function initial_config()
    {
        $this->config = new \stdClass();
        $this->config->debug_mode = config('smartdetect.debug_mode', false);
        Assert::that($this->config->debug_mode)->boolean();
        $this->config->involve_config = config('smartdetect.involve_config', true);
        Assert::that($this->config->involve_config)->boolean();
        $this->config->involve_domain = config('smartdetect.involve_domain', true);
        Assert::that($this->config->involve_domain)->boolean();
        $this->config->involve_ip = config('smartdetect.involve_ip', true);
        Assert::that($this->config->involve_ip)->boolean();
        $this->config->involve_request = config('smartdetect.involve_request', true);
        Assert::that($this->config->involve_request)->boolean();
        $this->config->involve_user = config('smartdetect.involve_user', true);
        Assert::that($this->config->involve_user)->boolean();
    }

    /**
     *
     */
    private function initial()
    {
        $this->initial_config();
        $this->initial_factors();
        $this->initial_results();
        $this->initial_involve();
    }

    /**
     *
     */
    private function boot()
    {
        if (!config()->has('smartdetect')) {
            return;
        }
        $this->is_off = config('smartdetect.turned_off', false);
        Assert::that($this->is_off)->boolean();
        $this->is_on = !($this->is_off);
        if ($this->is_on) {
            $this->initial();
        }
    }

    /**
     *
     */
    private function sector_0()
    {
        $this->result = new \stdClass();
        $this->result->factor_based =
            [
                'domain' =>
                    [
                        'entire' => null,
                        'extension' => null,
                        'name' => null,
                    ],
                'ip' => null,
                'request' => null,
                'user' =>
                    [
                        'email' => null,
                        'id' => null,
                    ],
            ];
        $this->result->flatten_factors =
            [
                'domain_entire' => null,
                'domain_extension' => null,
                'domain_name' => null,
                'ip' => null,
                'request' => null,
                'user_email' => null,
                'user_id' => null,
            ];
        $this->result->flatten = $this->result->flatten_factors;
        $this->result->at_least_one = false;
        $this->result->exact_all = false;
    }

    /**
     * SmartdetectClass constructor.
     */
    public function __construct()
    {
        $this->sector_0();
        $this->boot();
    }

    /**
     * SmartdetectClass destructor
     *
     */
    public function __destruct()
    {

    }

    /**
     *
     */
    protected function make_result_flatten()
    {
        $flatten = $this->result->flatten;
        foreach ($this->result->flatten_factors as $k => $v) {
            $flatten[$k] = (bool)$v;
        }
        $this->result->flatten = $flatten;
    }

    /**
     *
     */
    protected function make_result_flatten_factors()
    {
        $factor_based = $this->result->factor_based;
        $flatten_factors['domain_entire'] = $factor_based['domain']['entire'];
        $flatten_factors['domain_extension'] = $factor_based['domain']['extension'];
        $flatten_factors['domain_name'] = $factor_based['domain']['name'];
        $flatten_factors['ip'] = $factor_based['ip'];
        $flatten_factors['request'] = $factor_based['request'];
        $flatten_factors['user_email'] = $factor_based['user']['email'];
        $flatten_factors['user_id'] = $factor_based['user']['id'];
        $this->result->flatten_factors = $flatten_factors;
    }

    /**
     *
     */
    protected function make_result()
    {
        $this->result->factor_based = $this->results;
        $this->make_result_flatten_factors();
        $this->make_result_flatten();
        $this->result->at_least_one = in_array(true, $this->result->flatten);
        $this->result->exact_all = !in_array(false, $this->result->flatten);
    }

    /**
     * @param $factor
     * @param $factors
     * @return null
     */
    protected function make_user_email($factor, $factors)
    {
        return in_array($factor, $factors) ? $factor : null;
    }

    /**
     * @param $factor
     * @param $factors
     * @return null
     */
    protected function make_user_id($factor, $factors)
    {
        return in_array($factor, $factors) ? $factor : null;
    }

    /**
     *
     */
    protected function make_user()
    {
        $user = $this->factors['user'];
        if ($auth = auth()) {
            if ($auth->check()) {
                $email_factor = $auth->user()->email;
                $id_factor = $auth->id();
                $email_factors = $user['email'];
                $id_factors = $user['id'];
                $result =
                    [
                        'id' => $this->make_user_id($id_factor, $id_factors),
                        'email' => $this->make_user_email($email_factor, $email_factors),
                    ];
                $this->results['user'] = $result;
            }
        }
    }

    /**
     *
     */
    protected function make_request()
    {
        $result = null;
        $factors = $this->factors['request'];
        foreach ($factors as $factor_k => $factor) {
            switch (gettype($factor_k)) {
                case 'integer':
                    if (Request::exists($factor)) {
                        $result = $factor;
                    }
                    break;
                case 'string':
                    if ($factor == Request::input($factor_k)) {
                        $result = $factor_k;
                    }
                    break;
            }
        }
        $this->results['request'] = $result;
    }

    /**
     *
     */
    protected function make_ip()
    {
        if ($factor = Request::getClientIp()) {
            $factors = $this->factors['ip'];
            if (in_array($factor, $factors)) {
				$this->results['ip'] = $factor;
            }
        }
    }

    /**
     * @param $factor
     * @param $factors
     * @return null
     */
    protected function make_domain_entire($factor, $factors)
    {
        return in_array($factor, $factors) ? $factor : null;
    }

    /**
     * @param $factor
     * @param $factors
     * @return null
     */
    protected function make_domain_extension($factor, $factors)
    {
        if (function_exists('array_last')) {
            $extension = array_last(explode('.', $factor));
        } else {
            $extension = \Arr::last(explode('.', $factor));
        }
        foreach ($factors as $v) {
            if (preg_match("/\.$extension$/", '.' . $v)) {
                return $v;
            }
        }
        return null;
    }

    /**
     * @param $factor
     * @param $factors
     * @return null
     */
    protected function make_domain_name($factor, $factors)
    {
        if (function_exists('array_first')) {
            $name = array_first(explode('.', $factor));
        } else {
            $name = \Arr::first(explode('.', $factor));
        }
        foreach ($factors as $v) {
            if (preg_match("/^$name\./", $v . '.')) {
                return $v;
            }
        }
        return null;
    }

    /**
     *
     */
    protected function make_domain()
    {
        $domain = $this->factors['domain'];
        if ($factor = Request::getHttpHost()) {
            $entire_factors = $domain['entire'];
            $extension_factors = $domain['extension'];
            $name_factors = $domain['name'];
            $result =
                [
                    'entire' => $this->make_domain_entire($factor, $entire_factors),
                    'extension' => $this->make_domain_extension($factor, $extension_factors),
                    'name' => $this->make_domain_name($factor, $name_factors),
                ];
            $this->results['domain'] = $result;
        }
    }

    /**
     *
     */
    public function make()
    {
        if ($this->is_on) {
            $this->make_domain();
            $this->make_ip();
            $this->make_request();
            $this->make_user();
            $this->make_result();
        }
    }

    /**
     * @return mixed
     */
    public function get_factors()
    {
        return $this->factors;
    }

    /**
     * @param $factor
     */
    public function bind_ip($factor)
    {
        if ($this->is_on) {
            Assert::that($factor)->ip();
            array_push($this->factors['ip'], $factor);
        }
    }

    /**
     * @param $factor
     * @param $type
     */
    public function bind_domain($factor, $type)
    {
        if ($this->is_on) {
            Assert::lazy()
                ->that($factor, 'factor')->string()
                ->that($type, 'type')->between(self::DOMAIN_TYPE_ENTIRE, self::DOMAIN_TYPE_NAME)
                ->verifyNow();
            switch ($type) {
                case self::DOMAIN_TYPE_ENTIRE:
                    array_push($this->factors['domain']['entire'], $factor);
                    break;
                case self::DOMAIN_TYPE_EXTENSION:
                    array_push($this->factors['domain']['extension'], $factor);
                    break;
                case self::DOMAIN_TYPE_NAME:
                    array_push($this->factors['domain']['name'], $factor);
                    break;
            }
        }
    }

    /**
     * @param $factor
     * @param int $value
     */
    public function bind_request($factor, $value = null)
    {
        if ($this->is_on) {
            Assert::that($factor, 'factor')->string();
            try {
                Assert::that($value, 'value')->nullOr()->integer();
            } catch (AssertionFailedException $e) {
                Assert::that($value, 'value')->nullOr()->string();
            }
            switch (strtolower(gettype($value))) {
                case 'string':
                case 'integer':
                    $this->factors['request'] = array_merge($this->factors['request'], [$factor => $value]);
                    break;
                case 'null':
                    array_push($this->factors['request'], $factor);
                    break;
            }
        }
    }

    /**
     * @param $factor
     * @param $type
     */
    public function bind_user($factor, $type)
    {
        if ($this->is_on) {
            try {
                Assert::that($factor, 'factor')->integer();
            } catch (AssertionFailedException $e) {
                Assert::that($factor, 'factor')->string();
            }
            Assert::that($type, 'type')->between(self::USER_TYPE_EMAIL, self::USER_TYPE_ID);
            switch ($type) {
                case self::USER_TYPE_EMAIL:
                    array_push($this->factors['user']['email'], $factor);
                    break;
                case self::USER_TYPE_ID:
                    array_push($this->factors['user']['id'], $factor);
                    break;
            }
        }
    }
}
