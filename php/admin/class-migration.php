<?php
/**
 * Enable and validate Pro version licensing.
 *
 * @package   Block_Lab
 * @copyright Copyright(c) 2020, Block Lab
 * @license   http://opensource.org/licenses/GPL-2.0 GNU General Public License, version 2 (GPL-2.0)
 */

namespace Block_Lab\Admin;

use Block_Lab\Component_Abstract;

/**
 * Class Migration
 */
class Migration extends Component_Abstract {

	/**
	 * Adds an action for the notice.
	 */
	public function register_hooks() {
		add_action( 'admin_notices', [ $this, 'migration_notice' ] );
	}

	/**
	 * Outputs the migration notice if this is on the right page and the user has the right permission.
	 *
	 * This should display on Block Lab > Content Blocks,
	 * /wp-admin/plugins.php, the Dashboard, and Block Lab > Settings.
	 */
	public function migration_notice() {
		if ( ! current_user_can( 'install_plugins' ) ) {
			return;
		}

		$screen         = get_current_screen();
		$should_display = (
			( isset( $screen->base, $screen->post_type ) && 'edit' === $screen->base && 'block_lab' === $screen->post_type )
			||
			( isset( $screen->base ) && in_array( $screen->base, [ 'plugins', 'dashboard', 'block_lab_page_block-lab-settings' ], true ) )
		);

		if ( $should_display ) {
			?>
			<div class="notice updated is-dismissible">
				<p>
					<?php
					printf(
						/* translators: %1$s: the plugin name */
						esc_html__( 'The Block Lab team have moved. For future updates and improvements, migrate now to the new home of custom blocks: %1$s', 'block-lab' ),
						'<strong>Genesis Custom Blocks.</strong>'
					);
					?>
				</p>
				<p>
					<?php
					printf(
						'<a target="_blank" href="https://getblocklab.com/docs/genesis-custom-blocks">%1$s</a>',
						esc_html__( 'Learn more', 'block-lab' )
					);
					?>
				</p>
			</div>
			<?php
		}
	}
}