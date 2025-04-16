<?php

/**
 * EtherpadLite configuration user interface class
 *
 * @author  Fabian Wolf <wolf@ilias.de>
 * @author	Jan Rocho <jan.rocho@fh-dortmund.de>
 * @version $Id$
 *
 */
class ilEtherpadLiteConfig
{
    private ilDBInterface $db;

    public function __construct()
    {
        global $DIC;
        $this->db = $DIC->database();
    }

    public function setValue(string $key, mixed $value)
    {
        $this->db->replace("rep_robj_xpdl_adm_set", ["epkey" => ["text",$key]],["epvalue" => ["text",$value]]);
    }

    public function getValue(string $key) : ?string
    {

        $result = $this->db->query("SELECT epvalue FROM rep_robj_xpdl_adm_set WHERE epkey = " . $this->db->quote($key, "text"));
        if ($result->numRows() == 0) {
            return null;
        }
        $record = $this->db->fetchAssoc($result);

        return (string)$record['epvalue'];
    }

    public function getHost(): string
    {
        return (string)($this->getValue("host") ?? "");
    }

    public function setHost(string $host): void
    {
        $this->setValue("host", $host);
    }

    public function getPort(): ?int
    {
        $value = $this->getValue("port");
        return $value !== null ? (int)$value : null;
    }

    public function setPort(int $port): void
    {
        $this->setValue("port", $port);
    }

    public function getApikey(): string
    {
        return (string)($this->getValue("apikey") ?? "");
    }

    public function setApikey(string $apikey): void
    {
        $this->setValue("apikey", $apikey);
    }

    public function getDomain(): string
    {
        return (string)($this->getValue("domain") ?? "");
    }

    public function setDomain(string $domain): void
    {
        $this->setValue("domain", $domain);
    }

    public function getHttps(): bool
    {
        return (bool)($this->getValue("https") ?? false);
    }

    public function setHttps(bool $https): void
    {
        $this->setValue("https", $https);
    }

    public function getValidateCurl(): bool
    {
        return (bool)($this->getValue("https_validate_curl") ?? false);
    }

    public function setValidateCurl(bool $validate_curl): void
    {
        $this->setValue("https_validate_curl", $validate_curl);
    }

    public function getEpadlVersion(): string
    {
        return (string)($this->getValue("epadl_version") ?? "");
    }

    public function setEpadlVersion(string $epadl_version): void
    {
        $this->setValue("epadl_version", $epadl_version);
    }

    public function getPath(): string
    {
        return (string)($this->getValue("path") ?? "");
    }

    public function setPath(string $path): void
    {
        $this->setValue("path", $path);
    }

    public function getDefaulttext(): string
    {
        return (string)($this->getValue("defaulttext") ?? "");
    }

    public function setDefaulttext(string $defaulttext): void
    {
        $this->setValue("defaulttext", $defaulttext);
    }

    public function getOldGroup(): string
    {
        return (string)($this->getValue("old_group") ?? "");
    }

    public function setOldGroup(string $old_group): void
    {
        $this->setValue("old_group", $old_group);
    }

    public function getDefaultShowChat(): bool
    {
        return (bool)($this->getValue("default_show_chat") ?? false);
    }

    public function setDefaultShowChat(bool $default_show_chat): void
    {
        $this->setValue("default_show_chat", $default_show_chat);
    }

    public function getConfShowChat(): bool
    {
        return (bool)($this->getValue("conf_show_chat") ?? false);
    }

    public function setConfShowChat(bool $conf_show_chat): void
    {
        $this->setValue("conf_show_chat", $conf_show_chat);
    }

    public function getDefaultLineNumbers(): bool
    {
        return (bool)($this->getValue("default_line_numbers") ?? false);
    }

    public function setDefaultLineNumbers(bool $default_line_numbers): void
    {
        $this->setValue("default_line_numbers", $default_line_numbers);
    }

    public function getConfLineNumbers(): bool
    {
        return (bool)($this->getValue("conf_line_numbers") ?? false);
    }

    public function setConfLineNumbers(bool $conf_line_numbers): void
    {
        $this->setValue("conf_line_numbers", $conf_line_numbers);
    }

    public function getDefaultMonospaceFont(): bool
    {
        return (bool)($this->getValue("default_monospace_font") ?? false);
    }

    public function setDefaultMonospaceFont(bool $default_monospace_font): void
    {
        $this->setValue("default_monospace_font", $default_monospace_font);
    }

    public function getConfMonospaceFont(): bool
    {
        return (bool)($this->getValue("conf_monospace_font") ?? false);
    }

    public function setConfMonospaceFont(bool $conf_monospace_font): void
    {
        $this->setValue("conf_monospace_font", $conf_monospace_font);
    }

    public function getDefaultShowColors(): bool
    {
        return (bool)($this->getValue("default_show_colors") ?? false);
    }

    public function setDefaultShowColors(bool $default_show_colors): void
    {
        $this->setValue("default_show_colors", $default_show_colors);
    }

    public function getConfShowColors(): bool
    {
        return (bool)($this->getValue("conf_show_colors") ?? false);
    }

    public function setConfShowColors(bool $conf_show_colors): void
    {
        $this->setValue("conf_show_colors", $conf_show_colors);
    }

    public function getAllowReadOnly(): bool
    {
        return (bool)($this->getValue("allow_read_only") ?? false);
    }

