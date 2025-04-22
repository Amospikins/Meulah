<?php
/**
 * Base Controller
 * Loads the models and views
 */
class Controller {
    /**
     * Load a model
     * @param string $model The model name
     * @return object Instance of the model
     * @throws Exception If the model file or class is not found
     */
    public function model($model) {
        $model = preg_replace('/[^a-zA-Z0-9_]/', '', $model); // Security check
        $modelFile = __DIR__ . '/../models/' . $model . '.php';

        if (!file_exists($modelFile)) {
            throw new Exception("Model file <strong>'$model.php'</strong> not found.");
        }

        require_once $modelFile;

        if (!class_exists($model)) {
            throw new Exception("Class <strong>'$model'</strong> not found in <strong>'$model.php'</strong>.");
        }

        return new $model();
    }

    /**
     * Load a view
     * @param string $view The view file
     * @param array $data Data to pass to the view
     * @throws Exception If the view file is not found
     */
    public function view($view, $data = []) {
        $view = preg_replace('/[^a-zA-Z0-9_\/]/', '', $view); // Security check
        $viewFile = __DIR__ . '/../views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new Exception("View file <strong>'$view.php'</strong> not found.");
        }

        require_once $viewFile;
    }
}