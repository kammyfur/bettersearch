<?php

$cwd = getcwd();
$found = 0;

function crawl(string $dir) {
   global $found;
   echo("(DIR) " . $dir . "\n");
   $files = scandir($dir);
   foreach ($files as $file) {
      if (is_dir($file)) {
         if ($file == "." || $file == ".." || $file == ".git") {} else {
            crawl($dir . "/" . $file);
         }
      } else {
         if (is_link($file)) {} else {
            echo("(DOC) " . $dir . "/" . $file . "\n");
            $found = $found + count(file($dir . "/" . $file));
         }
      }
   }
   return $found;
}

if (PHP_SAPI === 'cli')
{
   echo("Couting lines...");
   crawl($cwd);
   echo("\nDONE!\n\nTotal code is " . $found . " lines long.");
}
