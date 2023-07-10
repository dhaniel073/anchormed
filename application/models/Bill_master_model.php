<?php
class Bill_master_model extends CI_Model {

	public function __construct()
	{
		$this->load->database();
		
	}
        
	
	public function getBillsForWalkInPatient()
	{
		
		$this->db->select('*');
		$this->db->order_by("date_created","desc");
		$this->db->from('bill_master');
		$this->db->where("status = 'A' AND (drug_price_id > 0 OR lab_price_id > 0 )");
		$query=$this->db->get();
		return $query->result_array();
	}
       
	    
	    
	    public function getBill($id = FALSE)
	    {
		if($id === FALSE)
		{
		        $this->db->select('*');
			$this->db->order_by("date_created","desc");
			$this->db->from('bill_master');
			$this->db->where("status = 'A'");
			$query=$this->db->get();
			return $query->result_array();
		}
		
		$query = $this->db->get_where('bill_master', array('bill_id' => $id));
                return $query->row_array();
	    }
	    
	    
	    public function getBillByLabPriceId($id)
	    {
		$query = $this->db->get_where('bill_master', array('lab_price_id' => $id));
                return $query->row_array();
	    }
	    public function getBillByDept($dept_id)
	    {
		$query = $this->db->get_where('bill_master', array('dept_id' => $dept_id));
                return $query->result_array();
	    }
	    
	    
	     public function searchBill($searchString, $limited = FALSE)
		{
		   $test = preg_split('[ ]',$searchString);
			
			$where_clause = "(";
			
			if(sizeof($test) > 1)
			{
				$i = 0;
				
				foreach($test as $t)
				{
					if($i > 0)
					{
						$where_clause = $where_clause." OR  ";
					}
					$where_clause = $where_clause."`service_name` LIKE '%$t%' AND `status` = 'A' OR  `description` LIKE '%$t%' AND `status` = 'A'" ;
					
					$i++;
				}
				
				$where_clause = $where_clause." AND `status` = 'A')";
				
				
			}
			else $where_clause = "(`service_name` LIKE '%$searchString%' AND `status` = 'A' OR  `description` LIKE '%$searchString%' AND `status` = 'A')";
			
			
			if($limited)
			{
				$where_clause = "( drug_price_id > 0 OR lab_price_id > 0 ) AND (".$where_clause.")";
			}
			
			
			
			
			$this->db->select('*');
                        $this->db->order_by("service_name","asc");
			$this->db->from('bill_master');
                        $this->db->where($where_clause);

		    
                        $query=$this->db->get();
			return $query->result_array();
		}
		
	
	
		
		
		
	    public function removeBillMaster($bills)
	    {
                $data = array('status'=>'D');
                
		foreach($bills as $bill)
			{
				
				$this->db->where('bill_id', $bill);
				$this->db->update('bill_master', $data);
			}
	    }
	    
	  
	    
	    public function set_Bill($staff_no)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'description' => ucfirst($this->input->post('description')),
			    'service_name' => ucfirst($this->input->post('service_name')),
			    'unit_price' => $this->input->post('unit_price'),
			    'created_by' => $staff_no,
			    'date_created' => $todaysDate,
			    'status' => 'A'
                    );
		    
		    if($this->input->post('dept_id'))
		    {
			$data['dept_id'] = $this->input->post('dept_id');
		    }
            
                    return $this->db->insert('bill_master', $data);
            }
	    
	    public function set_new_bill($description, $service_name, $unit_price, $created_by, $drug_price_id, $lab_price_id)
	    {
		$this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'description' => $description,
			    'service_name' => $service_name,
			    'unit_price' => $unit_price,
			    'created_by' => $created_by,
			    'date_created' => $todaysDate,
			    'drug_price_id' => $drug_price_id,
			    'lab_price_id' => $lab_price_id,
			    'status' => 'A'
                    );
		    
		    if($this->input->post('dept_id'))
		    {
			$data['dept_id'] = $this->input->post('dept_id');
		    }
            
                    return $this->db->insert('bill_master', $data);
	    }
	    
	    
	    public function set_drug_bill($staff_no, $description, $service_name, $unit_price,$drug_price_id)
            {
                    $this->load->helper('url');
		    $this->load->helper('date');
		    
		    $date = new DateTime();
                    date_timezone_set($date, timezone_open('Africa/Lagos'));
                    $todaysDate =  date_format($date, 'Y-m-d H:i:s') ;
            
	    
                
                    $data = array(
                            'description' => $description,
			    'service_name' => $service_name,
			    'unit_price' => $unit_price,
			    'created_by' => $staff_no,
			    'date_created' => $todaysDate,
			    'drug_price_id' => $drug_price_id,
			    'status' => 'A'
                    );
		    
            
                    return $this->db->insert('bill_master', $data);
            }
	    
	   
            
}