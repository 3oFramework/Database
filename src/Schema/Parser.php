<?php

    namespace Trio\Database\Schema;

    use Trio\Database\Traits\ConfigFolder;

    /**
     * Parse configuration and update the schema according to the schema definition.
     * To be used only on migration
     */
    class Parser {

        use ConfigFolder;

        /**
         * @param string $configFolder
         */
        public function __construct ( $configFolder = '' ) {
            $this->handleConfigFolder( $configFolder );
        }

        /**
         * Regenerates the database definitions.
         * This will parse DB.json from the config folder and regenerate DB-public.json
         * and DB.php
         * DB-public.json represents objects safe to be stored on the Client-side
         * DB.php hass the full server-side database structure
         */
        public function regenerate () {
            /* @var $globalDefinition array */
            $globalDefinition = $this->getConfigJson( 'DB.json' );
            $publicDefinition = $privateDefinition = [ ];

            foreach ( $globalDefinition as $tableName => $columns ) {
                $realTableName = static::realKey( $tableName );

                $publicColumns  = [ ];
                $privateColumns = [ ];

                foreach ( $columns as $colName => $col ) {
                    $realColumnName = static::realKey( $colName );
                    if ( static::checkPublic( $colName , $col ) ) {
                        $publicColumns [ $realColumnName ] = $col;
                    }
                    $privateColumns [ $realColumnName ] = $col;
                }
                if ( static::checkPublic( $tableName , $columns ) && !empty( $publicColumns ) ) {
                    $publicDefinition [ $realTableName ] = $publicColumns;
                }

                if ( !empty( $privateColumns ) ) {
                    $privateDefinition [ $realTableName ] = $privateColumns;
                }
            }

            $this->saveConfig( $privateDefinition , 'DB' , 'php' );
            $this->saveConfig( $publicDefinition , 'DB-public' , 'json' );
        }

        /**
         * Check if the provided object (table, field) is public.
         * An object is private if it has a "private " prefix
         * or the associated data has a falsy value for a "public" member
         * or a truey value for "private" member
         *
         * @param string $key
         * @param array  $data
         *
         * @return boolean
         */
        public static function checkPublic ( $key , $data ) {
            $keyParts = explode( ' ' , $key );
            if ( 'private' == $keyParts[ 0 ] ) {
                return FALSE;
            }

            $data = (array) $data;

            if ( isset( $data[ 'private' ] ) && $data[ 'private' ] ) {
                return FALSE;
            }

            if ( isset( $data[ 'public' ] ) && !$data[ 'public' ] ) {
                return FALSE;
            }

            return TRUE;
        }

        public static function realKey ( $key ) {
            $keyParts = explode( ' ' , $key );

            return $keyParts[ count( $keyParts ) - 1 ];
        }


    }