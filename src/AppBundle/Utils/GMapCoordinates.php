<?php
/**
 * Created by PhpStorm.
 * User: Maps_red
 * Date: 12/05/2017
 * Time: 22:53
 */

namespace AppBundle\Utils;


use AppBundle\Entity\Address;

class GMapCoordinates
{
    CONST API_MODEL = "http://maps.google.com/maps/api/geocode/json?address=%s";

    /**
     * @param Address $address
     * @return null|array
     */
    public function getCoordinates(Address $address)
    {
        $query = sprintf(self::API_MODEL, str_replace(" ", "+", $address->__toString()));
        $results = json_decode(file_get_contents($query), true);
        $cp = substr($address->getCity()->getZipcode(), 0, 2);
        if ($results['status'] === "OK") {
            $result = $results['results'][0];
            foreach ($result['address_components'] as $component) {
                if ($component['types'][0] == "postal_code" && substr($component['long_name'], 0, 2) != $cp) {
                    return null;
                }
            }
            return $result['geometry']['location'];
        }

        return null;
    }
}