<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        //$data['header'] = $this->load->view('header_default', NULL, TRUE);//lo pasa como param en vez de mostrarlo
        $this->load->library('session');
        $data["log"] = 0;
        if ($this->isAuthorized()) {
            $data["log"] = 1;
        }
        $this->load->view('home_layout', $data);
    }

//Devuelve true si está logueado
    private function isAuthorized() {
        return (isset($this->session->userdata()["logged_in"]) && $this->session->userdata()["logged_in"] === TRUE);
    }

}
