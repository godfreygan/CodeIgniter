<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class MY_Session {

    /**
     * Construct
     *
     * This is the construct function
     *
     * @access public
     * @return void
     */
    public function __construct() {
        $this->start();
        $this->set_name();
        $this->commit();
        return;
    }

    /**
     * start
     *
     * Start session
     *
     * @param string
     * @access public
     * @return void
     */
    public function start($oid = null) {
        if (!isset($_SESSION)) {
            if ($oid === null) {
                session_start();
            } else {
                session_start($oid);
            }
            return;
        }
    }

    /**
     * commit
     *
     * Write session data and end session
     *
     * @access public
     * @return void
     */
    public function commit() {
        //session_write_close();
        return;
    }

    /**
     * delete
     *
     * Unset session
     *
     * @access public
     * @return void
     */
    public function delete() {
        session_unset();
        return;
    }

    /**
     * destroy
     *
     * Destroy session
     *
     * @access public
     * @return boolean
     */
    public function destroy() {
        return session_destroy();
    }

    /**
     * regenerate_id
     *
     * Regenerate the session id
     *
     * @param string
     * @access public
     * @return boolean
     */
    public function regenerate_id($delete_old_session = FALSE) {
        return session_regenerate_id($delete_old_session);
    }

    /*------------------------------Getter------------------------------*/

    /**
     * get_data
     *
     * Get the session data
     *
     * @param string
     * @access public
     * @return string
     */
    public function get_data($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : FALSE;
    }

    /**
     * get_all_data
     *
     * Get all the session data
     *
     * @access public
     * @return array
     */
    public function get_all_data() {
        return $_SESSION;
    }

    /**
     * get_id
     *
     * Get the session id
     *
     * @access public
     * @return string
     */
    public function get_id() {
        return session_id();
    }

    /**
     * get_name
     *
     * Get the session name
     *
     * @access public
     * @return string
     */
    public function get_name() {
        return session_name();
    }

    /*------------------------------Setter------------------------------*/

    /**
     * set_id
     *
     * Set the session id
     * This function can be used before using start() only!
     *
     * @param string
     * @access public
     * @return void
     */
    public function set_id($id) {
        session_id($id);
        return $this->commit();
    }

    /**
     * set_name
     *
     * Set the session name
     * This function can be used before using start() only!
     *
     * @param string
     * @access public
     * @return void
     */
    public function set_name($name = '') {
        if (!empty($name) && !is_numeric($name))
            session_name($name);
        return $this->commit();
    }

    /**
     * set_data
     *
     * Set the session data
     * ex: set_userdata(array(1 => 'a', 2 => 'b'))
     *           set_userdata(1 => 'a')
     *
     * @param string
     * @param string
     * @access public
     * @return void
     */
    public function set_userdata($data = array(), $value = '') {
        if (is_string($data)) {
            $_SESSION[$data] = $value;
            return;
        }

        if (count($data) > 0) {
            foreach ($data as $key => $val) {
                $_SESSION[$key] = $val;
            }
        }

        $this->commit();
        return;
    }

    public function del() {
        $this->delete();
        $this->destroy();
    }
}

/* End of file My_Session.php */
