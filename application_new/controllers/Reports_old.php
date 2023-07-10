<?php
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define ('MODULE_NO', 13);
define ('TITLE', 'Reports');

class Reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
		$this->load->model('ult');
		$this->load->model('staff_master_model');
		$this->load->model('profile_pics_model');
		$this->load->model('module_map_model');
		$this->load->model('role_model');
		$this->load->model('hmo_model');
                $this->load->model('module_model');
		$this->load->model('department_model');
		$this->load->model('appointment_model');
		$this->load->model('daily_schedule_model');
		$this->load->model('patient_model');
		$this->load->model('sub_module_map_model');
		$this->load->model('user_groups_model');
		$this->load->model('shift_model');
		$this->load->model('general_update_model');
		$this->load->model('bill_master_model');
                $this->load->model('state_model');
                $this->load->model('country_model');
                $this->load->model('general_update_model');
		$this->load->model('bills_model');
		$this->load->model('hmo_bills_model');
		$this->load->model('hmo_transactions_model');
                $this->load->model('reports_model');
                $this->load->model('param_model');
		$this->load->helper('date');
		$this->utilities->loadUserLang();
		
		
		
		
	}
        
	private function downloadXcelReport($headers, $data, $filename)
	{
		 $this->load->library('excel');
	         
		 $this->excel->setActiveSheetIndex(0);
		 
		 $columnIndex = range('A', 'Z');
		 
		
		 
		 $this->excel->getActiveSheet()->setTitle('Report');
		 
		 $rowCount = 1;
		 $columnCount = 0;
		 
		 foreach($headers as $header)
		 {
			foreach($header as $column)
			{
				$this->excel->getActiveSheet()->getStyle($columnIndex[$columnCount].$rowCount)->getfont()->setBold(true);
				$this->excel->getActiveSheet()->setCellValue($columnIndex[$columnCount].$rowCount,$column);
			        $columnCount++;
			}
			
			$rowCount ++;
			$columnCount = 0;
		 }
		 
		 
		 //increase row count after header and reset column count
		 
		 
		 foreach($data as $row)
		 {
			foreach($row as $column)
			{
				$this->excel->getActiveSheet()->setCellValue($columnIndex[$columnCount].$rowCount,$column);
				$columnCount++;
			}
			$rowCount ++;
			$columnCount = 0;
		 }
		 
		 //$this->excel->getActiveSheet()->setCellValue('A1','This is just some test');
		 
		 
		 
		 
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$filename.'"');
		header('Cache-Control: max-age=0');
		
		ob_end_clean();
		ob_start();
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
		$objWriter->save('php://output');
		
		

	}
	
	
	
        private function prepareQuery($requiredPrams , $values, $query)
        {
            $preparedQuery = $query;
	    
	   
	    
	   // print_r($values);
            
            foreach($requiredPrams as $param){
				
                
                //date format fix
                if($param == "date" || $param == "start_date" || $param == "end_date")
                {                    
                    $array = explode("-", $values[$param]);
                    $values[$param] = $array[2]."-".$array[0]."-".$array[1];

                    if($param == "end_date"){

                        $values[$param] = $values[$param]." 23:59:59";

                    }else if($param == "date" || $param == "start_date"){

                        $values[$param] = $values[$param]." 00:00:00";
                    }
                }
                $placeholder =  "{".$param."}";
                $preparedQuery = str_replace($placeholder, $values[$param], $preparedQuery);
	
            }
            
            return $preparedQuery;
        }
        
        private function execute_report($request, $report, $requiredPrams)
        {
            
            if(!$request['report_short_name'])
            {
                $this->utilities->redirectWithNotice("reports", $this->lang->line(INVALID_FUNC_CALL));
            }
            
            $filename = $request['report_short_name'].".xls";
            
            $query = $this->prepareQuery($requiredPrams, $request,  $report["query"]);


         
            $query = $this->db->query($query);
            
	    
	    //if no result return a notice no result
	    if($query->num_rows() < 1)
	    {
		$this->utilities->redirectWithNotice("reports", $this->lang->line(NO_RESULT_FOR_REPORT));
	    }
	    
	    
            $reportData = "";
            $reportHeaders = "";
         
            $counter = 0;
	    
	    
            foreach($query->result() as $row)
            {
                 //convert object to array
                 $row = ( get_object_vars($row));
                 
                //GET THE ARRAY HEADERS
                if($counter == 0)
                {
                    $reportHeaders[$counter] = array_keys($row);
                }                         
               
                 $reportData[$counter] = $row;       
                 $counter++;
            }
          
          
         
	 $this->downloadXcelReport($reportHeaders,$reportData,$filename);
           
        }
        
        
        public function process()
        {
            $this->utilities->aunthenticateAccess(GENERATE_REPORTS, "reports");
            
            if(!$this->input->post("report_id"))
            {
                $this->utilities->redirectWithNotice("reports", $this->lang->line(INVALID_FUNC_CALL));
            }
          
          $report = $this->reports_model->getReports($this->input->post("report_id"));
          
          if(!$report){
            $this->utilities->redirectWithNotice("provider", $this->lang->line(INVALID_FUNC_CALL));
          }
          
          $request = $_POST;
          
          $request["report_short_name"] = $report["report_short_name"];
          
          $module = $this->module_model->getModule($report["module_no"]);
          
          $params =  explode(",",$report["report_params"]);
         
	
	
          $requiredParams = array();
          $counter = 0;
          foreach($params as $param)
          {
	   
            $paramDets = $this->param_model->getParam($param);	   
            $requiredParams[$counter] = $paramDets["name"];
            $counter ++;
          }
          
           
               
          $this->execute_report($request, $report, $requiredParams);
          
          
        }
        
	private function buildFrontEndReportParams()
	{
		$reportParams = "";
		
		$counter = 0;
		$params = $this->param_model-> getAllParam();
		foreach($params as $param)
		{
			$reportParams[$counter] = "<div class=\"form-group  report-param\" report_id = \"".$param["id"]."\" > ";
			$reportParams[$counter] = $reportParams[$counter]." <label for=\"exampleInputEmail1\">".ucfirst($param["display"])."</label>";
			
			//build each type accordingly
			if($param["type"] == "date")
			{
				$reportParams[$counter] = $reportParams[$counter]." <input type=\"text\" name=\"".$param["name"]."\" class=\"form-control default-date-picker\" placeholder=\"\" value=\"\"/>";
			}
			else if($param["type"] == "string")
			{
				$reportParams[$counter] = $reportParams[$counter]."<input type=\"text\" name=\"".$param["name"]."\" class=\"form-control\" placeholder=\"".ucfirst($param["display"])."\" value=\"\"/>";
			}
			
			else if($param["type"] == "list")
			{
				$reportParams[$counter] = $reportParams[$counter]."<select name=\"".$param["name"]."\" id=\"".$param["name"]."\" class=\"form-control m-bot15\">";
					
			        //if the select is not dynamic
				if($param["dynamic"] == "N")
				{
					$reportParams[$counter] = $reportParams[$counter].$param["options"];
				}
				else if($param["dynamic"] == "Y"){
					
					$query = $this->db->query($param["options"]);
					$options = $query->result_array();
					
					foreach($options as $option)
					{
					   $reportParams[$counter] = $reportParams[$counter]."<option value=\"".$option["id"]."\">".ucfirst($option["name"])."</option>";
					}
				}
				
			        $reportParams[$counter] = $reportParams[$counter]." </select>";
			}
			
			$reportParams[$counter] = $reportParams[$counter]." </div>";
			$counter ++;
		}
		
		
		
		return $reportParams;
	}
        
        public function index()
        {
            
            $this->utilities->aunthenticateAccess(VIEW_REPORT_HOME, "home");
	
		
		
			//get all user module mappings by role
			$data['usermodules'] = $this->module_map_model->getrolemodules($this->session->userdata('role'));
			
			
			
			$data["report_params"] = $this->buildFrontEndReportParams();
			
			
			//get the role title
			$data['user_role'] = $this->role_model->getrole($this->session->userdata('role'));
			
			
			$data['currentmodule']['number'] = MODULE_NO;
			$data['currentmodule']['title'] = TITLE;
                        
                        $data['reports'] = $this->reports_model->getReports();
			
			$data['title'] = "Medstation | Reports";
			$data['content-description'] = "Report Generator";
			//$data['title']=$this->passwordhash->HashPassword("password");
			
			$pages[0] = "reports/home";
			
			$this->page->loadPage($pages,$data,TRUE);
        }
        
        
}