<?php

namespace PH\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20171017090729 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->skipIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SEQUENCE sylius_payment_method_translation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ph_subscription_item_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ph_payment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ph_payment_method_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ph_subscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ph_gateway_config_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ph_webhook_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sylius_payment_method_translation (id INT NOT NULL, translatable_id INT NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, instructions TEXT DEFAULT NULL, locale VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_966BE3A12C2AC5D3 ON sylius_payment_method_translation (translatable_id)');
        $this->addSql('CREATE UNIQUE INDEX sylius_payment_method_translation_uniq_trans ON sylius_payment_method_translation (translatable_id, locale)');
        $this->addSql('CREATE TABLE ph_subscription_item (id INT NOT NULL, subscription_id INT NOT NULL, quantity INT NOT NULL, unit_price INT NOT NULL, total INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_21A30BA19A1887DC ON ph_subscription_item (subscription_id)');
        $this->addSql('CREATE TABLE ph_payment (id INT NOT NULL, method_id INT DEFAULT NULL, subscription_id INT NOT NULL, currency_code VARCHAR(3) NOT NULL, amount INT NOT NULL, state VARCHAR(255) NOT NULL, details JSON NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, canceled_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8E3A744B19883967 ON ph_payment (method_id)');
        $this->addSql('CREATE INDEX IDX_8E3A744B9A1887DC ON ph_payment (subscription_id)');
        $this->addSql('CREATE TABLE ph_payment_method (id INT NOT NULL, gateway_config_id INT DEFAULT NULL, code VARCHAR(255) NOT NULL, environment VARCHAR(255) DEFAULT NULL, is_enabled BOOLEAN NOT NULL, position INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, supports_recurring BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97C2D29877153098 ON ph_payment_method (code)');
        $this->addSql('CREATE INDEX IDX_97C2D298F23D6140 ON ph_payment_method (gateway_config_id)');
        $this->addSql('CREATE TABLE ph_subscription (id INT NOT NULL, currency_code VARCHAR(3) NOT NULL, amount INT NOT NULL, interval VARCHAR(255) DEFAULT NULL, type VARCHAR(255) NOT NULL, start_date DATE DEFAULT NULL, state VARCHAR(255) NOT NULL, purchase_completed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, number VARCHAR(255) DEFAULT NULL, items_total INT NOT NULL, total INT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, purchase_state VARCHAR(255) NOT NULL, payment_state VARCHAR(255) NOT NULL, token_value VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_98E208AC96901F54 ON ph_subscription (number)');
        $this->addSql('CREATE TABLE ph_gateway_config (id INT NOT NULL, gateway_name VARCHAR(255) NOT NULL, factory_name VARCHAR(255) NOT NULL, config JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ph_payment_security_token (hash VARCHAR(255) NOT NULL, details TEXT DEFAULT NULL, after_url TEXT DEFAULT NULL, target_url TEXT NOT NULL, gateway_name VARCHAR(255) NOT NULL, PRIMARY KEY(hash))');
        $this->addSql('COMMENT ON COLUMN ph_payment_security_token.details IS \'(DC2Type:object)\'');
        $this->addSql('CREATE TABLE ph_webhook (id INT NOT NULL, url VARCHAR(255) NOT NULL, is_enabled BOOLEAN NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6966E710F47645AE ON ph_webhook (url)');
        $this->addSql('ALTER TABLE sylius_payment_method_translation ADD CONSTRAINT FK_966BE3A12C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES ph_payment_method (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ph_subscription_item ADD CONSTRAINT FK_21A30BA19A1887DC FOREIGN KEY (subscription_id) REFERENCES ph_subscription (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ph_payment ADD CONSTRAINT FK_8E3A744B19883967 FOREIGN KEY (method_id) REFERENCES ph_payment_method (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ph_payment ADD CONSTRAINT FK_8E3A744B9A1887DC FOREIGN KEY (subscription_id) REFERENCES ph_subscription (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ph_payment_method ADD CONSTRAINT FK_97C2D298F23D6140 FOREIGN KEY (gateway_config_id) REFERENCES ph_gateway_config (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->skipIf('postgresql' !== $this->connection->getDatabasePlatform()->getName(), 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE sylius_payment_method_translation DROP CONSTRAINT FK_966BE3A12C2AC5D3');
        $this->addSql('ALTER TABLE ph_payment DROP CONSTRAINT FK_8E3A744B19883967');
        $this->addSql('ALTER TABLE ph_subscription_item DROP CONSTRAINT FK_21A30BA19A1887DC');
        $this->addSql('ALTER TABLE ph_payment DROP CONSTRAINT FK_8E3A744B9A1887DC');
        $this->addSql('ALTER TABLE ph_payment_method DROP CONSTRAINT FK_97C2D298F23D6140');
        $this->addSql('DROP SEQUENCE sylius_payment_method_translation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ph_subscription_item_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ph_payment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ph_payment_method_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ph_subscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ph_gateway_config_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ph_webhook_id_seq CASCADE');
        $this->addSql('DROP TABLE sylius_payment_method_translation');
        $this->addSql('DROP TABLE ph_subscription_item');
        $this->addSql('DROP TABLE ph_payment');
        $this->addSql('DROP TABLE ph_payment_method');
        $this->addSql('DROP TABLE ph_subscription');
        $this->addSql('DROP TABLE ph_gateway_config');
        $this->addSql('DROP TABLE ph_payment_security_token');
        $this->addSql('DROP TABLE ph_webhook');
    }
}
