<?php

namespace Beautinow\Fedex;


class Shipper {

    /**
     * optional
     * @var
     */
    public $contact_name;

    /**
     * required
     * @var
     */
    public $company;

    /**
     * required
     * @var
     */
    public $address1;

    /**
     * optional
     * @var
     */
    public $address2;

    /**
     * optional
     * @var
     */
    public $address3;

    /**
     * required
     * @var
     */
    public $city;

    /**
     * optional
     * @var
     */
    public $country;

    /**
     * required
     * Required for Destination Countries/Territories that use Zip/Post codes.
     * @var
     */
    public $zip;

    /**
     * required
     * ISO Country/Territory Code Eg. “GB”.
     * @var
     */
    public $country_code;

    /**
     * optional
     * @var
     */
    public $phone;

    /**
     * required
     * @var
     */
    public $email;

    /**
     * optional
     * @var
     */
    public $vat;

    public function __construct($company = null, $address1 = null, $city = null, $country_code = null, $email = null)
    {
        $this->company = $company;
        $this->address1 = $address1;
        $this->city = $city;
        $this->country_code = $country_code;
        $this->email = $email;
    }

}