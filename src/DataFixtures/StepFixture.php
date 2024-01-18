<?php

namespace App\DataFixtures;

use App\Entity\Step;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StepFixture extends Fixture
{
    public const FIRST_STEP_DESC = "That's one small step for man. One giant leap for mankind";
    public const SECOND_STEP_DESC = "This is my second desc and I don't have more ideas";
    public const FIRST_STEP_REFERENCE = "first-step-ref";
    public const SECOND_STEP_REFERENCE = "second-step-ref";

    public function load(ObjectManager $manager): void
    {
        $step = new Step();
        $step->setDescription(self::FIRST_STEP_DESC);
        $manager->persist($step);

        $secondStep = new Step();
        $secondStep->setDescription(self::SECOND_STEP_DESC);
        $manager->persist($secondStep);
        $manager->flush();

        $this->addReference(self::FIRST_STEP_REFERENCE, $step);
        $this->addReference(self::SECOND_STEP_REFERENCE, $secondStep);
    }
}
