<?php

namespace Beautinow\Fedex;


class Consignee {

    /**
     * required
     * @var
     */
    public $contact_name;

    /**
     * optional
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
     * required
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
     * ISO Country/Territory Code.
     * @var
     */
    public $country_code;

    /**
     * optional
     * Required for PUDO services and shipments going to HU, CZ, PL, SK and HR. (must be mobile), otherwise recommended. International format only (eg. +441268123456).
     * @var
     */
    public $phone;

    /**
     * optional
     * @var
     */
    public $email;

    /**
     * optional
     * @var
     */
    public $vat;

    public function __construct($contact_name = null, $address1 = null, $city = null, $country_code = null, $phone = null)
    {
        $this->contact_name = $contact_name;
        $this->address1 = $address1;
        $this->city = $city;
        $this->country_code = $country_code;
        $this->phone = $phone;
    }

}