    public function setAllowReadOnly(bool $allow_read_only): void
    {
        $this->setValue("allow_read_only", $allow_read_only);
    }

    public function getReadonlyDisableExport(): bool
    {
        return (bool)($this->getValue("allow_read_only_readonly_disable_export") ?? false);
    }

    public function setReadonlyDisableExport(bool $readonly_disable_export): void
    {
        $this->setValue("allow_read_only_readonly_disable_export", $readonly_disable_export);
    }

    public function getDefaultShowControls(): bool
    {
        return (bool)($this->getValue("default_show_controls") ?? false);
    }

    public function setDefaultShowControls(bool $default_show_controls): void
    {
        $this->setValue("default_show_controls", $default_show_controls);
    }

    public function getDefaultShowStyle(): bool
    {
        return (bool)($this->getValue("default_show_controls_default_show_style") ?? false);
    }

    public function setDefaultShowStyle(bool $default_show_style): void
    {
        $this->setValue("default_show_controls_default_show_style", $default_show_style);
    }

    public function getDefaultShowList(): bool
    {
        return (bool)($this->getValue("default_show_controls_default_show_list") ?? false);
    }

    public function setDefaultShowList(bool $default_show_list): void
    {
        $this->setValue("default_show_controls_default_show_list", $default_show_list);
    }

    public function getDefaultShowRedo(): bool
    {
        return (bool)($this->getValue("default_show_controls_default_show_redo") ?? false);
    }

    public function setDefaultShowRedo(bool $default_show_redo): void
    {
        $this->setValue("default_show_controls_default_show_redo", $default_show_redo);
    }

    public function getDefaultShowColoring(): bool
    {
        return (bool)($this->getValue("default_show_controls_default_show_coloring") ?? false);
    }

    public function setDefaultShowColoring(bool $default_show_coloring): void
    {
        $this->setValue("default_show_controls_default_show_coloring", $default_show_coloring);
    }

    public function getDefaultShowHeading(): bool
    {
        return (bool)($this->getValue("default_show_controls_default_show_heading") ?? false);
    }

    public function setDefaultShowHeading(bool $default_show_heading): void
    {
        $this->setValue("default_show_controls_default_show_heading", $default_show_heading);
    }

    public function getDefaultShowImpExp(): bool
    {
        return (bool)($this->getValue("default_show_controls_default_show_imp_exp") ?? false);
    }

    public function setDefaultShowImpExp(bool $default_show_imp_exp): void
    {
        $this->setValue("default_show_controls_default_show_imp_exp", $default_show_imp_exp);
    }

    public function getDefaultShowTimeline(): bool
    {
        return (bool)($this->getValue("default_show_controls_default_show_timeline") ?? false);
    }

    public function setDefaultShowTimeline(bool $default_show_timeline): void
    {
        $this->setValue("default_show_controls_default_show_timeline", $default_show_timeline);
    }

    public function getConfShowControls(): bool
    {
        return (bool)($this->getValue("conf_show_controls") ?? false);
    }

    public function setConfShowControls(bool $conf_show_controls): void
    {
        $this->setValue("conf_show_controls", $conf_show_controls);
    }

    public function getConfShowStyle(): bool
    {
        return (bool)($this->getValue("conf_show_controls_conf_show_style") ?? false);
    }

    public function setConfShowStyle(bool $conf_show_style): void
    {
        $this->setValue("conf_show_controls_conf_show_style", $conf_show_style);
    }

    public function getConfShowList(): bool
    {
        return (bool)($this->getValue("conf_show_controls_conf_show_list") ?? false);
    }

    public function setConfShowList(bool $conf_show_list): void
    {
        $this->setValue("conf_show_controls_conf_show_list", $conf_show_list);
    }

    public function getConfShowRedo(): bool
    {
        return (bool)($this->getValue("conf_show_controls_conf_show_redo") ?? false);
    }

    public function setConfShowRedo(bool $conf_show_redo): void
    {
        $this->setValue("conf_show_controls_conf_show_redo", $conf_show_redo);
    }

    public function getConfShowColoring(): bool
    {
        return (bool)($this->getValue("conf_show_controls_conf_show_coloring") ?? false);
    }

    public function setConfShowColoring(bool $conf_show_coloring): void
    {
        $this->setValue("conf_show_controls_conf_show_coloring", $conf_show_coloring);
    }

    public function getConfShowHeading(): bool
    {
        return (bool)($this->getValue("conf_show_controls_conf_show_heading") ?? false);
    }

    public function setConfShowHeading(bool $conf_show_heading): void
    {
        $this->setValue("conf_show_controls_conf_show_heading", $conf_show_heading);
    }

    public function getConfShowImportExport(): bool
    {
        return (bool)($this->getValue("conf_show_controls_conf_show_import_export") ?? false);
    }

    public function setConfShowImportExport(bool $conf_show_import_export): void
    {
        $this->setValue("conf_show_controls_conf_show_import_export", $conf_show_import_export);
    }

    public function getConfShowTimeline(): bool
    {
        return (bool)($this->getValue("conf_show_controls_conf_show_timeline") ?? false);
    }

    public function setConfShowTimeline(bool $conf_show_timeline): void
    {
        $this->setValue("conf_show_controls_conf_show_timeline", $conf_show_timeline);
    }
}
