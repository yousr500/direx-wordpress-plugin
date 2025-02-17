<div class="wrap">
<h1>Direx Plugin</h1>
<?php settings_errors(); ?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1">Manager Settings</a></li>
    <li><a href="#tab-2">Overview</a></li>
    <li><a href="#tab-3">About</a></li>
</ul>

<div class="tab-content">
    <div id="tab-1" class="tab-pane active">
    <form method="post" action="options.php">    
            <?php
                settings_fields( 'direx_plugin_settings' );
                do_settings_sections( 'direx_plugin' );
             
            ?>
        </form>
        <div class="dashboard-buttons">
                <a href="<?php echo admin_url('admin.php?page=direx_auth'); ?>" class="button button-primary">Go to Login</a>
                <a href="<?php echo admin_url('admin.php?page=direx_ord'); ?>" class="button button-primary">Go to Orders</a>
            </div>
            <div class="plugin-info">
                <h2>Welcome to Direx Plugin</h2>
                <p>This plugin helps you manage your orders and authentication seamlessly.</p>
                <p>Use the tabs above to navigate through the settings and features of the plugin.</p>
            </div>
            </div>
        <div id="tab-2" class="tab-pane">
            <h3>Overview</h3>
            <p>Welcome to the Direx Plugin Dashboard. Use the tabs above to navigate through the settings and features of the plugin.</p>
        </div>

        <div id="tab-3" class="tab-pane">
            <h3>About</h3>
            <p>The Direx Plugin is designed to provide essential functionalities for managing your WordPress site. For more information, visit our <a href="http://direx.com">website</a>.</p>
        </div>
        </div>

</div>