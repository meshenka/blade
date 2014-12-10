<?php

/**
 * Facebook Application Configuration
 *
 */
function bladenews_twitter_provider_form($form, &$form_state)
{
    $form['bladenews_twitter_app_consumer_key'] = array(
        '#type' => 'textfield',
        '#title' => 'Twitter Application Consumer Key',
        '#required' => true,
        '#default_value' => variable_get('bladenews_twitter_app_consumer_key', false),
    );

    $form['bladenews_twitter_app_consumer_secret'] = array(
        '#type' => 'password',
        '#title' => 'Twitter Application Consumer Secret',
        '#default_value' => variable_get('bladenews_twitter_app_consumer_secret', false),
    );

    return system_settings_form($form);
}

/**
 * Facebook Provider Configuration
 */
function bladenews_twitter_app_form($form, &$form_state)
{
    $form['bladenews_twitter_oauth_token'] = array(
        '#type' => 'textfield',
        '#title' => 'User Oauth token',
        '#required' => true,
        '#default_value' => variable_get('bladenews_twitter_oauth_token', false),
    );

    $form['bladenews_twitter_oauth_token_secret'] = array(
        '#type' => 'password',
        '#title' => 'User Oauth Token Secret',
        '#default_value' => variable_get('bladenews_twitter_oauth_token_secret', false),
    );

    return system_settings_form($form);
}
