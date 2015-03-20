<?php

    namespace Trio\Database\Schema\Builder;

    /**
     * (Re)Build the MySQL database schema
     *
     * @author Cornel Borina <cornel@borina.ro>
     */
    class MySQL {

        private $config = [ ];

        public function __construct ( array $config ) {
            $this->config = $config;
        }

        public function build () {
            foreach ( $this->config as $tableName => $fields ) {
                $this->buildTable( $tableName , $fields );
            }
        }

        public function buildTable ( $tableName , $fields ) {
            foreach ( $fields as $fieldName => $fieldData ) {
                $this->buildTableField( $tableName , $fieldName , $fieldData );
            }
        }

        public function buildTableField ( $tableName , $fieldName , $fieldData ) {

        }

    }
