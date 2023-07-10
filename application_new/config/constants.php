<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|--------------------------------------------------------------------------
| this are constants that declare user acccess levels to all modules
|--------------------------------------------------------------------------
|work with the module check access in the utilities helper
|
*/


define('HELLO',"Hello world");

define ('CASHIER_HOME', 21);
define ('VIEW_PROVIDER', 22);
define ('CREATE_PROVIDER', 23);
define ('DELETE_PROVIDER', 24);
define ('UPDATE_PROVIDER', 25);
define ('NON_CUSTOMER_ID', 'WALK_IN_CUSTOMER');

define ('CREATE_LAB_TEST', 47);
define ('VIEW_LAB_TEST', 48);
define ('UPDATE_LAB_PRICE', 49);
define ('PERFORM_LAB_TEST', 50);
define ('VIEW_PATIENT_LAB_RESULTS', 51);
define ('DEFINE_SAMPLE_TYPE', 52);
define ('RECORD_SAMPLES', 53);
define ('RECORD_RESULTS', 54);
define ('DELETE_TEST',55);
define ('DISPENSE_WITHOUT_PAYMENT',56);
define ('VIEW_SAMPLE_TYPE',57);
define ('UPDATE_SAMPLE_TYPE',58);
define ('DELETE_SAMPLE_TYPE',59);
define ('UPDATE_TEST_TYPE',60);
define ('GENERATE_HMO_BILL',61);
define ('VIEW_HMO_BILL',62);
define ('POST_HMO_BILL',63);
define ('DELETE_USER_GROUP',64);
define ('CREATE_DOSAGE_FORM', 65);
define ('DELETE_DOSAGE_FORM', 66);
define ('UPDATE_DOSAGE_FORM', 67);
define ('CREATE_DRUG_BILL_FORM', 68);
define ('UPDATE_DRUG_BILL_FORM', 69);
define ('DELETE_DRUG_BILL_FORM', 70);
define ('DELETE_BASEDATA', 71);
define ('VIEW_REPORT_HOME', 72);
define ('GENERATE_REPORTS', 73);
define ('UPDATE_VITALS', 74);
define ('VIEW_IN_PATIENT_HOME', 75);
define ('VIEW_IN_PATIENTS', 76);
define ('SCHEDULE_IN_PATIENT_TASK', 77);
define ('PERFORM_IN_PATIENT_TASK', 78);
define ('SKIP_TASK', 79);
define ('UPDATE_BILL_ITEM_PRICE', 80);
define ('REFUND_BILL_AMOUNT', 81);
define ('DELETE_USER', 82);
define ('RESET_PASSWORD', 83);
define ('NEW_PATIENT_EMAIL_TEMPLATE',"new-patient");
define ('NEW_USER_EMAIL_TEMPLATE',"new-user");
define ('PASSWORD_RESET_EMAIL_TEMPLATE',"password-reset");
define ('MOBILE_USER', "mobile_user");
define ('MOBILE_ADMIN', "mobile_admin");
define ('PATIENT_NUMBER', "patientNumber");
/*
|--------------------------------------------------------------------------
| this are the error codes
|--------------------------------------------------------------------------
|errror codes
|
*/

