$dept_color_array = array(
        "Department of Public Information" => "#FFCC33",
        "Department for General Assembly and Conference Management" => "#BD5400",
        "Department of Management" => "#70C175",
        "Department of Safety and Security" => "#FF9017",
        "Secretariat: Executive Office of the Secretary-General" => "#999DE8",
        "Office of Internal Oversight Services" => "#A0AB15",
        "Office of Legal Affairs" => "#FFFF73",
        "Office for Disarmament Affairs" => "#968375",
        "Economic Commission for Europe" => "#D1683E",
        "ESCAP" => "#AA5587",
        "UNOG" => "#AF8A2E",
);

$dept_color_band = "#000000";
if (array_key_exists($ultimate_parent_name, $dept_color_array)) {
        $dept_color_band = $dept_color_array[$ultimate_parent_name];
}
