<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class ApiController extends Controller {
    
    public function getPing() {
        return $this->makeSuccess('ok');
    }

    public function getCost($menuItem, $quantity) {
        $thisDirectory = '/assets/eat/' . $menuItem;
        if (file_exists(public_path() . $thisDirectory) == false) {
            return $this->makeError('Menu item does not exist');
        }

        if (!is_numeric($quantity)) {
            return $this->makeError('Quantity must be numeric');
        }

        return $this->makeSuccess(
            $this->costCalculator($menuItem, $quantity)
        );
    }

    public function postOrder() {
    	$input = array();
        $input['orderItem'] = Input::get('orderItem', null);
        $input['quantity'] = Input::get('quantity', null);
        $input['contactName'] = Input::get('contactName', null);
        $input['contactNumber'] = Input::get('contactNumber', null);
        $input['contactEmail'] = Input::get('contactEmail', null);
        $input['deliveryTime'] = Input::get('deliveryTime', null);
        $input['addressLine1'] = Input::get('addressLine1', null);
        $input['addressLine2'] = Input::get('addressLine2', null);
        $input['addressCity'] = Input::get('addressCity', null);
        $input['addressProvince'] = Input::get('addressProvince', null);
        $input['addressPostal'] = Input::get('addressPostal', null);

        $validator = Validator::make(
            array(
                'orderItem' => $input['orderItem'],
                'quantity' => $input['quantity'],
                'contactName' => $input['contactName'],
                'contactNumber' => $input['contactNumber'],
                'contactEmail' => $input['contactEmail'],
                'deliveryTime' => $input['deliveryTime'],
                'addressLine1' => $input['addressLine1'],
                'addressLine2' => $input['addressLine2'],
                'addressCity' => $input['addressCity'],
                'addressProvince' => $input['addressProvince'],
                'addressPostal' => $input['addressPostal'],
            ),
            array(
                'orderItem' => 'required|numeric',
                'quantity' => 'required|min:0',
                'contactName' => 'required',
                'contactNumber' => 'required',
                'contactEmail' => 'required|email',
                'deliveryTime' => 'required',
                'addressLine1' => 'required',
                'addressLine2' => 'required',
                'addressCity' => 'required|in:Kitchener,Waterloo',
                'addressProvince' => 'required|in:Ontario',
                'addressPostal' => 'required|alpha_num',
            )
        );

        if ($validator->fails()) {
            $messages = $validator->messages()->all();
            return $this->makeError($messages[0]);
        }

        $stripeToken = Input::get('stripeToken', null);
        if (!isset($stripeToken)) {
            return $this->makeError("The Stripe token was not generated correctly");
        }
        
        $amount = $league->playerCostActual;
        $amount = round($amount, 2);

        try {
            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $customer = \Stripe\Customer::create(
                array(
                    'email' => $input['contactEmail'],
                    'card'  => $stripeToken
                )
            );

            $charge = Stripe\Charge::create(
                array(
                    'customer' => $customer->id,
                    'amount'   => $amount * 100,
                    'currency' => 'cad',
                    'receipt_email' => $input['contactEmail'],
                    'metadata' => array(
                        'orderItem' => $input['orderItem'],
                        'quantity' => $input['quantity'],
                        'contactName' => $input['contactName'],
                        'contactNumber' => $input['contactNumber'],
                        'contactEmail' => $input['contactEmail'],
                        'deliveryTime' => $input['deliveryTime'],
                        'addressLine1' => $input['addressLine1'],
                        'addressLine2' => $input['addressLine2'],
                        'addressCity' => $input['addressCity'],
                        'addressProvince' => $input['addressProvince'],
                        'addressPostal' => $input['addressPostal'],
                    )
                )
            );
        } catch (Exception $e) {
            return $this->makeError($e->getMessage());
        }
        
        return $this->makeSuccess("Payment processed successfully.");
    }

    /******
     * Assumes that all parameters have been validated */
    private function costCalculator($menuItem, $quantity) {
        $thisDirectory = '/assets/eat/' . $menuItem;
        
        $price = "10";
        if (file_exists(public_path() . $thisDirectory . '/price.txt')) {
            $price = file_get_contents(public_path() . $thisDirectory . '/price.txt');
        }

        $foodCost = $price * $quantity;
        $paymentDue = 0;
        if ($foodCost > 0) {
            $paymentDue = $foodCost + DELIVERY_FEE;
        }

        return array(
            'foodCost' => $foodCost,
            'paymentDue' => $paymentDue
        );
    }
}