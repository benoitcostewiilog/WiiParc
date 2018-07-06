<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180704083637 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE utilisateurs ADD username VARCHAR(180) NOT NULL, ADD username_canonical VARCHAR(180) NOT NULL, ADD email VARCHAR(180) NOT NULL, ADD email_canonical VARCHAR(180) NOT NULL, ADD enabled TINYINT(1) NOT NULL, ADD salt VARCHAR(255) DEFAULT NULL, ADD password VARCHAR(255) NOT NULL, ADD last_login DATETIME DEFAULT NULL, ADD confirmation_token VARCHAR(180) DEFAULT NULL, ADD password_requested_at DATETIME DEFAULT NULL, ADD roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP login, DROP mdp, DROP nom');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315E92FC23A8 ON utilisateurs (username_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315EA0D96FBF ON utilisateurs (email_canonical)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_497B315EC05FB297 ON utilisateurs (confirmation_token)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_497B315E92FC23A8 ON utilisateurs');
        $this->addSql('DROP INDEX UNIQ_497B315EA0D96FBF ON utilisateurs');
        $this->addSql('DROP INDEX UNIQ_497B315EC05FB297 ON utilisateurs');
        $this->addSql('ALTER TABLE utilisateurs ADD mdp VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, DROP username, DROP username_canonical, DROP email, DROP email_canonical, DROP enabled, DROP salt, DROP last_login, DROP confirmation_token, DROP password_requested_at, DROP roles, CHANGE password login VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
