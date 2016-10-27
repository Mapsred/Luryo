<?php


namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use AppBundle\Entity\City;
use AppBundle\Entity\County;

ini_set('memory_limit', '-1');

/**
 * Class LoadLocationData
 * @package AppBundle\DataFixtures\ORM
 */
class LoadLocationData implements FixtureInterface
{
    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $counties = include(__DIR__."/../Data/county.php");
        foreach ($counties as $county) {
            $obj = new County();
            $obj->setName($county['name'])->setCode($county['code']);
            $manager->persist($obj);
        }

        $manager->flush();

        $cities = include(__DIR__."/../Data/city.php");
        foreach ($cities as $city) {
            if (strlen($city['zipcode']) > 5) {
                $zipcodes = explode("-", $city['zipcode']);
                foreach ($zipcodes as $zipcode) {
                    $this->createObject($manager, $city, $zipcode);
                }
            } else {
                $this->createObject($manager, $city, $city['zipcode']);
            }
        }

        $manager->flush();
    }

    /**
     * @param ObjectManager $manager
     * @param $city
     * @param $zipcode
     */
    private function createObject(ObjectManager $manager, $city, $zipcode)
    {
        $obj = new City();
        $county = $manager->getRepository("AppBundle:County")->findOneBy(['id' => $city['county_id']]);
        $obj->setName($city['name'])->setZipcode($zipcode)->setCounty($county);
        $manager->persist($obj);
    }

}