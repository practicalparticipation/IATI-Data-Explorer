<?php 
  $options = array("Country/AF" => "Afghanistan (ISO Country)",
"Country/AL" => "Albania (ISO Country)",
"Country/AO" => "Angola (ISO Country)",
"Country/SH" => "Ascension Island (ISO Country)",
"Country/BD" => "Bangladesh (ISO Country)",
"Country/BJ" => "Benin, Peoples Republic (ISO Country)",
"Country/BT" => "Bhutan (ISO Country)",
"Country/BO" => "Bolivia (ISO Country)",
"Country/BA" => "Bosnia (ISO Country)",
"Country/BR" => "Brazil (ISO Country)",
"Country/BF" => "Burkina Faso (ISO Country)",
"Country/MM" => "Burma (ISO Country)",
"Country/BI" => "Burundi (ISO Country)",
"Country/KH" => "Cambodia (ISO Country)",
"Country/CM" => "Cameroon (ISO Country)",
"Country/CV" => "Cape Verde (ISO Country)",
"Country/CF" => "Central African Republic (ISO Country)",
"Country/TD" => "Chad (ISO Country)",
"Country/CL" => "Chile (ISO Country)",
"Country/CN" => "China (ISO Country)",
"Country/CD" => "Congo, Dem Rep (ISO Country)",
"Country/CG" => "Congo, Peoples Republic of (ISO Country)",
"Country/DK" => "Denmark (ISO Country)",
"Country/TL" => "East Timor (ISO Country)",
"Country/EC" => "Ecuador (ISO Country)",
"Country/ER" => "Eritrea (ISO Country)",
"Country/ET" => "Ethiopia (ISO Country)",
"Country/FJ" => "Fiji (ISO Country)",
"Country/GM" => "Gambia, The (ISO Country)",
"Country/GE" => "Georgia (ISO Country)",
"Country/GH" => "Ghana (ISO Country)",
"Country/GI" => "Gibraltar (ISO Country)",
"Country/GT" => "Guatemala (ISO Country)",
"Country/GN" => "Guinea (ISO Country)",
"Country/GY" => "Guyana (ISO Country)",
"Country/HT" => "Haiti (ISO Country)",
"Country/HN" => "Honduras (ISO Country)",
"Country/IN" => "India (ISO Country)",
"Country/ID" => "Indonesia (ISO Country)",
"Country/IQ" => "Iraq (ISO Country)",
"Country/JM" => "Jamaica (ISO Country)",
"Country/JO" => "Jordan (ISO Country)",
"NonIATI/KO" => "Kosovo (Non-ISO Country)",
"Country/KE" => "Kenya (ISO Country)",
"Country/KG" => "Kyrgyz Republic (ISO Country)",
"Country/LA" => "Laos (ISO Country)",
"Country/LS" => "Lesotho (ISO Country)",
"Country/LR" => "Liberia (ISO Country)",
"Country/MG" => "Madagascar (ISO Country)",
"Country/MW" => "Malawi (ISO Country)",
"Country/MV" => "Maldives (ISO Country)",
"Country/MD" => "Moldova, Republic of (ISO Country)",
"Country/MN" => "Mongolia (ISO Country)",
"Country/MS" => "Montserrat (ISO Country)",
"Country/MZ" => "Mozambique (ISO Country)",
"Country/NA" => "Namibia (ISO Country)",
"Country/NP" => "Nepal (ISO Country)",
"Country/NI" => "Nicaragua (ISO Country)",
"Country/NE" => "Niger (ISO Country)",
"Country/NG" => "Nigeria (ISO Country)",
"Country/PK" => "Pakistan (ISO Country)",
"Country/PG" => "Papua New Guinea (ISO Country)",
"Country/PE" => "Peru (ISO Country)",
"Country/PH" => "Philippines (ISO Country)",
"Country/PN" => "Pitcairn Islands (ISO Country)",
"Country/RU" => "Russian Federation (ISO Country)",
"Country/RW" => "Rwanda (ISO Country)",
"Country/AS" => "Samoa (American) (ISO Country)",
"Country/SN" => "Senegal (ISO Country)",
"Country/RS" => "Serbia (ISO Country)",
"Country/SL" => "Sierra Leone (ISO Country)",
"Country/SO" => "Somali Democratic Rep (ISO Country)",
"Country/ZA" => "South Africa, Republic of (ISO Country)",
"Country/LK" => "Sri Lanka (ISO Country)",
"Country/SH" => "St Helena (ISO Country)",
"Country/LC" => "St. Lucia (ISO Country)",
"Country/SD" => "Sudan (ISO Country)",
"Country/TJ" => "Tajikstan, Republic of (ISO Country)",
"Country/TZ" => "Tanzania (ISO Country)",
"Country/TH" => "Thailand (ISO Country)",
"Country/SH" => "Tristan da Cunha (ISO Country)",
"Country/TR" => "Turkey (ISO Country)",
"Country/TC" => "Turks and Caicos Islands (ISO Country)",
"Country/UG" => "Uganda (ISO Country)",
"Country/UA" => "Ukraine (ISO Country)",
"Country/GB" => "United Kingdom (ISO Country)",
"Country/VU" => "Vanuatu (ISO Country)",
"Country/VN" => "Vietnam (ISO Country)",
"Country/PS" => "West Bank and Gaza (ISO Country)",
"Country/WS" => "Western Samoa (ISO Country)",
"Country/YE" => "Yemen (ISO Country)",
"Country/ZM" => "Zambia (ISO Country)",
"Country/ZW" => "Zimbabwe (ISO Country)",
"Region/298" => "Africa Regional (DAC Region)",
"Region/798" => "Asia Regional (DAC Region)",
"Region/380" => "Caribbean (DAC Region)",
"Region/89" => "Europe Regional (DAC Region)",
"Region/589" => "Middle East (DAC Region)",
"Region/189" => "North Africa Regional (DAC Region)",
"Region/289" => "Southern Africa (DAC Region)",
"NonIATI/BL" => "Balkan Regional (Non-DAC Region)",
"NonIATI/CP" => "Central Africa Regional (Non-DAC Region)",
"NonIATI/CB" => "Central America (Non-DAC Region)",
"NonIATI/EA" => "East Africa (Non-DAC Region)",
"NonIATI/ED" => "East Europe Regional (Non-DAC Region)",
"NonIATI/EF" => "EECAD Regional (Non-DAC Region)",
"NonIATI/SU" => "Former Soviet Union Reg (Non-DAC Region)",
"NonIATI/FA" => "Francophone Africa (Non-DAC Region)",
"NonIATI/IB" => "Indian Ocean Asia Regional (Non-DAC Region)",
"NonIATI/LE" => "Latin America Regional (Non-DAC Region)",
"NonIATI/OT" => "Overseas Territories (Non-DAC Region)",
"NonIATI/SQ" => "South East Asia (Non-DAC Region)",
"NonIATI/AC" => "Administrative/Capital (Non-Geographic)",
"NonIATI/EB" => "East African Community (Non-Geographic)",
"NonIATI/ZZ" => "Multilateral Organisation (Non-Geographic)",
"NonIATI/NS" => "Non Specific Country (Non-Geographic)",
"NonIATI/SS" => "Sthrn Af Dev Coord Ctte (Non-Geographic)");

foreach($options as $key => $value) {
	echo "<option value='$key'".($_GET['q']==$key ? " SELECTED" : "").">$value</option>";
}

