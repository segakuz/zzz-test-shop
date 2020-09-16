<?php

/**
 * View class
 */
class View
{
    private $template;

    /**
     * Creates view instance for given template
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * Renders view with given data
     */
    public function render($data=['data'=>null])
    {
        extract($data);
        ob_start();
        include_once TEMPLATE_PATH . $this->template;
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }
}
