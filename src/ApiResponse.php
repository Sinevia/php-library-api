<?php
// ========================================================================= //
// SINEVIA CONFIDENTIAL                                  http://sinevia.com  //
// ------------------------------------------------------------------------- //
// COPYRIGHT (c) 2008-2017 Sinevia Ltd                   All rights reserved //
// ------------------------------------------------------------------------- //
// LICENCE: All information contained herein is, and remains, property of    //
// Sinevia Ltd at all times.  Any intellectual and technical concepts        //
// are proprietary to Sinevia Ltd and may be covered by existing patents,    //
// patents in process, and are protected by trade secret or copyright law.   //
// Dissemination or reproduction of this information is strictly forbidden   //
// unless prior written permission is obtained from Sinevia Ltd per domain.  //
//===========================================================================//

namespace Sinevia;

class ApiResponse {

    private $id = null;
    private $status = null;
    private $message = null;
    private $data = null;

    const AUTHENTICATION_FAILED = "authentication_failed";
    const SUCCESS = "success";
    const ERROR = "error";
    const OK = "ok";
    const FAIL = "fail";
    
    function getData() {
        return $this->data;
    }
    
    function getId() {
        return $this->id;
    }
    
    function getMessage() {
        return $this->message;
    }    
    
    function getStatus() {
        return $this->status;
    }

    function setId($id) {
        $this->id = $id;
        return $this;
    }

    function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    function setMessage($message) {
        $this->message = $message;
        return $this;
    }

    function setData($data) {
        $this->data = $data;
        return $this;
    }

    function toJson() {
        $array = [];

        if ($this->id != null) {
            $array['id'] = $this->id;
        }
        if ($this->status !== null) {
            $array['status'] = $this->status;
        }
        if ($this->message !== null) {
            $array['message'] = $this->message;
        }
        if ($this->data !== null) {
            $array['data'] = $this->data;
        }

        return json_encode($array);
    }
    
    public static function auth($message = '', $data = []) {
        return (new ApiResponse)->setStatus(self::AUTHENTICATION_FAILED)->setMessage($message)->setData($data);
    }
    
    public static function error($message = '', $data = []) {
        return (new ApiResponse)->setStatus(self::ERROR)->setMessage($message)->setData($data);
    }
    
    public static function success($message = '', $data = []) {
        return (new ApiResponse)->setStatus(self::SUCCESS)->setMessage($message)->setData($data);
    }

}
