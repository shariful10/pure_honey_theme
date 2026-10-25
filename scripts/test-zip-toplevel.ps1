Add-Type -AssemblyName System.IO.Compression.FileSystem
$z = [System.IO.Compression.ZipFile]::OpenRead("d:\projects\purehoney\purehoney.zip")
$notInPurehoney = @()
$topLevel = @{}
foreach ($e in $z.Entries) {
    $firstPart = $e.FullName.Split('/')[0]
    $topLevel[$firstPart] = $true
    if (-not $e.FullName.StartsWith("purehoney/")) {
        $notInPurehoney += $e.FullName
    }
}
Write-Host "Top level keys in ZIP: $($topLevel.Keys -join ', ')"
Write-Host "Entries not starting with purehoney/: $($notInPurehoney.Count)"
if ($notInPurehoney.Count -gt 0) {
    Write-Host "Examples: $($notInPurehoney[0..5] -join ', ')"
}
$z.Dispose()
