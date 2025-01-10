<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250110223021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE book_read_comment (id INT AUTO_INCREMENT NOT NULL, book_read_id INT NOT NULL, user_id INT NOT NULL, content VARCHAR(2047) NOT NULL, INDEX IDX_7172FAB8A4948A88 (book_read_id), INDEX IDX_7172FAB8A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book_read_like (id INT AUTO_INCREMENT NOT NULL, book_read_id INT NOT NULL, user_id INT NOT NULL, is_liked TINYINT(1) NOT NULL, INDEX IDX_3B398ACCA4948A88 (book_read_id), INDEX IDX_3B398ACCA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book_read_comment ADD CONSTRAINT FK_7172FAB8A4948A88 FOREIGN KEY (book_read_id) REFERENCES book_read (id)');
        $this->addSql('ALTER TABLE book_read_comment ADD CONSTRAINT FK_7172FAB8A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE book_read_like ADD CONSTRAINT FK_3B398ACCA4948A88 FOREIGN KEY (book_read_id) REFERENCES book_read (id)');
        $this->addSql('ALTER TABLE book_read_like ADD CONSTRAINT FK_3B398ACCA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458A4948A88');
        $this->addSql('ALTER TABLE feedback DROP FOREIGN KEY FK_D2294458A76ED395');
        $this->addSql('DROP TABLE feedback');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feedback (id INT AUTO_INCREMENT NOT NULL, book_read_id INT NOT NULL, user_id INT NOT NULL, comment VARCHAR(2047) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, is_liked TINYINT(1) DEFAULT NULL, INDEX IDX_D2294458A4948A88 (book_read_id), INDEX IDX_D2294458A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458A4948A88 FOREIGN KEY (book_read_id) REFERENCES book_read (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE feedback ADD CONSTRAINT FK_D2294458A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE book_read_comment DROP FOREIGN KEY FK_7172FAB8A4948A88');
        $this->addSql('ALTER TABLE book_read_comment DROP FOREIGN KEY FK_7172FAB8A76ED395');
        $this->addSql('ALTER TABLE book_read_like DROP FOREIGN KEY FK_3B398ACCA4948A88');
        $this->addSql('ALTER TABLE book_read_like DROP FOREIGN KEY FK_3B398ACCA76ED395');
        $this->addSql('DROP TABLE book_read_comment');
        $this->addSql('DROP TABLE book_read_like');
    }
}
