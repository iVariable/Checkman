<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130907102919 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Employee (id INT AUTO_INCREMENT NOT NULL, firstName VARCHAR(255) NOT NULL, secondName VARCHAR(255) NOT NULL, salary DOUBLE PRECISION NOT NULL, notes LONGTEXT DEFAULT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE occupationToEmployee (employee_id INT NOT NULL, occupation_id INT NOT NULL, INDEX IDX_FD4F1F8D8C03F15C (employee_id), INDEX IDX_FD4F1F8D22C8FC20 (occupation_id), PRIMARY KEY(employee_id, occupation_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Occupation (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Project (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, status SMALLINT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE ProjectInvolvement (id INT AUTO_INCREMENT NOT NULL, project_id INT NOT NULL, employee_id INT DEFAULT NULL, involvement SMALLINT NOT NULL, notes LONGTEXT DEFAULT NULL, INDEX IDX_4E8C7C1E166D1F9C (project_id), INDEX IDX_4E8C7C1E8C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE Spendings (id INT AUTO_INCREMENT NOT NULL, project_id INT DEFAULT NULL, employee_id INT DEFAULT NULL, type_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, date DATE NOT NULL, INDEX IDX_6193A72D166D1F9C (project_id), INDEX IDX_6193A72D8C03F15C (employee_id), INDEX IDX_6193A72DC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE SpendingsType (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, canBeDeleted TINYINT(1) NOT NULL, UNIQUE INDEX title_idx (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE occupationToEmployee ADD CONSTRAINT FK_FD4F1F8D8C03F15C FOREIGN KEY (employee_id) REFERENCES Employee (id)");
        $this->addSql("ALTER TABLE occupationToEmployee ADD CONSTRAINT FK_FD4F1F8D22C8FC20 FOREIGN KEY (occupation_id) REFERENCES Occupation (id)");
        $this->addSql("ALTER TABLE ProjectInvolvement ADD CONSTRAINT FK_4E8C7C1E166D1F9C FOREIGN KEY (project_id) REFERENCES Project (id)");
        $this->addSql("ALTER TABLE ProjectInvolvement ADD CONSTRAINT FK_4E8C7C1E8C03F15C FOREIGN KEY (employee_id) REFERENCES Employee (id)");
        $this->addSql("ALTER TABLE Spendings ADD CONSTRAINT FK_6193A72D166D1F9C FOREIGN KEY (project_id) REFERENCES Project (id)");
        $this->addSql("ALTER TABLE Spendings ADD CONSTRAINT FK_6193A72D8C03F15C FOREIGN KEY (employee_id) REFERENCES Employee (id)");
        $this->addSql("ALTER TABLE Spendings ADD CONSTRAINT FK_6193A72DC54C8C93 FOREIGN KEY (type_id) REFERENCES SpendingsType (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE occupationToEmployee DROP FOREIGN KEY FK_FD4F1F8D8C03F15C");
        $this->addSql("ALTER TABLE ProjectInvolvement DROP FOREIGN KEY FK_4E8C7C1E8C03F15C");
        $this->addSql("ALTER TABLE Spendings DROP FOREIGN KEY FK_6193A72D8C03F15C");
        $this->addSql("ALTER TABLE occupationToEmployee DROP FOREIGN KEY FK_FD4F1F8D22C8FC20");
        $this->addSql("ALTER TABLE ProjectInvolvement DROP FOREIGN KEY FK_4E8C7C1E166D1F9C");
        $this->addSql("ALTER TABLE Spendings DROP FOREIGN KEY FK_6193A72D166D1F9C");
        $this->addSql("ALTER TABLE Spendings DROP FOREIGN KEY FK_6193A72DC54C8C93");
        $this->addSql("DROP TABLE Employee");
        $this->addSql("DROP TABLE occupationToEmployee");
        $this->addSql("DROP TABLE Occupation");
        $this->addSql("DROP TABLE Project");
        $this->addSql("DROP TABLE ProjectInvolvement");
        $this->addSql("DROP TABLE Spendings");
        $this->addSql("DROP TABLE SpendingsType");
    }
}
