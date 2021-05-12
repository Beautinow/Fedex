<?php

namespace Beautinow\Fedex;

class CreateShipmentResponse {

    public $error_level;

    public $error;

    /**
     * optional
     * @var CreateShipment
     */
    public $shipment;


    public function __construct($result)
    {
        $this->error_level = $result['ErrorLevel'];
        $this->error_level = $result['Error'];
        $shipment = new CreateShipment();
        $shipment->tracking_number          = $result['Shipment']['TrackingNumber'];
        $shipment->fedex_tracking_number    = $result['Shipment']['FedExTrackingNumber'];
        $shipment->tracking_url             = $result['Shipment']['TrackingUrl'];
        $shipment->shipper_reference_id     = $result['Shipment']['ShipperReferenceID'];
        $shipment->carrier_tracking_number  = $result['Shipment']['CarrierTrackingNumber'];
        $shipment->carrier_tracking_url     = $result['Shipment']['CarrierTrackingUrl'];
        $shipment->label_type               = $result['Shipment']['LabelType'];
        $shipment->label_format             = $result['Shipment']['LabelFormat'];
        $shipment->label_image              = $result['Shipment']['LabelImage'];
        $this->shipment = $shipment;
    }

}