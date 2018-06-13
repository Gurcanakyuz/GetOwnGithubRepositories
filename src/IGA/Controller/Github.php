<?php
/**
 * Project: GetOwnGithubRepositories
 * Author: Gurcan
 * Date: 12.06.2018
 * Time: 23:49
 * File: Github.php
 */

namespace IGA\Controller;

use IGA\Model\Github as MGithub;

class Github
{

    private $username;
    private $personalAccessToken;
    private $repositoryList;

    /**
     * Github constructor.
     */
    public function __construct()
    {

        if (!isset($_SERVER['APP_ENV']['USERNAME']) || !isset($_SERVER['APP_ENV']['PERSONAL_ACCESS_TOKEN'])) {
            throw new \RuntimeException(".env dosyasında USERNAME ve/veya PERSONAL_ACCESS_TOKEN parametreleri bulunamadı.");
        }

        $this->setUsername($_SERVER['APP_ENV']['USERNAME']);
        $this->setPersonalAccessToken($_SERVER['APP_ENV']['PERSONAL_ACCESS_TOKEN']);

        $github = new MGithub($this->getUsername(), $this->getPersonalAccessToken());
        $this->setRepositoryList($github->getRepos());

    }

    /**
     * @return mixed
     */
    private function getUsername()
    {
        return $this->username;
    }

    /**
     * @param mixed $username
     */
    private function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return mixed
     */
    private function getPersonalAccessToken()
    {
        return $this->personalAccessToken;
    }

    /**
     * @param mixed $personalAccessToken
     */
    private function setPersonalAccessToken($personalAccessToken)
    {
        $this->personalAccessToken = $personalAccessToken;
    }

    /**
     * @return mixed
     */
    public function getRepositoryList()
    {
        return json_decode($this->repositoryList);
    }

    /**
     * @param mixed $reposityList
     */
    private function setRepositoryList($reposityList)
    {
        $this->repositoryList = $reposityList;
    }



}