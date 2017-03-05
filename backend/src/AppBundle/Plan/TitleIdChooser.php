<?php
declare(strict_types = 1);

namespace AppBundle\Plan;

class TitleIdChooser
{
    private $sequenceOfGroups;

    private $groupsOfTerms;

    public function __construct(array $titleParts)
    {
        $this->sequenceOfGroups = $titleParts['sequence_of_groups'];
        $this->groupsOfTerms = $titleParts['groups_of_terms'];
    }

    public function chooseTitleId(string $activityIdsString): string
    {
        $activityIds = explode('-', $activityIdsString);
        if (5 !== count($activityIds)) {
            return '';
        }

        $planNumber = (int)implode('0', $activityIds);
        mt_srand($planNumber);

        $chosenSequenceId = mt_rand(0, count($this->sequenceOfGroups) - 1);
        $groupIds = $this->sequenceOfGroups[$chosenSequenceId];

        $chosenTermIds = [];
        foreach ($groupIds as $groupId) {
            $groupOfTerms = $this->groupsOfTerms[$groupId];
            $chosenTermIds[] = mt_rand(0, count($groupOfTerms) - 1);
        }

        return $chosenSequenceId.':'.implode('-', $chosenTermIds);
    }
}