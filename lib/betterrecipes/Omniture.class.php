<?php

/**
 * Omniture
 * 
 * @package betterrecipes
 * @subpackage analytics
 * @author Bastian Kuberek <bkubere@resolute.com>
 */
class Omniture {

  protected $data = array();
  protected $events = array();
  protected $validated_name_cache = array();
  protected $autoload = true;
  
  /**
   * Constructor
   * 
   * @param string $track_function the name of the javascript function to track
   */
  public function __construct(array $defaults = array(), $track_function = 'page.track') {
    $this->page_track = $track_function;
    if ($defaults)
      $this->setMany($defaults);
  }
  
  /**
   * Shortcut to render()
   * 
   * @return string
   */
  public function __toString() {
    return $this->render();
  }

  /**
   * Set an omniture value
   * 
   * @param type $name
   * @param type $value 
   * @return Omniture
   */
  public function set($name, $value) {
    $name = $this->validateName($name);
    if ($name == 'events') {
      $this->addEvent($value);
    } else {
      $this->data[$name] = $value;
    }
    return $this;
  }

  /**
   * Set many omniture values
   * 
   * @param array $vars 
   * @return Omniture
   */
  public function setMany(array $vars) {
    foreach ($vars as $name => $value) {
      $this->set($name, $value);
    }
    return $this;
  }

  /**
   * Set whether or not omniture fires on page load
   * 
   * @param boolean $autoload 
   */
  public function setAutoload($value = true) {
    $this->autoload = $value;
  }

  /**
   * Get whether or not omniture fires on page load
   * 
   * @return boolean
   */
  public function getAutoload() {
    return $this->autoload;
  }

  /**
   * Get an omniture value
   * 
   * @param string $name
   * @param mixed $default
   * @return mixed 
   */
  public function get($name, $default = null) {
    $name = $this->validateName($name);
    return isset($this->data[$name]) ? $this->data[$name] : $default;
  }

  /**
   * Get all omniture values
   * 
   * @return array 
   */
  public function getAll() {
    return $this->data;
  }

  /**
   * Removes and return an omniture value 
   * 
   * @param string $name
   * @param mixed $default
   * @return mixed
   */
  public function remove($name, $default = null) {
    $value = $this->get($name, $default);
    unset($this->data[$this->validateName($name)]);
    return $value;
  }
  
  /**
   * Add an event
   * 
   * @param string $event 
   * @return Omniture
   */
  public function addEvent($event) {
    if (is_array($event)) 
      return $this->addEvents($event);
    $events = $this->get('events', array());
    $events[] = $event;
    $this->data['events'] = $events;
    return $this;
  }
  
  /**
   * Add multiple events
   * 
   * @param string $events 
   * @return Omniture
   */
  public function addEvents(array $events) {
    $this->data['events'] = $this->get('events', array()) + $events;
    return $this;
  }

  /**
   * Clear all omniture values
   * 
   * @return Omniture
   */
  public function reset() {
    $this->data = array();
    return $this;
  }

  /**
   * Validates that $name is a valid Omniture property
   * 
   * @param string $name 
   */
  public function validateName($name) {
    if (!array_key_exists($name, $this->validated_name_cache)) {
      $map = array(
          'pagename' => 'pageName',
          'pagetype' => 'pageType',
          'evar' => 'eVar'
      );

      $this->validated_name_cache[$name] = preg_replace_callback(
          '!([^\d\s]+)(\d*)!i'
          , function($matches) use($map) {
            $name = strtolower($matches[1]);
            if (array_key_exists($name, $map)) 
              $name = $map[$name];
            return $name.$matches[2];
          }
          , $name
      );
    }
    return $this->validated_name_cache[$name];
  }
  
  /**
   * Render a javascript track call
   * 
   * @example
   * <code>
   *     <a href="#" onclick="<?= $omniture->renderJsTrack() ?>">Tab 2</a>
   * </code>
   * @return string
   */
  public function renderJsTrack() {
    return sprintf('%s(%s)', $this->page_track, $this->renderJsObject());
  }
  
  /**
   * Renders omniture variables as a javascript object
   * 
   * @return string
   */
  public function renderJsObject() {
    $gut = '';
    foreach ($this->data as $k => $v)
      $gut .= $k.':'.$this->renderValue($k).',';
    return '{'.rtrim($gut,',').'}';
  }
  
  /**
   * Renders omniture variables as JSON
   * 
   * @return string
   */
  public function renderJSON() {
    return json_encode($this->data);
  }
  
  /**
   * Renders the javascript value of the stored omniture for $name
   * 
   * @param string $name
   * @param mixed $default
   * @return mixed
   */
  public function renderValue($name, $default = null) {
    if (!($value = $this->get($name))) {
      $value = $default;
    }
    switch (gettype($value)) {
      case 'integer':
      case 'double':
        break;
      case 'boolean':
        $value = $value ? "'true'" : "'false'";
        break;
      // Array needs to be before default
      case 'array':
        if ($name == 'events') {
          $value = implode (',', $value);
        } else {
          $value = implode (';', $value);
        }
        // break; // -- Don't break. Want to pass through the default case now
      // The default is a string.
      default:
        $value = htmlentities($value, ENT_QUOTES, 'utf-8', false);
        $value = "'$value'";
        break;
    }
    return $value;
  }

  /**
   * Render traditional Omniture javascript
   * 
   * @param type $script_tag
   * @return string 
   */
  public function render($script_tag = false) {
    $text = '';
    if ($script_tag) {
      $text .= '<script type="text/javascript">'.PHP_EOL;
    }

    foreach ($this->data as $name => $value) {
      $text .= 's.'.$name.' = '.$this->renderValue($name).';'.PHP_EOL;
    }

    if ($script_tag) {
      $text .= '</script>'.PHP_EOL;
    }
    return $text;
  }

  /**
   * Creates a clone
   * 
   * @return Omniture
   */
  public function copy() {
    return clone $this;
  }
}