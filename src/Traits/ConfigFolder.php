<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 3/19/15
 * Time: 9:07 AM
 */

namespace Trio\Database\Traits;


trait ConfigFolder
{

    private $configFolder = '';

    /**
     * @param $configFolder
     */
    public function handleConfigFolder($configFolder)
    {
        if (!$configFolder) {
            $this->setConfigFolder(__DIR__ . '/../config');
        } else if (is_dir($configFolder)) {
            $this->setConfigFolder($configFolder);
        }
    }

    /**
     * @param $configFolder
     */
    public function setConfigFolder($configFolder)
    {
        $this->configFolder = realpath($configFolder);
    }

    /**
     * @return string
     */
    public function getConfigFolder()
    {
        return $this->configFolder;
    }

    /**
     * @param $file
     * @return mixed
     */
    public function getConfig($file)
    {
        return json_decode(file_get_contents(realpath($this->configFolder . '/' . $file)), TRUE);
    }

    /**
     * @param mixed $contents
     * @param string $file
     * @param string $format
     */
    public function saveConfig($contents, $file, $format = "json") {
        $format = strtolower($format);

        switch (strtolower($format)){
            case "php":
                file_put_contents(sprintf('%s/%s.php', $this->configFolder, $file), '<?php return ' . var_export($contents, true) . ';');
                break;
            case "json":
            default:
                file_put_contents(sprintf('%s/%s.%s', $this->configFolder, $file, $format), json_encode($contents));
                break;
        }
    }
}