# PureHoney Theme Packager (POSIX/WordPress Compliant)
# Builds purehoney.zip with standard forward-slash (/) paths for Linux/cPanel/Hostinger compatibility.
# Excludes heavy product showcase images to keep the file under 10MB for easy WP upload.

Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$srcDir     = "d:\projects\purehoney\theme\purehoney"
$zipDest    = "d:\projects\purehoney\purehoney.zip"
$exportDest = "d:\projects\purehoney\theme\purehoney-export.zip"

Write-Output "Scanning theme files from: $srcDir"

if (Test-Path $zipDest) {
    [System.IO.File]::Delete($zipDest)
}
if (Test-Path $exportDest) {
    [System.IO.File]::Delete($exportDest)
}

$zipArchive = [System.IO.Compression.ZipFile]::Open($zipDest, [System.IO.Compression.ZipArchiveMode]::Create)

$allFiles = Get-ChildItem $srcDir -Recurse -File

$fileCount = 0
foreach ($file in $allFiles) {
    $rel = $file.FullName.Substring($srcDir.Length + 1)
    
    # Exclude heavy product images and backup files
    if ($rel -like 'assets\images\products*' -or $rel -like '*.bak' -or $rel -eq 'scratch_temp.php') {
        continue
    }

    # CRITICAL: Always use POSIX forward slash (/) for ZIP entries.
    # Windows backslash (\) causes Linux servers (Hostinger) to miss style.css!
    $entryName = "purehoney/" + ($rel.Replace('\', '/'))
    
    [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
        $zipArchive,
        $file.FullName,
        $entryName,
        [System.IO.Compression.CompressionLevel]::Optimal
    ) | Out-Null

    $fileCount++
}

$zipArchive.Dispose()

Write-Output "Added $fileCount files with POSIX paths to purehoney.zip."

# Sync to theme export
Copy-Item $zipDest $exportDest -Force

$zipInfo = Get-Item $zipDest
$sizeMB  = [math]::Round($zipInfo.Length / 1MB, 2)
Write-Output "Build complete! purehoney.zip size: $sizeMB MB"
Write-Output "Timestamp: $($zipInfo.LastWriteTime.ToString('yyyy-MM-dd HH:mm:ss'))"
