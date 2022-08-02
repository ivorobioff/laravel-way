<?php
namespace RealEstate\Console\Cron;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Config\Repository as Config;
use RealEstate\Letter\Support\Frequency;
use DateTime;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
class CleanEmailFrequenciesCommand extends AbstractCommand
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param Config $config
     */
    public function fire(EntityManagerInterface $entityManager, Config $config)
    {
        $config = $config->get('app.emails_frequency_tracker');

        $builder = $entityManager->createQueryBuilder();

        $builder->delete(Frequency::class, 'f')
            ->where($builder->expr()->lte('f.updatedAt', ':current'))
            ->setParameter('current', new DateTime('-'.$config['waiting_time'].' seconds'))
            ->getQuery()
            ->execute();
    }
}