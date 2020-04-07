<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

use Entities\Product;
use Entities\Log;
use Listeners\ProductEventSubscriber;

class Site extends MY_Controller {

    const MAIN_PAGE = 0;
    const FORM_PAGE = 1;
    const LOGS_PAGE = 2;

    private $data = [
        'title' => "Welcome to CodeIgniter/Doctrine/Bootstrap",
    ];

    /** @var \Doctrine\ORM\EntityManager */
    private $em;

    function __construct() {
        parent::__construct();
        $this->load->library('Doctrine');
        $this->load->helper('url', 'form');
        $this->load->library('form_validation');        
        $this->em = $this->doctrine->em;

        $this->em->getEventManager()->addEventSubscriber(new ProductEventSubscriber());

        $this->load->model("ProductService");
    }

    function index() {

        $productRepository = $this->em->getRepository(Product::class);

        $this->data['products'] = $productRepository->findAll();
        $this->data['page'] = self::MAIN_PAGE;

        $this->load->view('main', $this->data);
    }

    function add() {

        if($this->input->post()){

            $rules = [
                [
                    'field' => 'name',
                    'label' => 'Product name',
                    'rules' => 'required'
                ],
                [
                    'field' => 'image_url',
                    'label' => 'Image URL',
                    'rules' => 'required'
                ]
            ];

            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run()) {

                $this->ProductService->createProduct($this->input->post());

                redirect(base_url('site'));
            }        
        }

        $this->data['page'] = self::FORM_PAGE;

        $this->load->view('main', $this->data);        
    }

    function delete($id) {

        $this->ProductService->deleteProduct($id);

        redirect(base_url('site'));
    }

    function logs() {

        $logRepository = $this->em->getRepository(Log::class);

        $this->data['logs'] = $logRepository ->findAll();
        $this->data['page'] = self::LOGS_PAGE;

        $this->load->view('main', $this->data);
    }
}