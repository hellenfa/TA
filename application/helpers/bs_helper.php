<?php
if (!function_exists('bs_input')) {
    function bs_input($label, $required = "required", $value = null, $type = 'text', $id = null, $name = null)
    {
        if ($name == null) {
            $name = strtolower(str_replace(" ", "_", $label));
        }
        if ($id != null) {
            $id = 'id="' . $id . '"';
        } else {
            $id = '';
        }

        return '<div class="form-group"><label class="control-label">' . $label . '</label><input ' . $required . ' type ="' . $type . '" ' . $id . ' class="form-control" placeholder="' . $label . '" name="' . $name . '" value="' . $value . '"></div>';
    }
}

if (!function_exists('button')) {
    function button($uri, $text, $arr = array('default', 'print'))
    {
        return "<a class='btn btn-xs btn-" . $arr[0] . "' href='" . base_url($uri) . "'><span class='fa fa-" . $arr[1] . "'></span>&nbsp; " . $text . "</a>";
    }
}