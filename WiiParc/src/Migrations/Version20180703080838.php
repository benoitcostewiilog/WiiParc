<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180703080838 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE affectations (id INT AUTO_INCREMENT NOT NULL, parc_id INT NOT NULL, societe_id INT NOT NULL, dentree DATETIME NOT NULL, dsortie DATETIME DEFAULT NULL, INDEX IDX_4209104812D24CA (parc_id), INDEX IDX_4209104FCF77503 (societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE droits (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, societe_id INT NOT NULL, INDEX IDX_7A9D4CEFB88E14F (utilisateur_id), INDEX IDX_7A9D4CEFCF77503 (societe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE parc (id INT AUTO_INCREMENT NOT NULL, type VARCHAR(255) NOT NULL, marque VARCHAR(255) NOT NULL, nserie VARCHAR(255) NOT NULL, propriete VARCHAR(255) NOT NULL, immatriculation VARCHAR(255) NOT NULL, annee INT NOT NULL, commentaires VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateurs (id INT AUTO_INCREMENT NOT NULL, login VARCHAR(255) NOT NULL, mdp VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectations ADD CONSTRAINT FK_4209104812D24CA FOREIGN KEY (parc_id) REFERENCES parc (id)');
        $this->addSql('ALTER TABLE affectations ADD CONSTRAINT FK_4209104FCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
        $this->addSql('ALTER TABLE droits ADD CONSTRAINT FK_7A9D4CEFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateurs (id)');
        $this->addSql('ALTER TABLE droits ADD CONSTRAINT FK_7A9D4CEFCF77503 FOREIGN KEY (societe_id) REFERENCES societe (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE affectations DROP FOREIGN KEY FK_4209104812D24CA');
        $this->addSql('ALTER TABLE affectations DROP FOREIGN KEY FK_4209104FCF77503');
        $this->addSql('ALTER TABLE droits DROP FOREIGN KEY FK_7A9D4CEFCF77503');
        $this->addSql('ALTER TABLE droits DROP FOREIGN KEY FK_7A9D4CEFB88E14F');
        $this->addSql('DROP TABLE affectations');
        $this->addSql('DROP TABLE droits');
        $this->addSql('DROP TABLE parc');
        $this->addSql('DROP TABLE societe');
        $this->addSql('DROP TABLE utilisateurs');
    }
}