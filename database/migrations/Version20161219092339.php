<?php

namespace RealEstate\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\ORM\EntityManagerInterface;
use RealEstate\Core\Back\Entities\Admin;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20161219092339 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        /**
         * @var EntityManagerInterface $entityManager
         */
        $entityManager = app(EntityManagerInterface::class);

        $admin = new Admin();

        $admin->setEmail('support@realestate.com');
        $admin->setFirstName('None');
        $admin->setLastName('None');
        $admin->setUsername('superadmin');
        $admin->setPassword('');

        $entityManager->persist($admin);
        $entityManager->flush();
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
