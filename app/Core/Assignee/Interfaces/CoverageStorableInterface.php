<?php
namespace RealEstate\Core\Assignee\Interfaces;

/**
 * @author Igor Vorobiov<igor.vorobioff@gmail.com>
 */
interface CoverageStorableInterface
{
    /**
     * @param CoverageInterface $coverage
     */
    public function addCoverage(CoverageInterface $coverage);

    /**
     * @return CoverageInterface[]
     */
    public function getCoverages();
    public function clearCoverages();
}