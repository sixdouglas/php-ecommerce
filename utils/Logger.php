<?php
/*
 * Copyright 2018 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class Logger {
    private const MESSAGE_TYPE = 3;
    private const DESTINATION = "log/applicationLog.txt";
    
    private $caller;
    private $config;

    public function __construct($config, $caller) {
        $this->caller = $caller;
        $this->config = $config;
    }

    public function logError($message){
        if ($this->config['logLevel'] == 'ERROR' || $this->config['logLevel'] == 'WARNING' || $this->config['logLevel'] == 'INFO' || $this->config['logLevel'] == 'DEBUG'){
            $this->log('ERROR', $message);
        }
    }

    public function logWarning($message){
        if ($this->config['logLevel'] == 'WARNING' || $this->config['logLevel'] == 'INFO' || $this->config['logLevel'] == 'DEBUG'){
            $this->log('WARNING', $message);
        }
    }

    public function logInfo($message){
        if ($this->config['logLevel'] == 'INFO' || $this->config['logLevel'] == 'DEBUG'){
            $this->log('INFO', $message);
        }
    }

    public function logDebug($message){
        if ($this->config['logLevel'] == 'DEBUG'){
            $this->log('DEBUG', $message);
        }
    }

    private function log($level, $message){
        $date = date('Y-m-d H:i:s');
        $outputMessage = '';
        if (is_array($message)){
            array_walk_recursive($message, 'Logger::test_print');
        } else if ($message instanceof PDOStatement){
            $outputMessage = 'PDOStatement errorCode: ' . $message->errorCode() . ', queryString: ' . $message->queryString;
        } else {
            $outputMessage = $message;
        }

        error_log($date . " " . $this->caller . " " . $level . " " . $outputMessage . "\n", Logger::MESSAGE_TYPE, Logger::DESTINATION);
    }

    function test_print($item, $key) {
        $date = date('Y-m-d H:i:s');
        $level = 'DEBUG';
        $outputMessage = "Key: $key, Value: $item";
        error_log($date . " " . $this->caller . " " . $level . " " . $outputMessage . "\n", Logger::MESSAGE_TYPE, Logger::DESTINATION);
    }
}

?>