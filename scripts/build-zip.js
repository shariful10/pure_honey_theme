/**
 * PureHoney – Theme ZIP Builder
 * Run: npm run zip
 *
 * Creates purehoney.zip in the project root, excluding /assets/images/products/
 * so the file stays small enough to upload directly to WordPress.
 */

const fs   = require('fs');
const path = require('path');
const { execSync } = require('child_process');

const THEME_SRC  = path.join(__dirname, '..', 'theme', 'purehoney');
const EXPORT_TMP = path.join(__dirname, '..', 'theme', 'purehoney-export');
const ZIP_DEST   = path.join(__dirname, '..', 'purehoney.zip');

// ── Exclusions ────────────────────────────────────────────────────────────────
const EXCLUDE_PATTERNS = [
  path.join('assets', 'images', 'products'), // heavy product photos already on server
];

function shouldExclude(relPath) {
  return EXCLUDE_PATTERNS.some(p => relPath.startsWith(p));
}

// ── Copy files ────────────────────────────────────────────────────────────────
function copyDir(src, dest) {
  if (!fs.existsSync(dest)) fs.mkdirSync(dest, { recursive: true });
  for (const entry of fs.readdirSync(src, { withFileTypes: true })) {
    const srcPath  = path.join(src, entry.name);
    const destPath = path.join(dest, entry.name);
    const rel      = path.relative(THEME_SRC, srcPath);
    if (shouldExclude(rel)) continue;
    if (entry.isDirectory()) {
      copyDir(srcPath, destPath);
    } else {
      fs.copyFileSync(srcPath, destPath);
    }
  }
}

// ── Main ──────────────────────────────────────────────────────────────────────
console.log('🔨 Building PureHoney theme ZIP...');

// Clean temp + old zip
if (fs.existsSync(EXPORT_TMP)) fs.rmSync(EXPORT_TMP, { recursive: true, force: true });
if (fs.existsSync(ZIP_DEST))   fs.rmSync(ZIP_DEST,   { force: true });

// Copy
copyDir(THEME_SRC, EXPORT_TMP);
console.log('✅ Files copied (product images excluded)');

// ── Zip using Node.js native zlib ────────────────────────────────────────────
const { createWriteStream } = require('fs');

function addDirToZip(zip, baseDir, prefix) {
  for (const entry of fs.readdirSync(baseDir, { withFileTypes: true })) {
    const full    = path.join(baseDir, entry.name);
    const zipPath = prefix ? `${prefix}/${entry.name}` : entry.name;
    const rel     = path.relative(EXPORT_TMP, full);
    if (shouldExclude(rel)) continue;
    if (entry.isDirectory()) {
      addDirToZip(zip, full, zipPath);
    } else {
      zip.file(zipPath, fs.readFileSync(full));
    }
  }
}

// Use adm-zip (built-in via execSync npm install first)
try {
  execSync('npm install adm-zip --save-dev --quiet', { cwd: path.join(__dirname, '..'), stdio: 'inherit' });
} catch(e) {}

const AdmZip = require('adm-zip');
const zip    = new AdmZip();

function addFolder(srcDir, zipPrefix) {
  for (const entry of fs.readdirSync(srcDir, { withFileTypes: true })) {
    const full    = path.join(srcDir, entry.name);
    const zipPath = zipPrefix ? `${zipPrefix}/${entry.name}` : entry.name;
    if (entry.isDirectory()) {
      addFolder(full, zipPath);
    } else {
      zip.addFile(zipPath, fs.readFileSync(full));
    }
  }
}

addFolder(EXPORT_TMP, '');
zip.writeZip(ZIP_DEST);

// Cleanup temp
fs.rmSync(EXPORT_TMP, { recursive: true, force: true });

const sizeMB = (fs.statSync(ZIP_DEST).size / (1024 * 1024)).toFixed(1);
console.log(`\n🎉 purehoney.zip ready: ${sizeMB} MB`);
console.log(`   Location: ${ZIP_DEST}`);
console.log(`\n   Upload to: WP Admin → Appearance → Themes → Add New → Upload Theme`);
