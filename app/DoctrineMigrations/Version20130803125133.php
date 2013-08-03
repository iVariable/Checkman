<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130803125133 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Employee (id INT AUTO_INCREMENT NOT NULL, firstName VARCHAR(255) NOT NULL, secondName VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, notes LONGTEXT NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Occupation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE ProjectInvolvement (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, involvement SMALLINT NOT NULL, notes LONGTEXT NOT NULL, INDEX IDX_4E8C7C1E166D1F9C (project_id), INDEX IDX_4E8C7C1E8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Spendings (id INT AUTO_INCREMENT NOT NULL, value DOUBLE PRECISION NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE ProjectInvolvement ADD CONSTRAINT FK_4E8C7C1E166D1F9C FOREIGN KEY (project_id) REFERENCES Project (id)");
        $this->addSql("ALTER TABLE ProjectInvolvement ADD CONSTRAINT FK_4E8C7C1E8C03F15C FOREIGN KEY (employee_id) REFERENCES Employee (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE ProjectInvolvement DROP FOREIGN KEY FK_4E8C7C1E8C03F15C");
        $this->addSql("ALTER TABLE ProjectInvolvement DROP FOREIGN KEY FK_4E8C7C1E166D1F9C");
        $this->addSql("DROP TABLE Employee");
        $this->addSql("DROP TABLE Occupation");
        $this->addSql("DROP TABLE Project");
        $this->addSql("DROP TABLE ProjectInvolvement");
        $this->addSql("DROP TABLE Spendings");
    }
}
