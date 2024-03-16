<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240315161953 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE incomes (id INT AUTO_INCREMENT NOT NULL, montant DOUBLE PRECISION NOT NULL, mois DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE budget ADD incomes_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE budget ADD CONSTRAINT FK_73F2F77B7C717147 FOREIGN KEY (incomes_id) REFERENCES incomes (id)');
        $this->addSql('CREATE INDEX IDX_73F2F77B7C717147 ON budget (incomes_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE budget DROP FOREIGN KEY FK_73F2F77B7C717147');
        $this->addSql('DROP TABLE incomes');
        $this->addSql('DROP INDEX IDX_73F2F77B7C717147 ON budget');
        $this->addSql('ALTER TABLE budget DROP incomes_id');
    }
}
