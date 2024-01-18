<?php

namespace App\DataFixtures;

use App\Entity\Type;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TypeFixture extends Fixture
{
    public const TYPE_NAME = "first type";
    public const TYPE_REFERENCE = "first-type";

    public function load(ObjectManager $manager): void
    {
        $type = new Type();
        $type->setName(self::TYPE_NAME);
        $manager->persist($type);
        $manager->flush();

        $this->addReference(self::TYPE_REFERENCE, $type);
    }
}
