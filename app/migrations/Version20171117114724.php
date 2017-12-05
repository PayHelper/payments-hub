<?php

namespace PH\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171117114724 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->skipIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE sylius_payment_method_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, instructions LONGTEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_966BE3A12C2AC5D3 (translatable_id), UNIQUE INDEX sylius_payment_method_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ph_subscription_item (id INT AUTO_INCREMENT NOT NULL, subscription_id INT NOT NULL, quantity INT NOT NULL, unit_price INT NOT NULL, total INT NOT NULL, INDEX IDX_21A30BA19A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ph_subscription (id INT AUTO_INCREMENT NOT NULL, method_id INT DEFAULT NULL, currency_code VARCHAR(3) NOT NULL, amount INT NOT NULL, `interval` VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, state VARCHAR(255) NOT NULL, purchase_completed_at DATETIME DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, items_total INT NOT NULL, total INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, purchase_state VARCHAR(255) NOT NULL, payment_state VARCHAR(255) NOT NULL, token_value VARCHAR(255) DEFAULT NULL, metadata LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', UNIQUE INDEX UNIQ_98E208AC96901F54 (number), INDEX IDX_98E208AC19883967 (method_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ph_payment_method (id INT AUTO_INCREMENT NOT NULL, gateway_config_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, environment VARCHAR(255) DEFAULT NULL, is_enabled TINYINT(1) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, supports_recurring TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_97C2D29877153098 (code), INDEX IDX_97C2D298F23D6140 (gateway_config_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ph_payment (id INT AUTO_INCREMENT NOT NULL, method_id INT DEFAULT NULL, subscription_id INT NOT NULL, currency_code VARCHAR(3) NOT NULL, amount INT NOT NULL, state VARCHAR(255) NOT NULL, details LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, canceled_at DATETIME DEFAULT NULL, INDEX IDX_8E3A744B19883967 (method_id), INDEX IDX_8E3A744B9A1887DC (subscription_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ph_gateway_config (id INT AUTO_INCREMENT NOT NULL, gateway_name VARCHAR(255) NOT NULL, factory_name VARCHAR(255) NOT NULL, config LONGTEXT NOT NULL COMMENT \'(DC2Type:json_array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ph_payment_security_token (hash VARCHAR(255) NOT NULL, details LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:object)\', after_url LONGTEXT DEFAULT NULL, target_url LONGTEXT NOT NULL, gateway_name VARCHAR(255) NOT NULL, PRIMARY KEY(hash)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ph_webhook (id INT AUTO_INCREMENT NOT NULL, url VARCHAR(255) NOT NULL, is_enabled TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_6966E710F47645AE (url), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE sylius_payment_method_translation ADD CONSTRAINT FK_966BE3A12C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES ph_payment_method (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ph_subscription_item ADD CONSTRAINT FK_21A30BA19A1887DC FOREIGN KEY (subscription_id) REFERENCES ph_subscription (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE ph_subscription ADD CONSTRAINT FK_98E208AC19883967 FOREIGN KEY (method_id) REFERENCES ph_payment_method (id)');
        $this->addSql('ALTER TABLE ph_payment_method ADD CONSTRAINT FK_97C2D298F23D6140 FOREIGN KEY (gateway_config_id) REFERENCES ph_gateway_config (id) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE ph_payment ADD CONSTRAINT FK_8E3A744B19883967 FOREIGN KEY (method_id) REFERENCES ph_payment_method (id)');
        $this->addSql('ALTER TABLE ph_payment ADD CONSTRAINT FK_8E3A744B9A1887DC FOREIGN KEY (subscription_id) REFERENCES ph_subscription (id) ON DELETE CASCADE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->skipIf('mysql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ph_subscription_item DROP FOREIGN KEY FK_21A30BA19A1887DC');
        $this->addSql('ALTER TABLE ph_payment DROP FOREIGN KEY FK_8E3A744B9A1887DC');
        $this->addSql('ALTER TABLE sylius_payment_method_translation DROP FOREIGN KEY FK_966BE3A12C2AC5D3');
        $this->addSql('ALTER TABLE ph_subscription DROP FOREIGN KEY FK_98E208AC19883967');
        $this->addSql('ALTER TABLE ph_payment DROP FOREIGN KEY FK_8E3A744B19883967');
        $this->addSql('ALTER TABLE ph_payment_method DROP FOREIGN KEY FK_97C2D298F23D6140');
        $this->addSql('DROP TABLE sylius_payment_method_translation');
        $this->addSql('DROP TABLE ph_subscription_item');
        $this->addSql('DROP TABLE ph_subscription');
        $this->addSql('DROP TABLE ph_payment_method');
        $this->addSql('DROP TABLE ph_payment');
        $this->addSql('DROP TABLE ph_gateway_config');
        $this->addSql('DROP TABLE ph_payment_security_token');
        $this->addSql('DROP TABLE ph_webhook');
    }
}
