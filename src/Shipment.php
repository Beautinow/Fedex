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

    protected $live_mode;

    protected $service = "CBEC";

    public function __construct($api_key, $live_mode = true)
    {
        $this->api_key = $api_key;
        $this->live_mode = $live_mode;
    }


    public function setShipper($shipper) {
        $this->shipper = $shipper;
    }

    public function setConsignee($consignee) {
        $this->consignee = $consignee;
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

        $request = new Request();

        $request->setBody($xml_body);

        $result = $request->send();

        return new CreateShipmentResponse($result);

    }

    private function buildRequestBody() {
        $xml =
        "<CreateShipment>
            <Apikey>[API_KEY]</Apikey>
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
                <Service>[SERVICE]</Service>
                
            </Shipment>
        </CreateShipment>";


        $xml = str_replace("[API_KEY]", $this->api_key, $xml);
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
        $xml = str_replace("[CONSIGNEE_EMAIL]", $this->consignee->email, $xml);

        $xml = str_replace("[SERVICE]", $this->service, $xml);

        return $xml;

    }


}