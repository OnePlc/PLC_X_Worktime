﻿$sModuleName = "Article"
$sModuleKey = "article"
$sTargetDir = "C:\Users\Praesidiarius\PhpstormProjects\OS\PLC_X_Article_NoGIT"

# Copy Worktime
Copy-Item -Path "..\*" -Destination "$sTargetDir" -recurse -Force