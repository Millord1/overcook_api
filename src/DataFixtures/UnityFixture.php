<?php

namespace App\DataFixtures;

use App\Entity\Unity;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UnityFixture extends Fixture
{
    public const UNITY_NAME = "Kg";
    public const UNITY_REFERENCE = "first-unity";

    public function load(ObjectManager $manager): void
    {
        $unity = new Unity();
        $unity->setUnity(self::UNITY_NAME);
        $manager->persist($unity);
        $manager->flush();

        $this->addReference(self::UNITY_REFERENCE, $unity);
    }
}