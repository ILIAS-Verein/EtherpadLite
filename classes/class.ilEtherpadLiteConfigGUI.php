<?php

/**
 * EtherpadLite configuration user interface class
 *
 * @author  Fabian Wolf <wolf@ilias.de>
 * @author	Jan Rocho <jan.rocho@fh-dortmund.de>
 * @version $Id$
 *
 *  @ilCtrl_IsCalledBy ilEtherpadLiteConfigGUI: ilObjComponentSettingsGUI
 *
 */
class ilEtherpadLiteConfigGUI extends ilPluginConfigGUI
{
    private \ILIAS\UI\Factory $ui_factory;
    private ilLanguage $lng;
    private ilEtherpadLiteConfig $config;
    private \ILIAS\UI\Renderer $renderer;
    private ilHelpGUI $help;
    private ilCtrlInterface $ctrl;
    private \Psr\Http\Message\ServerRequestInterface $request;
    private ilGlobalTemplateInterface $tpl;

    public function __construct()
    {
        global $DIC;

        $this->ui_factory = $DIC->ui()->factory();
        $this->renderer = $DIC->ui()->renderer();
        $this->tpl = $DIC->ui()->mainTemplate();
        $this->lng = $DIC->language();
        $this->config = new ilEtherpadLiteConfig();
        $this->help = $DIC->help();
        $this->request = $DIC->http()->request();
        $this->ctrl = $DIC->ctrl();
    }

    public function performCommand(string $cmd): void
    {
        $this->help->setScreenIdComponent($this->getPluginObject()->getId());
        $this->help->setScreenId("adm");

        switch ($cmd) {
            case "configure":
            case "save":
                $this->$cmd();
                break;
        }
    }

    public function configure()
    {
        $form = $this->buildForm();
        $this->tpl->setContent($this->renderer->render($form));
    }

    public function save()
    {
        $form = $this->buildForm()->withRequest($this->request);
        $config = $this->config;

        if ($data = $form->getData()) {
            $connection = $data["main"]["connection"];
            $pad = $data["main"]["pad"];

            $config->setHost($connection["host"]);
            $config->setDomain($connection["domain"]);
            $config->setPort($connection["port"]);
            $config->setApikey($connection["apikey"]);
            $config->setHttps($connection["https"] !== null);

            if ($connection["https"] !== null) {
                $config->setValidateCurl($connection["https"]["validate_curl"]);
            }

            $config->setEpadlVersion($connection["epadl_version"]);
            $config->setPath($connection["path"] ?? "");

            $config->setDefaulttext($pad["defaulttext"]);
            $config->setAllowReadOnly($pad["allow_read_only"] !== null);

            if ($pad["allow_read_only"] !== null) {
                $config->setReadonlyDisableExport($pad["allow_read_only"]["readonly_disable_export"]);
            }

            $config->setDefaultShowChat($pad["default_show_chat"]);
            $config->setConfShowChat($pad["conf_show_chat"]);
            $config->setDefaultLineNumbers($pad["default_line_numbers"]);
            $config->setConfLineNumbers($pad["conf_line_numbers"]);
            $config->setDefaultMonospaceFont($pad["default_monospace_font"]);
            $config->setConfMonospaceFont($pad["conf_monospace_font"]);
            $config->setDefaultShowColors($pad["default_show_colors"]);
            $config->setConfShowColors($pad["conf_show_colors"]);

            $config->setDefaultShowControls($pad["default_show_controls"] !== null);

            if ($pad["default_show_controls"] !== null) {
                $default = $pad["default_show_controls"];
                $config->setDefaultShowStyle($default["default_show_style"]);
                $config->setDefaultShowList($default["default_show_list"]);
                $config->setDefaultShowRedo($default["default_show_redo"]);
                $config->setDefaultShowColoring($default["default_show_coloring"]);
                $config->setDefaultShowHeading($default["default_show_heading"]);
                $config->setDefaultShowImpExp($default["default_show_imp_exp"]);
                $config->setDefaultShowTimeline($default["default_show_timeline"]);
            }

            $config->setConfShowControls($pad["conf_show_controls"] !== null);

            if ($pad["conf_show_controls"] !== null) {
                $conf = $pad["conf_show_controls"];
                $config->setConfShowStyle($conf["conf_show_style"]);
                $config->setConfShowList($conf["conf_show_list"]);
                $config->setConfShowRedo($conf["conf_show_redo"]);
                $config->setConfShowColoring($conf["conf_show_coloring"]);
                $config->setConfShowHeading($conf["conf_show_heading"]);
                $config->setConfShowImportExport($conf["conf_show_import_export"]);
                $config->setConfShowTimeline($conf["conf_show_timeline"]);
            }
            $this->tpl->setOnScreenMessage("success", $this->lng->txt("saved_successfully"), true);
            $this->ctrl->redirect($this, "configure");
        } else {
            $this->tpl->setContent($this->renderer->render($form));
        }
    }

