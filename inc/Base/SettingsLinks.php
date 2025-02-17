<?php
/**
 * @package DirexPlugin
 */
namespace Jemaa\DirexPlugin\Base;

use Jemaa\DirexPlugin\Base\BaseController;

/**
 * class SettingsLinks
 */
class SettingsLinks extends BaseController
{
      /**
     * Register the settings link filter
     *
     * @return void
     */
    public function register(): void
    {
        // Only add the filter if plugin_name is set
        if (!empty($this->plugin_name)) {
            add_filter(
                "plugin_action_links_{$this->plugin_name}", 
                [$this, 'settings_link']
            );
        }
    }

    /**
     * Add settings link to plugin listing
     *
     * @param array $links Existing plugin action links
     * @return array Modified plugin action links
     */
    public function settings_link(array $links): array
    {
        $settings_link = sprintf(
            '<a href="admin.php?page=%s">%s</a>',
            'direx_plugin',
            esc_html__('Settings', 'direx-plugin')
        );

        // Insert settings link at the beginning of the array
        array_push($links, $settings_link);

        return $links;
    }
}