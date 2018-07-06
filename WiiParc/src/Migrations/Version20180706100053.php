<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180706100053 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parc ADD type_id INT NOT NULL, ADD propriete_id INT NOT NULL, DROP type, DROP propriete');
        $this->addSql('ALTER TABLE parc ADD CONSTRAINT FK_CADCF501C54C8C93 FOREIGN KEY (type_id) REFERENCES type_vehicule (id)');
        $this->addSql('ALTER TABLE parc ADD CONSTRAINT FK_CADCF50118566CAF FOREIGN KEY (propriete_id) REFERENCES propriete (id)');
        $this->addSql('CREATE INDEX IDX_CADCF501C54C8C93 ON parc (type_id)');
        $this->addSql('CREATE INDEX IDX_CADCF50118566CAF ON parc (propriete_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE parc DROP FOREIGN KEY FK_CADCF501C54C8C93');
        $this->addSql('ALTER TABLE parc DROP FOREIGN KEY FK_CADCF50118566CAF');
        $this->addSql('DROP INDEX IDX_CADCF501C54C8C93 ON parc');
        $this->addSql('DROP INDEX IDX_CADCF50118566CAF ON parc');
        $this->addSql('ALTER TABLE parc ADD type VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD propriete VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP type_id, DROP propriete_id');
    }
}
