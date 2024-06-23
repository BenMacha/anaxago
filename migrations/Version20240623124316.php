<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


final class Version20240623124316 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, first_name VARCHAR(25) NOT NULL, last_name VARCHAR(25) NOT NULL, email VARCHAR(25) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(180) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX KEY_UNIQUE_USER_FILEDS ON user (email)');
    }

}
