<?php
/*
 * Copyright 2018 the original author or authors.
 *
 * Licensed under the Apache License, Version 2.0 (the 'License');
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an 'AS IS' BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

abstract class AbstractModel
{
    // PDO Database Access Object
    private $db;
    private $logger;
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
        $this->logger = new Logger('AbstractModel');
    }

    // Execute SQL Query, prepared if possible
    protected function executeQuery(string $sql, $params = null)
    {
        $this->logger->logDebug($sql);
        if ($params == null) {
            $resultat = $this->getDb()->query($sql); // execute right away
        } else {
            $resultat = $this->getDb()->prepare($sql); // prepared query
            $resultat->execute($params);
        }
        return $resultat->fetchAll(PDO::FETCH_ASSOC);
    }

    // Execute SQL Query, prepared if possible
    protected function executeSimpleQuery(string $sql, $params = null)
    {
        $this->logger->logDebug($sql);
        if ($params == null) {
            $return = $this->getDb()->query($sql); // execute right away
        } else {
            $resultat = $this->getDb()->prepare($sql); // prepared query
            $return = $resultat->execute($params);
        }
        $this->logger->logDebug('Return: ' . $return);
        return $return;
    }

    // Get DB connection Object, initialize it if needed
    private function getDB()
    {
        if ($this->db == null) {
            // Connection creation
            $this->db = new PDO('mysql:host=' . $this->config['database']['host'] . ':' . $this->config['database']['port'] . ';dbname=' . $this->config['database']['name'] . ';charset=utf8',
                $this->config['database']['user'], 
                $this->config['database']['password'], 
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        }
        return $this->db;
    }
}
