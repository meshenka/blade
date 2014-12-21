<?php
/**
 * @author sylvain.gogel@gmail.com
 * @package Blade
 * @subpackage Profile
 *
 */

namespace Drupal\blade\Profile;

use Drupal\blade\Configuration\AbstractConfigurator;

/**
 * Configure text Fields input format filters
 * @since 1.0.0
 */
final class FiltersConfigurator extends AbstractConfigurator
{
    /**
     * {@inheritdoc}
     */
    public function configure()
    {    // Add text formats.
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
        filter_format_save($filtered_html_format);

        $full_html_format = array(
            'format' => 'full_html',
            'name' => 'HTML Complet',
            'weight' => 1,
            'filters' => array(
                // URL filter.
                'filter_url' => array(
                    'weight' => 0,
                    'status' => 1,
                ),
                // Line break filter.
                'filter_autop' => array(
                    'weight' => 1,
                    'status' => 1,
                ),
                // HTML corrector filter.
                'filter_htmlcorrector' => array(
                    'weight' => 10,
                    'status' => 1,
                ),
            ),
        );

        $full_html_format = (object) $full_html_format;
        filter_format_save($full_html_format);

        //markdown
        $markdown_html_format = array(
            'format' => 'markdown',
            'name' => 'Markdown',
            'weight' => 1,
            'filters' => array(
                // URL filter.
                'filter_markdown' => array(
                    'weight' => 0,
                    'status' => 1,
                ),
            ),
        );
        $markdown_html_format = (object) $markdown_html_format;
        filter_format_save($markdown_html_format);
    }
}
