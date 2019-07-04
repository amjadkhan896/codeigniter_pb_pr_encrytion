<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pincode extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{

        $this->load->library("pagination");

        $this->load->model('Pincode_model');

        $config = array();

        $config['full_tag_open'] = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" >';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tagl_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tagl_close'] = '</li>';
        $config['first_tag_open'] = '<li class="page-item disabled">';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tagl_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Previous';
        $config['attributes'] = array('class' => 'page-link');



        $config["base_url"] = base_url() . "pincode";
        $total_row =  $this->Pincode_model->get_count();
        $config["total_rows"] = $total_row;
        $config["per_page"] = 2;
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = $total_row;


        $this->pagination->initialize($config);
        if($this->uri->segment(3)){
            $page = ($this->uri->segment(3)) ;
        }
        else{
            $page = 0;
        }
        $data['pincodes'] = $this->Pincode_model->get_pincodes($config["per_page"], $page);
        $str_links = $this->pagination->create_links();

        $data["links"] =$str_links;




        $this->load->view('list_pincodes', $data);
	}

    public function upload_pincodes()
    {
        $this->load->model('Pincode_model');
       // $data['pincodes'] = $this->Pincode_model->get_pincodes();

        $this->load->view('upload_pincodes');
    }


    public function add_pincodes()
    {
        $this->load->library('PublicPrivateKeyEncryption');

        //$this->encrypt->encrypt('This is test', );

        $fp = fopen($_FILES['pincode_file']['tmp_name'], 'rb');
        while ( ($line = fgets($fp)) !== false) {


            $explodeArr = explode(',',"$line<br>");

            $chkRecord = $this->chkDbRecord($explodeArr);
            if($chkRecord==1){
                $data = array(
                    'pincode'     => $this->publicprivatekeyencryption->encrypt(trim(strip_tags($explodeArr[0]))),
                    'serial_no'     => trim(strip_tags($explodeArr[1])),
                );
                //insert data into database table.
                $this->db->insert('pincodes',$data);
            }

        }

        redirect("pincode/");


    }


    /**
     *
     * Check DB Record if Exists
     */
    public function chkDbRecord($explodeArr)
    {
        $this->load->library('PublicPrivateKeyEncryption');

        $chkResultsArr = $this->db->select('pincode,serial_no')->from('pincodes')
                    // ->where('pincode',$pincode)
                   // ->where('serial_no',$serialNo)
                    ->get()->result();

     $temp = 1;
        foreach ($chkResultsArr as $key=>$val){
           // echo $this->publicprivatekeyencryption->decrypt($val->pincode).'-----'.$explodeArr[0].'<br>';
            if($this->publicprivatekeyencryption->decrypt($val->pincode) == trim(strip_tags($explodeArr[0]))
                || trim(strip_tags($explodeArr[1]))==$val->serial_no){
               // echo 'ddd';
                $temp=0;
            }

        }
      // echo $temp; exit;

        return $temp;


    }

    /**
     *
     * Genrate Public and Private keys
     */
    function generate()
    {
        $privateKey = openssl_pkey_new(array(
            "digest_alg" => "sha512",
            'private_key_bits' => 2048,      // Size of Key.
            'private_key_type' => OPENSSL_KEYTYPE_RSA,
        ));
        openssl_pkey_export_to_file($privateKey, 'codigniter_private.key');

        $a_key = openssl_pkey_get_details($privateKey);
        file_put_contents('codigniter_public.pem', $a_key['key']);

        openssl_free_key($privateKey);


    }

}
