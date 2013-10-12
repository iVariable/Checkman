<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131012091210 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Employee ADD region_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Employee ADD CONSTRAINT FK_A4E917F798260155 FOREIGN KEY (region_id) REFERENCES Region (id)");
        $this->addSql("CREATE INDEX IDX_A4E917F798260155 ON Employee (region_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Employee DROP FOREIGN KEY FK_A4E917F798260155");
        $this->addSql("DROP INDEX IDX_A4E917F798260155 ON Employee");
        $this->addSql("ALTER TABLE Employee DROP region_id");
    }
}
