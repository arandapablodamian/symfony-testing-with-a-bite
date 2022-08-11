<?php

declare(strict_types=1);

namespace  App\Tests\Services;

use PHPUnit\Framework\TestCase;
use App\Services\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use App\Factory\DinosaurFactory;
use App\Entity\Dinosaur;
use App\Entity\Enclosure;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Doctrine\ORM\EntityManager;
use App\Entity\Security;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

class EnclosureBuilderServiceIntegrationTest  extends KernelTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
        // si es la opcion con el ORMPurge
        $this->truncateEntities();
        // si es la forma manual
        // $this->truncateEntities([
        //     Enclosure::class,
        //     Security::class,
        //     Dinosaur::class
        // ]);
    }

    public function testItBuildsEnclosureWithDefaultSpecification()
    {
        //for integration test
        // $enclosureBuilderService = self::$kernel->getContainer()
        //                                         ->get('test.'.EnclosureBuilderService::class);
        // $enclosureBuilderService->buildEnclosure();

        //for partial mocking
        $dinoFactory = $this->createMock(DinosaurFactory::class);
        $dinoFactory->expects(
            $this->any())
            ->method('growFromSpecification')
            ->willReturnCallback(function ($spec) {
                return new Dinosaur();
            });

        $enclosureBuilderService = new EnclosureBuilderService(
            $this->getEntityManager(),
            $dinoFactory
        );
        /////////////////////

        $enclosureBuilderService->buildEnclosure();
        /**
         * @var EntityManager $em
        */
        $em = $this->getEntityManager();

        $count = (int) $em->getRepository(Security::class)
            ->createQueryBuilder('s')
            ->select('COUNT(s.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $this->assertSame(1, $count, 'Amount of security systems is not the same');

        $count = (int) $em->getRepository(Dinosaur::class)
            ->createQueryBuilder('d')
            ->select('COUNT(d.id)')
            ->getQuery()
            ->getSingleScalarResult();
        $this->assertSame(3, $count, 'Amount of dinosaurs systems is not the same');
    }

    private function truncateEntities(array $entities = [])
    {   
        ////una forma borrar a mano las tablas de la base de datos
        // $connection = $this->getEntityManager()->getConnection();
        // $databasePlatform = $connection->getDatabasePlatform();
        // if ($databasePlatform->supportsForeignKeyConstraints()) {
        //     $connection->query('SET FOREIGN_KEY_CHECKS=0');
        // }
        // foreach ($entities as $entity) {
        //     $query = $databasePlatform->getTruncateTableSQL(
        //         $this->getEntityManager()->getClassMetadata($entity)->getTableName()
        //     );
        //     $connection->executeUpdate($query);
        // }
        // if ($databasePlatform->supportsForeignKeyConstraints()) {
        //     $connection->query('SET FOREIGN_KEY_CHECKS=1');
        // }

        ////////otra forma
        //ORMPurger require symfony composer require doctrine/data-fixtures
        $purger = new ORMPurger($this->getEntityManager());
        $purger->purge();
    }

    /**
     *
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()->get('doctrine')->getManager();
    }
}
