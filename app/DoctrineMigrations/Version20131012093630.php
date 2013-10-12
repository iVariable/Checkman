<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20131012093630 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Project ADD region_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Project ADD CONSTRAINT FK_E00EE97298260155 FOREIGN KEY (region_id) REFERENCES Region (id)");
        $this->addSql("CREATE INDEX IDX_E00EE97298260155 ON Project (region_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Project DROP FOREIGN KEY FK_E00EE97298260155");
        $this->addSql("DROP INDEX IDX_E00EE97298260155 ON Project");
        $this->addSql("ALTER TABLE Project DROP region_id");
    }
}
