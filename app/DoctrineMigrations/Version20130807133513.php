<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130807133513 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE occupationToEmployee (occupation_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_FD4F1F8D22C8FC20 (occupation_id), INDEX IDX_FD4F1F8D8C03F15C (employee_id), PRIMARY KEY(occupation_id, employee_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE occupationToEmployee ADD CONSTRAINT FK_FD4F1F8D22C8FC20 FOREIGN KEY (occupation_id) REFERENCES Occupation (id)");
        $this->addSql("ALTER TABLE occupationToEmployee ADD CONSTRAINT FK_FD4F1F8D8C03F15C FOREIGN KEY (employee_id) REFERENCES Employee (id)");
        $this->addSql("ALTER TABLE Employee CHANGE notes notes LONGTEXT DEFAULT NULL");
        $this->addSql("ALTER TABLE Project CHANGE description description LONGTEXT DEFAULT NULL");
        $this->addSql("ALTER TABLE ProjectInvolvement CHANGE notes notes LONGTEXT DEFAULT NULL");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE occupationToEmployee");
        $this->addSql("ALTER TABLE Employee CHANGE notes notes LONGTEXT NOT NULL");
        $this->addSql("ALTER TABLE Project CHANGE description description LONGTEXT NOT NULL");
        $this->addSql("ALTER TABLE ProjectInvolvement CHANGE notes notes LONGTEXT NOT NULL");
    }
}
