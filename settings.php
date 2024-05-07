<?php

// Every file should have GPL and copyright in the header - we skip it in tutorials but you should not skip it for real.

// This line protects the file from being accessed by a URL directly.
defined('MOODLE_INTERNAL') || die();

// This is used for performance, we don't need to know about these settings on every page in Moodle, only when
// we are looking at the admin settings pages.
if ($ADMIN->fulltree) {

    // Boost provides a nice setting page which splits settings onto separate tabs. We want to use it here.
    $settings = new theme_boost_admin_settingspage_tabs('themesettingraven', get_string('configtitle', 'theme_raven'));

    // Each page is a tab - the first is the "General" tab.
    $page = new admin_settingpage('theme_raven_general', get_string('generalsettings', 'theme_raven'));

    // Replicate the preset setting from boost.
    $name = 'theme_raven/preset';
    $title = get_string('preset', 'theme_raven');
    $description = get_string('preset_desc', 'theme_raven');
    $default = 'default.scss';

    // We list files in our own file area to add to the drop down. We will provide our own function to
    // load all the presets from the correct paths.
    $context = context_system::instance();
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'theme_raven', 'preset', 0, 'itemid, filepath, filename', false);

    $choices = [];
    foreach ($files as $file) {
        $choices[$file->get_filename()] = $file->get_filename();
    }
    // These are the built in presets from Boost.
    $choices['default.scss'] = 'default.scss';
    $choices['plain.scss'] = 'plain.scss';

    $setting = new admin_setting_configselect($name, $title, $description, $default, $choices);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Preset files setting.
    $name = 'theme_raven/presetfiles';
    $title = get_string('presetfiles','theme_raven');
    $description = get_string('presetfiles_desc', 'theme_raven');

    $setting = new admin_setting_configstoredfile($name, $title, $description, 'preset', 0,
        array('maxfiles' => 20, 'accepted_types' => array('.scss')));
    $page->add($setting);

    // Variable $brand-color.
    // We use an empty default value because the default colour should come from the preset.
    $name = 'theme_raven/brandcolor';
    $title = get_string('brandcolor', 'theme_raven');
    $description = get_string('brandcolor_desc', 'theme_raven');
    $setting = new admin_setting_configcolourpicker($name, $title, $description, '');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Must add the page after definiting all the settings!
    $settings->add($page);

    // Advanced settings.
    $page = new admin_settingpage('theme_raven_advanced', get_string('advancedsettings', 'theme_raven'));

    // Raw SCSS to include before the content.
    $setting = new admin_setting_configtextarea('theme_raven/scsspre',
        get_string('rawscsspre', 'theme_raven'), get_string('rawscsspre_desc', 'theme_raven'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Raw SCSS to include after the content.
    $setting = new admin_setting_configtextarea('theme_raven/scss', get_string('rawscss', 'theme_raven'),
        get_string('rawscss_desc', 'theme_raven'), '', PARAM_RAW);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    // Login page background setting.
    $name = 'theme_raven/loginbackgroundimage';
    $title = get_string('loginbackgroundimage', 'theme_raven');
    $description = get_string('loginbackgroundimage_desc', 'theme_raven');
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'loginbackgroundimage');
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);

    // Banner settings.
    $page = new admin_settingpage('theme_raven_banner', get_string('banner', 'theme_raven'));

    // Show banner
    $name = 'theme_raven/banner_status';
    $title = get_string('banner_status', 'theme_raven');
    $description = get_string('banner_status_desc', 'theme_raven');
    $default = 0;
    $setting = new admin_setting_configcheckbox($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);
    $banner = get_config('theme_raven', 'banner_status');

    $name = 'theme_raven/banner_img';
    $title = get_string('banner_img', 'theme_raven');
    $description = get_string('banner_img_desc', 'theme_raven');
    $opts = array('accepted_types' => array('.png', '.jpg', '.gif', '.webp', '.svg'), 'maxfiles' => 1);
    $setting = new admin_setting_configstoredfile($name, $title, $description, 'banner_img', 0, $opts);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_raven/banner_header';
    $title = get_string('banner_header', 'theme_raven');
    $description = get_string('banner_header_desc', 'theme_raven');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $name = 'theme_raven/banner_text';
    $title = get_string('banner_text', 'theme_raven');
    $description = get_string('banner_text_desc', 'theme_raven');
    $default = '';
    $setting = new admin_setting_confightmleditor($name, $title, $description, $default);
    $setting->set_updatedcallback('theme_reset_all_caches');
    $page->add($setting);

    $settings->add($page);
}