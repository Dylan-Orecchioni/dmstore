<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211221150453 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, date DATETIME NOT NULL, total INT NOT NULL, INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande_list_product (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, UNIQUE INDEX UNIQ_35F979EB82EA2E54 (commande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE content_list (id INT AUTO_INCREMENT NOT NULL, list_product_id INT NOT NULL, product_id INT NOT NULL, qty INT NOT NULL, INDEX IDX_89AA15DD9FA91286 (list_product_id), INDEX IDX_89AA15DD4584665A (product_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE commande_list_product ADD CONSTRAINT FK_35F979EB82EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE content_list ADD CONSTRAINT FK_89AA15DD9FA91286 FOREIGN KEY (list_product_id) REFERENCES commande_list_product (id)');
        $this->addSql('ALTER TABLE content_list ADD CONSTRAINT FK_89AA15DD4584665A FOREIGN KEY (product_id) REFERENCES product (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commande_list_product DROP FOREIGN KEY FK_35F979EB82EA2E54');
        $this->addSql('ALTER TABLE content_list DROP FOREIGN KEY FK_89AA15DD9FA91286');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE commande_list_product');
        $this->addSql('DROP TABLE ');
    }
}
