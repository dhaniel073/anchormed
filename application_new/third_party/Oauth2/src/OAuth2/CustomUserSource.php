<?php
namespace OAuth2;
/**
 * Created by PhpStorm.
 * User: dusty
 * Date: 8/26/16
 * Time: 2:53 PM
 */

if(!defined('BASEPATH')) exit("No direct access to script");


class CustomUserSource implements Storage\UserCredentialsInterface
{

    public $medstation;

    /**
     * CustomUserSource constructor.
     */
    public function __construct()
    {
        $this->medstation =& get_instance();
        $this->medstation->load->database();
        $this->medstation->load->library('passwordhash', array('iteration_count_log2' => 8, 'portable_hashes' => FALSE ));
        $this->medstation->load->model("plt_model");
    }


    /**
     * Grant access tokens for basic user credentials.
     *
     * Check the supplied username and password for validity.
     *
     * You can also use the $client_id param to do any checks required based
     * on a client, if you need that.
     *
     * Required for OAuth2::GRANT_TYPE_USER_CREDENTIALS.
     *
     * @param $username
     * Username to be check with.
     * @param $password
     * Password to be check with.
     *
     * @return
     * TRUE if the username and password are valid, and FALSE if it isn't.
     * Moreover, if the username and password are valid, and you want to
     *
     * @see http://tools.ietf.org/html/rfc6749#section-4.3
     *
     * @ingroup oauth2_section_4
     */
    public function checkUserCredentials($username, $password)
    {
        // TODO: Implement checkUserCredentials() method.
        log_message("info","about checking user credentials for $username");

        $plt = $this->medstation->plt_model->findPltByPatientNumber($username);

        //invalid patient , or patient not activated for mobile yet
        if(!$plt){
            log_message("debug", "invalid patient or patient not enabled for mobile yet");
            return false;
        }

        $isPwdCorrect = $this->medstation->passwordhash->CheckPassword($password,$plt["password"]);

        return $isPwdCorrect;
    }

    /**
     * @return
     * ARRAY the associated "user_id" and optional "scope" values
     * This function MUST return FALSE if the requested user does not exist or is
     * invalid. "scope" is a space-separated list of restricted scopes.
     * @code
     * return array(
     *     "user_id"  => USER_ID,    // REQUIRED user_id to be stored with the authorization code or access token
     *     "scope"    => SCOPE       // OPTIONAL space-separated list of restricted scopes
     * );
     * @endcode
     */
    public function getUserDetails($username)
    {
        // TODO: Implement getUserDetails() method.
        log_message("info","getting user details");

        return array("user_id"=>$username, ""=>"");
    }
}