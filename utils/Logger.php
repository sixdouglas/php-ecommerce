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

    public function __construct($caller) {
        $this->caller = $caller;
    }

    public function logError($message){
        $this->log('ERROR', $message);
    }

    public function logWarning($message){
        $this->log('WARNING', $message);
    }

    public function logInfo($message){
        $this->log('INFO', $message);
    }

    public function logDebug($message){
        $this->log('DEBUG', $message);
    }

    private function log($level, $message){
        $date = date('Y-m-d H:i:s');
        $outputMessage = '';
        if (is_array($message)){
            if (!empty($message) && is_array($message[0])){
                $func = function($row) {
                    return implode(',', $row);
                };
                $outputMessage = implode(',', array_map($func, $message));
            }else{
                $outputMessage = implode(',', $message);
            }
        } else if ($message instanceof PDOStatement){
            $outputMessage = 'PDOStatement errorCode: ' . $message->errorCode() . ', queryString: ' . $message->queryString;
        } else {
            $outputMessage = $message;
        }

        error_log($date . " " . $this->caller . " " . $level . " " . $outputMessage . "\n", Logger::MESSAGE_TYPE, Logger::DESTINATION);
    }

}

?>