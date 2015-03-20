<?php
    /**
     * Created by PhpStorm.
     * User: adrian
     * Date: 3/20/15
     * Time: 9:23 AM
     */

    namespace Trio\Database;

    use Trio\Database\Traits\ConfigFolder;

    /**
     * Class Manager
     *
     * @package Trio\Database
     */
    class Manager extends \Illuminate\Database\Capsule\Manager {
        use ConfigFolder;

        public static function connect ( $connction = '' , $configFolder = '' ) {
            $connector = new Connector( $configFolder );

            $capsule = new static;
            $capsule->addConnection( $connector->getConnection( $connection ) );

            static::$instance = $capsule;
        }
    }