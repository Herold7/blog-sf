<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240116222634 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE category ALTER image DROP NOT NULL');
        $this->addSql('ALTER TABLE comment ADD post_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment ALTER author_id SET NOT NULL');
        $this->addSql('ALTER TABLE comment ALTER content SET NOT NULL');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_9474526C4B89032C ON comment (post_id)');
        $this->addSql('ALTER TABLE post ADD author_id INT NOT NULL');
        $this->addSql('ALTER TABLE post ALTER category_id DROP NOT NULL');
        $this->addSql('ALTER TABLE post ALTER "extract" DROP NOT NULL');
        $this->addSql('ALTER TABLE post ALTER content DROP NOT NULL');
        $this->addSql('ALTER TABLE post ALTER image DROP NOT NULL');
        $this->addSql('ALTER TABLE post ALTER updated_at SET NOT NULL');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DF675F31B ON post (author_id)');
        $this->addSql('ALTER TABLE "user" ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C4B89032C');
        $this->addSql('DROP INDEX IDX_9474526C4B89032C');
        $this->addSql('ALTER TABLE comment DROP post_id');
        $this->addSql('ALTER TABLE comment ALTER author_id DROP NOT NULL');
        $this->addSql('ALTER TABLE comment ALTER content DROP NOT NULL');
        $this->addSql('ALTER TABLE "user" ALTER created_at TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE post DROP CONSTRAINT FK_5A8A6C8DF675F31B');
        $this->addSql('DROP INDEX IDX_5A8A6C8DF675F31B');
        $this->addSql('ALTER TABLE post DROP author_id');
        $this->addSql('ALTER TABLE post ALTER category_id SET NOT NULL');
        $this->addSql('ALTER TABLE post ALTER extract SET NOT NULL');
        $this->addSql('ALTER TABLE post ALTER content SET NOT NULL');
        $this->addSql('ALTER TABLE post ALTER image SET NOT NULL');
        $this->addSql('ALTER TABLE post ALTER updated_at DROP NOT NULL');
        $this->addSql('ALTER TABLE category ALTER image SET NOT NULL');
    }
}
