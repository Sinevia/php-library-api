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

class ApiService {
    private $commandParameterName = "command";

    public $commands = array(
        'home' => 'Sinevia\ApiService@home',
    );

    public function home() {
        return ApiResponse::success(date('Y-m-d H:i:s'));
    }

    public function addCommands($commands = []) {
        $this->commands = array_merge($this->commands, $commands);
        return $this;
    }

    private function executeCommand($commandName) {
        if (isset($this->commands[$commandName]) == false) {
            $statusMessage = 'Command Not Recognized: ' . $commandName;
            return (new ApiResponse())->setStatus('error')->setMessage($statusMessage)->toJson();
        }

        $entry = $this->commands[$commandName];

        $chain = array();
        if (is_array($entry)) {
            foreach ($entry as $e) {
                $chain[] = explode('@', $e);
            }
        } else {
            $chain[] = explode('@', $entry);
        }

        foreach ($chain as $command) {
            $className = $command[0];
            $methodName = $command[1];
            if (class_exists($className) == false) {
                $statusMessage = 'Class Not Found: ' . $className;
                return (new ApiResponse())->setStatus('error')->setMessage($statusMessage)->toJson();
            }

            if (method_exists($className, $methodName) == false) {
                $statusMessage = 'Method Not Found: ' . $methodName;
                return (new ApiResponse())->setStatus('error')->setMessage($statusMessage)->toJson();
            }

            $refl = new \ReflectionMethod($className, $methodName);
            if ($refl->isPublic() == false) {
                $statusMessage = 'Method Not Public: ' . $methodName;
                return (new ApiResponse())->setStatus('error')->setMessage($statusMessage)->toJson();
            }

            $class = new $className;
            $response = $class->$methodName();
            if ($response == null) {
                continue;
            }
            if (is_string($response)) {
                return $response;
            }
            return $response->toJson();
        }
    }

    /**
     * Runs the controller
     * @return string
     */
    public function run($removeHeader = true) {
        if ($removeHeader == true) {
            header_remove();
        }

        $commandName = (isset($_REQUEST[$this->commandParameterName]) == false) ? '' : $_REQUEST[$this->commandParameterName];
        $callback = (isset($_REQUEST['callback']) == false) ? '' : trim(strip_tags($_REQUEST['callback']));
        $result = $this->executeCommand($commandName);

        // JSONP
        if ($callback !== '') {
            return $callback . "(" . $result . ")";
        } else {
            return $result;
        }
    }

}
