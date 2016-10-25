<?php

namespace Delivery\Http\Controllers\Api\Client;


use Delivery\Http\Controllers\Controller;
use Delivery\Http\Requests\CheckoutRequest;
use Delivery\Repositories\OrderRepository;
use Delivery\Repositories\ProductRepository;
use Delivery\Repositories\UserRepository;
use Delivery\Services\OrderService;
use Illuminate\Http\Request;

use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class ClientProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository){
        $this->productRepository = $productRepository;
    }

    public function index(){
        $products = $this->productRepository->skipPresenter(false)->all();
        return $products;
    }


}
