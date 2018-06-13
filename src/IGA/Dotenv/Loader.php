<?php
/**
 * Project: GetOwnGithubRepositories
 * Author: Gurcan
 * Date: 12.06.2018
 * Time: 22:45
 * File: Loader.php
 */

namespace IGA\Dotenv;

class Loader
{

    /**
     * @var string Dosya yolu
     */
    protected $filePath;

    /**
     *
     * Yeni bir örnek oluştur
     *
     * Loader constructor.
     * @param $filePath
     */
    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    /**
     *
     * .env dosyasını yükle
     *
     * @return array
     */
    public function load()
    {
        $this->checkFileIsReadable();
        $filePath = $this->filePath;
        $lines = $this->readLinesFromFile($filePath);
        foreach ($lines as $line) {
            if (!$this->isComment($line) && $this->isValidLine($line)) {
                $this->setEnvironmentVariable($line);
            }
        }
        return $lines;
    }

    /**
     * Dosyanın okunabilir olup olmadığını kontrol et.
     */
    protected function checkFileIsReadable()
    {
        if (!is_readable($this->filePath) || !is_file($this->filePath)) {
            throw new \RuntimeException(sprintf('Dosya okunamıyor %s.', $this->filePath));
        }
    }

    /**
     *
     * .env satırlarını oku
     *
     * @param $filePath
     * @return array
     */
    protected function readLinesFromFile($filePath)
    {
        // Read file into an array of lines with auto-detected line endings
        $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        ini_set('auto_detect_line_endings', $autodetect);
        return $lines;
    }

    /**
     *
     * Yorum satırı olup olmadığını kontrol et
     *
     * @param $line
     * @return bool
     */
    protected function isComment($line)
    {
        $line = ltrim($line);
        return isset($line[0]) && $line[0] === '#';
    }

    /**
     *
     * Geçerli bir satır olup olmadığını kontrol et, içerisinde "=" var mı?
     *
     * @param $line
     * @return bool
     */
    protected function isValidLine($line)
    {
        return strpos($line, '=') !== false;
    }

    /**
     *
     * Değişken adı ve değerini böl
     *
     * @param $name
     * @param $value
     * @return array
     */
    protected function splitParts($name, $value)
    {
        if (strpos($name, '=') !== false) {
            list($name, $value) = array_map('trim', explode('=', $name, 2));
        }
        return array($name, $value);
    }

    /**
     *
     * Değişkenleri ata
     *
     * @param $name
     * @param null $value
     */
    public function setEnvironmentVariable($name, $value = null)
    {

        list($name, $value) = $this->splitParts($name, $value); # burada validation yapılabilir.

        if (function_exists('apache_getenv') && function_exists('apache_setenv') && apache_getenv($name)) {
            apache_setenv($name, $value);
        }

        if (function_exists('putenv')) {
            putenv("$name=$value");
        }

        $_ENV[$name] = $value;
        $_SERVER['APP_ENV'][$name] = $value;

    }

}