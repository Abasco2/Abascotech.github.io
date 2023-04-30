<?php
/**
 * Interface for patch.
 *
 * @package basel
 */

use XTS\Modules\Patcher\Client;

?>
<div class="basel-row basel-one-column">
	<div class="basel-column basel-stretch-column">
		<div class="basel-column-inner">
			<div class="basel-box xtemos-dashboard">
				<div class="basel-box-header">
					<h2>
						<?php esc_html_e( 'Patcher', 'basel' ); ?>
					</h2>
					<span class="basel-box-label basel-label-warning">Optional</span>
				</div>
				<div class="basel-box-content">
					<div class="xtemos-loader-wrapper">
						<div class="xtemos-loader">
							<div class="xtemos-loader-el"></div>
							<div class="xtemos-loader-el"></div>
						</div>
						<p>
							<?php esc_html_e( 'It may take a few minutes...', 'basel' ); ?>
						</p>
					</div>
					<?php Client::get_instance()->interface(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
