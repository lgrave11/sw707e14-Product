<?php

/**
 * This is the "base controller class". All other "real" controllers extend this class.
 */
class Controller
{
    /**
     * @var null Database Connection
     */
    public $db = null;
    private $error = array();
    private $success = array();

    /**
     * Whenever a controller is created, open a database connection too. The idea behind is to have ONE connection
     * that can be used by multiple models (there are frameworks that open one connection per model).
     */
    function __construct()
    {
        $this->openDatabaseConnection();
    }

    /**
     * Open the database connection with the credentials from application/config/config.php
     */
    private function openDatabaseConnection()
    {
        
        $this->db = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    }

    /**
     * Load the model with the given name.
     * loadModel("SongModel") would include models/songmodel.php and create the object in the controller, like this:
     * $songs_model = $this->loadModel('SongsModel');
     * Note that the model class name is written in "CamelCase", the model's filename is the same in lowercase letters
     * @param string $model_name The name of the model
     * @return object model
     */
    public function loadModel($model_name)
    {
        require 'application/models/' . strtolower($model_name) . '.php';
        // return new model (and pass the database connection to the model)
        return new $model_name($this->db);
    }
    
    public function error($message) {
        $this->error[] = $message;
    }
    
    public function success($message) {
        $this->success[] = $message;
    }
    
    public function publishMessages($name) {
        if (!empty($this->error)) {
            $_SESSION[$name.'_error'] = $this->error;
        }
        if (!empty($this->success)) {
            $_SESSION[$name.'_success'] = $this->success;
        }
    }
}
