<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250411105739 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, availability JSON NOT NULL, efficiency JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE agent_queue (agent_id INT NOT NULL, queue_id INT NOT NULL, INDEX IDX_4653571B3414710B (agent_id), INDEX IDX_4653571B477B5BAE (queue_id), PRIMARY KEY(agent_id, queue_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE demand_forecast (id INT AUTO_INCREMENT NOT NULL, queue_id INT NOT NULL, timestamp DATETIME NOT NULL, expected_calls INT NOT NULL, INDEX IDX_D53C68DA477B5BAE (queue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE queue (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE schedule_request (id INT AUTO_INCREMENT NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, status VARCHAR(20) NOT NULL, result JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE shift (id INT AUTO_INCREMENT NOT NULL, agent_id INT NOT NULL, queue_id INT NOT NULL, start_time DATETIME NOT NULL, end_time DATETIME NOT NULL, INDEX IDX_A50B3B453414710B (agent_id), INDEX IDX_A50B3B45477B5BAE (queue_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE agent_queue ADD CONSTRAINT FK_4653571B3414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE agent_queue ADD CONSTRAINT FK_4653571B477B5BAE FOREIGN KEY (queue_id) REFERENCES queue (id) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demand_forecast ADD CONSTRAINT FK_D53C68DA477B5BAE FOREIGN KEY (queue_id) REFERENCES queue (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shift ADD CONSTRAINT FK_A50B3B453414710B FOREIGN KEY (agent_id) REFERENCES agent (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shift ADD CONSTRAINT FK_A50B3B45477B5BAE FOREIGN KEY (queue_id) REFERENCES queue (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE agent_queue DROP FOREIGN KEY FK_4653571B3414710B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE agent_queue DROP FOREIGN KEY FK_4653571B477B5BAE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE demand_forecast DROP FOREIGN KEY FK_D53C68DA477B5BAE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shift DROP FOREIGN KEY FK_A50B3B453414710B
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE shift DROP FOREIGN KEY FK_A50B3B45477B5BAE
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE agent
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE agent_queue
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE demand_forecast
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE queue
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE schedule_request
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE shift
        SQL);
    }
}
