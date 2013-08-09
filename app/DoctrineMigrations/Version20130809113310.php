<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20130809113310 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE SpendingsType (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, canBeDeleted TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Spendings ADD project_id INT DEFAULT NULL, ADD employee_id INT DEFAULT NULL, ADD type_id INT DEFAULT NULL");
        $this->addSql("ALTER TABLE Spendings ADD CONSTRAINT FK_6193A72D166D1F9C FOREIGN KEY (project_id) REFERENCES Project (id)");
        $this->addSql("ALTER TABLE Spendings ADD CONSTRAINT FK_6193A72D8C03F15C FOREIGN KEY (employee_id) REFERENCES Employee (id)");
        $this->addSql("ALTER TABLE Spendings ADD CONSTRAINT FK_6193A72DC54C8C93 FOREIGN KEY (type_id) REFERENCES SpendingsType (id)");
        $this->addSql("CREATE INDEX IDX_6193A72D166D1F9C ON Spendings (project_id)");
        $this->addSql("CREATE INDEX IDX_6193A72D8C03F15C ON Spendings (employee_id)");
        $this->addSql("CREATE INDEX IDX_6193A72DC54C8C93 ON Spendings (type_id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE Spendings DROP FOREIGN KEY FK_6193A72DC54C8C93");
        $this->addSql("DROP TABLE SpendingsType");
        $this->addSql("DROP INDEX IDX_6193A72D166D1F9C ON Spendings");
        $this->addSql("DROP INDEX IDX_6193A72D8C03F15C ON Spendings");
        $this->addSql("DROP INDEX IDX_6193A72DC54C8C93 ON Spendings");
        $this->addSql("ALTER TABLE Spendings DROP project_id, DROP employee_id, DROP type_id");
    }
}
