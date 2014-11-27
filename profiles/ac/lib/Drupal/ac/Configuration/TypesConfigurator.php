<?php
/**
 * @package Blade
 * @subpackage Profile
 */

namespace Drupal\ac\Configuration;

class TypesConfigurator extends AbstractConfigurator
{
    public function typeTaxonomy()
    {
        //Tags
        $vocabulary = (object) array(
            'name' => st('Product types'),
            'description' => 'Typologie de produits',
            'machine_name' => 'types',
        );

        try {
            taxonomy_vocabulary_save($vocabulary);
        } catch (\PDOException $ex) {
            $this->log("Vocabulary {$vocabulary->name} already created");
        }

        $field = array(
            'field_name' => 'field_'.$vocabulary->machine_name,
            'type' => 'taxonomy_term_reference',
            // Set cardinality to 1 for type
            'cardinality' => 1,
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
            $this->log("Field {$field['field_name']} already created");
        }

        $help = st('Enter the type of your product.');
        $instance = array(
            'field_name' => 'field_'.$vocabulary->machine_name,
            'entity_type' => 'node',
            'label' => 'Type',
            'bundle' => 'product',
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
            $this->log("Instance {$instance['field_name']} already created");
        }
    }

    public function tagsTaxonomy()
    {
        //Tags
        $vocabulary = (object) array(
            'name' => st('Tags'),
            'description' => 'Tags pour les actualités',
            'machine_name' => 'tags',
        );

        try {
            taxonomy_vocabulary_save($vocabulary);
        } catch (\PDOException $ex) {
            $this->log("Vocabulary {$vocabulary->name} already created");
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
            $this->log("Field {$field['field_name']} already created");
        }

        $help = st('Enter a comma-separated list of words to describe your content.');
        $instance = array(
            'field_name' => 'field_'.$vocabulary->machine_name,
            'entity_type' => 'node',
            'label' => 'Tags',
            'bundle' => 'news',
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
            $this->log("Instance {$instance['field_name']} already created");
        }
    }

    public function configure()
    {
        // Insert default pre-defined node types into the database. For a complete
        // list of available node type attributes, refer to the node type API
        // documentation at: http://api.drupal.org/api/HEAD/function/hook_node_info.
        $types = array(
            array(
                'type' => 'page',
                'name' => 'Page',
                'base' => 'node_content',
                'description' => "Utilisez <em>Page</em> pour toute page de contenu editoriale, comme Qui suis-je, Mon atelier etc.",
                'custom' => 1,
                'modified' => 1,
                'locked' => 0,
                ),
            array(
                'type' => 'news',
                'name' => 'Actualité',
                'base' => 'node_content',
                'description' => 'Utilisez <em>Actualité</em> pour tous ce qui est de type post de blog, actualité, commuiqué de presse etc. A noter que dans le profile Blade, ces <em>Actualité</em> sont automatiquement importé depuis vos pages de réseaux sociaux (Facebook, Twitter, Tumblr, Youtube, Instagram, ...)',
                'custom' => 1,
                'modified' => 1,
                'locked' => 0,
                ),
            array(
                'type' => 'product',
                'name' => 'Produit',
                'base' => 'node_content',
                'description' => 'Utilisez <em>Produit</em> pour toutes vos réalisations, à vendre ou non, Produit sert à montrer votre travail, vos réalisations',
                'custom' => 1,
                'modified' => 1,
                'locked' => 0,
                ),
            array(
                'type' => 'home',
                'name' => 'Homepage',
                'base' => 'node_content',
                'description' => 'Utilisez <em>Homepage</em> pour configurer votre page d\'acceuil. La <em>Homepage</em> "publié" et "promue en page d\'acceuil" est automatiquement utiliser pour la home de votre site.',
                'custom' => 1,
                'modified' => 1,
                'locked' => 0,
                ),
            );

        foreach ($types as $type) {
            try {
                $type = node_type_set_defaults($type);
                node_type_save($type);
                node_add_body_field($type);
            } catch (\PDOException $ex) {
                $this->log("Types {$type->type} already created");
            }
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
        variable_set('comment_page', 0);

        // Don't display date and author information for "Basic page" nodes by default.
        variable_set('node_submitted_page', false);

        // Enable user picture support and set the default to a square thumbnail option.
        variable_set('user_pictures', '0');

        // Allow visitor account creation with administrative approval.
        variable_set('user_register', USER_REGISTER_ADMINISTRATORS_ONLY);

        $this->typeTaxonomy();
        $this->tagsTaxonomy();

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
            $this->log("Field {$field['field_name']} already created");
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
            $this->log("Instance {$instance['field_name']} already created");
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

        return $this->getMessages();
    }
}