    public function buildForm() : \ILIAS\UI\Component\Input\Container\Form\Form
    {
        $field = $this->ui_factory->input()->field();
        $plugin = $this->plugin_object;
        $config = $this->config;

        $values = [
            "connection" => [
                "host" => $config->getHost(),
                "port" => $config->getPort(),
                "domain" => $config->getDomain(),
                "apikey" => $config->getApikey(),
                "https" => $config->getHttps() ? ["validate_curl" => $config->getValidateCurl()] : null,
                "epadl_version" => $config->getEpadlVersion(),
                "path" => $config->getPath(),
            ],
            "pad" => [
                "defaulttext" => $config->getDefaulttext(),
                "allow_read_only" => $config->getAllowReadOnly() ? [
                    "readonly_disable_export" => $config->getReadonlyDisableExport()
                ] : null,
                "default_show_chat" => $config->getDefaultShowChat(),
                "conf_show_chat" => $config->getConfShowChat(),
                "default_line_numbers" => $config->getDefaultLineNumbers(),
                "conf_line_numbers" => $config->getConfLineNumbers(),
                "default_monospace_font" => $config->getDefaultMonospaceFont(),
                "conf_monospace_font" => $config->getConfMonospaceFont(),
                "default_show_colors" => $config->getDefaultShowColors(),
                "conf_show_colors" => $config->getConfShowColors(),
                "default_show_controls" => $config->getDefaultShowControls() ? [
                    "default_show_style" => $config->getDefaultShowStyle(),
                    "default_show_list" => $config->getDefaultShowList(),
                    "default_show_redo" => $config->getDefaultShowRedo(),
                    "default_show_coloring" => $config->getDefaultShowColoring(),
                    "default_show_heading" => $config->getDefaultShowHeading(),
                    "default_show_imp_exp" => $config->getDefaultShowImpExp(),
                    "default_show_timeline" => $config->getDefaultShowTimeline()
                    ] : null,
                "conf_show_controls" => $config->getConfShowControls() ? [
                    "conf_show_style" =>$config->getConfShowStyle(),
                    "conf_show_list" => $config->getConfShowList(),
                    "conf_show_redo" => $config->getConfShowRedo(),
                    "conf_show_coloring" => $config->getConfShowColoring(),
                    "conf_show_heading" => $config->getConfShowHeading(),
                    "conf_show_import_export" => $config->getConfShowImportExport(),
                    "conf_show_timeline" => $config->getConfShowTimeline(),
                ] : null,
            ]
        ];

        $connection_section = $field->section([
            "host" => $field->text($plugin->txt("host"), $plugin->txt("info_host"))->withRequired(true),
            "domain" => $field->text($plugin->txt("domain"), $plugin->txt("info_domain"))->withRequired(true),
            "port" => $field->numeric($plugin->txt("port"), $plugin->txt("info_port"))->withRequired(true),
            "apikey" => $field->text($plugin->txt("apikey"), $plugin->txt("info_apikey"))->withRequired(true),
            "https" => $field->optionalGroup([
                "validate_curl" => $field->checkbox($plugin->txt("https_validate_curl"), $plugin->txt("info_validate_curl")),
            ], $plugin->txt("https"), $plugin->txt("info_https")),
            "epadl_version" => $field->select($plugin->txt("epadl_version"), [
                "130" => "<= v1.3.0",
                "140" => ">= v1.4.0"
            ], $plugin->txt("info_epadl_version"))->withRequired(true),
            "path" => $field->text($plugin->txt("path"), $plugin->txt("info_path")),
        ], $plugin->txt("connection_settings"));

        $pad_section =  $field->section([
            "defaulttext" => $field->textarea($plugin->txt("defaulttext"), $plugin->txt("info_defaulttext")),
            "allow_read_only" => $field->optionalGroup([
                "readonly_disable_export" => $field->checkbox($plugin->txt("allow_read_only_readonly_disable_export"), $plugin->txt("info_readonly_disable_export"))
            ], $plugin->txt("allow_read_only"), $plugin->txt("info_allow_read_only")),
            "default_show_chat" => $field->checkbox($plugin->txt("default_show_chat"), $plugin->txt("info_default_show_chat")),
            "conf_show_chat" => $field->checkbox($plugin->txt("conf_show_chat"), $plugin->txt("info_conf_show_chat")),
            "default_line_numbers" => $field->checkbox($plugin->txt("default_line_numbers"), $plugin->txt("info_default_line_numbers")),
            "conf_line_numbers" => $field->checkbox($plugin->txt("conf_line_numbers"), $plugin->txt("info_conf_line_numbers")),
            "default_monospace_font" => $field->checkbox($plugin->txt("default_monospace_font"), $plugin->txt("info_default_monospace_font")),
            "conf_monospace_font" => $field->checkbox($plugin->txt("conf_monospace_font"), $plugin->txt("info_conf_monospace_font")),
            "default_show_colors" => $field->checkbox($plugin->txt("default_show_colors"), $plugin->txt("info_default_show_colors")),
            "conf_show_colors" => $field->checkbox($plugin->txt("conf_show_colors"), $plugin->txt("info_conf_show_colors")),
            "default_show_controls" => $field->optionalGroup([
                "default_show_style" => $field->checkbox($plugin->txt("default_show_controls_default_show_style"), $plugin->txt("info_default_show_style")),
                "default_show_list" => $field->checkbox($plugin->txt("default_show_controls_default_show_list"), $plugin->txt("info_default_show_list")),
                "default_show_redo" => $field->checkbox($plugin->txt("default_show_controls_default_show_redo"), $plugin->txt("info_default_show_redo")),
                "default_show_coloring" => $field->checkbox($plugin->txt("default_show_controls_default_show_coloring"), $plugin->txt("info_default_show_coloring")),
                "default_show_heading" => $field->checkbox($plugin->txt("default_show_controls_default_show_heading"), $plugin->txt("info_default_show_heading")),
                "default_show_imp_exp" => $field->checkbox($plugin->txt("default_show_controls_default_show_imp_exp"), $plugin->txt("info_default_show_imp_exp")),
                "default_show_timeline" => $field->checkbox($plugin->txt("default_show_controls_default_show_timeline"), $plugin->txt("info_default_show_timeline")),
            ], $plugin->txt("default_show_controls"), $plugin->txt("info_default_show_controls")),
            "conf_show_controls" => $field->optionalGroup([
                "conf_show_style" => $field->checkbox($plugin->txt("conf_show_controls_conf_show_style"), $plugin->txt("info_conf_show_style")),
                "conf_show_list" => $field->checkbox($plugin->txt("conf_show_controls_conf_show_list"), $plugin->txt("info_conf_show_list")),
                "conf_show_redo" => $field->checkbox($plugin->txt("conf_show_controls_conf_show_redo"), $plugin->txt("info_conf_show_redo")),
                "conf_show_coloring" => $field->checkbox($plugin->txt("conf_show_controls_conf_show_coloring"), $plugin->txt("info_conf_show_coloring")),
                "conf_show_heading" => $field->checkbox($plugin->txt("conf_show_controls_conf_show_heading"), $plugin->txt("info_conf_show_heading")),
                "conf_show_import_export" => $field->checkbox($plugin->txt("conf_show_controls_conf_show_import_export"), $plugin->txt("info_conf_show_import_export")),
                "conf_show_timeline" => $field->checkbox($plugin->txt("conf_show_controls_conf_show_timeline"), $plugin->txt("info_conf_show_timeline")),
            ], $plugin->txt("conf_show_controls"), $plugin->txt("info_conf_show_controls")),
        ], $plugin->txt("pad_settings"));


        $main_section = $field->section([
            "connection" => $connection_section,
            "pad" => $pad_section,
        ], $plugin->txt("configuration"))
                              ->withValue($values);

        return $this->ui_factory->input()->container()->form()->standard(
            $this->ctrl->getFormAction($this, "save"),
            ["main" => $main_section]
        );
    }
}
