<?php
namespace RealEstate\Console\Project;

use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Console\Command;
use RealEstate\Core\Shared\Interfaces\TokenGeneratorInterface;

/**
 * @author Igor Vorobiov <igor.vorobioff@gmail.com>
 */
class ProjectOneTimeUpdateCommand extends Command
{
	protected $name = 'project:one-time-update';

	public function fire(EntityManagerInterface $entityManager, TokenGeneratorInterface $generator)
	{
		
	}
}