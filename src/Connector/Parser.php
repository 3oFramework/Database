<?php
/**
 * Created by PhpStorm.
 * User: adrian
 * Date: 3/19/15
 * Time: 9:05 AM
 */

namespace Trio\Database\Connector;

use Trio\Database\Traits\ConfigFolder;

/**
 * Class Parser
 * @package Trio\Database\Connector
 */
class Parser
{

    use ConfigFolder;

    /**
     * @param $configFolder
     */
    public function __construct($configFolder)
    {
        $this->handleConfigFolder($configFolder);
    }

    public function regenerate()
    {
        $config = $this->getConfig('connections.json');

        $this->saveConfig($config, 'connections', 'php');
    }
}