<?php
    /**
     * Created by PhpStorm.
     * User: adrian
     * Date: 3/20/15
     * Time: 9:36 AM
     */

    namespace Trio\Database;

    use Illuminate\Support\Arr;
    use Trio\Database\Traits\ConfigFolder;

    use Trio\Database\Manager as Capsule;

    class Connector {

        use ConfigFolder;

        /**
         * @param $configFolder
         */
        public function __construct ( $configFolder = "" ) {
            $this->handleConfigFolder( $configFolder );
        }

        /**
         * Parse the JSON configuration and cache it
         */
        public function regenerate () {
            $config = $this->getConfigJson( 'connections.json' );

            $this->saveConfig( $config , 'connections' , 'php' );
        }

        /**
         * Get the connection array, ready to be used by Laravel Database Capsule
         *
         * @param string $name The name of the connection.
         *
         * @return array
         * @throws \Exception
         */
        public function getConnection ( $name = '' ) {
            $config = $this->getConfig( 'connections' );

            if ( !$name ) {
                $name = Arr::get( $config , 'default' );
            }

            if ( !isset( $config[ $name ] ) ) {
                throw new \BadMethodCallException( "`$name` is not a valid database configuration" );
            }

            if ( !is_array( $config[ $name ] ) ) {
                throw new \BadMethodCallException( "`$name` is not a valid database configuration" );
            }

            return (array) $config;
        }

    }