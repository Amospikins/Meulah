<?php
/**
 * Core Class
 * Handles URL parsing and controller loading.
 * URL Format: /controller/method/params
 */
class Core {
    protected $currentController = 'Pages'; // Default controller
    protected $currentMethod = 'index'; // Default method
    protected $params = []; // URL parameters

    public function __construct() {
        $url = $this->getUrl();

        // Validate that a controller exists
        if (!empty($url[0]) && file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {
            $this->currentController = ucwords($url[0]); // Set controller
            unset($url[0]); // Remove from URL array
        }

        // Require the controller file
        require_once '../app/controllers/' . $this->currentController . '.php';

        // Instantiate the controller
        $this->currentController = new $this->currentController;

        // Validate method
        if (!empty($url[1]) && method_exists($this->currentController, $url[1])) {
            $this->currentMethod = $url[1];
            unset($url[1]); // Remove from URL array
        }

        // Get parameters (or empty array if none)
        $this->params = $url ? array_values($url) : [];

        // Call method with parameters
        call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
    }

    /**
     * Parses the URL into an array
     * @return array|null
     */
    public function getUrl() {
        if (!isset($_GET['url'])) {
            return [];
        }

        $url = trim($_GET['url'], '/'); // Remove trailing slash
        $url = filter_var($url, FILTER_SANITIZE_URL); // Sanitize URL
        $url = explode('/', $url); // Convert to array
        return array_filter($url); // Remove empty elements
    }
}