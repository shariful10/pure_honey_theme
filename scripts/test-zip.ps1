Add-Type -AssemblyName System.IO.Compression.FileSystem
$z = [System.IO.Compression.ZipFile]::OpenRead("d:\projects\purehoney\purehoney.zip")
foreach ($e in $z.Entries) {
    if ($e.FullName -like "*style.css*") {
        Write-Host "Found style.css: $($e.FullName)"
    }
}
Write-Host "Total entries: $($z.Entries.Count)"
Write-Host "First 10 entries:"
for ($i = 0; $i -lt [Math]::Min(10, $z.Entries.Count); $i++) {
    Write-Host "  $($z.Entries[$i].FullName)"
}
$z.Dispose()
