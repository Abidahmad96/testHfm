<?php 
/**
 * 
 */
class Car_Models extends CI_model
{
	
	public function create($table,$formArray){
		$this->db->insert($table,$formArray);
		 return $id = $this->db->insert_id();
	}
		// fetch all record from db
	public function all(){
        $result = $this->db
                    ->order_by('id','ASC')
                    ->get('car_models')
                    ->result_array();
        // SELECT * FROM car_models order by id ASC
        return $result;
    }
    public function getRow($id){
    	$this->db->where('id', $id);
    	$row = $this->db->get('car_models')->row_array();
    	return $row;
    }
    public function update($id,$formArray){
        $this->db->where('id',$id);
        $this->db->update('car_models',$formArray);
        return $id;
    }
    public function delete($id){
        $this->db->where('id',$id);
        $this->db->delete('car_models');
        
    }
}

 ?>