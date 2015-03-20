<?php

    namespace Trio\Database\Connector;

    use Trio\Database\Traits\ConfigFolder;

    /**
     * Class Parser
     *
     * @package Trio\Database\Connector
     */
    class Parser {

        use ConfigFolder;

        /**
         * @param $configFolder
         */
        public function __construct ( $configFolder = "" ) {
            $this->handleConfigFolder( $configFolder );
        }

        public function regenerate () {
            $config = $this->getConfigJson( 'connections.json' );

            $this->saveConfig( $config , 'connections' , 'php' );
        }

    }