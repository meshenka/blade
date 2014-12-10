<?php

use Facebook as FB;

/**
 * Facebook Application Configuration
 *
 */
function bladenews_fb_provider_form($form, &$form_state)
{
    $form['bladenews_fb_id'] = array(
        '#type' => 'textfield',
        '#title' => 'Facebook App ID',
        '#required' => true,
        '#default_value' => variable_get('bladenews_fb_id', false),
    );

    $form['bladenews_fb_secret'] = array(
        '#type' => 'password',
        '#title' => 'Facebook App SECRET',
        '#default_value' => variable_get('bladenews_fb_secret', false),
    );

    return system_settings_form($form);
}

/**
 * Facebook Provider Configuration
 */
function bladenews_fb_app_form($form, &$form_state)
{
    if (variable_get('bladenews_fb_id', false) && variable_get('bladenews_fb_secret', false)) {
        $fbId = variable_get('bladenews_fb_id', false);
        $fbSecret = variable_get('bladenews_fb_secret', false);

        $helper = new FB\FacebookRedirectLoginHelper('http://knifemaker.loc/admin/config/services/fb-provider', $fbId, $fbSecret);

        $form['authorize'] = array(
            '#markup' => '<a href="'.$helper->getLoginUrl(['read_stream', 'offline_access']).'">Authorize Blade Application with Facebook</a>' ,
        );
    } else {
        $form['configure'] = array(
            '#markup' => 'The Facebook application is not configured. Go <a href="'.url('admin/config/services/fb-app').'">here</a> to setup application' ,
        );
    }

    $form['bladenews_fb_userid'] = array(
        '#type' => 'textfield',
        '#title' => 'Facebook User Id to import',
        '#description' => 'To find a facebook user id go to <a href="http://findmyfacebookid.com/" target="_blank">Find My Facebook Id</a>',
        '#required' => true,
        '#default_value' => variable_get('bladenews_fb_userid', false),
    );

    return system_settings_form($form);
    //return $form;
}
