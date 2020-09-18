<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/**
 * 
 */
class Car_model extends CI_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->library('form_validation');
	}

	public function index()
	{
		$data['rows'] = $this->Car_Models->all();
		// print_r($data);die;
		$this->load->view('list',$data);

	}
	
	//show modal form
	public function showCreateForm(){
		$html = $this->load->view('create','',true);
		$response['html'] = $html ;
		echo json_encode($response);
	}	
	
	public function saveModal(){
		$this->form_validation->set_rules('name','Car Name','required');
		$this->form_validation->set_rules('color','Color','required');
		$this->form_validation->set_rules('price','Price','required');

		if($this->form_validation->run() == true ){
			// save entries to DB
			
			$formArray = array(
				'name' => $this->input->post('name'),
				'color' => $this->input->post('color'),
				'transmission' => $this->input->post('transmission'),	
				'price' => $this->input->post('price'),
				'create_at' => date('Y-m-d H:i:s')
			);
			$insert_id = $this->Car_Models->create('car_models',$formArray);
			$data['row'] = $this->Car_Models->getRow($insert_id);

			$rowHtml = $this->load->view('car_row',$data,true);
			$response['rowHtml'] = $rowHtml;
			$response['status'] = 1;
			$response['message'] ="<div class=\" alert alert-success \">Record Has been Successfully Added</div>";
		}
		else{
			// Show Error messages 
			$response['status'] = 0;
			$response['name'] = strip_tags(form_error('name'));
			$response['color'] = strip_tags(form_error('color'));
			$response['price'] = strip_tags(form_error('price'));
			
		}
		echo json_encode($response);
	}

	public function getCarModel($id){
		$row = $this->Car_Models->getRow($id);
		$data['row'] = $row;
		$html = $this->load->view('edit',$data, true);
		$response['html'] = $html;
		echo json_encode($response);


	}

	public function updateModal(){
		
		$id = $this->input->post('id');
		$row = $this->Car_Models->getRow($id);

		if (empty($row)) {
			$response['msg'] = "Either record deleted or not found in DB";
			$response['status'] = 100;
			json_encode($response);
			exit;
		}

		
		$this->form_validation->set_rules('name','Name','required');
		$this->form_validation->set_rules('color','Color','required');
		$this->form_validation->set_rules('price','Price','required');

		if($this->form_validation->run() == true) {
            //upated record
			$formArray = array();
			$formArray['name'] = $this->input->post('name');
			$formArray['color'] = $this->input->post('color');
			$formArray['transmission'] = $this->input->post('transmission');
			$formArray['price'] = $this->input->post('price');
			$formArray['update_at'] = date('Y-m-d H:i:s');           
			$id = $this->Car_Models->update($id,$formArray);
			$row = $this->Car_Models->getRow($id);
			
			$response['row'] = $row;
			$response['status'] = 1;
			$response['message'] ="<div class=\"alert alert-success\">Record has been updated successfully.</div>";
		} else {
			$response['status'] = 0;
			$response['name'] = strip_tags(form_error('name'));
			$response['color'] = strip_tags(form_error('color'));
			$response['price'] = strip_tags(form_error('price'));
            // return error messages
		}

		echo json_encode($response);

	}
	public function deleteModel($id){
		$row = $this->Car_Models->getRow($id);
		if(empty($row)){
			$response['msg'] = "Either record deleted or not found in DB";
			$response['status'] = 0;
			echo json_encode($response);
			exit;
		}
		else{
			$this->Car_Models->delete($id);	
			$response['msg'] = "Record deleted successfully..";
			$response['status'] = 1;
			echo json_encode($response);
			exit;
		}
	}
}

?>