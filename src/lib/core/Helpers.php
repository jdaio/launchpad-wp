<?php
/**
 * Class - Helpers
 *
 * Defines helper methods used by the theme.
 *
 * @package launchpad
 * @since 1.0.0
 */

namespace LAUNCHPAD;

class Helpers {
    /**
     * Method to check if Timber is installed and activated.
     *
     * @return boolean
     */
    public static function isTimberActivated()
    {
        return class_exists('Timber\\Timber');
    }

    /**
     * Method to handle returned messages for Timber errors.
     *
     * @return string
     */
    private static function timberErrorMessage()
    {
        ?>
            <div class="error notice">
                <p>
                    <a href="https://www.upstatement.com/timber/" title="<?php esc_attr_e('Timber by Upstatement', 'launchpad'); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e('Timber', 'launchpad'); ?></a><?php esc_html_e('is not activated. Please make sure it\'s activated and installed before using this theme.', 'launchpad'); ?>
                </p>
            </div>
        <?php
    }

    /**
     * Method to return error messages if Timber isn't installed/activated.
     *
     * @return void
     */
    public function addTimberErrorNotice()
    {
        if (is_admin()) {
            add_action('admin_notice', $this->timberErrorMessage());
        } else {
            wp_die($this->addTimberErrorMessage(), __('An error occurred.', 'launchpad'));
        }
    }
}