define('ACCESS_ERROR',"Contact Administrator, You Do not have enough permision to perform action");
define ('ERROR_INVALID_AMOUNT', 'error_invalid_amount');
define('ERROR_CODE_UNVERIFIED_MOBILE', "97");
define('ERROR_CODE_GENERAL_API_FAIL', "01");
define('ERROR_CODE_INVALID_PATIENT', "12");
define('API_SUCCESS_CODE', "00");
/*
|--------------------------------------------------------------------------
| global text variable indexes
|--------------------------------------------------------------------------
||
*/
define ('INVALID_FUNC_CALL', 'error_invalid_call');
define ('FREE_CODE_ALREADY_EXIST', 'error_free_code_exist');
define ('TASK_ALREADY_EXIST', 'error_task_exist');
define ('FREE_CODE_CREATED', 'error_free_code_created');
define ('NO_NON_PATIENT_LAB_ORDER_FOUND','notice_no_found_lab_order');
define ('RECORD_TEST_RESULTS_FIRST', 'error_record_test_results');
define ('NO_BILL_ITEM_SELECTED', 'error_no_bill_item_selected');
define ('NO_MODIFY_TEST_PERFORMED', 'error_test_already_performed');
define ('NO_MODIFY_SAMPLE_COLLECTED', 'error_lab_already_collected_sample');
define ('SAMPLE_TYPE_ALREADY_EXITS', 'error_sample_type_already_exists');
define ('NO_SAMPLE_TYPE_DEFINED', 'error_no_sample_type_created');
define ('EXISTING_SAMPLE_REF', 'error_sample_ref_exists');
define('NO_TESTS_NEED_PUBLISH_RESULT', 'error_no_tests_need_result');
define('INVALID_PATIENT', 'error_invalid_patient');
define('NO_PENDING_ORDERS','error_no_pending_disorders');
define('NO_MODIFY_DRUG_DISPENSED', 'error_drug_already_dispensed');
define('REMOVE_USERS_FROM_GROUP','error_users_exist_in_group');
define('DOSAGE_FORM_ALREADY_EXIST','error_dosage_form_exist');
define('DRUG_BILL_FORM_ALREADY_EXIST', 'error_drug_bill_form_exist');
define('UNIT_NAME_ALREADY_EXIST','error_unit_name_exist');
define('UNIT_SYMBOL_ALREADY_EXIST','error_unit_symbol_exist');
define('UNKNOWN_BASEDATA','error_unknown_basedata_type');
define('INVALID_TASK_START_DATE','error_invalid_task_date');

define("INPATIENT_TASK_SCHEDULED","notice_inpatient_task_success");
define("TASK_DELETED", "notice_task_deleted");
define('TASK_CREATED','notice_task_created');
define('FREE_CODE_DELETED', 'notice_free_code_deleted');
define('NO_RESULT_FOR_REPORT','notice_no_result_for_report');
define('DELETE_BASEDATA_SUCCESS','notice_basedata_delete_success');
define('UNIT_CREATE_SUCCESS','notice_create_unit_success');
define('DELETE_DRUG_BILL_FORM_SUCCESS', 'notice_delete_drug_bill_form_success');
define('CREATE_DRUG_BILL_FORM_SUCCESS', 'notice_drug_bill_form_create_success');
define('CREATE_DOSAGE_FORM_SUCCESS', 'notice_dosage_form_create_success');
define ('LAB_BILL_CREATE_SUCCESS', 'notice_lab_bill_create_success');
define ('NOTICE_LAB_TEST_CREATE_SUCCESS', 'notice_lab_create_success');
define ('NO_AVAILABLE_LAB_ORDER', 'notice_no_lab_requests');
define ('SUCCESS_RECORD_TEST_RESULTS', 'notice_test_result_success');
define ('NO_TEST_RESULTS', 'notice_no_test_results');
define('SAMPLE_TYPE_CREATED','notice_sample_type_created');
define('TEST_SAMPLE_RECORDED', 'notice_test_sample_recorded');
define('DELETE_LAB_TYPE_SUCCESS', 'notice_delete_lab_type_success');
define('DELETE_SAMPLE_TYPE_SUCCESS', 'notice_delete_sample_type_success');
define('UPDATE_SAMPLE_TYPE_SUCCESS', 'notice_sample_type_update_success');
define('UPDATE_TEST_TYPE_SUCCESS', 'notice_test_type_update_success');
define('DELETE_DEPT_SUCCESS', 'notice_dept_delete_success');
define('CREATE_PROVIDER_SUCCESS','notice_provider_create_success');
define('NO_CURRENT_BILL_FOR_HMO', 'notice_no_current_bill_for_hmo');
define('HMO_BILL_GENERATE_SUCCESS', 'notice_hmo_generate_bill_success');
define('HMO_BILL_POSTED', 'notice_hmo_bill_posted');
define('NO_BILL_FOR_HMO', 'notice_no_bill_found_for_hmo');
define('GROUP_DELETED','notice_group_deleted');
define('UPDATE_DOSAGE_FORM_SUCCESS',"notice_dosage_form_update_success");
define('DELETE_DOSAGE_FORM_SUCCESS', "notice_delete_dosage_form_success");
define('PARTIAL_PAYMENT_POSTED','notice_partial_payment_recieved');
define('PARTIAL_PAYMENT_COMPLETED','notice_partial_payment_completed');
/* End of file constants.php */
/* Location: ./application/config/constants.php */