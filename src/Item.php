<?php

namespace Beautinow\Fedex;


class Item {

    /**
     * optional
     * @var
     */
    public $description;

    /**
     * required
     * @var
     */
    public $sku_code;

    /**
     * required
     * @var
     */
    public $hs_code;

    /**
     * optional
     * @var
     */
    public $country_of_origin;

    /**
     * optional
     * @var
     */
    public $purchase_url;

    /**
     * required
     * @var
     */
    public $quantity;

    /**
     * optional
     * @var
     */
    public $value;


    public function __construct($description, $sku_code, $hs_code, $country_of_origin, $purchase_url, $quantity, $value)
    {
        $this->description          = $description;
        $this->sku_code             = $sku_code;
        $this->hs_code              = $hs_code;
        $this->country_of_origin    = $country_of_origin;
        $this->purchase_url         = $purchase_url;
        $this->quantity             = $quantity;
        $this->value                = $value;
    }

}