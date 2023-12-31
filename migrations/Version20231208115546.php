<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231208115546 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenu_panier DROP INDEX UNIQ_80507DC0F77D927C, ADD INDEX IDX_80507DC0F77D927C (panier_id)');
        $this->addSql('ALTER TABLE contenu_panier ADD produit_id INT NOT NULL, CHANGE panier_id panier_id INT NOT NULL');
        $this->addSql('ALTER TABLE contenu_panier ADD CONSTRAINT FK_80507DC0F347EFB FOREIGN KEY (produit_id) REFERENCES produit (id)');
        $this->addSql('CREATE INDEX IDX_80507DC0F347EFB ON contenu_panier (produit_id)');
        $this->addSql('ALTER TABLE panier DROP INDEX UNIQ_24CC0DF2A76ED395, ADD INDEX IDX_24CC0DF2A76ED395 (user_id)');
        $this->addSql('ALTER TABLE panier CHANGE user_id user_id INT NOT NULL');
        $this->addSql('ALTER TABLE produit DROP FOREIGN KEY FK_29A5EC2761405BF');
        $this->addSql('DROP INDEX IDX_29A5EC2761405BF ON produit');
        $this->addSql('ALTER TABLE produit DROP contenu_panier_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contenu_panier DROP INDEX IDX_80507DC0F77D927C, ADD UNIQUE INDEX UNIQ_80507DC0F77D927C (panier_id)');
        $this->addSql('ALTER TABLE contenu_panier DROP FOREIGN KEY FK_80507DC0F347EFB');
        $this->addSql('DROP INDEX IDX_80507DC0F347EFB ON contenu_panier');
        $this->addSql('ALTER TABLE contenu_panier DROP produit_id, CHANGE panier_id panier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE panier DROP INDEX IDX_24CC0DF2A76ED395, ADD UNIQUE INDEX UNIQ_24CC0DF2A76ED395 (user_id)');
        $this->addSql('ALTER TABLE panier CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD contenu_panier_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produit ADD CONSTRAINT FK_29A5EC2761405BF FOREIGN KEY (contenu_panier_id) REFERENCES contenu_panier (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_29A5EC2761405BF ON produit (contenu_panier_id)');
    }
}
