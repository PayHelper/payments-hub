<?php

namespace PH\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171030154049 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->skipIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ph_subscription ADD method_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ph_subscription ADD CONSTRAINT FK_98E208AC19883967 FOREIGN KEY (method_id) REFERENCES ph_payment_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_98E208AC19883967 ON ph_subscription (method_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->skipIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE ph_subscription DROP CONSTRAINT FK_98E208AC19883967');
        $this->addSql('DROP INDEX IDX_98E208AC19883967');
        $this->addSql('ALTER TABLE ph_subscription DROP method_id');
    }
}
