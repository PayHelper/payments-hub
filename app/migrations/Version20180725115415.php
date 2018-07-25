<?php

declare(strict_types=1);

namespace PH\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180725115415 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE ph_subscription_metadata_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE ph_subscription_metadata (id INT NOT NULL, subscription_id INT NOT NULL, metadata_key VARCHAR(255) DEFAULT NULL, metadata_value TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D5AB38299A1887DC ON ph_subscription_metadata (subscription_id)');
        $this->addSql('ALTER TABLE ph_subscription_metadata ADD CONSTRAINT FK_D5AB38299A1887DC FOREIGN KEY (subscription_id) REFERENCES ph_subscription (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ph_subscription DROP metadata');
        $this->addSql('ALTER TABLE ph_payment_method ALTER supports_recurring SET NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('DROP SEQUENCE ph_subscription_metadata_id_seq CASCADE');
        $this->addSql('DROP TABLE ph_subscription_metadata');
        $this->addSql('ALTER TABLE ph_payment_method ALTER supports_recurring DROP NOT NULL');
        $this->addSql('ALTER TABLE ph_subscription ADD metadata JSON DEFAULT NULL');
    }
}
