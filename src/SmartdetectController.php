<?php

namespace Lotfixyz\Smartdetect;

use App\Http\Controllers\Controller;

/**
 * Class SmartdetectController
 * @package Lotfixyz\Smartdetect
 */
class SmartdetectController extends Controller
{
    /**
     * @param null $result_type
     */
    public function test($result_type = null)
    {
        $smartdetect = new SmartdetectClass();
        $smartdetect->bind_ip('8.8.8.8');
        $smartdetect->bind_domain('lotfi.xyz', SmartdetectClass::DOMAIN_TYPE_ENTIRE);
        $smartdetect->bind_domain('.xyz', SmartdetectClass::DOMAIN_TYPE_EXTENSION);
        $smartdetect->bind_domain('lotfi.', SmartdetectClass::DOMAIN_TYPE_NAME);
        $smartdetect->bind_request('with_value', 110);
        $smartdetect->bind_request('without_value');
        $smartdetect->bind_user('demo', SmartdetectClass::USER_TYPE_EMAIL);
        $smartdetect->bind_user('2', SmartdetectClass::USER_TYPE_ID);
        $smartdetect->make();
        if (in_array($result_type, $smartdetect->result_types)) {
            dd($smartdetect->result->$result_type);
        } else {
            dd((array)$smartdetect->result);
        }
    }
}
