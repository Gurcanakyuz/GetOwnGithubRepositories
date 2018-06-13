<?php
/**
 * Project: GetOwnGithubRepositories
 * Author: Gurcan
 * Date: 12.06.2018
 * Time: 23:19
 * File: GithubApi.php
 */

namespace IGA\Model;

use IGA\Cache\Cache;

class Github
{

    private $username;
    private $githubApiUrl;
    private $personalAccessToken;

    /**
     * Github constructor.
     * @param $personalAccessToken
     */
    public function __construct($username, $personalAccessToken)
    {
        $this->username = $username;
        $this->githubApiUrl = "https://api.github.com/user/repos";
        $this->personalAccessToken = $personalAccessToken;
    }

    /**
     *
     */
    public function getRepos()
    {

        $cache = new Cache();
        $cachedData = $cache->get();

        if(empty($cachedData)) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_USERAGENT, 'Agent IGA');
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_USERPWD, $this->username . ":" . $this->personalAccessToken);
            curl_setopt($ch, CURLOPT_TIMEOUT, 30);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

            curl_setopt($ch, CURLOPT_URL, $this->githubApiUrl);

            $output = curl_exec($ch);
            curl_close($ch);

            $cache->set($output);
            $cachedData = $cache->get();

        }

        return $cachedData;

    }

}