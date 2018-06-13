<?php
/**
 * Project: GetOwnGithubRepositories
 * Author: Gurcan
 * Date: 12.06.2018
 * Time: 22:45
 * File: Dotenv.php
 */

namespace IGA\Dotenv;

class Dotenv
{

    /**
     * @var string Dosya yolu
     */
    protected $filePath;

    /**
     * @var Loader Yükleyici
     */
    protected $loader;

    /**
     * Dotenv constructor.
     * @param $path
     * @param string $file
     */
    public function __construct($path, $file = '.env')
    {
        $this->filePath = $this->getFilePath($path, $file);
        $this->loader = new Loader($this->filePath);
    }

    /**
     * @return array
     */
    public function load()
    {
        return $this->loadData();
    }

    /**
     * @param $path
     * @param $file
     * @return string
     */
    protected function getFilePath($path, $file)
    {
        if (!is_string($file)) {
            $file = '.env';
        }
        $filePath = rtrim($path, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$file;
        return $filePath;
    }

    /**
     * @return array
     */
    protected function loadData()
    {
        return $this->loader->load();
    }

}