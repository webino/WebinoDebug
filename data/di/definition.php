<?php 
return array (
  'WebinoDebug\\Module' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ModuleManager\\Feature\\InitProviderInterface',
      1 => 'Zend\\ModuleManager\\Feature\\ConfigProviderInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDebug\\Factory\\ModuleOptionsFactory' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\ServiceManager\\FactoryInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
  'WebinoDebug\\Options\\ModuleOptions' => 
  array (
    'supertypes' => 
    array (
      0 => 'Zend\\Stdlib\\ParameterObjectInterface',
      1 => 'Zend\\Stdlib\\AbstractOptions',
      2 => 'Zend\\Stdlib\\ParameterObjectInterface',
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
      '__construct' => 3,
      'setEnabled' => 0,
      'setMode' => 0,
      'setBar' => 0,
      'setStrict' => 0,
      'setLog' => 0,
      'setEmail' => 0,
      'setMaxDepth' => 0,
      'setMaxLen' => 0,
      'setTemplateMap' => 0,
      'setFromArray' => 0,
    ),
    'parameters' => 
    array (
      '__construct' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::__construct:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setEnabled' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setEnabled:0' => 
        array (
          0 => 'enabled',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMode' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setMode:0' => 
        array (
          0 => 'mode',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setBar' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setBar:0' => 
        array (
          0 => 'bar',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setStrict' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setStrict:0' => 
        array (
          0 => 'strict',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setLog' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setLog:0' => 
        array (
          0 => 'log',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setEmail' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setEmail:0' => 
        array (
          0 => 'email',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMaxDepth' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setMaxDepth:0' => 
        array (
          0 => 'maxDepth',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setMaxLen' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setMaxLen:0' => 
        array (
          0 => 'maxLen',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
      'setTemplateMap' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setTemplateMap:0' => 
        array (
          0 => 'templateMap',
          1 => NULL,
          2 => false,
          3 => NULL,
        ),
      ),
      'setFromArray' => 
      array (
        'WebinoDebug\\Options\\ModuleOptions::setFromArray:0' => 
        array (
          0 => 'options',
          1 => NULL,
          2 => true,
          3 => NULL,
        ),
      ),
    ),
  ),
  'WebinoDebug\\Tracy\\Workaround\\DisabledBar' => 
  array (
    'supertypes' => 
    array (
    ),
    'instantiator' => '__construct',
    'methods' => 
    array (
    ),
    'parameters' => 
    array (
    ),
  ),
);
