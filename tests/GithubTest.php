<?php
/**
 * Project: GetOwnGithubRepositories
 * Author: Gurcan
 * Date: 13.06.2018
 * Time: 02:27
 * File: GithubTest.php
 */

use IGA\Controller\Github;
use IGA\Dotenv\Dotenv;

class GithubTest extends PHPUnit_Framework_TestCase
{

    public function setUp()
    {

        require_once __DIR__ . "/../src/IGA/Controller/Github.php";
        require_once __DIR__ . "/../src/IGA/Dotenv/Dotenv.php";
        require_once __DIR__ . "/../src/IGA/Dotenv/Loader.php";
        require_once __DIR__ . "/../src/IGA/Model/Github.php";
        require_once __DIR__ . "/../src/IGA/Cache/Cache.php";

        if (!isset($_SERVER['APP_ENV'])) {
            if (!class_exists(Dotenv::class)) {
                throw new \RuntimeException('.env dosyası bulunamadı.');
            }
            (new Dotenv(__DIR__ . "/.."))->load();
        }

    }

    public function testGetRepositoryList()
    {
        $github = new Github();
        $repositoryList = $github->getRepositoryList();
        $this->assertInternalType('array', $repositoryList);

        if(count($repositoryList) > 0) {
            $first = $repositoryList[0];
            $this->assertInstanceOf('stdClass',$first);
            $this->assertInternalType('int', $first->id);
            $this->assertInternalType('string', $first->name);
            $this->assertInternalType('string', $first->html_url);
            $this->assertInternalType('string', $first->language);
            $this->assertInternalType('int', $first->stargazers_count);
        }

    }

}