<div class="wrap">
<h1>Welcome to Direx Plugin</h1>
<?php settings_errors(); ?>

<ul class="nav nav-tabs">
    <li class="active"><a href="#tab-1">Settings Manager</a></li>
    <li><a href="#tab-2">Overview</a></li>
</ul>

<div class="tab-content">
    <div id="tab-1" class="tab-pane active">
    <form method="post" action="options.php">    
            <?php
                settings_fields( 'direx_plugin_settings' );
                do_settings_sections( 'direx_plugin' );
             
            ?>
        </form>
        <div class="direx-cards-grid">
            <!-- Quick Actions Card -->
            <div class="direx-card">
                <div class="card-header">
                    <div class="header-icon settings-icon">
                    <svg width="24" height="24" fill="#2271b1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M4 5h16v2H4V5zm0 5h16v2H4v-2zm0 5h16v2H4v-2z"></path>
    </svg>
</div>
                    <h3>Quick Actions</h3>
                </div>
                <div class="card-content">
                    <div class="quick-actions-grid">
                        <a href="<?php echo admin_url('admin.php?page=direx_auth'); ?>" class="action-button">
                            <span>Go to Login</span>
                            <p>Manage authentication settings</p>
                        </a>
                        <a href="<?php echo admin_url('admin.php?page=direx_ord'); ?>" class="action-button">
                            <span>Go to Orders</span>
                            <p>View and manage deliveries</p>
                        </a>
                    </div>
                </div>
            </div>
            </div>
            <div class="plugin-info">
                <p>This plugin helps you manage your orders and authentication seamlessly.</p>
                <p>Use the tabs above to navigate through the settings and features of the plugin.</p>
            </div>
            </div>
        <div id="tab-2" class="tab-pane">
                <div class="direx-cards-grid">
                <div class="direx-card">
                <div class="card-header">
                    <div class="header-icon guide-icon"> <svg width="24" height="24" fill="#2271b1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
        <path d="M3 3h8v8H3V3zm10 0h8v8h-8V3zM3 13h8v8H3v-8zm10 0h8v8h-8v-8z"/>
    </svg>
</div>
                    

                    <h3>Getting Started</h3>
                </div>
                <div class="card-content">
                    <ul class="getting-started-list">
                        <li>
                            <div class="step-number">1</div>
                            <span>Configure your API credentials</span>
                        </li>
                        <li>
                            <div class="step-number">2</div>
                            <span>Set up delivery zones</span>
                        </li>
                        <li>
                            <div class="step-number">3</div>
                            <span>Start managing orders</span>
                        </li>
                    </ul>
                </div>
            </div>
            </div>
            <div class="plugin-info">
            <p>The Direx Plugin is designed to provide essential functionalities for the user, 
                with the buttons in the Manager Settings section of the Dashboard page you can access 
                the Login page to put in you're credentials in return be provided with a token and the Order page to check all the active orders.</p>
                <div class="plugin-info">
        </div>
   
        </div>

        
        </div>

</div>