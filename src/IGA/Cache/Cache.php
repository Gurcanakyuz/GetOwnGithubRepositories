<?php
/**
 * Project: GetOwnGithubRepositories
 * Author: Gurcan
 * Date: 13.06.2018
 * Time: 02:49
 * File: Cache.php
 */

namespace IGA\Cache;

class Cache
{

    private $cacheFile;
    private $cacheTime;

    /**
     * Cache constructor.
     */
    public function __construct()
    {
        $this->cacheFile = __DIR__ . "/../../../cache/repos.json";
        $this->cacheTime = 60; // Saniye
    }

    /**
     * @return bool|string
     */
    public function get()
    {

        if(!file_exists($this->cacheFile)){
            touch($this->cacheFile);
        }

        $cachedData = file_get_contents($this->cacheFile);

        if(strlen($cachedData) > 0) {
            $cachedDataObject = json_decode($cachedData);
            $cachedTime = $cachedDataObject->cacheTime;

            // Eğer cache süresi dolduysa uzaktan çekeceğiz.
            if(time() - $cachedTime > $this->cacheTime) {
                return "";
            }
            return $cachedDataObject->data;
        }

        return "";

    }

    /**
     * @param $data
     */
    public function set($data)
    {

        if(!file_exists($this->cacheFile)){
            touch($this->cacheFile);
        }

        $cachedData = new \stdClass();
        $cachedData->cacheTime = time();
        $cachedData->data = $data;

        $file = fopen($this->cacheFile, "w");
        fwrite($file, json_encode($cachedData));
        fclose($file);

    }

}