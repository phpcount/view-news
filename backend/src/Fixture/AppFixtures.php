<?php

namespace App\Fixture;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{

    public function __construct(private int $newsLimit)
    {
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        for ($i = 0; $i < $this->newsLimit; $i++) {
            $originalId = $faker->uuid();
            $post = new Post();

            $post
                ->setTitle($faker->jobTitle())
                ->setCreatedAt(\DateTimeImmutable::createFromMutable($faker->dateTimeBetween('-1 days', 'now')))
                ->setTextOverview($faker->text(120))
                ->setOriginalId($originalId)
                ->setLink($faker->url() . '/post/' . $originalId)
                ->setRating($faker->numberBetween(1, 10))
                ->setContent($faker->realTextBetween(150, 500))
                ->setImage($faker->imageUrl());

            $manager->persist($post);
        }

        $manager->flush();
    }
}
