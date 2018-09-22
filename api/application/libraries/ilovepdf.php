<?php

//Helpers
require_once __DIR__ . '/ilovepdf/JWT.php';
require_once __DIR__ . '/ilovepdf/File.php';
require_once __DIR__ . '/ilovepdf/Method.php';
require_once __DIR__ . '/ilovepdf/Response.php';
require_once __DIR__ . '/ilovepdf/Request.php';
require_once __DIR__ . '/ilovepdf/Request/Body.php';

//Exceptions
require_once __DIR__ . '/ilovepdf/Exceptions/ExtendedException.php';
require_once __DIR__ . '/ilovepdf/Exceptions/DownloadException.php';
require_once __DIR__ . '/ilovepdf/Exceptions/ProcessException.php';
require_once __DIR__ . '/ilovepdf/Exceptions/UploadException.php';
require_once __DIR__ . '/ilovepdf/Exceptions/StartException.php';
require_once __DIR__ . '/ilovepdf/Exceptions/AuthException.php';
require_once __DIR__ . '/ilovepdf/Exceptions/PathException.php';

//Ilovepdf
require_once __DIR__ . '/ilovepdf/Ilovepdf.php';
require_once __DIR__ . '/ilovepdf/Task.php';

//Specific processes
require_once __DIR__ . '/ilovepdf/CompressTask.php';
require_once __DIR__ . '/ilovepdf/ImagepdfTask.php';
require_once __DIR__ . '/ilovepdf/MergeTask.php';
require_once __DIR__ . '/ilovepdf/OfficepdfTask.php';
require_once __DIR__ . '/ilovepdf/PagenumberTask.php';
require_once __DIR__ . '/ilovepdf/PdfaTask.php';
require_once __DIR__ . '/ilovepdf/PdfjpgTask.php';
require_once __DIR__ . '/ilovepdf/ProtectTask.php';
require_once __DIR__ . '/ilovepdf/RepairTask.php';
require_once __DIR__ . '/ilovepdf/RotateTask.php';
require_once __DIR__ . '/ilovepdf/SplitTask.php';
require_once __DIR__ . '/ilovepdf/UnlockTask.php';
require_once __DIR__ . '/ilovepdf/WatermarkTask.php';

