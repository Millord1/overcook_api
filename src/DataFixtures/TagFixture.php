<?php

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class TagFixture extends Fixture
{
    public const FIRST_TAG_NAME = "first tag";
    public const SECOND_TAG_NAME = "second tag";
    public const FIRST_TAG_REFERENCE = "first-tag";
    public const SECOND_TAG_REFERENCE = "second-tag";

    public function load(ObjectManager $manager): void
    {
        $tag = new Tags();
        $tag->setName(self::FIRST_TAG_NAME);
        $manager->persist($tag);

        $secondTag = new Tags();
        $secondTag->setName(self::SECOND_TAG_NAME);
        $manager->persist($secondTag);
        $manager->flush();

        $this->addReference(self::FIRST_TAG_REFERENCE, $tag);
        $this->addReference(self::SECOND_TAG_REFERENCE, $secondTag);
    }
}
