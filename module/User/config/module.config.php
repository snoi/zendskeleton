<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'User\Controller\User' => 'User\Controller\UserController',
        ),
    ),
     // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'usery' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/usery[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'User\Controller\User',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/admin.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);

/*
 * module/User/config/module.config.php
 */

/*
 * 
 * The config information is passed to the relevant components by the ServiceManager. We need two initial sections: controllers and view_manager. The controllers section provides a list of all the controllers provided by the module. We will need one controller, UserController, which we’ll reference as User\Controller\User. The controller key must be unique across all modules, so we prefix it with our module name.
 * Within the view_manager section, we add our view directory to the TemplatePathStack configuration. This will allow it to find the view scripts for the User module that are stored in our view/ directory.
 */