<?php

namespace PH\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20181116074304 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE ph_subscription_metadata (id INT AUTO_INCREMENT NOT NULL, subscription_id INT NOT NULL, metadata_key VARCHAR(255) DEFAULT NULL, metadata_value LONGTEXT DEFAULT NULL, INDEX IDX_D5AB38299A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ph_subscription_metadata ADD CONSTRAINT FK_D5AB38299A1887DC FOREIGN KEY (subscription_id) REFERENCES ph_subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ph_subscription DROP metadata');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE ph_subscription_metadata');
        $this->addSql('ALTER TABLE ph_subscription ADD metadata LONGTEXT NOT NULL COLLATE utf8_unicode_ci COMMENT \'(DC2Type:json_array)\'');
    }
}
