<?php

function ac_configure_types()
{
    $msg = '';
    // Insert default pre-defined node types into the database. For a complete
// list of available node type attributes, refer to the node type API
// documentation at: http://api.drupal.org/api/HEAD/function/hook_node_info.
    $types = array(
        array(
            'type' => 'page',
            'name' => 'Basic page',
            'base' => 'node_content',
            'description' => "Use <em>basic pages</em> for your static content, such as an 'About us' page.",
            'custom' => 1,
            'modified' => 1,
            'locked' => 0,
            ),
        array(
            'type' => 'article',
            'name' => 'Article',
            'base' => 'node_content',
            'description' => 'Use <em>articles</em> for time-sensitive content like news, press releases or blog posts.',
            'custom' => 1,
            'modified' => 1,
            'locked' => 0,
            ),
        );

    try {
        foreach ($types as $type) {
            $type = node_type_set_defaults($type);
            node_type_save($type);
            node_add_body_field($type);
        }
    } catch (\PDOException $ex) {
        $msg .= 'Types already created';
    }

// Insert default pre-defined RDF mapping into the database.
    $rdf_mappings = array(
        array(
            'type' => 'node',
            'bundle' => 'page',
            'mapping' => array(
                'rdftype' => array('foaf:Document'),
                ),
            ),
        array(
            'type' => 'node',
            'bundle' => 'article',
            'mapping' => array(
                'field_image' => array(
                    'predicates' => array('og:image', 'rdfs:seeAlso'),
                    'type' => 'rel',
                    ),
                'field_tags' => array(
                    'predicates' => array('dc:subject'),
                    'type' => 'rel',
                    ),
                ),
            ),
        );
    foreach ($rdf_mappings as $rdf_mapping) {
        rdf_mapping_save($rdf_mapping);
    }

// Default "Basic page" to not be promoted and have comments disabled.
    variable_set('node_options_page', array('status'));
    variable_set('comment_page', COMMENT_NODE_HIDDEN);

// Don't display date and author information for "Basic page" nodes by default.
    variable_set('node_submitted_page', false);

// Enable user picture support and set the default to a square thumbnail option.
    variable_set('user_pictures', '0');

// Allow visitor account creation with administrative approval.
    variable_set('user_register', USER_REGISTER_ADMINISTRATORS_ONLY);

// Create a default vocabulary named "Tags", enabled for the 'article' content type.
    $description = 'Use tags to group articles on similar topics into categories.';
    $vocabulary = (object) array(
        'name' => st('Tags'),
        'description' => $description,
        'machine_name' => 'tags',
        );

    try {
        taxonomy_vocabulary_save($vocabulary);
    } catch (\PDOException $ex) {
        $msg .= 'Tag Vocabulary already created';
    }

    $field = array(
        'field_name' => 'field_'.$vocabulary->machine_name,
        'type' => 'taxonomy_term_reference',
// Set cardinality to unlimited for tagging.
        'cardinality' => FIELD_CARDINALITY_UNLIMITED,
        'settings' => array(
            'allowed_values' => array(
                array(
                    'vocabulary' => $vocabulary->machine_name,
                    'parent' => 0,
                    ),
                ),
            ),
        );

    try {
        field_create_field($field);
    } catch (\FieldException $ex) {
        $msg .= "Field {$field['field_name']} already created";
    }

    $help = st('Enter a comma-separated list of words to describe your content.');
    $instance = array(
        'field_name' => 'field_'.$vocabulary->machine_name,
        'entity_type' => 'node',
        'label' => 'Tags',
        'bundle' => 'article',
        'description' => $help,
        'widget' => array(
            'type' => 'taxonomy_autocomplete',
            'weight' => -4,
            ),
        'display' => array(
            'default' => array(
                'type' => 'taxonomy_term_reference_link',
                'weight' => 10,
                ),
            'teaser' => array(
                'type' => 'taxonomy_term_reference_link',
                'weight' => 10,
                ),
            ),
        );

    try {
        field_create_instance($instance);
    } catch (\FieldException $ex) {
        $msg .= "Instance {$instance['field_name']} already created";
    }

// Create an image field named "Image", enabled for the 'article' content type.
// Many of the following values will be defaulted, they're included here as an illustrative examples.
// See http://api.drupal.org/api/function/field_create_field/7

    $field = array(
        'field_name' => 'field_image',
        'type' => 'image',
        'cardinality' => 1,
        'locked' => FALSE,
        'indexes' => array('fid' => array('fid')),
        'settings' => array(
            'uri_scheme' => 'public',
            'default_image' => FALSE,
            ),
        'storage' => array(
            'type' => 'field_sql_storage',
            'settings' => array(),
            ),
        );

    try {
        field_create_field($field);
    } catch (\FieldException $ex) {
        $msg .= "Field {$field['field_name']} already created";
    }

// Many of the following values will be defaulted, they're included here as an illustrative examples.
// See http://api.drupal.org/api/function/field_create_instance/7
    $instance = array(
        'field_name' => 'field_image',
        'entity_type' => 'node',
        'label' => 'Image',
        'bundle' => 'article',
        'description' => st('Upload an image to go with this article.'),
        'required' => FALSE,

        'settings' => array(
            'file_directory' => 'field/image',
            'file_extensions' => 'png gif jpg jpeg',
            'max_filesize' => '',
            'max_resolution' => '',
            'min_resolution' => '',
            'alt_field' => TRUE,
            'title_field' => '',
            ),

        'widget' => array(
            'type' => 'image_image',
            'settings' => array(
                'progress_indicator' => 'throbber',
                'preview_image_style' => 'thumbnail',
                ),
            'weight' => -1,
            ),

        'display' => array(
            'default' => array(
                'label' => 'hidden',
                'type' => 'image',
                'settings' => array('image_style' => 'large', 'image_link' => ''),
                'weight' => -1,
                ),
            'teaser' => array(
                'label' => 'hidden',
                'type' => 'image',
                'settings' => array('image_style' => 'medium', 'image_link' => 'content'),
                'weight' => -1,
                ),
            ),
    );

    try {
        field_create_instance($instance);
    } catch (\FieldException $ex) {
        $msg .= "Instance {$instance['field_name']} already created";
    }

    $filtered_html_format = array(
        'format' => 'filtered_html',
        'name' => 'HTML Filtré',
        'weight' => 0,
        'filters' => array(
// URL filter.
            'filter_url' => array(
                'weight' => 0,
                'status' => 1,
                ),
// HTML filter.
            'filter_html' => array(
                'weight' => 1,
                'status' => 1,
                ),
// Line break filter.
            'filter_autop' => array(
                'weight' => 2,
                'status' => 1,
                ),
// HTML corrector filter.
            'filter_htmlcorrector' => array(
                'weight' => 10,
                'status' => 1,
                ),
            ),
        );
    $filtered_html_format = (object) $filtered_html_format;

    // Enable default permissions for system roles.
    $filtered_html_permission = filter_permission_name($filtered_html_format);
    user_role_grant_permissions(DRUPAL_ANONYMOUS_RID, array('access content', $filtered_html_permission));
    user_role_grant_permissions(DRUPAL_AUTHENTICATED_RID, array('access content', $filtered_html_permission));
}
