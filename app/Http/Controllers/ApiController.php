<?php

namespace App\Http\Controllers;

use Stripe;
use Exception;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ApiController extends Controller {
    
    public function getPing() {
        return $this->makeSuccess('ok');
    }

    public function getCost($menuItem, $quantity) {
        try{
            return $this->makeSuccess(
                $this->costCalculator($menuItem, $quantity)
            );
        } catch (Exception $e) {
            return $this->makeError($e->getMessage());
        }
    }

    public function postOrder(Request $request) {
    	$validator = Validator::make( $request->all(), 
            array(
                'orderItem' => 'required|numeric',
                'quantity' => 'required|min:1',
                'contactName' => 'required',
                'contactNumber' => 'required',
                'contactEmail' => 'required|email',
                'deliveryTime' => 'required',
                'addressLine1' => 'required',
                'addressLine2' => '',
                'addressCity' => 'required|in:Kitchener,Waterloo',
                'addressProvince' => 'required|in:Ontario',
                'addressPostal' => 'required|alpha_num',
            )
        );

        if ($validator->fails()) {
            $messages = $validator->errors()->all();
            return $this->makeError($messages[0]);
        }

        $stripeToken = $request->input('stripeToken', null);
        if (!isset($stripeToken)) {
            return $this->makeError("The Stripe token was not generated correctly");
        }

        try {
            $costs = $this->costCalculator(
                $request->input('orderItem', null), 
                $request->input('quantity', null)
            );
            $amount = $costs['paymentDue'];
            $amount = round($amount, 2);

            \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
            $customer = \Stripe\Customer::create(
                array(
                    'email' => $request->input('contactEmail', null),
                    'card'  => $stripeToken
                )
            );

            $charge = Stripe\Charge::create(
                array(
                    'customer' => $customer->id,
                    'amount'   => $amount * 100,
                    'currency' => 'cad',
                    'receipt_email' => $request->input('contactEmail', null),
                    'metadata' => array(
                        'orderItem' => $request->input('orderItem', null),
                        'quantity' => $request->input('quantity', null),
                        
                        'foodCost' => $costs['foodCost'],
                        'paymentDue' => $costs['paymentDue'],
                        'deliveryFee' => $costs['deliveryFee'],
                        
                        'contactName' => $request->input('contactName', null),
                        'contactNumber' => $request->input('contactNumber', null),
                        'contactEmail' => $request->input('contactEmail', null),
                        'deliveryTime' => $request->input('deliveryTime', null),
                        
                        'addressLine1' => $request->input('addressLine1', null),
                        'addressLine2' => $request->input('addressLine2', null),
                        'addressCity' => $request->input('addressCity', null),
                        'addressProvince' => $request->input('addressProvince', null),
                        'addressPostal' => $request->input('addressPostal', null),
                    )
                )
            );
        } catch (Exception $e) {
            return $this->makeError($e->getMessage());
        }
        
        return $this->makeSuccess("Payment processed successfully");
    }

    /******
     * Assumes that all parameters have been validated */
    private function costCalculator($menuItem, $quantity) {
        $thisDirectory = '/assets/eat/' . $menuItem;
        if (file_exists(public_path() . $thisDirectory) == false || !is_numeric($quantity)) {
            throw new Exception('Costing parameters are bad');
        }

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
            'paymentDue' => $paymentDue,
            'deliveryFee' => DELIVERY_FEE
        );
    }
}