<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250109160612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book CHANGE category_id category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_CBE5A33112469DE2 ON book (category_id)');
        $this->addSql('ALTER TABLE book_read CHANGE book_id book_id INT NOT NULL');
        $this->addSql('ALTER TABLE book_read ADD CONSTRAINT FK_81CA0A6F16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)');
        $this->addSql('ALTER TABLE book_read ADD CONSTRAINT FK_81CA0A6FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_81CA0A6F16A2B381 ON book_read (book_id)');
        $this->addSql('CREATE INDEX IDX_81CA0A6FA76ED395 ON book_read (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('DROP INDEX IDX_CBE5A33112469DE2 ON book');
        $this->addSql('ALTER TABLE book CHANGE category_id category_id BIGINT NOT NULL');
        $this->addSql('ALTER TABLE book_read DROP FOREIGN KEY FK_81CA0A6F16A2B381');
        $this->addSql('ALTER TABLE book_read DROP FOREIGN KEY FK_81CA0A6FA76ED395');
        $this->addSql('DROP INDEX IDX_81CA0A6F16A2B381 ON book_read');
        $this->addSql('DROP INDEX IDX_81CA0A6FA76ED395 ON book_read');
        $this->addSql('ALTER TABLE book_read CHANGE book_id book_id BIGINT NOT NULL');
    }
}