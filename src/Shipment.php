<?php

namespace Beautinow\Fedex;


class Shipment {

    /**
     * $shipper
     * @var Shipper $shipper
     */
    protected $shipper;

    /**
     * $consignee
     * @var Consignee $consignee
     */
    protected $consignee;

    protected $api_key;

    protected $shipper_reference_id;

    protected $live_mode;

    protected $service = "CBEC";

    /**
     * weight of package
     * @var float
     */
    protected $weight = 0.0;

    /**
     * unit of weight
     * @var string
     */
    protected $weight_unit = "K";

    protected $items = [];

    public function __construct($api_key, $live_mode = true)
    {
        $this->api_key = $api_key;
        $this->live_mode = $live_mode;
    }

    public function setShipper($shipper) {
        $this->shipper = $shipper;
        return $this;
    }

    public function setShipperReferenceId($shipper_reference_id) {
        $this->shipper_reference_id = $shipper_reference_id;
        return $this;
    }

    public function setConsignee($consignee) {
        $this->consignee = $consignee;
        return $this;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
        return $this;
    }

    /**
     * “K” = Kg, “L” = Lbs
     * @param $weight_unit
     * @return $this
     */
    public function setWeightUnit($weight_unit) {
        $this->weight_unit = $weight_unit;
        return $this;
    }

    /**
     * Create a shipment
     * @throws \Exception
     */
    public function create() {

        if ($this->shipper == null) {
            throw new \Exception("shipper is required");
        }

        if ($this->consignee == null) {
            throw new \Exception("shipper is required");
        }

        $xml_body = $this->buildRequestBody();

        $request = new Request($this->live_mode);

        $request->setBody($xml_body);

        $result = $request->send();

        return new CreateShipmentResponse($result);

    }

    private function buildRequestBody() {
        $xml =
        "<CreateShipment>
            <Apikey>[API_KEY]</Apikey>
            <ShipperReferenceID>[SHIPPER_REFERENCE_ID]</ShipperReferenceID>
            <Shipment>
                <Shipper>
                    <ContactName>[SHIPPER_CONTACT_NAME]</ContactName>
                    <Company>[SHIPPER_Company]</Company>
                    <Address1>[SHIPPER_ADDRESS1]</Address1>
                    <Address2>[SHIPPER_ADDRESS2]</Address2>
                    <Address3>[SHIPPER_ADDRESS3]</Address3>
                    <City>[SHIPPER_CITY]</City>
                    <County>[SHIPPER_COUNTRY]</County>
                    <Zip>[SHIPPER_ZIP]</Zip>
                    <CountryCode>[SHIPPER_COUNTRY_CODE]</CountryCode>
                    <Phone>[SHIPPER_PHONE]</Phone>
                    <Email>[SHIPPER_EMAIL]</Email> 
                </Shipper>
                <Consignee>
                    <ContactName>[CONSIGNEE_CONTACT_NAME]</ContactName>
                    <Address1>[CONSIGNEE_ADDRESS1]</Address1>
                    <Address2>[CONSIGNEE_ADDRESS2]</Address2>
                    <Address3>[CONSIGNEE_ADDRESS3]</Address3>
                    <City>[CONSIGNEE_CITY]</City>
                    <County>[CONSIGNEE_COUNTRY]</County>
                    <Zip>[CONSIGNEE_ZIP]</Zip>
                    <CountryCode>[CONSIGNEE_COUNTRY_CODE]</CountryCode>
                    <Phone>[CONSIGNEE_PHONE]</Phone>
                    <Email>[CONSIGNEE_EMAIL]</Email> 
                </Consignee>
                <Weight>[P_WEIGHT]</Weight>		
                <WeightUnit>[P_WEIGHT_UNIT]</WeightUnit>
                <Service>[SERVICE]</Service>
                [ITEMS]
            </Shipment>
        </CreateShipment>";


        $xml = str_replace("[API_KEY]", $this->api_key, $xml);
        $xml = str_replace("[SHIPPER_REFERENCE_ID]", $this->api_key, $xml);
        $xml = str_replace("[SHIPPER_CONTACT_NAME]", $this->shipper->contact_name, $xml);
        $xml = str_replace("[SHIPPER_Company]", $this->shipper->company, $xml);
        $xml = str_replace("[SHIPPER_ADDRESS1]", $this->shipper->address1, $xml);
        $xml = str_replace("[SHIPPER_ADDRESS2]", $this->shipper->address2, $xml);
        $xml = str_replace("[SHIPPER_ADDRESS3]", $this->shipper->address3, $xml);
        $xml = str_replace("[SHIPPER_CITY]", $this->shipper->city, $xml);
        $xml = str_replace("[SHIPPER_COUNTRY]", $this->shipper->country, $xml);
        $xml = str_replace("[SHIPPER_ZIP]", $this->shipper->zip, $xml);
        $xml = str_replace("[SHIPPER_COUNTRY_CODE]", $this->shipper->country_code, $xml);
        $xml = str_replace("[SHIPPER_PHONE]", $this->shipper->phone, $xml);
        $xml = str_replace("[SHIPPER_EMAIL]", $this->shipper->email, $xml);

        $xml = str_replace("[CONSIGNEE_CONTACT_NAME]", $this->consignee->contact_name, $xml);
        $xml = str_replace("[CONSIGNEE_ADDRESS1]", $this->consignee->address1, $xml);
        $xml = str_replace("[CONSIGNEE_ADDRESS2]", $this->consignee->address2, $xml);
        $xml = str_replace("[CONSIGNEE_ADDRESS3]", $this->consignee->address3, $xml);
        $xml = str_replace("[CONSIGNEE_CITY]", $this->consignee->city, $xml);
        $xml = str_replace("[CONSIGNEE_COUNTRY]", $this->consignee->country, $xml);
        $xml = str_replace("[CONSIGNEE_ZIP]", $this->consignee->zip, $xml);
        $xml = str_replace("[CONSIGNEE_COUNTRY_CODE]", $this->consignee->country_code, $xml);
        $xml = str_replace("[CONSIGNEE_PHONE]", $this->consignee->phone, $xml);
        $xml = str_replace("[CONSIGNEE_EMAIL]", $this->consignee->email, $xml);

        $xml = str_replace("[P_WEIGHT]", $this->weight, $xml);
        $xml = str_replace("[P_WEIGHT_UNIT]", $this->weight_unit, $xml);
        $xml = str_replace("[SERVICE]", $this->service, $xml);

        $xml = str_replace("[ITEMS]", $this->createItemsXml($this->items), $xml);

        return $xml;

    }

    private function createItemsXml($items) {
        $xml = "";
        foreach ($items as $item) {
            $xml .= $this->createItemXML($item);
        }
        return $xml;
    }

    private function createItemXML($item) {
        $xml = "<Item>
            <Description>" . $item->description."</Description>
            <SkuCode>" . $item->sku_code."</SkuCode>
            <HsCode>" . $item->hs_code."</HsCode>
            <CountryOfOrigin>" . $item->country_of_origin."</CountryOfOrigin>
            <PurchaseUrl>" . $item->purchase_url."</PurchaseUrl>
            <Quantity>" . $item->quantity."</Quantity>
            <Value>" . $item->value."</Value>
        </Item>";
        return $xml;
    }

}