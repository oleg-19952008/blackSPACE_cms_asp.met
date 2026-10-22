# Move files/folders NOT used by entry points index.php / indexInternal.es.php
# Pure ASCII source (safe for PowerShell 5.1 in any console codepage).
# Cyrillic names are built from Unicode code points inside the script.
param(
    [string]$Root = (Split-Path -Parent $MyInvocation.MyCommand.Path),
    [switch]$DryRun
)

$ErrorActionPreference = "Stop"

# Destination folder name: "_NE_ISPOLZUETSJA" (transliteration, ASCII-safe)
$DestName = "_NE_ISPOLZUETSJA"

$unusedFolders = @(
    "chat","gamechat","rank","space","cms","htdocs","htdocsupd","dashboard",
    "old","test","indx","internalStart","internalDock","internalMap","Zedron",
    "_mmServerScripts","_notes","xampp","administratorpanel_for",
    "administratorpanel_for-off","includes","models","views","views23",
    "controllers","public","ajaxAPI","flashinput","img","index_files",
    "util","config"
)

# ajax/ : move everything EXCEPT nanoTechfactory (live dependency)
$ajaxKeep = @("nanoTechfactory")

$unusedFiles = @(
    "screen.php","text.php","tesst.php","test.php","mail.php","mailtest.php",
    "voucher.php","jumpgate.php","jumpgate","dateandtime.php","upd_db.php",
    "CheckPush.php","check_push.php","applications.html","donate.html",
    "bitnami.css","c66d41c90be2.html","msweb-brand.png","welcome.png",
    "ws8-brand.png","bkg-gry.jpg","GameAPI","gameserver.es","getflashres.es",
    "crossdomain.xml","sajaxAPI.php","xajaxAPI.php","xajaxAPI"
)

$dest = Join-Path $Root $DestName
if (-not $DryRun) { New-Item -ItemType Directory -Force -Path $dest | Out-Null }

function Move-ToDest($srcPath, $label) {
    if (-not (Test-Path -LiteralPath $srcPath)) { Write-Host "  SKIP (missing): $label" -ForegroundColor DarkGray; return }
    if ($DryRun) { Write-Host "  [DryRun] $label" -ForegroundColor Yellow; return }
    $leaf = Split-Path -Leaf $srcPath
    $target = Join-Path $dest $leaf
    if (Test-Path -LiteralPath $target) { Remove-Item -Recurse -Force -LiteralPath $target }
    Move-Item -LiteralPath $srcPath -Destination $dest
    Write-Host "  MOVED: $label" -ForegroundColor Green
}

Write-Host ""
Write-Host "=== Folders ===" -ForegroundColor Cyan
foreach ($f in $unusedFolders) { Move-ToDest (Join-Path $Root $f) ($f + "/") }

Write-Host ""
Write-Host "=== ajax/ (keep nanoTechfactory only) ===" -ForegroundColor Cyan
$ajaxDir = Join-Path $Root "ajax"
if (Test-Path -LiteralPath $ajaxDir) {
    Get-ChildItem -LiteralPath $ajaxDir | Where-Object { $ajaxKeep -notcontains $_.Name } | ForEach-Object {
        Move-ToDest $_.FullName ("ajax/" + $_.Name)
    }
}

Write-Host ""
Write-Host "=== Files ===" -ForegroundColor Cyan
foreach ($f in $unusedFiles) { Move-ToDest (Join-Path $Root $f) $f }

Get-ChildItem -LiteralPath $Root -Filter "*.ttf" -File | ForEach-Object { Move-ToDest $_.FullName $_.Name }
Get-ChildItem -LiteralPath $Root -Filter "*.rar" -File | ForEach-Object { Move-ToDest $_.FullName $_.Name }

# Cyrillic-named items built from code points (no encoding issues):
# BEKAP folder (backup) and "na praktiku.sql"
$bkp = [string][char]0x0411 + [char]0x042D + [char]0x041A + [char]0x0410 + [char]0x041F
Move-ToDest (Join-Path $Root $bkp) ($bkp + "/")
$sql = [string][char]0x043D + [char]0x0430 + " " + [char]0x043F + [char]0x0440 + [char]0x0430 + [char]0x043A + [char]0x0442 + [char]0x0438 + [char]0x043A + [char]0x0443 + ".sql"
Move-ToDest (Join-Path $Root $sql) $sql

Write-Host ""
Write-Host "=== Done ===" -ForegroundColor Cyan
if (-not $DryRun) {
    $readmeLines = @(
        "THESE FILES AND FOLDERS ARE NOT USED BY THE APPLICATION ENTRY POINTS:",
        "  index.php and indexInternal.es.php",
        "Verified by static analysis of require/include chains and template links.",
        ("Date: " + (Get-Date -Format "yyyy-MM-dd"))
    )
    Set-Content -LiteralPath (Join-Path $dest "README.txt") -Value $readmeLines -Encoding UTF8
    Write-Host "README.txt created in $DestName" -ForegroundColor Green
}
