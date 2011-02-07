<?php

//Simple caching function
function c_file_get_contents($url,$age = 3600,$prefix = "") { 
   
   $cache = md5($url);
   $filename = $prefix."cache/urls/$cache.cache";

  if (file_exists($filename)) {
    $mtime = filemtime($filename);
    $fileage = time() - mtime;
    if ($fileage>$age) {
      $file = file_get_contents($filename);
    } else {
      $file = cleanXML(file_get_contents($url));
      file_put_contents($filename,$file);
    }
  } else {
      $file = cleanXML(file_get_contents($url));
      file_put_contents($filename,$file);
  }
 
  return $file;
}

//Handle non UTF-8 encoding in the XML http://www.w3.org/TR/1999/WD-xml-c14n-19991109.html
function cleanXML($file) {
   $replace = array("&#xD;","&#x9;","&#xA;");
   return str_replace($replace," ",$file);
}
